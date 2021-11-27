<?php
error_reporting(0);
function gettokken($steamid){
	$rs = mysql_query("SELECT * FROM `account` WHERE `steamid`='$steamid'");
	if(mysql_num_rows($rs) == 0) echo'0';	
	else{
		$row = mysql_fetch_array($rs);
		$token = $row['linkid'];
		if(strlen($token) > 5){
			echo'1';
		}
		else echo'2';
	}
}
function allprice($steamid)
{
	$rs2 = mysql_query("SELECT SUM(price) AS value FROM `items` WHERE `steamid`='$steamid'");
	$rows = mysql_fetch_assoc($rs2);
	return round($rows["value"]);
}
function profile($msg,$steamid)
{
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
	 if(mysql_num_rows($win)>0){
		 $winrate = round(100 * mysql_num_rows($win)/ $gamespr);
	 } else $winrate = 0;
	echo'
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    <div class="popup_block" style="display: block;position: relative      ;top: 0%;      left: 0%;">
		<header class="head">
			<h2>'.$msg['profile'].' '.$name.'</h2>
		</header>
    <div class="rank">
        <div class="number" id="reputatd">'.$msg['skrskr'].'
            <br>' . $cash . ' руб.</div>
        <div class="number" id="reputatd">Win Rate
            <br> '.$winrate.' %</div>
        <div class="rank-edit" style="margin-left: 450px;">'.$msg['skrskr1'].'
            <br>' . $gamespr . '</div>
        <div class="rank-edit2">'.$msg['skrskr2'].'
            <br>' . mysql_num_rows($win) . '</div>
    </div>';
	if ($steamid==$_SESSION['steamid']){
	 echo '<a class="Setting" href="/settings/" >'.$msg['setting1'].'</a>
     <a class="Referal" href="/referal/">'.$msg['refcun'].'</a>';
	}echo'
	  <a class="invent" href="#">'.$msg['inv'].'</a>
	  <a class="gamehis" href="#">'.$msg['gamehis'].'</a>
	 ';
	 
	
	echo'<div class="mini-profile" style="border-bottom: 3px solid #ffa200;background: #323640; margin-top:5px; border-top-left-radius: 4px; border-top-right-radius: 4px; padding: 8px 7px; box-sizing: border-box; text-align: center; position: relative;">
						<a href="http://steamcommunity.com/profiles/'. $steamid.'" target="_blank">
							<span class="tooltip"><span class="text">'.$msg['hi'].', '.$name.'</span></span>
							<img src="' . $avatar . '" alt="SiriusMC csgobix.ru" style="width: 120px; height: 120px; box-sizing: border-box; border: 5px solid #2a2d36; border-radius: 50%;">
							<img src="/style/images/img/mini-profile-icon.png" class="mini-profile-icon">
						</a>
						  <a class="rus9pidr" href="http://steamcommunity.com/profiles/'. $steamid.'/" target="_blank">http://steamcommunity.com/profiles/'. $steamid.'/</a>
					</div>		
	<div id="gameid" class="list selector-investments-block" style="margin-top: 13px;">
		<div class="chat-block">
			<h2>'.$msg['spis1'].'</h2>
			
			<div class="profile" style="overflow: scroll;">
				<ul class="selector-investments" style="transform: translateZ(0px);">
		
			
				
			
			
			';
     $username = fetchinfo("hisgames", "account", "steamid", $steamid);
     $username = implode(array_reverse(preg_split('//u', $username)));
     $username = preg_replace('/(\b[\pL0-9]++\b)(?=.*?\1)/siu', '', $username);
     $username = implode(array_reverse(preg_split('//u', $username)));
     if (strlen($username) < 1) {
          echo '<div class="user-history-content" id="showMoreContainer">
                    <div class="deposit-txt-info">
                Вы пока что не участвовали ни в одной игре
            </div>
            </div>';
     }
     else {
          $keywords = preg_split("/[\s,]+/", $username);
            for ($x = 0; $x < count($keywords); $x++) {
			  if($x<=15){
               $gamenum = $keywords[$x];
			   if(is_numeric($gamenum)){
               $winner = 'Не завершена';
               $rs = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$steamid' AND `game`='$gamenum' GROUP BY `userid` ORDER BY `id` DESC");
               $rs2 = mysql_query("SELECT SUM(value) AS value FROM `gamejack` WHERE `userid`='$steamid' AND `game`='$gamenum'");
               $row = mysql_fetch_array($rs);
               $rows = mysql_fetch_assoc($rs2);
               $bank = fetchinfo("cost", "games", "id", $gamenum);
               $win = fetchinfo("userid", "games", "id", $gamenum);
               if (empty($win)) $winner = '<font color="orang">Не окончено</font>';
               else
               if ($win == $steamid) $winner = '<font color="#73D070">Победа</font>';
               else
               if ($win != $steamid) $winner = '<font color="#E0A08D;">Поражение</font>';
                echo '
					<li class="selector-investment-element">
				<p><span class="nick" style="width:20%;display: inline-table;text-align: center;"><a href="/game/'.$gamenum.'" class="game-number">Игра <span style="color:#6b8cf8;">#'.$gamenum.'</span></a></span><span class="afternick" style="width:29%;display: inline-table;text-align: center;">Поставил  ' . round($bank, 1) . ' руб. </span><span class="selector-investment-name" style="width:20%;display: inline-table;text-align: center;">Шанс ' . round($rows["value"] * 100 / $bank, 1) . '%</span> <span class="price" style="width:30%;display: inline-table;text-align: center;"> <span class="selector-investment-sum">'.$winner.'</span>  </span></p>
			</li>
                     ';
			   } }
            }
     }
     echo '	</ul>
			</div>
		</div>
	</div>		';
}

