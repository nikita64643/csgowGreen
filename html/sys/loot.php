<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function allplayer(){
	$loot = mysql_query("SELECT * FROM `loot`");
	echo mysql_num_rows($loot);
}
function game(){
	        $idloot = fetchinfo("value","info","name","lootgame");
			$playerlooot = fetchinfo("player","lootgame","id",$idloot);
			$img = fetchinfo("img","lootgame","id",$idloot);
			$loot = mysql_query("SELECT * FROM `loot`");
			$winner = fetchinfo("winner","lootgame","id",$idloot);
			if(strlen($winner)>5){
				$win = '<a href="/profile/'.$winner.'">'.fetchinfo("personaname","account","steamid",$winner).'</a>';
			}else $win = 'не выбран';
			$num = $playerlooot - mysql_num_rows($loot);
	        $allplayer =mysql_num_rows($loot);
	echo '
<span class="wineinf">Победитель: будет объявлен через <span id="countdown">'.$num.'</span>.  
</span>
<span class="wineinf2">Статистика раздач за все время: 1 раздача, 
1 победитель, 90 игроков</span>
<div class="giveaway"><img src="'.$img.'" original-title="★ Нож-бабочка | Патина" class="giveaway_subject"></div>

<div class="panel"><span class="gusers">Всего <span id="gusersgi">'.$allplayer.'</span> участников</span><a class="add" id="add_to_giveaway" onclick="joinf()" href="javascript://">Принять участие</a>
<span class="gusers2">Победитель: '.$win.'  </span></div>';
}

function allplayerlenta(){
			$idloot = fetchinfo("value","info","name","lootgame");
			$playerlooot = fetchinfo("player","lootgame","id",$idloot);
			$loot = mysql_query("SELECT * FROM `loot`");
			if(mysql_num_rows($loot) >= $playerlooot){
			   $winnerf = fetchinfo("winner","lootgame","id",$idloot);   
			   if(strlen($winnerf)<5){
				   $min = mysql_fetch_assoc(mysql_query("SELECT * FROM `loot` ORDER BY `id` ASC LIMIT 1"));
				   $max = mysql_fetch_assoc(mysql_query("SELECT * FROM `loot` ORDER BY `id` DESC LIMIT 1"));
				   $winid = mt_rand($min['id'],$max['id']);
                   $pip = mysql_query("SELECT * FROM `loot` WHERE `id`='$winid'");
				   $fff = mysql_fetch_assoc($pip);
				   $winner = $fff['steamid'];
			       mysql_query("UPDATE lootgame SET `winner`='$winner'")or die(mysql_error());
				   $playerlooot = fetchinfo("player","lootgame","id",$idloot);
				   $tradelink = fetchinfo("linkid","account","steamid",$winner);
				   $token = substr(strstr($tradelink, 'token='),6);
				   $item = fetchinfo("name","lootgame","id",$idloot);
				   mysql_query("INSERT INTO `queue` (`userid`,`status`,`token`,`items`) VALUES ('$winner','active','$token','$item')")or die(mysql_error());
			   }              
			}
	     $loot = mysql_query("SELECT * FROM `loot`");
	     while ($row34 = mysql_fetch_array($loot)) {
	           echo '<div class="block tooltipanim" title="' . $row34['name'] . '" style="background-image:url(\'' . $row34['avatar'] . '\');"></div>';
	     }
}
function test(){

                   $min = mysql_fetch_assoc(mysql_query("SELECT * FROM `loot` ORDER BY `id` ASC LIMIT 1"));
				   $max = mysql_fetch_assoc(mysql_query("SELECT * FROM `loot` ORDER BY `id` DESC LIMIT 1"));
				   $winid = mt_rand($min['id'],$max['id']);
				   echo $winid.'';

}
/* '.$loot['data'].' */

/* <div class="name">
				'.$loot['market_name'].'</div> */
function lootgame($msg){
	$lootgame = mysql_query("SELECT * FROM lootgame");
	$lootf = mysql_query("SELECT * FROM `loot`");
	$loot = mysql_fetch_assoc($lootgame);
	echo'	<div class="titleh">'.$msg['rosgr'].' '.$loot['market_name'].'  !</div>
			<div class="picture">
				<img src="'.$loot['img'].'" alt="" title="">

			
				<div class="buttons" style="margin-left: 140px;margin-top: 20px;"> 
				<a class="skins" href="/loot">'.$msg['rosgr222'].'</a>		
				</div>
		';

	
	
}
function joinf($SaitBrand){
	if (isset($_SESSION['steamid'])) {
		$name = $_SESSION['personaname'];
		$avatar = $_SESSION['avatarfull'];
		$steamid = $_SESSION['steamid'];
        $test = fetchinfo("value","info","name","value");
		if (stristr($name, $SaitBrand) != NULL) {
			$player = fetchinfo("avatar","loot","steamid",$_SESSION['steamid']);
			$idloot = fetchinfo("value","info","name","lootgame");
			$playerlooot = fetchinfo("player","lootgame","id",$idloot);
			$loot = mysql_query("SELECT * FROM `loot`");
			if(mysql_num_rows($loot) <= $playerlooot){
              if(strlen($player) > 5){
				echo 'Вы уже приняли участие!'; 
			  }
		      else{
				$date = date('Y-m-d H:i:s');
			    mysql_query("INSERT INTO loot (steamid, avatar, name, data) VALUES ('$steamid', '$avatar', '$name', '$date')")or die(mysql_error());
			    echo 'Вы успешно приняли участие!';
			  }
			}else echo 'Набрано максимальное число участников!Игра окончена!';
		}
		else {
			echo 'Для участвие в вашем нике должно быть дописано ' . $SaitBrand . '!';
		}	
	}
	else {	
		echo 'Авторизируйтесь,чтобы принять участие!';
	}
}

?>