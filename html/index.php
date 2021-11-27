<?php
	ob_start('ob_gzhandler');
	header('Cache-control: private');
    define('MODULES', 'page');
    include 'sys/api.php';
// Загрузка
// Действие

include_once 'header.php';
if (isset($_GET['steamid'])) $steamid = $_GET['steamid'];
if (isset($_GET['login'])) login();
if (isset($_GET['spotgame'])) $spotgame = $_GET['spotgame'];
if (isset($_GET['itemid'])) $itemid = $_GET['itemid'];
if (isset($_GET['caseid'])) $caseid = $_GET['caseid'];
if (isset($_GET['getgame'])) $getgame = $_GET['getgame'];
if (isset($_GET['data'])) $datagame = $_GET['data'];
if (isset($_GET['inv'])) $inv = $_GET['inv'];
if (isset($_GET['ref'])) SetCookie("signup_ref",$_GET['ref']);
if (isset($_GET['match'])) $match = $_GET['match'];
if (isset($_GET['do'])) {
	$Page = $_GET['do'];

	// Страница

	if (in_array($Page, array(
		'about',
		'jackpot',
		'game',
		'history',
		'rules',
		'profile',
		'loot',
		'spot',
		'top',
		'shop',
		'referal',
		'inventory',
		'data',		
		'settings',			
		'escrow',		
		'double',		
		'rooms',			
		'case'
	))) {

		// Выбор

		switch ($Page) {
		case 'profile':
			include (MODULES . '/profile.php');

			break;

		case 'referal':
			include (MODULES . '/referal.php');

			break;
		case 'history':
			include (MODULES . '/history.php');

			break;

		case 'game':
			include (MODULES . '/game.php');

			break;

		case 'rooms':
			include (MODULES . '/rooms.php');

			break;
			
		case 'settings':
			include (MODULES . '/setting.php');

			break;
			
		case 'escrow':
			include (MODULES . '/escrow.php');

			break;

		case 'data':
			include (MODULES . '/data.php');

			break;		
			
		case 'double':
			include (MODULES . '/double.php');

			break;				
		case 'about':
			include (MODULES . '/about.php');

			break;
		case 'jackpot':
			include (MODULES . '/jackpot.php');

			break;

		case 'loot':
			include (MODULES . '/loot.php');

			break;

		case 'spot':
			include (MODULES . '/spot.php');

			break;

		case 'top':
			include (MODULES . '/top.php');

			break;

		case 'shop':
			include (MODULES . '/shop.php');

			break;
			
		case 'case':
			include (MODULES . '/case.php');

			break;
			
		case 'inventory':
			include (MODULES . '/inventory.php');

			break;			

		default:
			
			break;
		}
	}
	else {
		include (MODULES . '/404.php');

	}
}else{
	include (MODULES . '/main.php');
}
require 'footer.php';

?>