function referal($msg,$SaitBrand){
	 $steamid =$_SESSION['steamid'];
     $gamespr = fetchinfo("games", "account", "steamid", $steamid);
	 $id = fetchinfo("id", "account", "steamid", $steamid);
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
	 $rs3 = mysql_query("SELECT * FROM `account` WHERE  `ref`='$steamid'");
	 $rs2 = mysql_query("SELECT SUM(refmoney) AS refmoney FROM `account` WHERE `ref`='$steamid' ");
	 $rows = mysql_fetch_assoc($rs2);
echo'
    <div class="popup_block" style="display: block;position: relative      ;top: 0%;      left: 0%;">
		<header class="head">
			<h2>'.$msg['profile'].' '.$name.'</h2>
		</header>
    <div class="rank">
        <div class="number" id="reputatd">'.$msg['inviteer1'].'
            <br>' . mysql_num_rows($rs3) . ' </div>

        <div class="rank-edit" <div class="rank-edit" style="
    margin-left: 500px;">'.$msg['inviteer2'].'
            <br>' . round($rows["refmoney"],2) . ' руб.</div>

    </div>';
	if ($steamid==$_SESSION['steamid']){
	 echo '<a class="Setting" href="/settings/" >'.$msg['setting1'].'</a>
     <a class="Referal" href="/referal/">'.$msg['refcun'].'</a>';
	}
	echo'<div class="mini-profile" style="border-bottom: 3px solid #ffa200;background: #323640; margin-top:5px; border-top-left-radius: 4px; border-top-right-radius: 4px; padding: 8px 7px; box-sizing: border-box; text-align: center; position: relative;">
						<a href="http://steamcommunity.com/profiles/'.$_SESSION['steamid'].'" target="_blank">
							<span class="tooltip"><span class="text">'.$msg['hi'].', '.$name.'</span></span>
							<img src="' . $avatar . '" alt="SiriusMC csgobix.ru" style="width: 120px; height: 120px; box-sizing: border-box; border: 5px solid #2a2d36; border-radius: 50%;">
							<img src="/style/images/img/mini-profile-icon.png" class="mini-profile-icon">
						</a>
						  <a class="rus9pidr" href="http://'. $_SERVER['SERVER_NAME'].'?ref='. $id.'" target="_blank">http://'. $_SERVER['SERVER_NAME'].'?ref='. $id.'</a>
 
 
					</div>';
    echo'

<div class="list" style="margin-top: 10px;">
			<div class="chat-block">
			<h2>'.$msg['refshre1'].' <span style="color: blue;">'.$SaitBrand.'</span>?</h2>
				<div class="chat-cover2" style="overflow-y: scroll;">
					<ul>
					<li>
					'.$msg['refshre2'].' «<span style="color: red;">'.$msg['refshre3'].'</span>». 
					<p>'.$msg['refshre4'].'</p>
					</li>
					<li><p>• '.$msg['refshre5'].' </p><span style="font-size: 11px;font-style: italic;"><span style="color: blue;">'.$msg['refshre6'].'</span> '.$msg['refshre7'].' '.$SaitBrand.'. '.$msg['refshre8'].' '.$SaitBrand.' '.$msg['refshre9'].'</span></li>
 <li> <p>• '.$msg['refshre10'].'</p><span style="font-size: 11px;font-style: italic;"><span style="color: blue;">'.$msg['refshre6'].'</span> '.$msg['refshre7'].' '.$SaitBrand.'. '.$msg['refshre11'].'</li></span><p></p> <li><span style="color: red;">'.$msg['ramka1'].'</span> '.$msg['refshre12'].'<p></p></div> <div class="user-profile-content" style="margin-top:20px;">
	
								</li>
																		</ul>
				</div>
			</div>
		</div>


	<div class="user-history-content" id="showMoreContainer">
                    <div class="deposit-txt-info2">
                '.$msg['refshre13'].'
            </div>
            </div>';
     $username = fetchinfo("hisgames", "account", "steamid", $steamid);
	 $rs3 = mysql_query("SELECT * FROM `account` WHERE  `ref`='$steamid'");
	 if (mysql_num_rows($rs3) == 0){
		 echo'<div class="user-history-content" id="showMoreContainer">
                    <div class="deposit-txt-info">
                 '.$msg['refshre14'].'
            </div>
            </div>';
	 }
	 else{
    while ($row2 = mysql_fetch_array($rs3)){
	 $steamidref = $row2['steamid'];
     $nameref = fetchinfo("personaname", "account", "steamid",$steamidref);
	 $cashref = fetchinfo("won", "account", "steamid", $steamidref);
	 $winref = mysql_query("SELECT * FROM `games` WHERE `userid`='$steamidref'"); 
	 $gameref = fetchinfo("games", "account", "steamid", $steamidref);
	 $refmoney = fetchinfo("refmoney", "account", "steamid", $steamidref);
                echo '
                    <div class="table">
				      <div class="list">
        <div class="tb7"><a href="/profile/'.$row2['steamid'].'" class="game-number"><span style="color:#6b8cf8;">'.$nameref.'</span></a> </div>

                    <div class="tb8">
                           '.$msg['refshre15'].' ' . $gameref . '
                    </div>
                    <div class="tb9">
                            <span class="prize-status status-wait">'.$msg['refshre16'].' '.mysql_num_rows($winref).'</span>
                    </div>
                    <div class="tb12">
				    	<div class="chance">'.$msg['refshre17'].' '.$cashref.' руб.</div> 
					</div>
                   <div class="tb12">
				    	<div class="chance">'.$msg['refshre18'].' '.round($refmoney).' руб.</div> 
					</div>

		</div></div>';
			   
	 }}
     
            echo '
       
    </div>

</div>';
	
	
}


