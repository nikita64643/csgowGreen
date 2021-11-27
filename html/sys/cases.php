<?php

function openCase($id){
	$row = mysql_query("SELECT * FROM `case` WHERE `id` = '$id'");
	if(mysql_num_rows($row) == 0){ echo ""; }
	else{	
		while($row1 = mysql_fetch_array($row)){
			if(!isset($_SESSION['steamid'])){
				echo json_encode(['result' => 'false', 'message' => 'no_login']);
			}else{
				if(($_SESSION['money'] - $row1['price']) < 0){
					echo json_encode(['result' => 'false', 'message' => 'no_money']);
				}else{
					$itemsjson = items($id);

					$winid = 10;

					echo json_encode(['result' => 'true','win_slot' => $winid, 'items' => $itemsjson
						]);

				}
			}
		}
	}
}

function items($id)
{
	$items = mysql_query("SELECT * FROM `caseitems` WHERE `case`='$id'");

	while ($row = mysql_fetch_array($items)){
		$slovo = explode("|", $row['steam_name']);
		$randItems[] = ['id' => $row['id'], 'weapon' => $slovo[0], 'name' => $slovo[1], 'image' => $row['avatar'], 'type' => $row['Quality']];
		shuffle($randItems);	
	}

	$itemsjson = getSteamInventory($randItems);

	return $itemsjson;

	foreach($randItems as $new){
		$itemsjson[] = [
		'image' => $new['image'],
		'name_first' => $new['weapon'],
		'name_second' => $new['name'],
		'color' => $new['type']
		];
	}

	$randItem = array_rand($inv1);

	$itemsjson[$winid] = [
	'image' => $randItem['image'],
	'name_first' => $randItem['weapon'],
	'name_second' => $randItem['name'],
	'color' => $randItem['type']
	];

	shuffle($itemsjson);

	return $itemsjson;
}

function getSteamInventory($items){
	global $Functions;
	$json = json_decode(file_get_contents("http://steamcommunity.com/id/funtikkk/inventory/json/730/2?l=russian"),true);
	if(isset($json['rgDescriptions'])){
		$new = [];
		foreach($json['rgDescriptions'] as $key => $botInv){
			foreach($items as $i){
				$str = $i['weapon'].' | '.$i['name'];
				if(strpos($botInv['market_hash_name'], $str) !== false || strpos($botInv['name'], $str) !== false){
					if(strpos($botInv['market_hash_name'], "StatTrak™") !== false){
						$i['stattrak'] = "true";
					}else{
						$i['stattrak'] = "false";
					}
					$i['market_hash_name'] = $botInv['market_hash_name'];
					$i['inventory_id'] = $key;
					foreach($json['rgInventory'] as $rgInv){
						if($rgInv['classid'] == $botInv['classid'] && $rgInv['instanceid'] == $botInv['instanceid']){
							$i['weaponid'] = $rgInv['id'];
							break;
						}
					}
					//$new[] = $i;
				}
			}
		}
		return $new;
		if(count($new) == 0){
			return false;
		}else{
			return $new;
		}
	}else{
		return false;
	}
}

?>