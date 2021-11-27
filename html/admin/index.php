<?php
include $_SERVER['DOCUMENT_ROOT'].('/sys/api.php');
if(isset($_SESSION["steamid"])) {
    $login = $_SESSION["steamid"];
    $admin = fetchinfo("admin", "account", "steamid", $login);
    if ($admin  !== '1') {
		die('Ты не админ!');
    }
}else{
	   die('Ты не авторизирован!');
}
if(isset($_GET['act'])){
    $game        = $_GET['game'];
    $market_name = $_GET['MarketName'];
    $value       = $_GET['value'];
    $item        = $_GET['item'];
    $info        = $_GET['info'];
    $rarity      = $_GET['rarity'];
    $mest        = $_GET['mest'];
    $img         = $_GET['img'];
    $qual        = $_GET['qual'];
    mysql_query("INSERT INTO `spotinfo` (`game`,`market_name`,`value`,`item`,`info`,`rarity`,`mest`,`img`,`qual`) VALUES ('$game','$market_name','$value','$item','$info','$rarity','$mest','$img','$qual')");
    for ($x = 0; $x < $mest; $x++) {
        $mesto = $x + 1;
        mysql_query("INSERT INTO `spotgames` (`id`,`game`,`mesto`) VALUES ('','$game','$mesto')");
    }
	 header("Location: " . $_SERVER['HTTP_REFERER']);

}
if(isset($_POST['fakebat'])){
		$steamid = $_POST['steamid'];
	    $name = $_POST['fakebat'];
	    $img = $_POST['img'];
                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=975C08CE912527A770E124C9E815E971&steamids=$steamid";
				$json_decoded = json_decode(curl_get_contents($url));     
                foreach ($json_decoded->response->players as $player)
                { 
                     $ava = $player-> avatarfull;
                     $steamidf = mysql_query("SELECT * FROM account WHERE steamid = '$player->steamid'");
                     $row = mysql_fetch_assoc($steamidf);
                     if ($row > 1) {
                     	mysql_query("UPDATE account SET personaname='$player->personaname', avatar='$player->avatar', avatarfull='$player->avatarfull' WHERE steamid='$steamid'");
                     } else {
                     	if ($player-> steamid != $row[steamid]) {
                     		$ref = '';
							$date = date('Y-m-d H:i:s');
							mysql_query("INSERT INTO account (steamid, personaname, profileurl, avatar, avatarfull, bonus, datareg) VALUES ('$player->steamid', '$player->personaname', '$player->profileurl', '$player->avatar' , '$player->avatarfull', '0', '$date')");
                     	}
                     }
				$gamenum = fetchinfo("value", "info", "name", "current_game");
				$avatarfull = fetchinfo("avatarfull", "account", "steamid", $steamid);
				$steamname = fetchinfo("personaname", "account", "steamid", $steamid);
		        $gamejack = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$steamid' AND `game`='$gamenum'");
				$data = array();
				$GAME = mysql_query("SELECT `cost`,`itemsnum` FROM `games` WHERE `id`='$gamenum'");
				$gameselect = mysql_fetch_array($GAME);
				$num1 = substr(md5(rand(0, mt_getrandmax())), 0, 4);
				$num2 = substr(md5(rand(0, mt_getrandmax())), 0, 4);
				$num3 = substr(md5(rand(0, mt_getrandmax())), 0, 4);
				$num4 = substr(md5(rand(0, mt_getrandmax())), 0, 4);
				$random = $num1.'-'.$num2.'-'.$num3.'-'.$num4;
	            $kurs = '0.67';
	            $cost = fetchinfo("value", "weapons_temp", "weaponname", $name );
                $itemprise = $cost * $kurs;
		        $zena =floatval($itemprise);
                $current_bank = floatval($gameselect['cost']);					
							$to = $current_bank+$cost;
							mysql_query("UPDATE `account` SET `hisgames`=concat(`hisgames`,',$gamenum,') WHERE `steamid` = '$steamid'");
							mysql_query("INSERT INTO `gamejack` (`avatar`,`username`,`userid`,`item`,`color`,`itemtype`,`value`,`image`,`from`,`to`,`thisitem`,`game`,`tradeid`) VALUES ('$avatarfull','$steamname','$steamid','$name','rgba(255,0,0,0.2)','rgba(255,0,0,0.2)','$zena','$img','$current_bank','$to','yes','$gamenum','$random')") or die(mysql_error());
							mysql_query("UPDATE `games` SET `itemsnum`=`itemsnum`+1, `cost`=`cost`+'$zena' WHERE `id` = '$gamenum'");
							$data['status'] = true;
				            $data['msg'] = 'Items Added to game '.$gamenum.'!';
						
					
                }				

	echo json_encode($data);
}
if(isset($_POST['coderef'])){
	$code = $_POST['coderef'];
	$value = $_POST['valuecode'];
	$textref= mysql_real_escape_string($_POST['textcode']);
    mysql_query("INSERT INTO `codes` (`code`,`price`,`text`) VALUES ('$code','$value','$textref')") or die(mysql_error());
	 header("Location: ".$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['delid'])){
	 mysql_query("DELETE FROM shop_content WHERE `id`='".$_GET['delid']."'");
	 header("Location: ".$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['delidspot'])){
	 $game = fetchinfo("game", "spotinfo", "id", $_GET['delidspot']);
	 mysql_query("DELETE FROM spotinfo WHERE `id`='".$_GET['delidspot']."'");
	  mysql_query("DELETE FROM spotgames WHERE `game`='".$game."'");
	 header("Location: ".$_SERVER['HTTP_REFERER']);
}