function inventory($steamid,$msg) {
	$rs3 = mysql_query("SELECT * FROM `items` WHERE `steamid`='$steamid' ORDER BY `price` DESC");
	echo'
	<div id="inventoryid" class="list selector-investments-block" style="margin-top: 13px;display:none;">
		<div class="chat-block">
			<h2>'.$msg['allprice'].''.allprice($steamid).' руб. ('.mysql_num_rows($rs3).')';
			
			if ($steamid==$_SESSION['steamid']){
			    echo'<span id="update" onclick="getinventoryid();">Обновить</span>';
			}
			echo'</h2>
			
			<div class="profile" id ="inventoryload" style="overflow: scroll;">
				<ul class="selector-investments" style="transform: translateZ(0px);">
		
			
				
			
			
			';
     
	 
     if ( mysql_num_rows($rs3) < 1) {
          echo '<div class="user-history-content" id="showMoreContainer">
                    <div class="deposit-txt-info">
                Инвентарь пуст или невозможно загрузить!
            </div>
            </div>';
     }
     else {
		 while ($row33 = mysql_fetch_array($rs3)) {

                echo '
					<li class="selector-investment-element">
				<p><span class="nick" style="width:20%;margin-left: 50px;display: inline-table;text-align: center;"><a href="http://steamcommunity.com/market/listings/730/'. $row33['market_name'] . '" target="_blank" class="game-number"><img class="aaa itemd tooltipanim" title="' . $row33['market_name'] . '" style = "margin-top: -18px;" src="https://steamcommunity-a.akamaihd.net/economy/image/' . $row33['img'] . '/60fx60f"></a></span><span class="selector-investment-name" style="margin-left: 79px;width: 30%;display: inline-table;text-align: center;">'. $row33['market_name'] . '</span> <span class="price" style="width:30%;display: inline-table;text-align: center;"> <span class="selector-investment-sum">' . $row33['price'] . ' руб.</span>  </span></p>
			</li>
                     ';
			   } 
            }
     
     echo '	</ul>
			</div>
		</div>
	</div>		';
}

