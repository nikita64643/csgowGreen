function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function get_cookie (cookie_name){
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}
var sound = get_cookie('sound') == 'true';
var chat = get_cookie('chat') == 'true';
jQuery(document).ready(function ($) {
    var margintop = 0;
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#slider').css({ width: 439, height: 220 });
	
	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
		return false;
    });

    $('a.control_next').click(function () {
        moveRight();
		return false;
    });
	$(".test").click(function(){
		if(sound){
			$('#newitem')[0].play();
		}
		
	});
    $('.toggle').mousedown(function () {
        if(sound){	
		    $("#soundon").text('false');
			setCookie("sound", "false", "", "/");
			sound = false;
			console.log(sound);
		}else{
			$("#soundon").text('true');
			sound = true;
			console.log(sound);
			setCookie("sound", "true", "", "/");
		}
    });
});    
function tooltip(){
	 $('.tooltip').tooltipster();
	 $('.tooltipanim').tooltipster({
     animation: 'grow',
     delay: 200,
     theme: 'tooltipster-default',
     touchDevices: false,
     trigger: 'hover'
    });
}
var circle, bets = 100500,
    timeleft = 180,
    ms = 1000;
var load_in_process = false;
function chatopen(){
	            if ($('#chatBody').is(':visible')) {
					$("#chatBody").slideUp('slow');
				    setCookie("chat", "false", "", "/");
					$('#chatHeader').removeAttr( 'style' );
                }
                else {
					$("#chatBody").slideDown('slow');
	                $('#chatScroll').css('height', $(window).height() -558);
	                $('#chatScroll').css('max-height', $(window).height()-558);
					$('#chatHeader').css('height', 30);
			    	$('#chatHeader').css('line-height', '36px');
					setCookie("chat", "true", "", "/");			
                }	
}
$(document).ready(function($) {	
    $('#ajaxloader1').fadeOut('slow');
    if(chat){
		chatopen();
	}
    $('#chatHeader').click(function() {
			chatopen();         
    });
    tooltip();
	$('body').on('click', '.up-window-smile', function() {
        $('.all-smiles-window').fadeIn(500);
		return false;
    });

    $('body').on('click', '#closebtn', function() {
        $('.all-smiles-window').fadeOut(500);
		return false;
    });
	$('.smile-item img').click(function() {	
        var names = ':' + $(this).attr('alt') + ': ';
        var valchat = $('#chatInput').val();
        $('#chatInput').val(valchat + names);
    });
	
	$('.coderefill').click(function(){
		var code = $('.coderefll').val();
		$.ajax({
        url: "/sys/api.php",
        data: "activcode="+code,
        type: 'GET',
           success: function(data) {
                var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                     layout: 'topRight',
                    text: data
                });
           }
        })
		return false;
	});
	$('.invent').click(function() {
		if($('#inventoryid').is(':hidden')){
			$("#inventoryid").slideDown('slow');
			$("#gameid").slideUp('slow');
		}
		return false;
	});
		$('.gamehis').click(function() {
		if($('#gameid').is(':hidden')){
			$("#gameid").slideDown('slow');
			$("#inventoryid").slideUp('slow');
		}
		return false;
	});
    $('.loadmore').click(function() {
        var page = parseInt($(this).attr('data-page'));
        page++;
        $(this).attr('data-page', page);
        $.ajax({
            url: './sys/api.php?pagejackpot=' + page,
            type: "GET",
            beforeSend: function() {
                $('.loadmore').addClass('load');
            },
            success: function(data) {
                if (data != 'false') {
                    $('.loadmore').removeClass('load');
                    $('.history-matches').append(data);
                } else {
                    $('.loadmore').removeClass('load');
                    $('.loadmore').hide();
                }
            }
        });
        return false;
    }); 
        setInterval("Load();", 2000);
		setInterval("init();", 2000);
		$("#chatInput").keypress(function(e){
         if(!(e.keyCode == 13&&e.shiftKey)){
          if(e.keyCode == 13){
            Send();
          }
         }
        });
});

