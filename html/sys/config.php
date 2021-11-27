<?php 
/************************************* SAIT CONFIG *******************************************/
$MainUrl = "http://csgow.ru/";
$Bdhost = "127.0.0.1";
$BdUser = "root";
$BdPass = "Nikitalox646431";
$BdName = "csgow";
$SaitBrand = "csgow.ru";

// Api BackPack

$apiBackPack = '57d063d48667475aa3700d2a';

// Trade

$tradebot = 'https://steamcommunity.com/tradeoffer/new/?partner=150454320&token=0YX4dHhA';

// Api(Онлайн Оплата) gdonate не дописан
$oplata = 2;//1- gdonate 2-freekasa
/////////////////////Free-Kassa////////////////////////////
$fk_merchant_id = '35433'; //merchant_id ID мазагина в free-kassa.ru (http://free-kassa.ru/merchant/cabinet/help/)
$fk_merchant_key = 'xvkg9zfr'; //Секретное слово http://free-kassa.ru/merchant/cabinet/profile/tech.php
$fk_merchant_key2 = '9gqa1yvi'; //Секретное слово2 (result) http://free-kassa.ru/merchant/cabinet/profile/tech.php
/////////////////////Gdonate///////////////////////////////
$publicgdonate = 'b68cf-760';
$privategdonate = 'eb68cffd1b41b14860d82d98d98174e8';
// /////////////////////////////////////Беграунд на сайт////////////////////////////////////////
$link = mysql_connect($Bdhost, $BdUser, $BdPass);
if (!$link) {
    die('Ошибка соединения: ' . mysql_error());
}
$db_selected = mysql_select_db($BdName, $link);
if (!$db_selected) {
    die ('Не удалось выбрать базу : '.$BdName);
}
mysql_query("SET NAMES utf8");
$background = array(
	'/style/images/fon-csgohidev2.2.png',
	'/style/images/fon-csgohidev2.png',
	'/style/images/fon-csgohidev2.3.png',
	'/style/images/fon-csgohidev2.4.png',
); // - массив с именами файлов изображений.
$j = rand(0, count($background) - 1); // - генерируем случайное число для элементов массива.
$selectedBackground = $background[$j];

?>