// Добавление ссылки обмена в БД + проверки !

function saveurl($saveurl) {
     $data = array();
     $usertd = $_SESSION["steamid"];
     $UserLinkSql = "UPDATE account SET linkid='$saveurl' WHERE steamid='$usertd'";
     if (mysql_query($UserLinkSql)) {
          $data['status'] = true;
          echo json_encode($data);
     }
     else {
          $data['status'] = false;
          echo json_encode($data);
     }
}

// Профиль пользователя


// Отправить коментарий

if (isset($_POST['comment']) && isset($_POST['id'])) {
     $comment = $_POST["comment"];
     $steamid = $_POST["id"];
     $steam = $_SESSION["steamid"];
	 $winneravatar = fetchinfo("avatarfull", "account", "steamid", $steam);
     $name = fetchinfo("personaname", "account", "steamid", $steam);
     $UserComSql = "INSERT INTO comments (comment, steamid, pageid) VALUES ('$comment','$steam','$steamid') ";
     if (mysql_query($UserComSql)) {
        echo '<p style="text-align:left;"><img class="rounded-image profile-image" src="' . $winneravatar . '" height="30px" width="30px"/><strong>' . $name . '</strong> : ' . $comment . '</p>';

     }

}

// Получить коментарии

function comments($userid) {
     $rs = mysql_query("SELECT * FROM `comments` WHERE `pageid`='$userid'");
	 echo'<div id="commentspag">';
     while ($row = mysql_fetch_array($rs)) {
          $winneravatar = fetchinfo("avatarfull", "account", "steamid", $row['steamid']);
          $name = fetchinfo("personaname", "account", "steamid", $row['steamid']);
          $comment = $row['comment'];
          $steamid = $row['steamid'];
          $data = $steamid;
          echo '<p style="text-align:left;"><img class="rounded-image profile-image" src="' . $winneravatar . '" height="30px" width="30px"/><strong>' . $name . '</strong> : ' . $comment . '</p>';
     }

     echo '  </div><form id="sendcomment">
				 <div class="input-group" style="width: 290px;">
                      
                        <input style="width: 261px;" id="com_text" type="text" class="form-control messsageforchat" placeholder="Введите сообщение...">
                            <span class="input-group-btn">
                                <button onclick="sendComm(\'' . $userid . '\')" data-page="'.$userid.'" class="btn btn-primary send-mess-chat" type="button"><i class="fa fa-paper-plane"></i></button>
                            </span>
                  </div>								
				</form>';
}