if(isset($_GET['delchat'])){
	 mysql_query("DELETE FROM chat");
	 header("Location: ".$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['data'])){
	 $data = $_GET['data'];

     $d1 = date('Y-m-d', strtotime($data));
	 header("Location: ".$MainUrl."/data/".$d1."");
}
if(isset($_POST['rake'])){
   mysql_query("UPDATE info SET value='".$_POST['rake']."' WHERE name='rake'");
   mysql_query("UPDATE info SET value='".$_POST['minbet']."' WHERE name='minbet'");
   mysql_query("UPDATE info SET value='".$_POST['maxitems']."' WHERE name='maxitems'");
   mysql_query("UPDATE info SET value='".$_POST['rakeVIP']."' WHERE name='rakeVIP'");
   mysql_query("UPDATE info SET value='".$_POST['rakemoney']."' WHERE name='rakemoney'");
   mysql_query("UPDATE info SET value='".$_POST['norakepercent']."' WHERE name='norakepercent'");
   mysql_query("UPDATE info SET value='".$_POST['refmoney']."' WHERE name='refmoney'");
   mysql_query("UPDATE info SET value='".$_POST['refwin']."' WHERE name='refwin'");
   header("Location: ".$_SERVER['HTTP_REFERER']);
}
function spotadmin(){
	$rs3 = mysql_query("SELECT * FROM `spotinfo`");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo '
                  <div class="list-item">

                            <div class="list-info">
                                <img src="' . $row33["img"] . '" style="width: 60px;" class="img-circle img-thumbnail"/>
                            </div>
                            <div class="list-text">
                                <a href="#" class="list-text-name">' . $row33["item"] . '</a>
                                <p>' . $row33["mest"] . ' мест по ' . $row33["qual"] . ' цене</p>
                            </div>
                            <div class="list-controls">                           
                                <a href="index.php?delidspot='.$row33["id"].'" class="widget-icon widget-icon-circle"><span class="icon-remove"></span></a>
                            </div>                            
                        </div> 
	           <!-- </item> -->'; 
	     } 
		
	}
}
function shopadmin(){
	$rs3 = mysql_query("SELECT * FROM `shop_content`");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo '
                  <div class="list-item">

                            <div class="list-info">
                                <img src="' . $row33["img"] . '" style="width: 60px;" class="img-circle img-thumbnail"/>
                            </div>
                            <div class="list-text">
                                <a href="#" class="list-text-name">' . $row33["title"] . '</a>
                                <p>' . $row33["lod"] . '</p>
                            </div>
                            <div class="list-controls">                           
                                <a href="index.php?delid='.$row33["id"].'" class="widget-icon widget-icon-circle"><span class="icon-remove"></span></a>
                            </div>                            
                        </div> 
	           <!-- </item> -->'; 
	     } 
		
	}
}
function chat(){
	$query = mysql_query("SELECT * FROM chat ORDER BY id DESC LIMIT 10");

if (mysql_num_rows($query) > 0) {
	$messages = array();
	while ($row = mysql_fetch_array($query)) {
		$messages[] = $row;
	}

	$last_message_id = $messages[0]['id'];
	$messages = array_reverse($messages);
	if (!isset($_SESSION["steamid"])) $admin = 0;
	else $admin = fetchinfo("admin", "account", "steamid", $_SESSION["steamid"]);
	foreach($messages as $value) {
		$text = $value['text'];
		$textchat = str_replace(array(
			':acute:',
			':aggressive:',
			':help:',
			':cray:',
			':bad:',
			':bb:',
			':beee:',
			':drinks:',
			':dash2:',
			':crazy:',
			':gamer3:',
			':fool:',
			':good:',
			':heat:',
			':lazy:',
			':music2:',
			':negative:',
			':nea:',
			':shok:',
			':rtfm:',
			':pardon:',
			':yahoo:',
			':suicide2:',
			':facepalm:',
			':ok:',
			':ireful1:',
			':popcorm2:',
			':russian_ru:',
			':triniti:',
			':skull:',
			':rofl:',
			':this:',
			':sad:',
			':scare2:',
			':cool:',
			':biggrin:',
			':mad:',
			':middlefinger:',
		) , array(
			'<img src=\'/style/images/smiles/acute.gif\' />',
			'<img src=\'/style/images/smiles/aggressive.gif\' />',
			'<img src=\'/style/images/smiles/help.gif\' />',
			'<img src=\'/style/images/smiles/cray.gif\' />',
			'<img src=\'/style/images/smiles/bad.gif\' />',
			'<img src=\'/style/images/smiles/bb.gif\' />',
			'<img src=\'/style/images/smiles/beee.gif\' />',
			'<img src=\'/style/images/smiles/drinks.gif\' />',
			'<img src=\'/style/images/smiles/dash2.gif\' />',
			'<img src=\'/style/images/smiles/crazy.gif\' />',
			'<img src=\'/style/images/smiles/gamer3.gif\' />',
			'<img src=\'/style/images/smiles/fool.gif\' />',
			'<img src=\'/style/images/smiles/good.gif\' />',
			'<img src=\'/style/images/smiles/heat.gif\' />',
			'<img src=\'/style/images/smiles/lazy.gif\' />',
			'<img src=\'/style/images/smiles/music2.gif\' />',
			'<img src=\'/style/images/smiles/negative.gif\' />',
			'<img src=\'/style/images/smiles/nea.gif\' />',
			'<img src=\'/style/images/smiles/shok.gif\' />',
			'<img src=\'/style/images/smiles/rtfm.gif\' />',
			'<img src=\'/style/images/smiles/pardon.gif\' />',
			'<img src=\'/style/images/smiles/yahoo.gif\' />',
			'<img src=\'/style/images/smiles/suicide2.gif\' />',
			'<img src=\'/style/images/smiles/facepalm.gif\' />',
			'<img src=\'/style/images/smiles/ok.gif\' />',
			'<img src=\'/style/images/smiles/ireful1.gif\' />',
			'<img src=\'/style/images/smiles/popcorm2.gif\' />',
			'<img src=\'/style/images/smiles/russian_ru.gif\' />',
			'<img src=\'/style/images/smiles/triniti.gif\' />',
			'<img src=\'/style/images/smiles/skull.gif\' />',
			'<img src=\'/style/images/smiles/rofl.gif\' />',
			'<img src=\'/style/images/smiles/this.gif\' />',
			'<img src=\'/style/images/smiles/sad.gif\' />',
			'<img src=\'/style/images/smiles/scare2.gif\' />',
			'<img src=\'/style/images/smiles/cool.gif\' />',
			'<img src=\'/style/images/smiles/biggrin.gif\' />',
			'<img src=\'/style/images/smiles/mad.gif\' />',
			'<img src=\'/style/images/smiles/middlefinger.gif\' />',
		) , $text);

        if(preg_match("/https:\/\/|http:\/\/|[0-9a-z_]+\.[a-z\/]{2,4}/i", $textchat)){
             $textchat = preg_replace("/(https:\/\/|http:\/\/|[0-9a-z_]+\.[a-z\/]{2,4})/i", "***", $textchat);
        }

		$avatar = fetchinfo("avatar", "account", "steamid", $value['steamid']);
		if ($admin > 0) $admtext= '<a onclick="delcom(\'' . $value['id'] . '\')">D</a><a onclick="bansteam(\'' . $value['steamid'] . '\')">B</a>';
		else  $admtext='';
		echo '<div class="messages-item">
                             <img src="'.$avatar.'" class="img-circle img-thumbnail"/>
                                <div class="messages-item-text">' . $textchat . '</div>
                                <div class="messages-item-date">   <a href="/profile/' . $value['steamid'] . '">' . $value['name'] . '</a></div>
                            </div>
		
		   
		
		
		
		';
	}

	  
	   
}
}

