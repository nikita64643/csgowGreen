var socketIO = io(':8305',{'max reconnection attempts':Infinity});	
 var loggedinn = false;
$(document).ready(function($) {	
particlesJS.load('particles-js', 'assets/particlesjs.json', function() { 
console.log('callback - particles.js config loaded'); 
});
var wheelSVG = $();
      var spinner = $();
      var centerText = $();
      var beforeLoginSpinInterval;
      var brown = {fill: "#6d4c41"};
      var red = {fill: "#f44336"};
      var green = {fill: "#4caf50"};
      var black = {fill: "#212121"};
	  loggedinn = $("#loggedin").text() == 'true';
	  if(!loggedinn) {
		  $(".bonus-game-calc").css("opacity",0.2);
		  $(".bonus-game-auth").css("display","block").css("margin-top","133px");
	  }
      $("object").load(function() {
        wheelSVG = $("object").contents().find("svg");
        spinner = spinner.add(wheelSVG.find("#spin"));
        center = wheelSVG.find("#ui ellipse");
        centerText = wheelSVG.find("#number");
        clearInterval(beforeLoginSpinInterval);
        if(!loggedinn) {
          beforeLoginSpinInterval = setInterval(function() {
            currentRotation += 0.25;
            spinner.css("transform", 'rotate('+currentRotation+'deg)');
          }, 20);
        }
      });
      setTimeout(function() {
        wheelSVG = $("object").contents().find("svg");
		console.log(wheelSVG);
        spinner = spinner.add(wheelSVG.find("#spin"));
        centerText = wheelSVG.find("#number");
        clearInterval(beforeLoginSpinInterval);
        if(!loggedinn) {
          beforeLoginSpinInterval = setInterval(function() {
            currentRotation += 0.25;
            spinner.css("transform", 'rotate('+currentRotation+'deg)');
          }, 10);
        }

        $('.wheel').click(function() {
          $('.free-coins-card').stop().animate({top:'-35%'}, 500, 'easeInCirc');
        });
      }, 2000);



      var currentRotation = 0;
      var numberOrder = [1,8,2,9,3,10,4,11,5,12,6,13,7,14,0].reverse();
      var curNum = 0;
      setInterval(function(){
            var angle = currentRotation + 12;
            angle%=360;
            curNum = numberOrder[Math.floor(angle/24)];
            centerText.text(curNum);
            if(!loggedinn) {
              var cla = curNum == 0 ? green : ((curNum >= 1 && curNum <= 7) ? black : red);

              center.css(cla);
            }
            $("#past-rolls").css("height", $("#past-rolls").width()/10);
            $(".past-roll").css("font-size", $(".past-roll").width()*(1/2));
      },5);






			$.ajax({
            type: "get",
            url: "/api/allstatdouble",
			dataType: 'json',
            success: function(data) {
				var player = data.players;
				var progres = data.progress;
				for(var i=0; i<player.length; i++) {
                       socketIO.emit('double', {
                            name: player[i].name,
							ava: player[i].ava,
							point: player[i].coin,
							color: player[i].color,
                        });
				}
				        socketIO.emit('double', {
                            zero: progres[0].zero,
							red: progres[0].red,
							black: progres[0].black,
							game: progres[0].game,
							redpoint:progres[0].redpoint,
							blackpoint:progres[0].blackpoint,
							zeropoint:progres[0].zeropoint,
                        });

            }
        });	
	socketIO.on('double', function(data){
		$("#zero").css({width:data.zero+'%'});
		$("#red").css({width:data.red+'%'});
		$("#black").css({width:data.black+'%'}); 
		$("#redpoint").text(data.redpoint); 
		$("#blackpoint").text(data.blackpoint); 
		$("#zeropoint").text(data.zeropoint); 
		$(".game-num").text(data.game); 
		if(typeof data.name !='undefined'){
			 $(".game-bets-list").prepend('<li class="bonus-game-bet '+data.color+' showed magictime slideLeftRetourn"><div class="bonus-game-bet-user-info"><div class="avatar" style="background-image: url(&quot;'+data.ava+'&quot;);"></div><div class="user-name">'+data.name+'</div></div><div class="bet-value">'+data.point+'</div></li>');
		}
	});
$(".bonus-game-calc-button.all").click(function() {
	var g = $('.bonus-user-value').text();
	  $("#bet").val(parseInt(g));
});	
$(".bonus-game-calc-place-bet").click(function() {
	var c = $(this).data("bet-type");
	switch (c) {
                case "zero":
                case "red":
                case "black":
                    break;
                default:
                    return
            }
			$.ajax({
            type: "POST",
            url: "/sys/api.php",
            data: {
                act: 'addpoint',
                color: c,
				point: $("#bet").val(),
            },
			dataType: 'json',
			error: function(msg) {
                var n = noty({
                    timeout: '2000',
                    theme: 'warningnoty',
                     layout: 'topRight',
                    text: 'Ошибка,возможно вы указали неверное число!'
                });
            },
            success: function(html) {
				console.log(html);
                       socketIO.emit('update', {
						    black: html.black,
                            name: html.name,
							ava:html.ava,
							point:html.point,
							zero:html.zero,
							color:html.color,
							red:html.red,
							redpoint:html.redpoint,
					        zeropoint:html.zeropoint,
				         	blackpoint:html.blackpoint,
                        });
						
            }
        });	
 						
	
});	
$(".bonus-game-calc-button.value").click(function() {
	  var b = parseInt($("#bet").val()),
            c = $(this).data("method"),
			  d = parseInt($(this).data("value"));         
                var e;
                switch (c) {
                    case "plus":
                        e = b + d;
                        break;
                    case "multiply":
                        e = b * d;
                        break;
                    case "divide":
                        e = b / d;
                        break;
                    default:
                        console.log("Not found method update bet")
                }
                $("#bet").val(parseInt(e));      
});

$(".row.bets button").click(function() {	
    var color = $(this).data("color");	
		 $.ajax({
            type: "POST",
            url: "/sys/api.php",
            data: {
                act: 'addpoint',
                color: color,
				point: $("#bet").val(),
            },
            success: function(html) {
               var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: html
                });
            }
        });	
	
});
});