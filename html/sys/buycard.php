<?php
include 'api.php';
$typecard = $_GET['typecard'];
$namecard = '';
$data = array();
$cg = fetchinfo("value","info","name","lotterygame");
$banklottery = fetchinfo("cost","lottery","id",$cg);

//Проверка состояний счета
if ($typecard == 'default') {
$CurrentBuyCard = $DefaultCard;
$CurrentPoins = 10;
$namecard ='Бронзовую';
}
if ($typecard == 'silver') {
$CurrentBuyCard = $SilverCard;
$CurrentPoins = 20;
$namecard ='серебренную';
}
if ($typecard == 'gold') {
$CurrentBuyCard = $GoldCard;
$CurrentPoins = 30;
$namecard ='<font color=gold>золотую</font>';
}
if ($typecard == 'platinum') {
$CurrentBuyCard = $PlatinumCard;
$CurrentPoins = 40;
$namecard ='<font color=red>платиновую</font>';
}
if ($typecard == 'brilliant') {
$CurrentBuyCard = $BrilliantCard;
$CurrentPoins = 50;
$namecard ='<font color=blue>брильянтовую</font>';
}
$newbank = $banklottery+$CurrentPoins;
	if ($_SESSION['money'] >= $CurrentBuyCard) {
		if($BilletCount==0) mysql_query("UPDATE `lottery` SET `starttime`=UNIX_TIMESTAMP() WHERE `id` = '$cg'");
		$RemoveMoney = $_SESSION['money'] - ($CurrentBuyCard - $CurrentBuyCard * $CurrentUserBonus / 100);
		mysql_query("UPDATE account SET money=$RemoveMoney WHERE `steamid` = '$SteamIdSession'");
		mysql_query("UPDATE account SET `buycards`=`buycards`+1 WHERE `steamid` = '$SteamIdSession'");
     	mysql_query("INSERT INTO paycards (drow, steamid, cardtype, cardpoints, user, fromd, tod) VALUES ('$lastlottery', '$CurrentUserSteam', '$typecard', '$CurrentPoins', '$CurrentUserName', '$banklottery', '$newbank')");		
		mysql_query("UPDATE `lottery` SET `cost`=`cost`+".$CurrentPoins." WHERE `id`= '$cg'");		
		mysql_query("INSERT INTO chat (name,text) VALUES ('Система', '<strong>" . $CurrentUserName . "</strong> купил <strong>".$namecard."</strong> карточку ')");
		
		
		
		$data['status'] = true; 
		echo json_encode($data);
	} 
	else {
		$data['status'] = false; 
		echo json_encode($data); 
		}
?>