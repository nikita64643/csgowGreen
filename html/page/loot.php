 <div class="content">
	<!-- <middle> -->			<header class="head">
			<h2><?php echo $msg['rosdat1']; ?></h2>
		</header>

	<div class="about" style=" padding: 0; ">
<div class="info">
			<div>
				<ul>
					<li><?php echo $msg['norm1']; ?></li>
					<li id="webAPI"><font color="green">Нормально</font></li>
				</ul>
			</div>
			<div>
				<ul>
					<li><?php echo $msg['norm2']; ?></li>
					<li id="store"><font color="green">Нормально</font></li>
				</ul>
			</div>
			<div>
				<ul>
					<li><?php echo $msg['norm3']; ?></li>
					<li id="community"><font color="orange">Медленно</font></li>
				</ul>
			</div>
		</div>
					<?php
	            if(!isset($_COOKIE['sound'])) {
					$sound = 'true';
	                setcookie("sound","true");
                }else{
					$sound = $_COOKIE["sound"];
				}
				$mod='false';
				if (isset($_SESSION['steamid'])) { ?>	
                    <div class="mini-profile" style="width: 237px; margin-top:5px;margin: 0 auto; border-top-left-radius: 4px; border-top-right-radius: 4px; padding: 8px 7px; box-sizing: border-box; position: relative;">
						<a href="http://steamcommunity.com/profiles/<?php echo $_SESSION['steamid'];?> " target="_blank">
							
							<span class="tooltip"><span class="text">Привет, <?php echo $_SESSION['personaname'];?></span></span>
							
							<img src="<?php echo $_SESSION['avatarfull'];?>" style="width: 120px; height: 120px; box-sizing: border-box; border: 5px solid #2a2d36; border-radius: 50%;">
							<img src="/style/images/img/mini-profile-icon.png" class="mini-profile-icon">
						</a>
					</div>
					<?php 
					            
                    $mod = "true";                 
				    $win = mysql_query("SELECT * FROM `games` WHERE `userid`='".$_SESSION['steamid']."'"); 
				   	$i = 0;
				   	while ($thistop = mysql_fetch_array($CountFetchArrayPROF)) {
			           $i++;
					        if($thistop["steamid"]==$_SESSION['steamid']){
								$rank = $i; 
					        }
					}
					echo '<div class="mini-profileg">
							<div style="overflow: hidden; margin-bottom: 5px;">
								<div class="block" >
									<img src="/style/images/img/mini-profile-icon-wins.png" alt="Побед" style="vertical-align: middle; position: relative; margin-top: -1px;">
									' . $msg['pobeda1'] . '
									<span style="color: #ffa200;">' . mysql_num_rows($win) . '</span>
								</div>
								<div class="block" style=" margin-left: 5px;">
									<img src="/style/images/img/mini-profile-icon-top.png" alt="В топе" style="vertical-align: middle; position: relative; margin-top: -1px;">
									' . $msg['intop1'] . '
									<span style="color: #ffa200;">'.$rank.'</span>
								</div>
							</div>
							<a href="/settings" class="mini-profile-settings">
								<img src="/style/images/img/mini-profile-icon-settings.png" alt="Настройки" style="position: absolute; left: 12px; top: 50%; width: 16px; height: 16px; box-sising: border-box; margin-top: -11px; background: #0385c0; border: 3px solid #0385c0; border-radius: 50%;">
								' . $msg['setting1'] . '
							</a>
							<a href="/profile" class="prof">
		
								' . $msg['profile1'] . '
							</a>
						</div>';
				
				}
				echo "<phpvar style=\"display: none;\" id='loggedin'>".$mod."</phpvar><phpvar style=\"display: none;\" id='soundon'>".$sound."</phpvar>";				?>	
