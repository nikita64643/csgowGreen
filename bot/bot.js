//Компоненты
var Steam = require('steam');
var mysql = require('mysql');
var request = require("request");
var fs = require('fs');
var Winston = require('winston');
var SteamTotp = require('steam-totp');
var SteamUser = require('steam-user');
var SteamCommunity = require('steamcommunity');
var TradeOfferManager = require('steam-tradeoffer-manager');
var client = new SteamCommunity();
var steam = new SteamUser();
var config = require('./config.js');
var io = require('socket.io').listen(config.port || 8880);
///////////////////////////////////

///////////////////////////Логер/////////////////////////////////
var logger = new(Winston.Logger)({
    transports: [
        new(Winston.transports.Console)({
            colorize: true,
            level: 'debug'
        }),
        new(Winston.transports.File)({
            level: 'info',
            timestamp: true,
            filename: 'bot.log',
            json: false
        })
    ]
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Настройки рулетки
var GameTime = config.bot.gametime;
var timerID = 0;
var sitename = config.domain;
var pause = false;
var roulete = false;
var	noacept = false;
var last = false;
var relogin = null;
var detected = false;
var minprice = 0;
//Настройки MYSQL
var mysqlInfo = {
        host: config.mysql.host,
        user: config.mysql.user,
        password: config.mysql.pass,
        database: config.mysql.database,
        charset: 'utf8_general_ci'
    }
    ///////////////////////////////СОКЕТЫ//////////////////////////////////////////////
io.on('connection', function(socket) {
	 io.emit('init', {
            name: 'init',
        });
    if (last) {
        io.emit('lastitems', {
            time: '0:0',
        });
    }
    if (roulete) {

    }
    socket.on('newitem', function(msg) {
        io.emit('newitem', {
            name: 'newitem',
        });
        getPlayers();
    });
	socket.on('newmassage', function(msg) {
        io.emit('newmassage', {
            name: 'newitem',
        });
    });
});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
fs.readFile('key', 'utf8', function(err, data) {
    if (err) {
        logger.debug("Ключ не найден,используем пароль!");
        steam.logOn({
            accountName: config.bot.username,
            password: config.bot.password,
            twoFactorCode: SteamTotp.generateAuthCode(config.bot.shared_secret),
            rememberPassword: true
        });
    } else {
        logger.debug("Найден ключ!Импортируем...");
        steam.logOn({
            accountName: config.bot.username,
            loginKey: data,
            twoFactorCode: SteamTotp.generateAuthCode(config.bot.shared_secret),
            rememberPassword: true
        });
    }
});

client.on('loginKey', function(key) {
    fs.writeFile("key", key, function(err) {
        if (err) {
            return logger.info(err);
        }
        logger.info("Новый ключ сохронён!");
    });
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function message(steamid, mes) {
    io.emit('message', {
        steamid: steamid,
        mes: mes,
    });
}
///////////////////////////////////////////////////////////////////
var mysqlConnection = mysql.createConnection(mysqlInfo);
var manager = new TradeOfferManager({
    "steam": steam,
    "domain": "localhost",
    "language": "en"
    //cancelTime: config.bot.CancelOffer
})
manager.on('pollData', function(pollData) {
    fs.writeFile('polldata.json', JSON.stringify(pollData));
});
manager.on('sentOfferChanged', function(offer, oldState) {
    if (offer.state == TradeOfferManager.ETradeOfferState.Accepted) {
        mysqlConnection.query('UPDATE queue SET tradeStatus="8" WHERE status LIKE "%' + offer.id + '%"', function(err, row, fields) {
            if (err) throw err;
        });
        mysqlConnection.query('SELECT * FROM `queue` WHERE status LIKE "%' + offer.id + '%"', function(err, row, fields) {
            for (var i = 0; i < row.length; i++) {

                var attempts = row[i].attempts;
                if (attempts == 0) {
                    attempts++;
                    mysqlConnection.query('UPDATE queue SET attempts=' + attempts + ' WHERE status LIKE "%' + offer.id + '%"', function(err, row, fields) {
                        if (err) throw err;
                    });
                    logger.info('Updating the attempts made to send round #' + offer.id);

                } else {

                    if (attempts == 1) {
                        mysqlConnection.query('UPDATE queue SET attempts=2 WHERE status LIKE "%' + offer.id + '%"', function(err, row, fields) {
                            if (err) throw err;
                        });
                        logger.info('Updating the attempts made to send round #' + offer.id);
                    }

                }

            }
        });
        logger.info("Офер #" + offer.id + " был принят!");
    }
    if (offer.state == TradeOfferManager.ETradeOfferState.Decline) {
        mysqlConnection.query('UPDATE queue SET tradeStatus="3" WHERE status LIKE "%' + offer.id + '%"', function(err, row, fields) {
            if (err) throw err;
        });
        logger.info("Офер #" + offer.id + " был отклонён!(Видимо не понравился)");
    }
});
manager.on('pollFailure', function(err) {
    logger.error('Стим лагает!Ошибка торговых сделок: ' + err);
});
var checker = false;
var offers = 0;
var players = [];
var timer = false;
var acceptedTrades = [];
function getPlayers() {
    mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, row, fields) {
        var current_game = (row[0].value);
        mysqlConnection.query('SELECT COUNT(DISTINCT userid) AS playersCount FROM `gamejack` WHERE `game` = \'' + current_game + '\'', function(err, rows) {
            someVar = rows[0].playersCount;
            logger.info('Игроков: ' + someVar);
            mysqlConnection.query('SELECT `starttime` FROM `games` WHERE `id`=\'' + current_game + '\'', function(errs, rowss, fieldss) {
                if (someVar >= 2 && rowss[0].starttime == 2147483647 && !timer) {
					timer = true;
                    logger.info('Найдено 2 игрока,Стартуем игру!');
					io.emit('timer', {
                        time: '0:0',
                    });
                    setTimeout(endgame, GameTime * 1000);
					setTimeout(noenter, GameTime * 1000-10000);
                    mysqlConnection.query('UPDATE `games` SET `starttime`=UNIX_TIMESTAMP() WHERE `id` = \'' + current_game + '\'', function(err, row, fields) {});
                }
            });
        });
    });
}
function crash(err){
		fs.writeFileSync('./crashdb.txt', err);
		logger.error('Ошибка: ' + err);
}
function processing(offer) {
    if (pause) {
        logger.info('>>>>>>> Включена пауза <<<<<<<<<<<<');
        offer.decline(function(err) {
            message(offer.partner.getSteamID64(), 'На сайте ведутся тех.работы,ожидайте!')
            return;
        });
    } else {
        if (noacept) {
            logger.info('>>>>>>> Принятие последних ставок <<<<<<<<<<<<');
            offer.decline(function(err) {
                message(offer.partner.getSteamID64(), 'Ожидайте завершения игры!')
            });
            return;
        } else {
            logger.info('>>>>>>> Распознал трейд <<<<<<<<<<<<');
            if (config.admins.indexOf(offer.partner.getSteamID64()) != -1 && offer.itemsToGive.length > 0) {
                logger.info('Админ ' + offer.partner.getSteam3RenderedID() + ' забрал вещи с бота!');
                offer.accept(function(err) {
                    if (err) {
                        logger.error('Ошибка принятия трейда ' + offer.id + '!Ошибка: ' + err.message);
                    } else {
                        logger.info('Обмен принят');
                    }
                });
            } else if (offer.itemsToGive.length === 0) {
			    message(offer.partner.getSteamID64(), 'Ваш трейд поступил в обработку!');
                offer.getEscrowDuration(function(err, daysTheirEscrow, daysMyEscrow) {
                    if (err) {
                        reconnect();
                        logger.error('Ошибка ESCROW ' + err);
                        offer.decline(function(err) {
                            if (err)  crash(err);
                            message(offer.partner.getSteamID64(), 'Возможные проблемы с STEAM escrow!');
                        });
                        return;
                    } else {
                        if (daysTheirEscrow != 0) offer.decline(function(err) {
                            if (err) {
                                crash(err);
                                return;
                            }
                            message(offer.partner.getSteamID64(), 'У вас не включено мобильное подтверждение!')
                            return;
                        });
                        else {
                            var items = [];
                            var checker = true;
                            var itemsString = "";
                            var totalPrice = 0;
                            var cost = 0;
                            var items = offer.itemsToReceive;
                            items.forEach(function(item, i, arr) {
								if (item.appid != 730) {
                                    offer.decline(function(err) {
                                        message(offer.partner.getSteamID64(), 'Предмет ' + item.market_hash_name + ' не с CSGO!');
                                        checker = false;
                                    });
                                    return;
                                } 
                                var itemname = addslashes(item.market_hash_name);
                                request('http://' + sitename + '/sys/api.php?cost=' + encodeURIComponent(itemname), function(error, response, body) {
                                    if (!error && response.statusCode === 200) {
                                        if (body.indexOf('+-') > -1) {
                                            offer.decline(function(err) {
                                                if (err) crash(err);
                                                message(offer.partner.getSteamID64(), 'Предмет ' + item.market_hash_name + ' не найден в базе данных!');
                                            });
                                            return;
                                        } else {
                                            totalPrice += parseFloat(body);
                                            item.cost = parseFloat(body);
                                        }
                                    } else {
                                        offer.decline();
                                        logger.info("Что-то с сайтом!Проверьте настройки сайта!");
                                        return;
                                    }
                                });
                                if (item.market_hash_name.indexOf("Souvenir") > -1) {
                                    offer.decline(function(err) {
                                        message(offer.partner.getSteamID64(), 'Предмет ' + item.market_hash_name + ' запрещён на нашем сайте!');
                                        checker = false;
                                    });
                                    return;
                                }
                                else {
                                    itemsString += item.market_hash_name + "!END!";
                                }
                            });
                            setTimeout(function() {
                                    if (totalPrice < minprice) {
                                        logger.info('Отмена офера (Минимальная цена' + row[0].value + ' ,у игрока ' + totalPrice + ')');
                                        offer.decline(function(err) {
                                            message(offer.partner.getSteamID64(), 'Минимальная ставка ' + row[0].value + ' руб!Вы внесли ' + totalPrice + '!');
                                            checker = false;
                                        });
                                        return;
                                    }
                                mysqlConnection.query('SELECT * FROM `account` WHERE `steamid`="' + offer.partner.getSteamID64() + '"', function(usrerr, usrres, usrfields) {
                                    if (usrres.length == 0) {
                                        offer.decline(function(err) {
                                            logger.info('Пользователя : ' + offer.partner.getSteamID64() + ' нету в базе !');
                                            checker = false;
                                        });
                                        return;
                                    } else if (usrres[0].linkid == null) {
                                        logger.info('Пользователь : ' + offer.partner.getSteamID64() + ' не указал трейд-ссылку !');
                                        offer.decline(function(err) {
                                            message(offer.partner.getSteamID64(), 'Вы забыли указать ссылку на обмен!');
                                            checker = false;
                                        });
                                        return;

                                    } else {
                                        mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, row, fields) {
                                            var current_game = (row[0].value);
                                            logger.info('Обработка трейда в игру №' + current_game);
                                            mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'maxitems\'', function(err, rowa, fields) {
                                                mysqlConnection.query('SELECT * FROM `gamejack` WHERE `userid`=\'' + offer.partner.getSteamID64() + '\' AND `game`=\'' + current_game + '\'', function(err, rowf, fields) {
                                                    var vsego = rowf.length + items.length;
                                                    if (vsego > rowa[0].value) {
                                                        logger.info('Внесено максимально вещей');
                                                        offer.decline(function(err) {
                                                            message(offer.partner.getSteamID64(), 'Вы внесли (' + vsego + '), максимальное количество (' + rowa[0].value + ') вещей');
                                                            checker = false;
                                                        });
                                                        return;
                                                    }
                                                });
                                                if (items.length > rowa[0].value) {
                                                    logger.info('Внесено максимум вещей');
                                                    offer.decline(function(err) {
                                                        message(offer.partner.getSteamID64(), 'Вы внесли (' + items.length + '), максимальное количество (' + rowa[0].value + ') вещей');
                                                        checker = false;
                                                    });
                                                    return;
                                                }
                                            });
											logger.info('Получение информации о игроке: ' + offer.partner.getSteamID64());
                                            getUserInfo(offer.partner.getSteamID64(), function(error, data) {
                                                if (error) {
													message(offer.partner.getSteamID64(), 'Ошибка получения информации о пользователе!');
													logger.info('Ошибка 160' + error);
                                                    offer.decline(function(err) {                                                
                                                        crash(err);
                                                    });
                                                    return;
                                                }
                                                var datadec = JSON.parse(JSON.stringify(data.player));
                                                var name = addslashes(cleanString(datadec.name));
                                                var avatar = (datadec.ava);
                                                if (checker) {
                                                    logger.info('Проверяем на ставки: '+noacept);
                                                    var acceptRetry = 5;
                                                    var acceptTrade = function() {
														logger.info('Принимаем трейд от игрока: ' + offer.partner.getSteamID64());
                                                        if (noacept) {
                                                            logger.info('>>>>>>> Принятие последних ставок <<<<<<<<<<<<');
                                                            offer.decline(function(err) {
                                                                message(offer.partner.getSteamID64(), 'Ожидайте завершения игры!')
                                                            });
                                                            return;
                                                        }
                                                        acceptRetry--;
                                                        offer.accept(function(err, response) {
															if (typeof offer.tradeID == "undefined" || offer.tradeID == null) {
                                                                logger.info('Трейдоффер №' + offer.tradeID + ' отклонен. Причина: не удалось принять трейдоффер. ');
                                                                message(offer.partner.getSteamID64(), 'Ваше предложение обмена отклонено. Причина: не удалось принять обмен.');
                                                                offer.decline();
                                                            }
														  var setinmysql = function() {
                                                            manager.getOffer(offer.id, function(err, offer) {
																if(err){
																	console.log(err);
																	setinmysql();
																} else {
																if(offer.state == 1){
																	setinmysql();
																} else if(offer.state == 6 || offer.state == 7){
																	console.log('Трейд-оффер '+offer.id+' был отменен.');
																} else if(offer.state == 3){
																acceptedTrades.push(offer.tradeID);
                                                                message(offer.partner.getSteamID64(), 'Ваш обмен принят!');
                                                                mysqlConnection.query('UPDATE `account` SET `hisgames`=concat(`hisgames`,\',' + current_game + ',\') WHERE `steamid` = \'' + offer.partner.getSteamID64() + '\'', function(err, row, fields) {  if (err) crash(err);});
                                                                mysqlConnection.query('SELECT `cost`,`itemsnum` FROM `games` WHERE `id`=\'' + current_game + '\'', function(err, row, fields) {
                                                                    if (err) crash(err);
																	var current_bank = parseFloat(row[0].cost);
                                                                    items.forEach(function(item, i, arr) {
                                                                        var itemsnum = row[0].itemsnum;
                                                                        var marketname = item.type;
                                                                        var itemname = addslashes(item.market_hash_name);
                                                                        if (marketname != null) {
                                                                            var color = '';
                                                                            if (marketname.indexOf('Mil-Spec') > -1) {
                                                                                color = 'rgb(75,105,205)';
                                                                            } else if (marketname.indexOf('Industrial grade') > -1) {
                                                                                color = 'rgb(100,150,225)';
                                                                            } else if (marketname.indexOf('Restricted') > -1) {
                                                                                color = 'rgb(136,71,255)';
                                                                            } else if (marketname.indexOf('Classified') > -1) {
                                                                                color = 'rgb(211,44,230)';
                                                                            } else if (marketname.indexOf('Case') > -1) {
                                                                                color = 'rgb(211,44,230)';
                                                                            } else if (marketname.indexOf('Covert') > -1) {
                                                                                color = 'rgb(235,75,75)';
                                                                            } else if (marketname.indexOf('High Grade') > -1) {
                                                                                color = 'rgb(0,153,153)';
                                                                            } else {
                                                                                color = 'rgb(0,153,153)';
                                                                            }
                                                                            mysqlConnection.query('INSERT INTO `gamejack` (`userid`,`username`,`item`,`color`,`itemtype`,`value`,`avatar`,`image`,`from`,`to`,`thisitem`,`game`,`tradeid`) VALUES (\'' + offer.partner.getSteamID64() + '\',\'' + name + '\',\'' + itemname + '\',\'' + item.name_color + '\',\'' + color + '\',\'' + item.cost + '\',\'' + avatar + '\',\'' + item.getLargeImageURL() + '\',\'' + current_bank + '\'+\'0\',\'' + current_bank + '\'+\'' + item.cost + '\',\'yes\',\'' + current_game + '\',\'' + offer.tradeID + '\')', function(err, row, fields) {
                                                                                if (err) logger.info('Ошибка 12' + err);
                                                                            });
                                                                            mysqlConnection.query('UPDATE `games` SET `itemsnum`=`itemsnum`+1, `cost`=`cost`+\'' + item.cost + '\' WHERE `id` = \'' + current_game + '\'', function(err, row, fields) {if (err) logger.info(err);});
                                                                            current_bank = parseFloat(current_bank + item.cost);
                                                                            itemsnum++;
                                                                        }
                                                                    });
																	logger.info('Добавили предметы в игру!');
                                                                    //////Рсширение///////
                                                                    io.emit('game', {
                                                                        bank: current_bank,
                                                                        game: current_game,
                                                                    });
                                                                    /////////////////////
                                                                });
                                                                io.emit('newitem', {
                                                                    name: 'newitem',
                                                                });
                                                                logger.info('Трейд #' + offer.tradeID + ' от ' + name + ' (' + offer.partner.getSteamID64() + ') принят в игру ' + current_game + '!');
                                                                setTimeout(getPlayers, 2000);
															    }
															  }
															});
														  }
														  setTimeout(setinmysql, 5000);
                                                        });
                                                    };
                                                    acceptTrade();
                                                }
                                            });
                                        });
                                    }
                                });
                            }, 1000);
                        }
                    }
                });
            } else {
                logger.info('Человек с ID ' + offer.partner.getSteamID64() + ' пытается спиздить вещи!');
                offer.decline(function(err) {
                    if ('Ошибка 16' + err) {
                        logger.error('Немогу отменить офер ' + offer.id + ' ошибка: ' + err);
                    } else {
                        logger.debug('Обмен отклонен');

                    }
                });
            }
        }
    }
}
manager.on('newOffer', function(offer) {
    processing(offer);
});
function noenter() {
		logger.info('Заканчиваем приём!');
		noacept = true;
}
function endgame() {
	logger.info('Последние ставки!');
    last = true;
    io.emit('lastitems', {
        time: '0:1',
    });
    setTimeout(function() {
        last = false;
        roulete = true;
        mysqlConnection.query('UPDATE info SET value = "pause" WHERE name = "state"', function(err, row, fields) {});
        var url = 'http://' + sitename + '/sys/winnerJack.php?item=dsadasdfasf8saf6fas67as7f4af1';
        request(url, function(error, response, body) {
			logger.info(body);
			timer = false;
                mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, row, fields) {
                    var current_game = (row[0].value);
                    io.emit('end-game', {
                        game: current_game-1,
                    });
                    logger.info('Конец игры' + current_game);
                });

            setTimeout(function() {
                mysqlConnection.query('UPDATE info SET value = "waiting" WHERE name = "state"', function(err, row, fields) {});
                logger.info('Закончилась рулетка');
				setTimeout(function() {
				io.emit('newitem', {
                    name: 'newitem',
                });
				},2000);
                roulete = false;
				noacept = false;

            }, 10000);
            logger.info('Закончилась игра!Определяем победителя....');
            endtimer = -1;
        });
    }, 7000);
};