// Получить цену предмета

function getUserInfo($steamid) {
	 $select = mysql_query("SELECT * FROM `account` WHERE `steamid`='$steamid'");
	 $data = array();
	 if ( mysql_num_rows($select) > 0) {
		 $trade = fetchinfo("linkid", "account", "steamid", $steamid);
		 if(strlen($trade)>5){
			  $winneravatar = fetchinfo("avatarfull", "account", "steamid", $steamid);
	          $personaname = fetchinfo("personaname", "account", "steamid", $steamid);
			  $link = fetchinfo("linkid", "account", "steamid", $steamid);
			  $personaname = str_replace('"', '\"', $personaname);
			  $data['response'] = 'ok';
			  $data['player']['name']=$personaname;
			  $data['player']['ava']=$winneravatar;
			  $data['player']['link']=$link;
			  
		 }else{
			$data['response'] = 'nolink';
		 }
		 
		 
	 }else{		
          $data['response'] = 'noplayer';
	 }
	 echo json_encode($data);
}

function activcode($code){
	if(isset($_SESSION['steamid'])){
	$steamid = $_SESSION['steamid'];
	$rs3 = mysql_query("SELECT * FROM `codes` WHERE `code`='$code' ORDER BY `price` DESC");
    if (mysql_num_rows($rs3) > 0) {
		$row = mysql_fetch_array($rs3);
		$money = $row['price'];
		mysql_query("UPDATE account SET `money`=`money`+".$money." WHERE `steamid` = '$steamid'");
		mysql_query("DELETE FROM codes WHERE id='".$row['id']."'");
		echo'Ваш счёт успешно пополнен на '.$money.'</br>'.$row['text'];
	}else{
		echo'Code not found!';
	}
	}else{
		echo'Авторизуйся,сцук!';
	}
}
function insertinventory($steam,$msg){	
	mysql_query("DELETE FROM items WHERE steamid='$steam'"); 
    $json_decoded_inv = json_decode(file_get_contents('http://steamcommunity.com/profiles/' . $steam . '/inventory/json/730/2/?trading=1'), true);
    // iterate through Inventory and find ids.
    $rgInventory = $json_decoded_inv["rgInventory"];
    $rgInventory = array_values($rgInventory);
    $rgDesc = $json_decoded_inv["rgDescriptions"];
    $rgDesc = array_values($rgDesc);
    $itemnames = array();	   
    for ($i = 0;$i < count($rgInventory);$i++) { 
	          $classidInv = $rgInventory[$i]['classid'];
        $instanceidInv = $rgInventory[$i]['instanceid'];
        for ($j = 0;$j < count($rgDesc);$j++) { //iterate through rgDesc.
            $classid = $rgDesc[$j]['classid'];
            $instanceid = $rgDesc[$j]['instanceid'];
            if ($classidInv == $classid && $instanceidInv == $instanceid) {
                $classids = $rgDesc[$j]['classid'];
				$icon_url = $rgDesc[$j]['icon_url'];
                $market_name = $rgDesc[$j]['market_name'];
                $market_name_formatted = str_replace("'", "", $market_name);
                $st_color = $rgDesc[$j]['name_color'];
                for ($k = 0;$k < count($rgDesc[$j]['tags']);$k++) {
                    if ($rgDesc[$j]['tags'][$k]['category'] == "Rarity") {
                        $name_color = $rgDesc[$j]['tags'][$k]['color'];
                    } else if ($rgDesc[$j]['tags'][$k]['category'] == "Exterior") {
                        $name_exterior = $rgDesc[$j]['tags'][$k]['name'];
                    }
                }
            }
        }
        if ($st_color == "CF6A32") {
            $name_color = "CF6A32";
        }
		$price = getprice($market_name_formatted);
		mysql_query("INSERT INTO items (id,market_name, steamid, img, color, market_id, price) VALUES ('','$market_name', '$steam', '$icon_url', '$name_color', '$classids', '$price')"); 
	}
	 inventory($steam,$msg);
}
?>