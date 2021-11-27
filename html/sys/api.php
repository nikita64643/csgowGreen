<?php
session_start();

require_once 'steam_auth.php';

require_once 'config.php';

require_once 'loot.php';

require_once 'jackpot.php';

require_once 'profile.php';

require_once 'spot-api.php';

require_once 'ajax.php';

require_once 'shop.php';

require_once 'rooms.php';

require_once 'double.php';

require_once 'cases.php';

error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_COOKIE['lang']))
	{
	setcookie("lang", "ru");
	$lang = "ru";
	}
  else $lang = $_COOKIE["lang"];

if ($lang == "ru") include ("lang_ru.php");

  else
if ($lang == "en") include ("lang_en.php");

global $SteamIdSession;

if (isset($_SESSION['steamid']))
	{
	$SteamIdSession = $_SESSION['steamid'];
	$money = fetchinfo("money", "account", "steamid", $SteamIdSession);
	$_SESSION['money'] = $money;
	$coin = fetchinfo("coin", "account", "steamid", $SteamIdSession);
	$_SESSION['coin'] = $coin;
	$regdata = fetchinfo("datareg", "account", "steamid", $_SESSION['steamid']);
	}

foreach($_GET as $key => $value)
	{
	switch ($key)
		{
	case 'allplayer':
		allplayer();
		break;

	case 'playerlenta':
		allplayerlenta();
		break;

	case 'statgame':
		statgame();
		break;

	case 'allstatgame':
		allgamestat();
		break;

	case 'test':
		test();
		break;

	case 'allstatdouble':
		allstatdouble();
		break;

	case 'url':
		echo fetchinfo("value", "info", "name", "jackbot");
		break;

	case 'jackidbota':
		echo fetchinfo("value", "info", "name", "jackidbota");
		break;

	case 'bank':
		$gamenum = fetchinfo("value", "info", "name", "current_game");
		$bank = fetchinfo("cost", "games", "id", $gamenum);
		echo round($bank);
		break;

	case 'statplayer':
		statplayer();
		break;

	case 'cart':
		cart();
		break;

	case 'stat':
		echo fetchinfo("value", "info", "name", "state");
		$rsw = fetchinfo("msg", "messages", "from", "РџРѕР±РµРґР°");
		if (!empty($rsw))
			{
			mysql_query("DELETE FROM messages WHERE `msg`='$rsw'");
			}

		break;

	case 'pagejackpot':
		historypages($value - 1);
		break;

	case 'playergame':
		playergame();
		break;

	case 'lastwinner':
		lastwinner();
		break;

	case 'lootgame':
		game();
		break;

	case 'statjsong':
		statejson(mysql_real_escape_string($_GET['statjsong']));
		break;

	case 'itemsingame':
		itemsingame();
		break;

	case 'activcode':
		activcode(mysql_real_escape_string($_GET['activcode']));
		break;

	case 'inventory':
		inventory(mysql_real_escape_string($_GET['inventory']));
		break;

	case 'comments':
		comments(mysql_real_escape_string($_GET['comments']));
		break;

	case 'insertinventory':
		insertinventory($_SESSION['steamid'], $msg);
		break;

	case 'gettokken':
		gettokken(mysql_real_escape_string($_GET['gettokken']));
		break;

	case 'getUserInfo':
		getUserInfo(mysql_real_escape_string($_GET['getUserInfo']));
		break;

	case 'myhistory':
		myhistory(mysql_real_escape_string($_GET['myhistory']));
		break;

	case 'spotdeteil':
		spotgame(mysql_real_escape_string($_GET['spotdeteil']));
		break;

	case 'allplayer':
		allplayer();
		break;

	case 'shop':
		shop();
		break;

	case 'itemid':
		itemdeteil(mysql_real_escape_string($_GET['itemid']));
		break;

	case 'cost':
		echo getprice(mysql_real_escape_string($_GET['cost']));
		break;

	case 'steamstus':
		echo steamstus();
		break;

	case 'update':
		echo update($BdUser, $BdPass, $BdName, $apiBackPack);
		break;

	case 'newlogin':
		insertinventory(mysql_real_escape_string($_GET['newlogin']));
		break;

	case 'ru':
		setcookie("lang", "ru", 2147485547, "/");
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
		break;

	case 'en':
		setcookie("lang", "en", 2147485547, "/");
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit();
		break;

	case 'exit':
		$_SESSION = array();
		session_destroy();
		header("Location: " . $MainUrl . "");
		break;

	case "freepay":
		$hash = md5($fk_merchant_id . ":" . mysql_real_escape_string($_GET['freepay']) . ":" . $fk_merchant_key . ":" . $_SESSION['steamid']);
		$link = "http://www.free-kassa.ru/merchant/cash.php?m=" . $fk_merchant_id . "&oa=" . mysql_real_escape_string($_GET['freepay']) . "&s=" . $hash . "&o=" . $_SESSION['steamid'] . "";
		header('Location: ' . $link);
		break;

	case "gdonatepay":
		$link = "https://api.gdonate.ru/pay?public_key=" . $publicgdonate . "&sum=" . mysql_real_escape_string($_GET['gdonatepay']) . "&account=" . $_SESSION['steamid'] . "&desc=РћРїР»Р°С‚Р° СѓСЃР»СѓРі " . $SaitBrand . "";
		header('Location: ' . $link);
		break;

	case 'joinf':
		joinf($SaitBrand);
		break;

	case 'allplayer':
		allplayer();
		break;

	default:
		break;
		}
	}

