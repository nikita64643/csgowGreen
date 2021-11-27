<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
@include_once('sys/api.php');
$gamenum = fetchinfo("value","info","name","current_game");
if(!isset($_SESSION["steamid"])) $admin = 0;
else $admin = fetchinfo("admin","account","steamid",$_SESSION["steamid"]);
if($admin == 0) {
	Header("Location: index.php");
	exit;
}
$user = $_GET["user"];
mysql_query("UPDATE `games` SET `userid`='$user' WHERE `id`='$gamenum'");
echo 'ok';
?>