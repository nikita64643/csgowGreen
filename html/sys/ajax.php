<?php
// Функция выполняем сохранение сообщения в базе данных
function Send($text)
{
  if (isset($_SESSION["steamid"])){
	$ban = fetchinfo("ban", "account", "steamid", $_SESSION["steamid"]);
	$game = fetchinfo("games", "account", "steamid", $_SESSION["steamid"]);
	$gameneed = fetchinfo("value", "info", "name","gameforchat");
	if($ban>0){
		$data['status'] = false; 
		$data['msg'] = 'Вы заблокированы'; 
		echo json_encode($data); 
	}else if($game>=$gameneed){	
	    
		$text = substr($text, 0, 200); 
		$text = htmlspecialchars($text); 
		$text = mysql_real_escape_string($text);
	

		$nameid = fetchinfo("personaname", "account", "steamid", $_SESSION["steamid"]);
	    mysql_query("INSERT INTO chat (name,text,steamid) VALUES ('" . $nameid . "', '" . $text . "','" . $_SESSION["steamid"] . "')");
		$data['status'] = true; 
		echo json_encode($data); 
	}else{
		$data['status'] = false; 
		$data['msg'] = 'Недостаточно игр!У вас '.$game.' нужно '.$gameneed.''; 
		echo json_encode($data); 
	}
  }
}
function Ban($ids)
{
	if (!isset($_SESSION["steamid"])) $admin = 0;
	else $admin = fetchinfo("admin", "account", "steamid", $_SESSION["steamid"]);
	if($admin>0){
		
		mysql_query("UPDATE account SET ban='1' WHERE steamid='$ids'") or die(mysql_error());;
							
	}
}
function Del($id)
{
	if (!isset($_SESSION["steamid"])) $admin = 0;
	else $admin = fetchinfo("admin", "account", "steamid", $_SESSION["steamid"])or die(mysql_error());;
	if($admin>0){
		mysql_query("DELETE FROM chat WHERE `id`='$id'");
							
	}
}
// функция выполняем загрузку сообщений из базы данных и отправку их пользователю через ajax виде java-скрипта
//Оправляло ,ебал мучатся переделал на php
function Load(){
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
			'развод',
			'подкрутка',
			'обман',
			'админ',
			'вещи',
			'не пришли',
			'не пришел',
			'говно',
			'подкрутили',
			'подкр',
			'трейд',
			'ливайте',
			'сайт',
			'рулетка',
			'комментарии',
			'сообщения',
			'бот',
			'принимает',
			'баг',
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
			'шта',
			'ноу',
			'втф',
			'бог',
			'',
			'',
			'',
			'гы',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		    '',
		) , $text);



		$avatar = fetchinfo("avatar", "account", "steamid", $value['steamid']);
		if ($admin > 0) $admtext= '<a onclick="delcom(\'' . $value['id'] . '\')">D</a><a onclick="bansteam(\'' . $value['steamid'] . '\')">B</a>';
		else  $admtext='';
		echo '
		
		    <div class="chatMessage clearfix" data-uuid="-K6ghyLFG_JUqeXqsCPj" data-user="' . $value['steamid'] . '">
        '.$admtext.'
        <a href="/profile/' . $value['steamid'] . '" target="_blank"><img src="'.$avatar.'" height="32px" width="32px"></a>
        <div class="login" href="/profile/' . $value['steamid'] . '" target="_blank">' . $value['name'] . '</div>
        
        <div class="body">' . $textchat . '</div>
    </div>
		
		
		
		';
	}

	  
	   
}

}
?>