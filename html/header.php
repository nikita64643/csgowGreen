<?php
require 'blocked.php';
foreach($ip_blocked as $ip){
	if ($ip==$ip_address){
		die('Your IP address, '.$ip_address.'has been blocked.');
	}
	
}
?>
<!DOCTYPE html>
<html lang="en" class="bets-layout">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<title><?php echo $SaitBrand; ?> | Вступай и выигрывай</title>

	<!-- Fonts -->
     	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300&subset=latin,cyrillic,latin-ext,cyrillic-ext"rel='stylesheet' type='text/css'>
	<!-- JS -->	
	    
		<script type="text/javascript" src="/style/js/socket.js"></script>
   <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="/style/js/controls.js"></script>
		<script type="text/javascript" src='/style/js/jquery.noty.packaged.min.js'></script>
		<script type="text/javascript" src="/style/js/jquery.tooltipster.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
		<script src="/style/js/particles.js"></script>
		<link href="/style/css/style.css"  rel="stylesheet">
		<link href="/style/css/anim.css"  rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="../oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" tppabs="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="../oss.maxcdn.com/respond/1.4.2/respond.min.js" tppabs="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- head counters start -->
		
	<!-- head counters end -->
</head>

<body data-websockets-domain="" data-steamid="" data-currency-multiplier="1">
<script>
particlesJS.load( 'style/js/particlesjs.json', function() { 
console.log('callback - particles.js config loaded'); 
});
</script>
<div id="ajaxloader1"></div>
	<!-- body counters start -->
		
	<!-- body counters end -->
	<center><div id="wrapper">
		<header id="header">
			<div class="logo-holder">
				<strong class="logo"><a href="/" tppabs="/">logo-hunter</a></strong>
			</div>
			<ul>
						
				<li class="stat2">
					<span class="item2" ><span class="selector-stat-unique-players">0</span><i class="icon-rouble"></i></span>
					<p><?php echo $msg['raffled']; ?></p>
				</li>
				<li class="stat3">
					<span class="item3"><span class="selector-stat-today-matches">0</span><i class="icon-gamepad"></i></span>
					<p><?php echo $msg['seg_igr']; ?></p>
				</li>
				<li class="stat4">
					<span class="item4"><span class="selector-stat-max-sum">0</span><i class="icon-award-1"></i></span>
					<p><?php echo $msg['max_win']; ?></p>
				</li>
				<?php if (isset($_SESSION['steamid'])) { ?>	
				
				<li class="stat5" >		
<a data-modal="pay" class="md-trigger" style="cursor:pointer;">				
					<span class="item4"><span class="selector-stat-balans"><?php echo round($_SESSION['money']); ?></span>₽</span>
					<p style="color:#c5c5c5;"><?php echo $msg['refill']; ?></p>	</a>				
				</li>
			
				<?php } ?>
			</ul><?php if (isset($_SESSION['steamid'])) { ?>	
							<a class="btn" href="/sys/api.php?exit"><i class="icon-steam"></i><span><?php echo $msg['my_out']; ?></span></a>
			<?php } else { ?>	
		                 	<a class="btn" href="/?login"><i class="icon-steam"></i><span><?php echo $msg['login']; ?></span></a>
			<?php } ?>	
			<a href="#" class="user-count">
				<div class="close">
					<i class="icon-user"></i>
					<span class="selector-online-users">0</span>
				</div>
				<div class="open">
					<div class="holder">
						<span class="selector-online-users">0</span>
						<p><?php echo $msg['online']; ?></p>
					</div>
				</div>
			</a>
	<div class="language-change">
				
				<?php if($lang == "ru") {
					echo '<a href="/api/ru">
						<span class="tooltip"><span class="text">Русский</span></span>
						<img src="/style/images/lang-ru.png" alt="Русский" style="">
					</a>
					<a href="/api/en">
						<span class="tooltip"><span class="text">English</span></span>
						<img src="/style/images/lang-en.png" alt="English" style=" opacity: 0.25; ">
					</a>';
				}
                      else if($lang == "en") {
						  echo'				<a href="/api/ru">
						<span class="tooltip"><span class="text">Русский</span></span>
						<img src="/style/images/lang-ru.png" alt="Русский" style="opacity: 0.25; ">
					</a>
					<a href="/api/en">
						<span class="tooltip"><span class="text">English</span></span>
						<img src="/style/images/lang-en.png" alt="English" style="">
					</a>';
					  }
					  
					  ?>
				</div>
		
		</header>
			