function getUserInfo(steamids, callback) {
    var url = 'http://' + sitename + '/sys/api.php?getUserInfo=' + steamids;
    request({
        url: url,
        json: true
    }, function(error, response, body) {
        if (!error && response.statusCode === 200) {
            callback(null, body);
        } else if (error) {
            getUserInfo(steamids, callback);
        }
    });
}

function addslashes(str) {
	if (typeof str !== "undefined" && str !== null) {
    // some code here
    str = str.replace(/\\/g, '\\\\');
    str = str.replace(/\'/g, '\\\'');
    str = str.replace(/\"/g, '\\"');
    str = str.replace(/\0/g, '\\0');
    return str;
	}else  return ;
}

var itemscopy;
var endtimer = -1;
steam.on('accountLimitations', function(limited, communityBanned, locked, canInviteFriends) {
    var limitations = [];
    if (limited) {
        logger.warn('Найдено ограничение связаное с WebAPI,пожалуйста ,решите проблему!');
    }
    if (communityBanned) {
        logger.warn('Аккаунт получил community бан,замените на новый!');
    }
    if (locked) {
        logger.error('Этот аккаунт заблокирован!Ждём замены....Выключаемся......');
        process.exit(1);
    }
    if (limitations.length === 0) {
        logger.info("Ваш аккаунт не имеет банов.");
    } else {
        logger.info("Ваш аккаунт " + limitations.join(', ') + ".");
    }
    if (!canInviteFriends) {
        logger.warn('Невозможно добавлять в друзья!На аккаунте ограничения!')
    }
});
steam.on('loginKey', function(key) {
    fs.writeFile("key", key, function(err) {
        if (err) {
            return logger.info('Ошибка key' + err);
        }
        logger.info("Создан и сохранён новый ключ!");
    });
});

steam.on('error', function(e) {
    logger.info(e);
    process.exit(1);
});
steam.on('loggedOn', function(result) {
    mysqlConnection.query('UPDATE info SET value = "waiting" WHERE name = "state"', function(err, row, fields) {});
    if (result.eresult === Steam.EResult.OK) {
        relogin = setInterval(reconnect, 1000 * 60 * 60 * 2);
        setTimeout(function() {
            mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, rows, fields) {
                if (err) return;
                mysqlConnection.query('SELECT `starttime` FROM `games` WHERE `id`=\'' + rows[0].value + '\'', function(errs, rowss, fieldss) {
                    if (errs) return;
                    var timeleft;
                    if (rowss[0].starttime == 2147483647) timeleft = GameTime;
                    else {
                        var unixtime = Math.round(new Date().getTime() / 1000.0);
                        timeleft = rowss[0].starttime + GameTime - unixtime;
                        if (timeleft < 0) timeleft = 0;
                    }
                    if (timeleft != GameTime) {
                        setTimeout(endgame, timeleft * 1000);
                        logger.info('Restoring game on ' + timeleft + 'second');
                    }
                });
            });
        }, 1500);
        logger.info('==============================Информация===============================');
        logger.info('Авторизован под  steamid:' + steam.steamID.getSteamID64() + '');
        steam.on('emailInfo', function(address, validated) {
            logger.info("Почта : " + address + " " + (validated ? "Привязана" : "Не привязана"));
        });
        steam.on('wallet', function(hasWallet, currency, balance) {
            logger.info("На счету: " + SteamUser.formatCurrency(balance, currency));
        });
        logger.info("Привязан к сайту : " + config.domain);
        mysqlConnection.query('SELECT * FROM `gamejack`', function(err, row, fields) {
            if (err) {
                logger.error("Ошибка подключения к бд : - " + err);
                process.exit(1);
            } else logger.info("Подключение к БД " + config.mysql.database + " успешно");
        });
		mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'minbet\'', function(err, row, fields) {
           minprice= row[0].value;
		   logger.error("Минимальная цена выставлена на : " + row[0].value+" рублей");
        });
        logger.info("Все процессы запущены,Начинаем работу!");
        steam.setPersona(Steam.EPersonaState.LookingToTrade, config.name + '');
        for (var i = 0; i < config.admins.length; i++) {
            steam.addFriend(config.admins[i]);
            logger.info(config.admins[i] + ' Добавили в друзья')
			steam.chatMessage(config.admins[i], 'Бот перезапущен!');
        }
        steam.gamesPlayed(config.name);
    }


});

