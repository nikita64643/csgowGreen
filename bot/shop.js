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
var config  = require('./config.js');
///////////////////////////Логер/////////////////////////////////
var logger = new (Winston.Logger)({
	transports: [
		new (Winston.transports.Console)({
			colorize: true,
			level: 'debug'
		}),
		new (Winston.transports.File)({
			level: 'info',
			timestamp: true,
			filename: 'shop.log',
			json: false
		})
	]
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Настройки рулетки
var sitename = config.domain;

//Настройки MYSQL
var mysqlInfo = {
    host: config.mysql.host,
    user: config.mysql.user,
    password: config.mysql.pass,
    database: config.mysql.database,
    charset: 'utf8_general_ci'
}
fs.readFile('keyshop', 'utf8', function (err, data) {
    if (err) {
        logger.debug("Ключ не найден,используем пароль!");
            steam.logOn({
                accountName: config.shopBot.username,
                password: config.shopBot.password,
                twoFactorCode: SteamTotp.generateAuthCode(config.shopBot.shared_secret),
                rememberPassword: true
             });
    } else {
        logger.debug("Найден ключ!Импортируем...");
            steam.logOn({
                accountName: config.shopBot.username,
                loginKey: data,
                twoFactorCode: SteamTotp.generateAuthCode(config.shopBot.shared_secret),
                rememberPassword: true
            });
    }
});

function getSHA1(bytes) {
    var shasum = require('crypto').createHash('sha1');
    shasum.end(bytes);
    return shasum.read();
}
client.on('loginKey', function (key) {
    fs.writeFile("keyshop", key, function (err) {
        if (err) {
            return console.log(err);
        }
         logger.info("Новый ключ сохронён!");
    });
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var mysqlConnection = mysql.createConnection(mysqlInfo);
var manager = new TradeOfferManager({
    "steam": steam,
    "domain": "localhost",
    "language": "en",
    pollInterval: 10000,
	cancelTime: 300000
})
manager.on('pollData', function (pollData) {
    fs.writeFile('polldata.json', JSON.stringify(pollData));
});
manager.on('newOffer', function(offer) {
	try{
    console.log('>>>>>>> Распознал трейд <<<<<<<<<<<<');
	if (config.admins.indexOf(offer.partner.getSteamID64()) != -1 && offer.itemsToGive.length > 0) {
		logger.info('Админ ' + offer.partner.getSteam3RenderedID() + ' забрал вещи с бота!');
		offer.accept(function(err) {
			if (err) {
				logger.error('Ошибка принятия трейда ' + offer.id + '!Ошибка: ' + err.message);
			} else {
				logger.info('Обмен принят');
			}
		});
	}else if (config.admins.indexOf(offer.partner.getSteamID64())!= -1) {
				var items = [];
                var checker = true;
                var itemsString = "";
                var totalPrice = 0;
                var cost = 0;
				var price = 0;
                var items = offer.itemsToReceive;
                var itemsObj = new Array(items.length);
				items.forEach(function(item, i, arr) {
                    request('http://' + sitename + '/sys/api.php?cost=' + encodeURIComponent(item.market_hash_name), function(error, response, body) {
                        if (!error && response.statusCode === 200) {						
                            if (body.indexOf('+-') > -1) {
                               offer.decline();	 
                               logger.info('Не найдена цена в базе!Добавление отменено');
							   return;
                            } else {	
                                offer.accept(function(err, response) {	
                                                        if(err)	{
															logger.info('Стим лагает,не смог принять!');
														}							
                                                        var marketname1 = item.type;                                                   
                                                        var color = '';
                                                        if (marketname1.indexOf('Mil-Spec') > -1) {
                                                            color = 'Армейское качество';
                                                        } else if (marketname1.indexOf('Industrial grade') > -1) {
                                                            color = 'Промышленное качество';
                                                        } else if (marketname1.indexOf('Restricted') > -1) {
                                                            color = 'Запрещенное';
                                                        } else if (marketname1.indexOf('Classified') > -1) {
                                                            color = 'Засекреченное';
                                                        } else if (marketname1.indexOf('Case') > -1) {
                                                            color = 'Кейс';
                                                        } else if (marketname1.indexOf('Covert') > -1) {
                                                            color = 'Тайное';
                                                        } else if (marketname1.indexOf('High Grade') > -1) {
                                                            color = 'высшего класса';
                                                        } else {
                                                            color = 'Бомжо';
                                                        }
													    var rarity = '';
														var marketname = item.market_hash_name;
                                                        if (marketname.indexOf('Field-Tested') > -1) {
                                                            rarity = 'После полевых испытаний';
                                                        } else if (marketname.indexOf('Minimal Wear') > -1) {
                                                            rarity = 'Немного поношенное';
                                                        } else if (marketname.indexOf('Battle-Scarred') > -1) {
                                                            rarity = 'Закаленное в боях';
                                                        } else if (marketname.indexOf('Well-Worn') > -1) {
                                                            rarity = 'Поношенное';
                                                        } else if (marketname.indexOf('Factory New') > -1) {
                                                            rarity = 'Прямо с завода';
                                                        } else {
                                                            rarity = 'Я хз что это';
                                                        }
								   cost = parseFloat(body);				
 								   price = cost *0.75;
                                   console.log('Выставлен '+item.market_hash_name+'по цене' + price+'.Цена стим '+cost);							
                                   mysqlConnection.query('INSERT INTO `shop_content` (`title`,`img`,`lod`,`price`,`rarity`,`market_name`,`steam_price`) VALUES (\'' + item.market_hash_name + '\',\'' + item.getLargeImageURL() + '\',\'' + color + '\',\'' + price + '\',\'' + rarity + '\',\'' + item.market_hash_name + '\',\'' + cost + '\')', function(err, row, fields) {});
								});
                         }
                       
                        }
                    });
                });
			

	}else if( offer.itemsToGive.length < 0) {
		var items = [];
                var checker = true;
                var itemsString = "";
                var totalPrice = 0;
                var cost = 0;
				var price = 0;
                var items = offer.itemsToReceive;
                var itemsObj = new Array(items.length);
				items.forEach(function(item, i, arr) {
                    request('http://' + sitename + '/sys/api.php?cost=' + encodeURIComponent(item.market_hash_name), function(error, response, body) {
                        if (!error && response.statusCode === 200) {						
                            if (body.indexOf('+-') > -1) {
                               offer.decline();	
                               
                               logger.info('Не найдена цена в базе!Добавление отменено');
							   return;
                            } else {	
                                offer.accept(function(err, response) {							
								  								mysqlConnection.query('SELECT `value` FROM `info` WHERE `name`=\'prozpay\'', function(err, row, fields) {
                                   var comis = (row[0].value);					
								   cost = parseFloat(body);				
 								   price = cost *comis;
                                   console.log('Пополнил профиль  '+ offer.partner.getSteamID64() +' на ' + price);							
                                   mysqlConnection.query('UPDATE `account` SET money=money+'+price+' WHERE `steamid` = \'' + offer.partner.getSteamID64() + '\'', function(err, row, fields) {});
								});
								});
                         }
                       
                        }
                    });
                });
	}else{
		offer.decline();
	}
	} catch (err) {
      console.log(err);
    }
});




function addslashes(str) {
    str = str.replace(/\\/g, '\\\\');
    str = str.replace(/\'/g, '\\\'');
    str = str.replace(/\"/g, '\\"');
    str = str.replace(/\0/g, '\\0');
    return str;
}

var itemscopy;
var endtimer = -1;
steam.on('webSession', function (sessionID, cookies) {
        manager.setCookies(cookies, function (err) {
           if (err) {
            logger.error('Не могу получить куки,ошибка: ' + err);
            process.exit(1);
           }
		   logger.info("API ключ: " + manager.apiKey);
        });
		client.setCookies(cookies);	
		client.startConfirmationChecker(30000, config.shopBot.identity_secret);
});
steam.on('accountLimitations', function(limited, communityBanned, locked, canInviteFriends) {
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
	if (!canInviteFriends) {
		logger.warn('Невозможно добавлять в друзья!На аккаунте ограничения!')
	}
});
manager.on('sentOfferChanged', function (offer, oldState) {

    if (offer.state == TradeOfferManager.ETradeOfferState.Accepted) {
        logger.info("Офер #" + offer.id + " был принят!");
    }
	if (offer.state == TradeOfferManager.ETradeOfferState.Decline) {
        logger.info("Офер #" + offer.id + " был отклонён");
    }
});
manager.on('pollFailure', function(err) {
	logger.error('Стим лагает!Ошибка торговых сделок: ' + err);
});
steam.on('error', function (e) {
    console.log(e);
    process.exit(1);
});
steam.on('loggedOn', function(result) {
	if (result.eresult === Steam.EResult.OK) {
	  logger.info('==============================Информация===============================');
	  logger.info('Авторизован под  steamid:'+steam.steamID.getSteamID64()+'');
	  steam.on('emailInfo', function(address, validated) {
	     logger.info("Почта : " + address + " " + (validated ? "Привязана" : "Не привязана"));
      });
	  steam.on('wallet', function(hasWallet, currency, balance) {
	       logger.info("На счету: " + SteamUser.formatCurrency(balance, currency));
      });
	  logger.info("Привязан к сайту : " + config.domain);
	  mysqlConnection.query('SELECT * FROM `gamejack`', function(err, row, fields) {
		  if(err) {
		      logger.error("Ошибка подключения к бд : - " + err);
			  process.exit(1);
		  }
		  else logger.info("Подключение к БД "+config.mysql.database+ " успешно");
	  });
	  logger.info("Все процессы запущены,Начинаем работу!");
      steam.setPersona(Steam.EPersonaState.LookingToTrade, config.name+' SHOP');
	  for (var i = 0; i < config.admins.length; i++) {	 
		  steam.addFriend(config.admins[i]);
		  logger.info(config.admins[i]+' Добавили в друзья')
	  }
      steam.gamesPlayed(config.name+ " Магазин/Shop");
	  setInterval(sendoffers, 10000);
	}
	
	
});

client.on("newConfirmation", function(confirmation) {
	console.log("New confirmation");
	processConfirmation(confirmation, function(passed) {
		console.log(passed);
	});
});

client.on("confKeyNeeded", function(tag, callback) {
	console.log("Confirmation key needed");
	var time = Math.floor(Date.now() / 1000);
	console.log(callback.toString());
	callback(null, time, SteamTotp.getConfirmationKey(config.shopBot.identity_secret, time, tag));
});
function processConfirmation(confirmation, callback) {
	var time = Math.floor(Date.now() / 1000);
	var key = SteamTotp.getConfirmationKey(config.shopBot.identity_secret, time, "conf");
	client.respondToConfirmation(confirmation.id, confirmation.key, time, key, true, function (err) {
		console.log("Responding to confirmation "+confirmation.id);
		var ret = true;
		if (err != null) {
			console.log(err);
			ret = false;
			console.log("Responding to confirmation "+confirmation.id+" failed");
		} else {
			console.log("Responding to confirmation "+confirmation.id+" succeeded");
		}

		if (typeof(callback) == "function") {
			callback(ret);
		}
	});
}
function weblogon() {
   steam.on('webSession', function(sessionID, cookies) {
        manager.setCookies(cookies, function (err) {
           if (err) {
            logger.error('Не могу получить куки,ошибка: ' + err);
            process.exit(1);
           }
		   logger.info("API ключ: " + manager.apiKey);
        });
		client.setCookies(cookies);	
		client.startConfirmationChecker(30000, config.shopBot.identity_secret);
		setInterval(sendoffers, 1000);
    });
}
function sendoffers() {
    manager.loadInventory(730, 2, true, function(err, myItems) {
        mysqlConnection.query('SELECT * FROM `shop` WHERE `status`=\'active\'', function(err, row, fields) {
            if (err) {
                return;
            }
            for (var i = 0; i < row.length; i++) {
				logger.info('Появился предмет на отправку');
                if (row[i].steamid != "" && row[i].token != "" && row[i].items != "") {
					logger.info('Проверка трейд ссылки');
                    var gameid = row[i].id;
                    var sendItems = (row[i].items).split('/');
                    var offer = manager.createOffer(row[i].steamid);
                    for (var x = 0; x < myItems.length; x++) {
                        for (var j = 0; j < sendItems.length; j++) {
                            if (myItems[x].tradable && (myItems[x].market_name).indexOf(sendItems[j]) == 0) {
							  sendItems[j] = "hgjhgnhgjgnjghjjghjghjghjhgjghjghjghngnty";
                               offer.addMyItem(myItems[x]);
							   logger.info(myItems[x]);
                            }
                        }
                    }
                       offer.send("Ваши вещи с сайта"+config.name, row[i].token, function(err, csgo) {
					    if (err) {
						     logger.info('Ошибка:'+err);
							 weblogon();
							 mysqlConnection.query('UPDATE `shop` SET `status`=\'nosent\',`err`=\''+err+'\' WHERE `id`=\''+gameid+'\'', function(err, row, fields) {});
                           return;
					    }else{
						     mysqlConnection.query('UPDATE `shop` SET `status`=\'sent\' WHERE `id`=\''+gameid+'\'', function(err, row, fields) {});
					
						}		                           
                          });
                       

                    
                }
            }
        });
    });
}