if (isset($_POST['SIGN']))
	{
	$hash = md5($fk_merchant_id . ":" . $_POST['AMOUNT'] . ":" . $fk_merchant_key2 . ":" . $_POST['MERCHANT_ORDER_ID']);
	if ($hash == $_POST['SIGN'])
		{
		$steamid = $_POST['MERCHANT_ORDER_ID'];
		$money = $_POST['AMOUNT'];
		mysql_query("UPDATE account SET `money`=`money`+" . $money . " WHERE `steamid` = '$steamid'");
		}
	  else
		{
		echo 'РћРїР»Р°С‚Р° РЅРµ СѓСЃРїРµС€РЅР°!';
		}
	}

if (isset($_POST['act']))
	{
	switch ($_POST['act'])
		{
	case "buycard":
		buycard(mysql_real_escape_string($_POST['card']));
		break;

	case "buyspot":
		buyspot(mysql_real_escape_string($_POST['mesto']) , mysql_real_escape_string($_POST['game']) , $SteamIdSession);
		break;

	case "savetrade":
		saveurl(mysql_real_escape_string($_POST['linktr']));
		break;

	case "load":
		Load();
		break;

	case "send":
		Send(mysql_real_escape_string($_POST['text']));
		break;

	case "del":
		Del(mysql_real_escape_string($_POST['id']));
		break;

	case "ban":
		ban(mysql_real_escape_string($_POST['steamid']));
		break;

	case "shopsearch":
		search(preg_replace("/[^0-9]/", " ", mysql_real_escape_string($_POST['fromf'])) , preg_replace("/[^0-9]/", " ", mysql_real_escape_string($_POST['to'])));
		break;

	case "namesearch":
		namesearch(preg_replace("/[^A-Za-z0-9]/", " ", mysql_real_escape_string($_POST['query'])));
		break;

	case "buymarket":
		buymarket(mysql_real_escape_string($_POST['buy']));
		break;

	case "addpoint":
		addpoint(mysql_real_escape_string($_POST['color']) , mysql_real_escape_string($_POST['point']));
		break;

	case "openCase":
		openCase($_POST['text']);
		break;	

	default:
		exit();
		}
	}

if (isset($_GET['id']))
	{
	$_SESSION['id'] = $_GET['id'];
	}