client.on("newConfirmation", function(confirmation) {
    logger.info("New confirmation");
    processConfirmation(confirmation, function(passed) {
        logger.info(passed);
    });
});

client.on("confKeyNeeded", function(tag, callback) {
    logger.info("Confirmation key needed");
    var time = Math.floor(Date.now() / 1000);
    logger.info(callback.toString());
    callback(null, time, SteamTotp.getConfirmationKey(config.bot.identity_secret, time, tag));
});

function processConfirmation(confirmation, callback) {
    var time = Math.floor(Date.now() / 1000);
    var key = SteamTotp.getConfirmationKey(config.bot.identity_secret, time, "conf");
    client.respondToConfirmation(confirmation.id, confirmation.key, time, key, true, function(err) {
        logger.info("Responding to confirmation " + confirmation.id);
        var ret = true;
        if (err != null) {
            logger.info('Ошибка 65' + err);
            ret = false;
            logger.info("Responding to confirmation " + confirmation.id + " failed");
        } else {
            logger.info("Responding to confirmation " + confirmation.id + " succeeded");
        }

        if (typeof(callback) == "function") {
            callback(ret);
        }
    });
}
steam.on('webSession', function(sessionID, cookies) {
    manager.setCookies(cookies, function(err) {
        if (err) {
            logger.error('Не могу получить куки,ошибка: ' + err);
            process.exit(1);
        }
        logger.info("API ключ: " + manager.apiKey);
    });
    client.setCookies(cookies);
    client.startConfirmationChecker(30000, config.bot.identity_secret);
    setInterval(sendoffers, 5000);
});

