var socketIO = io(':2052'||':8304',{'max reconnection attempts':Infinity});	
var roulete = false;
function get_cookie (cookie_name){
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}
var sound = get_cookie('sound') == 'true';	
var openWin = function(msg) {
		 window.open(msg, 'steam', "scrollbars=1,height=800,width=1000");

}
$(document).ready(function($) {	
 setInterval("reloadinfo();", 1000);
	$.ajax({
        type: "GET",
        url: "/api/statplayer",
        dataType: 'json',
        success: function(data) {
				initTimer(data['time']); 
        }
    });
	socketIO.on('lastitems', function(data){
	    lastit();
	});
	socketIO.on('timer', function(data){
				$.ajax({
                    type: "GET",
                    url: "/api/statplayer",
                    dataType: 'json',
                    success: function(data) {
						console.log(data['time']);
						initTimer(data['time']); 
                    }
                });
	});
    $('#info_dialog_url_web').click(function () {
         openWin('https://steamcommunity.com/tradeoffer/new/?partner=150454320&token=0YX4dHhA');
		 return false;
    });
	$('#info_dialog_url').on("click",function(){
        $.ajax({
                    type: "GET",
                    url: "/api/jackidbota",
                    success: function(msg) {
						  document.location.href = "steam://url/SteamIDPage/"+msg;  						       
                    }
        });
		return false;
	})
	$('.bottom-game').hide();
	socketIO.on('lastitems', function(data){
           lastit();
	});
	socketIO.on('newitem',function(data){
            update ()
	});
	socketIO.on('end-game', function(data){
	$('.depositor').css({color:'#c5d3e6',background:'#5e6a79'}).addClass('inactive').text('Разыгрывается...');
    $.getJSON('/sys/api.php?statjsong='+data.game, function(data) {	
	if(!roulete){
	        roulete = true; 
			$(".part").slideUp('slow');
			$('#rulka').slideDown('slow', function () {			
            $users = $('.part').find('.block');
            var itemsTape = [];
            $.each($users, function(index, el) {
                var img_src = $(el).find('img').attr('src');
                var chance_field = $(el).find('.chance').text();
                var chance = parseFloat(chance_field.substr(0, chance_field.indexOf('%')));

                for (var i = 0; i <= chance; i++) {
                    itemsTape.push(img_src);
                }
            });

            function shuffle(o) {
                for (var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
                return o;
            }

            itemsTape = shuffle(itemsTape);

            itemsTape.splice(210, itemsTape.length - 210);

            if (itemsTape.length < 210) {
                var differ = 210 - itemsTape.length;
                for (var i = 0; i < differ; i++) {
                    itemsTape.push(itemsTape[0]);
                }
            }

            itemsTape[78] = data.win_avatar;

            $.each(itemsTape, function(i, v) {
				$('.players').append('<li id="'+i+'" class="player"><a href="javascript:;"><img class="selector-roulette-depositor-image" src="' + v + '"  height="61" width="61"></a></li>');	  
            });
            setTimeout(function() {
				if(sound){
					$('#scrollSlider')[0].play();
				    myVid=document.getElementById("scrollSlider");
			        myVid.volume=0.5;
				}
                $('.players').css('-moz-transform', 'translate3d(-7605px, 0, 0)');
                $('.players').css('-ms-transform', 'translate3d(-7605px, 0, 0)');
                $('.players').css('-o-transform', 'translate3d(-7605px, 0, 0)');
                $('.players').css('-webkit-transform', 'translate3d(-7605px, 0, 0)');
                $('.players').css('transform', 'translate3d(-7605px, 0, 0)');
                setTimeout(function() {
					lastwin();
                    $('#winbtn').text(data.win_name);
                    $('.selector-current-rul-prizepool').text(data.win_cost);
                    $('.selector-rul-chance').text(data.win_percent);
                }, 13000);
				setTimeout(function() {
					update ();
					$('.depositor').css({color:'#fff'}).removeClass('inactive').html('Сделать депозит [<span class="selector-depositor-items-counter">0</span>/<span class="selector-depositor-maxitems-counter">15</span>]');
					$('#newGame')[0].play();
					myVid=document.getElementById("newGame");
				    myVid.volume=0.5;
                    $("#rulka").slideUp('slow');
					$(".part").slideDown('slow');
                    $('#winbtn').text('Определяется победитель...');
                    $('.selector-current-rul-prizepool').text('0');
                    $('.selector-rul-chance').text('0');
                    $('.players').empty();
                    $('.players').css('-moz-transform', 'translate3d(458px, 0, 0)');
                    $('.players').css('-ms-transform', 'translate3d(458px, 0, 0)');
                    $('.players').css('-o-transform', 'translate3d(458px, 0, 0)');
                    $('.players').css('-webkit-transform', 'translate3d(458px, 0, 0)');
                    $('.players').css('transform', 'translate3d(458px, 0, 0)');
					roulete = false;
                }, 18000);
		

            }, 1000);
	
    });
	}
	});
    return;
});
});
function lastit (){
		$('.depositor').css({color:'#c5d3e6',background:'#5e6a79'}).addClass('inactive').text('Принятие последних ставок...');
}
function update (){

				$.ajax({
                    type: "GET",
                    url: "/api/itemsingame",
                    success: function(msg) {
                        $(".selector-rates").html(msg);
                    }
                });
				$.ajax({
                    type: "GET",
                    url: "/api/playergame",
                    success: function(msg) {
                        $(".part").html(msg);
                    }
                });
}
////////////////////////Рулетка////////////////////
function addTicket(btn) {
	if(btn<=0){
                var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: 'Ставка слишком мала!'
                });		
	}else{
	if(!roulete){
    $.ajax({
        url: "./sys/api.php",
        data: {
			 act: "buycard",
            card: btn,
        },
        type: 'POST',
        success: function(fus) {
            $.noty.closeAll();       
                var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: fus
                });
				socketIO.emit('newitem', {
                            name: 'card',
                });
        }
    })
}else{
	            var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: 'Дождитесь начала игры'
                });
}
	}
};
function lastwin(){
	            $.ajax({
                    type: "GET",
                    url: "/api/lastwinner",
                    success: function(msg) {
                        $(".last-winner").html(msg);
                    }
                });
}
////////////////////////***************////////////////////
function startCountdown(){
	
	initTimer("5:11"); 
	
}
var reloadBtn = document.querySelector('.reload');
var timerEl = document.querySelector('.timer--clock');

