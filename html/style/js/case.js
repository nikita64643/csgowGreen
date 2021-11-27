$(document).ready(function () {
	$('.purse').click(function() {
		$('.addmoney').slideToggle('slow');
	});
	$('.howto').click(function() {
		$('.faq').slideToggle('slow');
	});
	$('.faq-qs-one-q').click(function(){
		$('.faq-qs-one-a').hide();
		$(this).siblings('.faq-qs-one-a').show();
	});

	$('.plink.start').click(function(){
		$('.profil-tabs').slideToggle();
	});
	$('.p-set').click(function() {
		if($(this).hasClass('current'));
		var index = $('div', $(this).parent()).removeClass('current').index(this);
		$(this).addClass('current').parents('.profil .rcol').find('.profil-tabs-in').hide().eq(index).fadeIn('slow');
		return false;
	});
});
$(document).ready(function(){
            $('.spoiler_title').click(function(){ // при клике по заголовку спойлера
                var show = $(this).attr('show'); // проверяем атрибут, в котором записано - отображен спойлер или скрыт
                if(show == 1){ // если отображен, то прячем
                	$(this).attr('show', 0);
                	$('#' + $(this).attr('data-block')).slideUp(300);
                }else{ // если спрятан, то показываем
                	$(this).attr('show', 1);
                	$('#' + $(this).attr('data-block')).slideDown(300);
                }
            });
        });
$(function(){
	
	$.getScript('/style/js/jquery-ui.custom.min.js');

	var __rand = function(min, max){
		return Math.round(Math.random() * (max - min - 1)) + min;
	};

	var apiUrl = '/sys/api.php';

	var __openCase = function(){	
		$('.opencase-bottom-open').hide();
		var id = $('.opencase-bottom-open').attr("data-id");
		console.log(id);
		$.ajax({
			url: '/sys/api.php',
			data: {
				act: "openCase",
				text: id,
			},
			type: 'POST',
		success: function(rdata){
			if('false' == rdata.result){
				switch(rdata.message){
					case 'no_money':
					$('.opencase-bottom-nofunds').show();
					break;
					case 'no_login':
					$('.opencase-bottom-auth').show();
					break;
					case 'no_items':
					$('.opencase-bottom-items').show();
					break;
					case 'no_case':
					$('.opencase-bottom-case').show();
					break;
					case 'stop_case':
					$('.opencase-bottom-case1').show();
					break;					
				}
			} else {
				__buildLine(rdata);
			}
		}
	});
	};
	
	var __buildLine = function(data){
		$('.opencase-top-case, .opencase-bottom-open').hide();
		$('.opencase-top-carousel, .opencase-bottom-opening').show();


		$('.opencase-top-carousel-line').html('');

		$.each(data.items, function(_, v){
			if(v.color == "uncommon") v.color = "#305f8d";
			if(v.color == "milspec") v.color = "#3f50be";
			if(v.color == "restricted") v.color = "#7339bd";
			if(v.color == "classified") v.color = "#bb22b6";
			if(v.color == "covert") v.color = "#d43c39";
			if(v.color == "rare") v.color = "#ddb401";

			$('<div>')
			.addClass('opencase-top-carousel-line-item')
			.appendTo('.opencase-top-carousel-line')
			.append(
				$('<div>')
				.addClass('opencase-top-carousel-line-item-image')
				.css('background-image', 'url(https://steamcommunity-a.akamaihd.net/economy/image/class/730/' + v.image + '/110fx82f)')
				)
			.append(
				$('<div>')
				.addClass('opencase-top-carousel-line-item-text')
				.css('background-color', v.color)
				.append(
					$('<div>').html(v.name_first)
					)
				.append(
					$('<div>').html(v.name_second)
					)
				);
		});
		$('.purse').html('Баланс: <span>'+data.balans+' <small>p</small></span>');
		var thing_win = data.items[data.win_slot];
$('.opencase-opened-drop').html(thing_win.name_first + ' | ' + thing_win.name_second);
$('.opencase-opened-image').css('background-image', 'url(//steamcommunity-a.akamaihd.net/economy/image/' + thing_win.image + '/110fx82f)');

var start = parseInt( $('.opencase-top-carousel-line').css('left') ),
slot_width = $('.opencase-top-carousel-line-item').outerWidth(true),
offset = (data.win_slot + Math.min(Math.max(Math.random(), .1), .9)) * slot_width,
position = 0,
interval = setInterval(function(){
	var offset = parseInt( $('.opencase-top-carousel-line').css('left') ) - start,
	position_actual = Math.floor(offset / slot_width);

	if(position_actual !== position){
			}
			position = position_actual;
		}, 10);


$('.opencase-top-carousel-line')
.css('left', '')
.animate({ left: '-=' + offset }, 4000, 'easeOutQuad', function(){
	clearInterval(interval);

	$('.opencase-top-carousel, .opencase-bottom-opening').hide();
	$('.opencase-top-case, .opencase-bottom-open').show();

	$('.opencase-top, .opencase-bottom').hide();
	$('.opencase-opened').show();
});

kek = apiUrl+"?action=sellItem&item_id="+data.info.item_id;
$('.opencase-opened-actions-one.s__sell')
.attr('href', kek)
.children('.opencase-opened-actions-one-text')
.html('Продать за ' + data.info.cost  + 'р');
	//$('.__inspect').attr('href', 'steam://rungame/' + data.info.ingame.ingame_appid + '/' + data.info.ingame.ingame_owner + '/+csgo_econ_action_preview%20' + data.info.ingame.ingame_hash);
};

$('.opencase-bottom-open').on('click', function(event){
	__openCase();
	
	event.preventDefault();
	return false;
});
$('.opencase-opened-actions-one.s__again').on('click', function(event){
	$('.opencase-opened').hide();
	$('.opencase-top, .opencase-bottom').show();
});

});