function reconnect() {
    clearTimeout(relogin);
    steam.webLogOn();
}


var detected = false;
var detected2 = true;
var itemscopy;

function in_array(needle, haystack, strict) {
    var found = false,
        key, strict = !!strict;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }

    return found;
}

function cleanString(input) {
    var output = "";
    for (var i = 0; i < input.length; i++) {
        if (input.charCodeAt(i) <= 127) {
            output += input.charAt(i);
        }
    }
    return output;
}

function sendoffers() {
    mysqlConnection.query('SELECT * FROM `queue` WHERE `status`=\'active\' ORDER BY `unic` DESC LIMIT 1', function(err, row, fields) {
        if (err) {
            logger.info('Tried checking offers: ERROR 3! (mysql query error: ' + err.stack + ')');
            return;
        }
        if (detected == true) {
                //logger.info('Tried checking offers: ERROR 4! (detected==true)');
                return;
       }
       

        for (var y = 0; y < row.length; y++) {
			detected = true;
            logger.info('Y: ' + y + ' Processing offer ' + row[y].id + ' for game ' + row[y].unic);
            var bd = row[y];
                manager.loadInventory(730, 2, true, function(err, myItems, currencies) {

                    if (err) {
						detected = false;
                        reconnect();
                        logger.info('Ошибка загрузка инвентаря: ' + err);
                        return;
                    }
                    itemscopy = myItems;
                    if (bd.token.length < 5) {
                        logger.info('Token is: ' + bd.token + ' which seems to be incorrect. Stopping the process...');
                        logger.info('The "token" is the last part in trade url and it is 6 characters long, maybe user hasn\'t set his trade url in the database. Check user with steam id ' + row[y].userid);
                        detected = false;
				   }
 

                    var queueid = bd.id;
                    var gameid = bd.unic;
                    var theuserid = bd.userid;
                    var thetoken = bd.token;
                    var theitems = bd.items;
                    var sendItems = (bd.items).split('/');
                    var item = [],
                        queries = [],
                        itemstobesent = '',
                        itemidsintheoffer = [],
                        num = 0;

                    for (var x = 0; x < itemscopy.length; x++) {
                        (function(z) { //fucking bullshit asynchronous crap
                            mysqlConnection.query('SELECT * FROM `sentitems` WHERE `itemid`=\'' + itemscopy[z].id + '\'', function(errz, rowz, fieldsz) {
                                if (errz) {
									detected = false;
                                    logger.info('Q:' + queueid + '/G:' + gameid + '/ Error while trying to check for sent items (mysql query error: ' + errz.stack + ')');
                                    return;
                                }
                                itemscopy[z].market_name = itemscopy[z].market_name.replace('?', '&#9733;');
                                itemscopy[z].market_name = itemscopy[z].market_name.replace('??', '??');
                                itemscopy[z].market_name = itemscopy[z].market_name.replace('?', '?');

                                var countitems = rowz.length;
                                for (var j = 0; j < sendItems.length; j++) {
                                    if (itemscopy[z].tradable && (itemscopy[z].market_name).indexOf(sendItems[j]) == 0) {
                                        if (!(countitems > 0)) {
                                            item[num] = {
                                                appid: 730,
                                                contextid: 2,
                                                amount: 1, //was itemscopy[z].amount ?
                                                assetid: itemscopy[z].id
                                            }
                                            itemstobesent = itemstobesent + '' + itemscopy[z].market_name + '/';
                                            queries[num] = 'INSERT INTO `sentitems` (`id`,`itemid`,`name`,`gameid`,`queueid`,`userid`) VALUES ("","' + itemscopy[z].id + '","' + itemscopy[z].market_name.replace('??', '??') + '","' + gameid + '","' + queueid + '","' + theuserid + '")';
                                            sendItems[j] = "emptyqq";
                                            itemscopy[z].market_name = "zzzzzz";
                                            num++;

                                        } else {
											detected = false;
                                            logger.info('Q:' + queueid + '/G:' + gameid + '/Z:' + z + ' ' + itemscopy[z].market_name + ' with id ' + itemscopy[z].id + ' was already sent in another offer. looking for another item...');
                                        }
                                    }
                                }
                                if (num == sendItems.length) {
                                    logger.info(num + '==' + sendItems.length);
                                    var offer = manager.createOffer(theuserid);
                                    item.forEach(function(itemf) {
                                        offer.addMyItem(itemf);
                                    });
									var sentRetry = 5;
                                    var sendtrade = function() {
									sentRetry--;
								    offer.send("Ваши вещи с сайта " + config.name, thetoken, function(err, csgo) {
                                        if (err) {
											if (sentRetry > 0) {
                                                logger.info('Не удалось отослать трейдоффер. Повторяю попытку. Попыток осталось: ' + sentRetry + '. Текст ошибки: ' + err + '');
                                                setTimeout(function() {
                                                    sendtrade();
                                                }, (6 - sentRetry) * 1000);
                                            } else {
												detected = false;
												logger.info('Q:' + queueid + '/G:' + gameid + '/ ' + '(ERROR) Tried sending offers: Token: ' + thetoken + '; USERID: ' + theuserid + '; items: ' + itemstobesent + ' (steam servers down? too many offers sent already? empty token (from trade link) in database? check pls). ' + err + '. https://github.com/SteamRE/SteamKit/blob/master/Resources/SteamLanguage/eresult.steamd');
                                                logger.info('Трейдоффер отослать не удалось.Текст ошибки: ' + err+'.Игра: '+gameid);                   
                                                mysqlConnection.query('UPDATE `queue` SET `err`=\'' + err + '\', `status`=\'nosent\' WHERE `id`=\'' + queueid + '\'', function(err, row, fields) {
                                                      if (err) throw err;
                                                });
												return;
                                            }
                                        }else{				
			                            detected = false;
                                        logger.info('Q:' + queueid + '/G:' + gameid + '/ ' + 'Trade offer ' + queueid + ' (game ' + gameid + ') sent! Marking items as sent in the database....');
                                        var thetheitems = theitems.replace(/\/$/, '');
                                        var theitemstobesent = itemstobesent.replace(/\/$/, '');
                                        var numtheitems = (thetheitems).split('/').length;
                                        var numitemstobesent = (theitemstobesent).split('/').length;
                                        if (numtheitems != numitemstobesent) {
                                            logger.info('Q:' + queueid + '/G:' + gameid + '/ ' + 'WARNING !!! Sent ' + numtheitems + ' items! Needed to send ' + numitemstobesent + '!!!');
                                            logger.info('Sent (' + numtheitems + '): ' + thetheitems);
                                            logger.info('Needed to send (' + numitemstobesent + '): ' + theitemstobesent);
                                        } else {
                                            logger.info('Q:' + queueid + '/G:' + gameid + '/ ' + 'ALL IS GOOD! Sent ' + numtheitems + ' items! Needed to send ' + numitemstobesent + '.');
                                        }
                                        for (bla = 0; bla < queries.length; bla++) {
                                            mysqlConnection.query(queries[bla], function(blaerr, blarows, blafields) {
                                                if (blaerr) {
                                                    throw blaerr;
                                                }

                                            });
                                        }
                                        mysqlConnection.query('UPDATE `queue` SET `status`=\'sent ' + offer.id + '\' WHERE `id`=\'' + queueid + '\'', function(err, row, fields) {
                                            if (err) throw err;
                                        });

										}
                                    });
									}
                                    sendtrade();

                                    num++; //avoid running this multiple times when the loop runs
                                }else detected = false;
                            });
                        })(x);
                    }
                });


        }
    });
}