function settings($SaitBrand){
	  $gamenum = fetchinfo("value", "info", "name", "current_game");
	  $rake = fetchinfo("value", "info", "name", "rake");
	  $minbet = fetchinfo("value", "info", "name", "minbet");	  
	  $maxitems = fetchinfo("value", "info", "name", "maxitems");	  
	  $refmoney = fetchinfo("value", "info", "name", "minbet");	  
	  $rakeVIP = fetchinfo("value", "info", "name", "rakeVIP");	  
	  $rakemoney = fetchinfo("value", "info", "name", "rakemoney");	  
	  $norakepercent = fetchinfo("value", "info", "name", "norakepercent");	 
      $minbet = fetchinfo("value", "info", "name", "minbet");	
      $refwin = fetchinfo("value","info","name","refwin");	 
	echo '          <form method="post">
	                <div class="content controls">
                        <div class="form-row">
                          <div class="col-md-3">Название сайта:</div>
                            <div class="col-md-9"><input type="text" readonly="readonly" class="form-control" value="'.$SaitBrand.'"/></div>
                        </div>
						<div class="head bg-default bg-light-rtl">
                        <h2>Настройки JackPot</h2>
                    </div>
						<div class="form-row" style="margin-top:20px;">
                          <div class="col-md-3">Игра:</div>
                            <div class="col-md-9"><input type="text" readonly="readonly" class="form-control" value="'. $gamenum.'"/></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Комисия:</div>
                            <div class="col-md-9"><input type="text" name="rake" class="form-control" pattern="[0-9]{1,2}" value="'. $rake.'"></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Мин.ставка:</div>
                            <div class="col-md-9"><input type="text" name="minbet" class="form-control" pattern="[0-9]{1,2}" value="'. $minbet.'"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Макс.предметов:</div>
                            <div class="col-md-9"><input type="text" name="maxitems" class="form-control" pattern="[0-9]{1,2}" value="'. $maxitems.'"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">VIP комисия:</div>
                            <div class="col-md-9"><input type="text" name="rakeVIP" class="form-control" pattern="[0-9]{1,2}" value="'. $rakeVIP.'"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Комисия денег:</div>
                            <div class="col-md-9"><input type="text" name="rakemoney" class="form-control" pattern="[0-9]{1,2}" value="'. $rakemoney.'"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Не брать комисию при:</div>
                            <div class="col-md-9"><input type="text" name="norakepercent" class="form-control" pattern="[0-9]{1,2}" value="'. $norakepercent.'"/></div>
                        </div>
					    <div class="head bg-default bg-light-rtl" >
                        <h2>Реферальная система</h2>
                         </div>
						<div class="form-row" style="margin-top:20px;">
                            <div class="col-md-3">Денег зя приглашение:</div>
                            <div class="col-md-9"><input type="text" name="refmoney" class="form-control" pattern="[0-9]{1,10}" value="'. $refmoney.'"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Комисия Реф.при победе:</div>
                            <div class="col-md-9"><input type="text" name="refwin" class="form-control" pattern="[0-9]{1,2}" value="'. $refwin.'"/></div>
                        </div>
     <button type="submit" class="btn btn-default btn-clean" style="float:right;margin-right:20px;" name="delchat">Сохранить</button>				
                    </div></form>';
}
function logsbot(){
  $file_array = file("/bott/cratedump.log");
  if(!$file_array)
  {
    echo("<li>Ошибка открытия файла</li>");
  }
  else
  {
    for($i=0; $i < count($file_array); $i++)
    {
      printf("<li>%s<br></li>", $file_array[$i]);
    }
  }
}
function logshop(){
  $file_array = file("/root/.forever/shop.log");
  if(!$file_array)
  {
    echo("Ошибка открытия файла");
  }
  else
  {
    for($i=0; $i < count($file_array); $i++)
    {
      printf("%s<br>", $file_array[$i]);
    }
  }
}
function profadmin(){
	$steamid = $_SESSION["steamid"];
	 $gamespr = fetchinfo("games", "account", "steamid", $steamid);
     $avatar = fetchinfo("avatarfull", "account", "steamid", $steamid);
     $name = fetchinfo("personaname", "account", "steamid", $steamid);
     $buycards = fetchinfo("buycards", "account", "steamid", $steamid);
	 $mest = fetchinfo("mest", "account", "steamid", $steamid);
     $ban = fetchinfo("ban", "account", "steamid", $steamid);
	 $skype = fetchinfo("skype", "account", "steamid", $steamid);
	 $realname = fetchinfo("skype", "account", "steamid", $steamid);
	 $about = fetchinfo("about", "account", "steamid", $steamid);
	 $datareg = fetchinfo("datareg", "account", "steamid", $steamid);
	 $win = mysql_query("SELECT * FROM `games` WHERE `userid`='$steamid'"); 
     $cash = fetchinfo("won", "account", "steamid", $steamid);
     $tradeurl = fetchinfo("linkid", "account", "steamid", $steamid);
	 $money = fetchinfo("money", "account", "steamid", $steamid);
	echo'        <div class="block block-drop-shadow">
                    <div class="user bg-default bg-light-rtl">
                        <div class="info">                                                                                
                            <a href="#" class="informer informer-three">
                                <span>'.$name .'</span>
                                Name
                            </a>                            
                            <a href="#" class="informer informer-four">
                                <span>'.$money.' руб.</span>
                                Balance
                            </a>                                                        
                            <img src="'.$avatar.'" class="img-circle img-thumbnail"/>
                        </div>
                    </div>
                    <div class="content list-group list-group-icons">
                    
                        <a href="/sys/api.php?exit" class="list-group-item"><span class="icon-off"></span>Logout<i class="icon-angle-right pull-right"></i></a>
                    </div>
                </div> ';
}
function statadmin(){
	$user = mysql_query("SELECT * FROM `account`");
	$games = mysql_query("SELECT * FROM `games`");
	$item = mysql_query("SELECT * FROM `gamejack`");
	$weapon = mysql_query("SELECT * FROM `weapons_temp`");
	$queue = mysql_query("SELECT * FROM `queue`");
	$chat = mysql_query("SELECT * FROM `chat`");
	echo ' 
                        	<div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Пользователей:<span class="label label-info">'.mysql_num_rows($user).'</span></span>
                                <span class="hp-sm">Игр: <span class="label label-info">'.mysql_num_rows($games).'</span></span>
                               <span class="hp-sm">Вещей: <span class="label label-info">'.mysql_num_rows($item).'</span></span>
                            </div>                 
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">В базе: <span class="label label-warning">'.mysql_num_rows($weapon).' ценников</span> </span>
                                <span class="hp-sm">Вещей отдано: <span class="label label-warning">'.mysql_num_rows($queue).'</span> </span>
                                <span class="hp-sm">В чате: <span class="label label-warning">'.mysql_num_rows($chat).' сообщений</span> </span>
                            </div>  ';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>        
    <title><?php echo $SaitBrand; ?> - Admin Panel</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />        
    
    <script type='text/javascript' src='js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-ui.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/globalize.js'></script>    
    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script type='text/javascript' src='js/plugins/uniform/jquery.uniform.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>
    <script type='text/javascript' src='js/plugins/sparkline/jquery.sparkline.min.js'></script>
    <script type='text/javascript' src='js/plugins/flot/jquery.flot.js'></script>     
    <script type='text/javascript' src='js/plugins/flot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='js/plugins.js'></script>    
    <script type='text/javascript' src='js/actions.js'></script>    
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/settings.js'></script>
    
</head>
<body class="bg-img-num1"> 
    
    <div class="container">        
        <div class="row">                   
            <div class="col-md-12">
                
                 <nav class="navbar brb" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-reorder"></span>                            
                        </button>                                                
                        <a class="navbar-brand" href="/"><img src="img/logo.png"/></a>                                                                                     
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                        <ul class="nav navbar-nav">
                            <li class="active">
                                <a href="#tab121" data-toggle="tab" class="dropdown-toggle"><span class="icon-home"></span> Главная</a>
                            </li>                            
                           
                               <li> <a href="#tab120" data-toggle="tab" class="dropdown-toggle"><span class="icon-pencil"></span> Настройки</a></li>
                               <li> <a href="#spot" data-toggle="tab" class="dropdown-toggle"><span class="icon-pencil"></span> SPOTS</a></li>
                               <li> <a href="#tab122" data-toggle="tab" class="dropdown-toggle"><span class="icon-pencil"></span> Логи</a></li>                
                        </ul>
                                         
                    </div>
                </nav>                

            </div>            
        </div>
        <div class="row">
            
            <div class="col-md-2">
                
        <?php profadmin(); ?>
                

  
                <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Статистика сайта</h2>
                        <div class="side pull-right">               
                        </div>
                        <div class="head-panel nm">
                       <?php statadmin(); ?>               
                        </div>                        
                    </div>                    
                    
                </div>                
                
            </div>
			<div class="tab-content">
			<div class="tab-pane"  id="spot">
			<div class="col-md-5">
			    <div class="block">
                    <div class="head bg-default bg-light-rtl">
                        <h2>Добавление в SPOT</h2>
                    </div>
					
					

                                                              <div class="content controls">
             
              
                    <form action="../admin/index.php" method="get" target="_blank" style="margin-top:20px;" class="form-horizontal">
					<input name="act" type="hidden" id="hidden" value="spotadd">
			
  <div class="form-row">
    <label class="col-md-3">Game</label>
    <div class="col-md-9">
      <input class="form-control" name="game" type="text" id="formGroupInputSmall" placeholder="Game">
    </div>
</div>
<div class="form-row">
    <label class="col-md-3">Market Name</label>
    <div class="col-md-9">
      <input class="form-control" name="MarketName" type="text" id="formGroupInputSmall" placeholder="Market Name">
    </div>
</div>
<div class="form-row">
    <label class="col-md-3">Price Steam</label>
    <div class="col-md-9">
      <input class="form-control" name="value" type="text" id="formGroupInputSmall" placeholder="Price">
    </div>
</div>
<div class="form-row">
    <label class="col-md-3">Name</label>
    <div class="col-md-9">
      <input class="form-control" name="item" type="text" id="formGroupInputSmall" placeholder="name">
    </div>
</div><div class="form-row">
    <label class="col-md-3">Info</label>
    <div class="col-md-9">
      <input class="form-control" name="info" type="text" id="formGroupInputSmall" placeholder="Тайное">
    </div>
</div><div class="form-row">
    <label class="col-md-3">Rarity</label>
    <div class="col-md-9">
      <input class="form-control" name="rarity" type="text" id="formGroupInputSmall" placeholder="Прямо с завода">
    </div>
</div>
<div class="form-row">
    <label class="col-md-3">Slots</label>
    <div class="col-md-9">
      <input class="form-control" name="mest" type="text" id="formGroupInputSmall" placeholder="mest">
    </div>
</div>
<div class="form-row">
    <label class="col-md-3">img</label>
    <div class="col-md-9">
      <input class="form-control" name="img" type="text" id="formGroupInputSmall" placeholder="images item">
    </div>
</div><div class="form-row">
    <label class="col-md-3">Price</label>
    <div class="col-md-9">
      <input class="form-control" name="qual" type="text" id="formGroupInputSmall" placeholder="qual">
    </div>
</div>

    <button type="submit" class="btn btn-default btn-clean"style="float:right;margin-right:20px;">Submit</button>
                                </form>
            
            </div>
					
                    
					
					
      
                </div>   
			</div>   
			<div class="col-md-5">
				<div class="block block-drop-shadow">
                    <div class="head bg-default bg-light-rtl">
                        <h2>Игры SPOT</h2>
                    </div>
					
					
					<div class="content messages npr npb npt">                         
                        <div class="scroll oh content list" style="height: 250px;">
                                                  <?php spotadmin(); ?>
					
                        </div>
                    </div>
					
					
      
                	 </div>		
</div>	
       




























					 
			   </div>
			<div class="col-md-8 tab-pane"  id="tab122">
			    <div class="block block-drop-shadow">
                    <div class="head bg-default bg-light-rtl">
                        <h2>Логи бота рулетки</h2>
                    </div>
					
					
					<div class="content messages npr npb npt">                         
                        <div class="scroll oh content list" style="height: 250px;">
                                                  <?php logsbot(); ?>
					
                        </div>
                    </div>
					
					
      
                </div>   
			    <div class="block block-drop-shadow">
                    <div class="head bg-default bg-light-rtl">
                        <h2>Логи бота магазина</h2>
                    </div>
					
					
					<div class="content messages npr npb npt">                         
                        <div class="scroll oh content list" style="height: 250px;">
                                                  <?php logshop(); ?>
					
                        </div>
                    </div>
					
					
      
                </div> 				
			   </div>
           <div class="tab-pane active"  id="tab121">
            <div class="col-md-5">
                <div class="block block-drop-shadow">
                    <div class="head bg-default bg-light-ltr">
                        <h2>Статистика игр</h2>                      
                        <div class="head-panel nm">
                            <div class="left_abs_100" style="margin-top: 20px;">
                                <div class="knob">
                                    <input type="text" data-fgColor="#FFFFFF" data-min="0" data-max="200" data-width="100" data-height="100" value="155" data-readOnly="true"/>
                                </div>  
                            </div>
                            <div class="chart" id="dash_chart_1" style="height: 150px;"></div>
                        </div>
                        <div class="head-panel nm">
                                                      
                            <div class="hp-info pull-right">
                                <div class="hp-icon">
                                    <span class="icon-usd"></span>
                                </div>       
<?php
$rs = mysql_query("SELECT SUM(cost) AS ValueSum FROM `games`");
$row = mysql_fetch_array($rs);
$winforeve = $row["ValueSum"];
?>								
                                <span class="hp-main"><?php echo $winforeve; ?></span>                                
                                <span class="hp-sm">Total Income</span>                                
                            </div>                            
                        </div>
                    </div>

                    <div class="footer footer-defaut tac">
						<form method="get">
                        <div class="pull-left" style="width: 200px;">
						
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar"></span></div>
								<form method="get">
                                <input type="text" name="data" class="datepicker form-control" value="10/02/2016"/>
								
                                <div class="input-group-btn"><button type="submit" class="btn"><span class="icon-search"></span></button></div>
                            </div>                                                        
                        </div>
                        <div class="pull-right">
                            <span>Просмотр игры</span>
                        </div></form>
                    </div>
                </div>                
                                <div class="block block-drop-shadow">
                    
                    <div class="head bg-dot30">
                        <h2> Генератор ваучера</h2>
                      
                                     
                    </div>                                        
                    
                  
 <div class="content controls">

						<div class="head bg-default bg-light-rtl">
                        <h2>Настройка Пользователя</h2>
                    </div>
                        <form method="post">
                        <div class="form-row">
                            <div class="col-md-3">Код:</div>
                            <div class="col-md-9"><div class="input-group">
                                    <div class="input-group-addon" id="codegeny"><span class="icon-key"></span></div>
                                    <input type="text" class="form-control hasDatepicker" id="codegenerator" name="coderef">
                                </div></div>
                           </div>
						   <div class="form-row">
                            <div class="col-md-3">Пополнить на :</div>
                            <div class="col-md-9"><input type="text" name="valuecode" class="form-control" value=""/></div>
                          </div>
						  <div class="form-row">
                            <div class="col-md-3">Текст получателю :</div>
                            <div class="col-md-9"><input type="text" name="textcode" class="form-control" value=""/></div>
                          </div>
						  <center>Код пополнить баланс игрока!</center>
						  <button type="submit" class="btn btn-success btn-clean" style="float:right;margin-right:20px;" name="delchat">Сохранить</button>
						</form>



   					
                    </div>
                                                  
            
                </div>
                <div class="block block-drop-shadow">
                    
                    <div class="head bg-dot30">
                        <h2> Фейковая ставка</h2>
                      
                                     
                    </div>                                        
                    
                  
 <div class="content controls">

						<div class="head bg-default bg-light-rtl">
                        <h2>Настройка Пользователя</h2>
                    </div>

                        <div class="form-row">
                            <div class="col-md-3">STEAMID:</div>
                            <div class="col-md-9"><input id="fakesteamid" type="text" name="rake" class="form-control" value=""/></div>
                        </div>
						<center>Всю информацию о STEAMID занесёт в базу данных</center>
					    <div class="head bg-default bg-light-rtl">
                        <h2>Ставка</h2>
                         </div>
						<div class="form-row">
                            <div class="col-md-3">Предмет:</div>
                            <div class="col-md-9"><input id="fakeitem" type="text" name="refmoney" class="form-control" value=""/></div>
                        </div>
							<center>Название предмета на английском <span class="label label-danger">(Пример: Negev | Army Sheen (Minimal Wear))</span>!<p>Цена предмета спарсится с базы данных!</p></center>
						<div class="form-row">
                            <div class="col-md-3">Картинка:</div>
                            <div class="col-md-9"><input id="fakeimg" type="text" name="refmoney" class="form-control" value=""/></div>
                        </div>

   
<a class="btn btn-success btn-clean" id="fakebat" onclick="fakebat()" style="float:right;">Добавить</a>						
                    </div>
                                                  
            
                </div>
</div>
<script>
function fakebat (){
	console.log('111');
	    var img = $("#fakeimg").val();
		var steamid = $("#fakesteamid").val();
		var item = $("#fakeitem").val();		
            $.ajax({
            type: "POST",
            url: "./index.php",
            data: {
                steamid: steamid,
				img: img,
                fakebat: item
            },
            success: function(html) {
               console.log(html);
            }
            });
}
</script>
     <div class="col-md-5">
                
                <div class="block block-drop-shadow">
                    <div class="head bg-default bg-light-rtl">
                        <h2>Товары магазина</h2>
                    </div>
					
					
					<div class="content messages npr npb npt">                         
                        <div class="scroll oh content list" style="height: 250px;">
                                                  <?php shopadmin(); ?>
					
                        </div>
                    </div>
					
					
      
                </div>                

                <div class="block block-drop-shadow">
                    <div class="header">
                        <h2>Messaging</h2>                                            
                    </div>
                    <div class="content messages npr npb npt">                         
                        <div class="scroll oh" style="height: 250px;">
                            
                       <?php chat(); ?>                          
                        </div>
                    </div>
                    <div class="footer">
                        <div class="input-group">
                           <form method="get">
                            <span class="input-group-btn">
                                <button type="submit" class="btn" name="delchat"><span class="icon-remove"></span></button>
                            </span>
							</form>
                        </div>                        
                    </div>
                </div>
                
                
                
            </div>  
            </div>

            <div class="col-md-10 tab-pane"  id="tab120">
                            <div class="block">
                    <div class="header">
                        <h2>Настройки сайта</h2>
                    </div>
  <?php settings($SaitBrand); ?>
                </div>      

            </div>
            </div>
          
            
        </div>
        <div class="row">
            <div class="page-footer">
                <div class="page-footer-wrap">
                    <div class="side pull-left">
                        Copyirght &COPY; <a href="http://envires.ru/" target="_blank">EnVires.ru</a> 2016. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>