<script type="text/javascript">
<?php if(isset($_SESSION['steamid'])){
	
	echo '
	var socketIO = io(\':2052\',{\'max reconnection attempts\':Infinity});	
	
	socketIO.on(\'message\', function(data){';
	
		echo "if(data.steamid==".$_SESSION['steamid']."){

		var n = noty({
                    timeout: '2000',
                    theme: 'successnoty',
                    layout: 'topRight',
                    text: data.mes
                });
				
		}";
		echo' });';
	}

	

?>
</script>
		<div class="infoshop">
<div id="slider">
  <a href="#" class="control_next">></a>
  <a href="#" class="control_prev"><</a>
  <ul>
    <li>  <?php lastitems($msg);?></li>
    <li>  <?php lootgame($msg);?></li>  
	<li> <?php lastspot($msg); ?></li>
	<li>  
	<div class="titleh"><?php echo $msg['referality1']; ?></div> 
	<div style="margin-left: -40px;margin-top: 10px;">
				<img src="../style/images/referral-program-siam-home-source.jpg" width="80px" alt="" title="">
			<div style="margin-left: -10px;margin-top: 2px;">
				<?php echo $msg['referality3']; ?>
				 <br><?php echo $msg['referality2']; ?>
			</div>
			
				<div class="buttons" style="margin-left: 195px;margin-top: 6px;"> 
				<a class="skins" href="/referal">&nbsp;&nbsp;<?php echo $msg['referality4']; ?> &nbsp;&nbsp;</a>		
				</div>
	</div>
	</li>
  </ul>  
</div>
</div>
<div class="store">
<div class="stat001">
<div onclick="location.href='/history';" class="activeroom room1"><?php echo $msg['history_igrok']; ?></div>
<div onclick="location.href='/top';" class="activeroom room1"><?php echo $msg['top']; ?></div>
<div class="activeroom room1" onclick="location.href='/';"><?php echo $msg['glava1']; ?></div>
<div onclick="location.href='/spot';" class="activeroom room1"><?php echo $msg['glava2']; ?></div>
<div onclick="location.href='/loot';" class="activeroom room1"><?php echo $msg['rosdat1']; ?></div>
<div onclick="location.href='/referal';" class="activeroom room1"><?php echo $msg['ref']; ?></div>
</div>
<script src="//cdn.rawgit.com/hilios/jQuery.countdown/2.1.0/dist/jquery.countdown.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment-with-locales.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.0/moment-timezone-with-data-2010-2020.min.js"></script>
<div id="lootgame">
<?php game(); ?>
</div>

<div class="giveaway_users" id="g_users">
<script type="text/javascript">

	function updateGiveaway() {
		$.get('/sys/api.php?playerlenta',function(data) {
			
	       $('#g_users').html(data);
			
		});
		$.get('/sys/api.php?allplayer',function(data) {
			$('#gusersgi').html(data);
		});
		$.get('/sys/api.php?lootgame',function(data) {
			$('#lootgame').html(data);
		});
	}
	updateGiveaway();
	u_give_users = setInterval(updateGiveaway,10000);

  // Handle timezone issue
 
</script>




 
	 
 <?php  allplayerlenta();  ?>
 


	 



</div>



<script>
$('#add_to_giveaway').click(function(){

	if(!$('.giveaway_subject').length) {
 		alertmessage("warning",null,'Игра окончена, или еще не начата');
	}
	else {		
       joinf();
	}
});

</script> 
<div class="about">
<p class="title-work"><?php echo $msg['rosdat2']; ?></p>
<ol>
	<li><?php echo $msg['rosdat3']; ?><?php echo $SaitBrand ;?></li>
	<li><?php echo $msg['rosdat4']; ?> <?php echo $SaitBrand ;?> <?php echo $msg['rosdat5']; ?> </li>
    <li><span><?php echo $msg['rosdat6']; ?> <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="http://vk.com/js/api/share.js?93" charset="windows-1251"></script>

<!-- Put this script tag to the place, where the Share button will be -->
<script type="text/javascript"><!--
document.write(VK.Share.button(false,{type: "round", text: "ЭТУ ЗАПИСЬ!"}));
--></script></span></li>
	</ol>
</div>

	</div>
</div>

		 
		 
	<!-- <middle> -->
</div>