function init() {
    $.ajax({
        url: "/sys/api.php",
        data: "allstatgame",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
			$('.selector-online-users').html(data['online']);
			$('.selector-stat-unique-players').html(data['itemsall'])
			$('.selector-stat-today-matches').html(data['today'])
			$('.selector-stat-max-sum').html(data['maxwin'])
			$('.selector-stat-balans').html(data['balans'])
        }
    })

}


function sendComm(pageid) {
    var comment = $("#com_text").val();
    $('#com_text').val('');
    if (comment == '') {
        var n = noty({
            timeout: '2000',
            theme: 'warningnoty',
             layout: 'topRight',
            text: 'Текст для коментария пуст'
        });
    } else {
        $.ajax({
            type: "POST",
            url: "./sys/profile.php",
            data: {
                id: pageid,
                comment: comment
            },
            error: function(msg) {
                var n = noty({
                    timeout: '2000',
                    theme: 'warningnoty',
                     layout: 'topRight',
                    text: 'Ошибка'
                });
            },
            success: function(html) {
                $("#commentspag").append(html);
            }
        });
    }
    return false;
};
////////////////////////Покупка карточек//////////////


function buyMesto(id, btn) {
    $.ajax({
        url: "/sys/api.php",
        data: {
			act: 'buyspot',
            mesto: id,
            game: btn,
        },
        type: 'POST',
        success: function(data) {
            $.noty.closeAll();
            getspotdeteil(btn);
            var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: data
            });


        }
    })
};



//Функция сохранения ссылки на обмен --------------------------------------------------------------------		
function SaveUrl() {
    var link = $('.save-trade-link-input').val();
    if (link.indexOf('&token=') < 0) {
        var n = noty({
            timeout: '2000',
            theme: 'successnoty',
             layout: 'topRight',
            text: 'Введите правильную ссылку'
        });
    } else {
        $.ajax({
            url: "/sys/api.php",
            data: {
				act: "savetrade",
                linktr: link,
            },
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $.noty.closeAll();
                if (data && data['status'] == true){
                    var n = noty({
                        timeout: '2000',
                        theme: 'successnoty',
                         layout: 'topRight',
                        text: 'Ваша ссылка успешно сохранена'
                    });
				}
                if (data && data['status'] == false)
                    var n = noty({
                        timeout: '2000',
                        theme: 'warningnoty',
                         layout: 'topRight',
                        text: 'Ошибка отправки<br/>СВЯЖИТЕСЬ С АДМИНОМ'
                    });
            }
        })
    }
};


function getgamehis(game) {
    $.ajax({
        type: "GET",
        url: "/sys/api.php?getgamehis=" + game,
        success: function(msg) {
            $('#modalcontent').html(msg);
			$('#modalhead').html('История игры');

        }
    });

}



function getspot() {
    $.ajax({
        type: "GET",
        url: "./sys/spot-api.php?spot=game",
        success: function(msg) {
            $('#spots').html(msg);
        }
    });
}

function getspotdeteil(id) {
    $.ajax({
        type: "GET",
        url: "/sys/api.php?spotdeteil=" + id,
        success: function(msg) {
            $('#spotgame').html(msg);
        }
    });
}
//Релизация профилья игрока --------------------------------------------------------------------		
function getProf(steamid) {   
    $.ajax({
        type: "GET",
        url: "./sys/profile.php?steamids=" + steamid,
        success: function(data) {
			$('#profileclass').html(data);
			gethistoryid(steamid);
        }
    })
}
//===============================================================================================
//Релизация чата для сайта --------------------------------------------------------------------		
function Send() {
    if ($("#chatInput").val().trim() == "") {
        var n = noty({
                        timeout: '2000',
                        theme: 'warningnoty',
                        layout: 'topRight',
                        text: 'Введите сообщение для отправки !'
                    });
        $("#chatInput").val('');
        return false;
    } else {		
        $.ajax({
            url: "/sys/api.php",
            data: {
                act: "send",
                text: $("#chatInput").val().trim(),
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $.noty.closeAll();
                if (data && data['status'] == false)
                    var n = noty({
                        timeout: '2000',
                        theme: 'warningnoty',
                         layout: 'topRight',
                        text: data['msg']
                    });
            }
        })
		$("#chatInput").val('');
        $("#pac_text").val("");
        $("#pac_text").focus();
        return false;
    }
}