steam.on('friendMessage', function(steamID, message) {
    if (config.admins.indexOf(steamID.getSteamID64()) != -1) {
        if (message.indexOf("/sendallitems") == 0) {
            manager.loadInventory(730, 2, true, function(err, myItems) {
                var offer = manager.createOffer(steamID.getSteamID64());
                if (err) {
                    logger.info('Ошибка fr' + err);
                    return;
                }
                for (var i = 0; i < myItems.length; i++) {
                    offer.addMyItem(myItems[i]);
                }
                offer.send("Вывод вещей с бота!");
                steam.chatMessage(steamID.getSteamID64(), 'Обмен отправлен!');
            });
        } else if (message.indexOf("/send") == 0) {
            var params = message.split(' ');
            if (params.length == 1) return steam.chatMessage(steamID.getSteamID64(), 'Формат: /send [название предмета]');
            manager.loadInventory(730, 2, true, function(err, myItems) {
                if (err) {
                    logger.info('Ошибка ff' + err);
                    steam.chatMessage(steamID.getSteamID64(), 'Не могу загрузить свой инвентарь, попробуй ещё раз');
                    return;
                }
                var offer = manager.createOffer(steamID.getSteamID64());
                for (var i = 0; i < myItems.length; i++) {
                    if ((myItems[i].market_hash_name).indexOf(params[1]) != -1) {
                        offer.addMyItem(myItems[i]);
                    }
                }
                offer.send("Запрос на отправку");
                steam.chatMessage(steamID.getSteamID64(), 'Обмен отправлен!');
            });
        } else if (message.indexOf("/show") == 0) {
            var params = message.split(' ');
            manager.loadInventory(730, 2, true, function(err, items) {
                if (err) {
                    steam.chatMessage(steamID.getSteamID64(), 'Не могу загрузить свой инвентарь, попробуй ещё раз!');
                    return;
                }
                steam.chatMessage(steamID.getSteamID64(), 'Смотри: ');
                for (var i = 0; i < items.length; i++) {
                    steam.chatMessage(steamID.getSteamID64(), 'http://steamcommunity.com/id/76561198195552698/inventory/#' + items[i].appid + '_' + items[i].contextid + '_' + items[i].id);
                }
            });
        } else if (message.indexOf("/end") == 0) {
            steam.chatMessage(steamID.getSteamID64(), 'Игра окончена!');
            if (endtimer != -1) clearTimeout(endtimer);
            endgame();
        } else if (message.indexOf("/code") == 0) {
            var code = SteamTotp.generateAuthCode(config.bot.shared_secret);
            steam.chatMessage(steamID.getSteamID64(), 'Your login code: ' + code + '');
        } else if (message.indexOf("/stop") == 0) {
            pause = true;
            steam.chatMessage(steamID.getSteamID64(), 'Сайт закрыт!');
        } else if (message.indexOf("/play") == 0) {
            steam.chatMessage(steamID.getSteamID64(), 'Приём трейдов возобновлён!');
            pause = false;
        }else if (message.indexOf("/gameplay")==0){
			    mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, row, fields) {
                    var current_game = (row[0].value);
                      mysqlConnection.query('SELECT COUNT(DISTINCT userid) AS playersCount FROM `gamejack` WHERE `game` = \'' + current_game + '\'', function(err, rows) {
                         someVar = rows[0].playersCount;
                         logger.info('Игроков: ' + someVar);
                           mysqlConnection.query('SELECT `starttime` FROM `games` WHERE `id`=\'' + current_game + '\'', function(errs, rowss, fieldss) {
                                 if (rowss[0].starttime == 2147483647) {								 
                                     logger.info('Найдено 2 игрока,Стартуем игру!');
									 io.emit('timer', {
                                        time: '0:0',
                                     });
                                     endtimer = setTimeout(endgame, GameTime * 1000);
                                     mysqlConnection.query('UPDATE `games` SET `starttime`=UNIX_TIMESTAMP() WHERE `id` = \'' + current_game + '\'', function(err, row, fields) {});
                                 }
                           });
                     });
                });		
        } else if (message.indexOf("/rol") == 0) {
            steam.chatMessage(steamID.getSteamID64(), 'Рулетка запущена!');
            var params = message.split(' ');
            mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'current_game\'', function(err, row, fields) {
                var current_game = (row[0].value);
                io.emit(params[1], {
                    game: current_game,
                });
            });

        } else if (message.indexOf("/help") == 0) {
            steam.chatMessage(steamID.getSteamID64(), 'Помощь по командам:');
            steam.chatMessage(steamID.getSteamID64(), '/stop -  остановить приём ставок');
            steam.chatMessage(steamID.getSteamID64(), '/play - возобновить приём ставок');
            steam.chatMessage(steamID.getSteamID64(), '/rol -крутить рулетку(Визуально)');
            steam.chatMessage(steamID.getSteamID64(), '/code -получить код ESCROW');
            steam.chatMessage(steamID.getSteamID64(), '/show - показать инвентарь');
            steam.chatMessage(steamID.getSteamID64(), '/send [] -  отправить нужный предмет');
            steam.chatMessage(steamID.getSteamID64(), '/sendallitems -  отправить все предметы');
            steam.chatMessage(steamID.getSteamID64(), '/end = закончить текущий раунд досрочно');


        }
    }
    getUserInfo(steamID.getSteamID64(), function(error, data) {
        if (error) throw error;
        var datadec = JSON.parse(JSON.stringify(data.player));
        var name = datadec.name;
        logger.info('STEAM ==>' + name + ': ' + message); // Log it
    });
});