function initTimer (t) {
   
   var self = this,
       timerEl = document.querySelector('.timer--clock'),
       minutesGroupEl = timerEl.querySelector('.minutes-group'),
       secondsGroupEl = timerEl.querySelector('.seconds-group'),

       minutesGroup = {
          firstNum: minutesGroupEl.querySelector('.first'),
          secondNum: minutesGroupEl.querySelector('.second')
       },

       secondsGroup = {
          firstNum: secondsGroupEl.querySelector('.first'),
          secondNum: secondsGroupEl.querySelector('.second')
       };

   var time = {
      min: t.split(':')[0],
      sec: t.split(':')[1]
   };

   var timeNumbers;

   function updateTimer() {

      var timestr;
      var date = new Date();

      date.setHours(0);
      date.setMinutes(time.min);
      date.setSeconds(time.sec);

      var newDate = new Date(date.valueOf() - 1000);
      var temp = newDate.toTimeString().split(" ");
      var tempsplit = temp[0].split(':');

      time.min = tempsplit[1];
      time.sec = tempsplit[2];

      timestr = time.min + time.sec;
      timeNumbers = timestr.split('');
      updateTimerDisplay(timeNumbers);
     console.log();
      if(timestr == '0000'||timestr == '0200')
         clearInterval(timer);

   }

   function updateTimerDisplay(arr) {

          animateNum(minutesGroup.firstNum, arr[0]);
          animateNum(minutesGroup.secondNum, arr[1]);
          animateNum(secondsGroup.firstNum, arr[2]);
          animateNum(secondsGroup.secondNum, arr[3]);
      
   }

   function animateNum (group, arrayValue) {

      TweenMax.killTweensOf(group.querySelector('.number-grp-wrp'));
      TweenMax.to(group.querySelector('.number-grp-wrp'), 1, {
         y: - group.querySelector('.num-' + arrayValue).offsetTop
      });

   }
   if(t !='02:01'&&t !='00:00'){
	     var timer= setInterval(updateTimer, 1000);
   }

}


//Функция обновления информации JackPot --------------------------------------------------------------------	
function reloadinfo() {
    $.ajax({
        type: "GET",
        url: "/api/stat",
        success: function(state) {
            $('#statf').html(state);
            if (state.indexOf("waiting") != -1) {
				$.ajax({
                    type: "GET",
                    url: "/api/statplayer",
                    dataType: 'json',
                    success: function(data) {
						$(".selector-current-match-prizepool").html(data['bank']);
						$(".selector-depositor-chance").html(data['percent']);
						$(".selector-items-progress").css({width:data['width']+'%'});
						$(".selector-depositor-items-counter").html(data['items']);
						$(".selector-depositor-maxitems-counter").html(data['maxitems']);
						$(".selector-items-counter").html(data['width']);
						if(data['bank']=="0")  document.getElementsByTagName('title')[0].innerHTML = 'csgow.ru Испытай удачу!';
						else document.getElementsByTagName('title')[0].innerHTML = data['bank']+'руб. csgow.ru Испытай удачу!';
                    }
                });
            }
        }
    });

}