function lastwin() {
    $.ajax({
        type: "GET",
        url: "./sys/profile.php?lastwin=name",
        success: function(msg) {
            $("#lastwin").html(msg);
        }
    });
};

function shop() {
    $.ajax({
        type: "GET",
        url: "./sys/shop.php?shop=name",
        success: function(msg) {
            $("#shopstory").html(msg);
        }
    });
};

function getinventoryid() {
	 $("#inventoryload").html("<center>Идёт обновление инвентаря <img src=\"/style/images/loading.gif\"></center>");
     $.ajax({
        type: "GET",
        url: "/api/insertinventory",
        success: function(msg) {			
            $("#onlyupdate").html(msg);
			$("#inventoryid").slideDown('slow');
			
        }
    });
};
function joinf() {
    $.ajax({
        type: "GET",
        url: "/sys/api.php?joinf",
        success: function(msg) {
                var n = noty({
                        timeout: '2000',
                        theme: 'warningnoty',
                         layout: 'topRight',
                        text: msg
                    });   
             updateGiveaway();				
        }
    });
};


function gethistoryid(steamid) {
	$("#deposit-txt-info2").text("Список игр");
    $("#updateprof").text("Идёт поиск игр");
	$.ajax({
        type: "GET",
        url: "/sys/api.php?myhistory=" + steamid,
        success: function(msg) {
            $("#updateprof").html(msg);
        }
    });
};

function getComments(steamid) {

  $(".user-profile-content").html('<center><div class="shaft-load11"><div class="shaft1"></div><div class="shaft2"></div><div class="shaft3"></div><div class="shaft4"></div><div class="shaft5"></div><div class="shaft6"></div><div class="shaft7"></div><div class="shaft8"></div><div class="shaft9"></div><div class="shaft10"></div></div></center>');
  $.ajax({
        type: "GET",
        url: "./sys/profile.php?comments=" + steamid,
        success: function(msg) {
            $(".user-profile-content").html(msg);
        }
    });
};

function Load() {
    if (!load_in_process) {

        load_in_process = true;
        $.post("/sys/api.php", {
                act: "load",
            },
            function(result) {
				$("#chat_area").html(result);
                $("#chatScroll").scrollTop($("#chatScroll").get(0).scrollHeight);
                load_in_process = false;
            });
    }
}

function delcom(id) {
    $.ajax({
        url: "./sys/api.php",
        data: {
            id: id,
            act: 'del',
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {

        }
    })
}

function bansteam(id) {
    $.ajax({
        url: "./sys/api.php",
        data: {
            steamid: id,
            act: 'ban',
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {

        }
    })
}



function errorpay() {
    var n = noty({
        timeout: '3000',
        theme: 'warningnoty',
         layout: 'topRight',
        text: 'Не удалось произвести оплату'
    });
};
function notradelink() {
    var n = noty({
        timeout: '3000',
        theme: 'warningnoty',
         layout: 'topRight',
        text: 'Пожайлуста,введите ссылку для обмена в личном кабинете!'
    });
	return false;
};
function successpay() {
    var n = noty({
        timeout: '3000',
        theme: 'successnoty',
         layout: 'topRight',
        text: 'Оплата произведена успешно,благодарим за покупку!'
    });
};



