if (isset($_GET['key']))
	{
	$_SESSION['key'] = $_GET['key'];
	};
$CountFetchArrayPROF = mysql_query("SELECT * FROM account ORDER BY `won` DESC");
$CountFetchArray = mysql_query("SELECT * FROM account ORDER BY `won` DESC LIMIT 10");
$result = mysql_query("SELECT id FROM games WHERE `starttime` > " . (time() - 86400));
$gamestoday = mysql_num_rows($result);

function curl_get_contents($url)
	{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json"
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$data = curl_exec($ch);
	if ($data === FALSE)
		{
		return "cURL Error: " . curl_error($ch);
		curl_close($ch);
		}
	  else
		{
		return $data;
		curl_close($ch);
		}
	}

function fetchinfo($rowname, $tablename, $finder, $findervalue)
	{
	if ($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
	  else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'") or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	return $row[$rowname];
	}

function update($BdUser, $BdPass, $BdName, $api)
	{
	$time_start = microtime(true);
	$query_count = 0;
	$link = mysqli_connect('localhost', $BdUser, $BdPass, $BdName);
	echo "РџРѕРґРєР»СЋС‡РµРЅРёРµ СѓСЃРїРµС€РЅРѕ!" . PHP_EOL;
	echo "<br/>РРЅС„РѕСЂРјР°С†РёСЏ Рѕ С…РѕСЃС‚Рµ: " . mysqli_get_host_info($link) . "<br/>" . PHP_EOL;
	$prices = json_decode(file_get_contents('http://backpack.tf/api/IGetMarketPrices/v1/?key=566fc5d7b98d889f5be94baa&appid=730') , true);
	if ($prices['response']['success'] == 0)
		{
		die('<br/>Error recieved from backpack.tf: ' . $prices['response']['message']);
		}

	$prices_clean = $prices['response']['items'];
	$fakepricestest = array(
		'response' => array(
			'items' => array(
				'Weapon1' => array(
					'last_updated' => 1336678011,
					'quantity' => 50,
					'value' => 500
				) ,
				'weapon2' => array(
					'last_updated' => 1336678511,
					'quantity' => 75,
					'value' => 650
				)
			)
		)
	);
	$fakepricestest_clean = $fakepricestest['response']['items'];
	$sql = <<<SQL
          DROP TABLE IF EXISTS weapons_temp;
          CREATE TABLE weapons_temp (
	            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              	weaponname varchar(255),
	            lastupdated INT(11),
	            quantity INT,
	            value INT
          );
SQL;
	if ($result = mysqli_multi_query($link, $sql))
		{
		echo $result . " Weapon table created.";
		$link->next_result();
		}
	  else
		{
		die('There was an error running the query [' . $link->error . ']');
		}

	$query_count++;
	if (is_array($prices_clean))
		{
		foreach($prices_clean as $key => $value)
			{
			$sql = "INSERT INTO weapons_temp (weaponname, lastupdated, quantity, value) VALUES 
		('" . mysqli_real_escape_string($link, $key) . "', '" . mysqli_real_escape_string($link, $value['last_updated']) . "', 
		'" . mysqli_real_escape_string($link, $value['quantity']) . "', '" . mysqli_real_escape_string($link, $value['value']) . "');";
			if (!$result = mysqli_multi_query($link, $sql))
				{
				die('There was an error running the query [' . $link->error . ']');
				}

			$query_count++;
			}
		}

	$time = $time_end - $time_start;
	echo "<br/>$query_count Р·Р°РїРёСЃРµР№ РІРЅРµСЃРµРЅРѕ Р·Р° $time СЃРµРєСѓРЅРґ.";
	mysqli_close($link);
	}

function getprice($item)
	{
	$kurs = '0.77';
	$cost = fetchinfo("value", "weapons_temp", "weaponname", $item);
	if (isset($cost))
		{
		$itemprise = $cost * $kurs;
		return floatval($itemprise);
		}
	  else return $item . '+-';
	} ?>