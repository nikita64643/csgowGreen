<?php
function statplayer()	{
	$gamenum = fetchinfo("value", "info", "name", "current_game");
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	$maxitems = fetchinfo("value","info","name","maxitems");	
	$r = fetchinfo("starttime", "games", "id", $gamenum);
	if ($r == 2147483647){
		$r='121';
	}else{
		$r+= 120 - time();		
	}
	if ($r < 0){ $r = 0;}
	$r= date("i:s", $r);
	if (isset($_SESSION['steamid'])){
		       	$steamid = $_SESSION['steamid'];
				$balans = fetchinfo("money","account", "steamid", $steamid);
                $result = mysql_query("SELECT SUM(value) AS value FROM `gamejack` WHERE `userid`='$steamid' AND `game`='$gamenum'");
	            $row = mysql_fetch_assoc($result);
	            $winnerpercent = round(fetchinfo("percent","games","id",$gamenum),1);
				$rs = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$steamid' AND `game`='$gamenum'");	
            	if($bank >0)$mypercent = round($row["value"] * 100 / $bank, 1);
             	else $mypercent=0;
				$desitem = mysql_num_rows($rs);
	}else{
		$mypercent = 0;
		$desitem = 0;
	}
	echo '{"bank":"'.round($bank,2).'","maxitems":"'.$maxitems.'","game":"'.$gamenum.'","width":"'.round(fetchinfo("itemsnum","games","id",$gamenum), 2).'","percent":"'.$mypercent.'","items":"'.$desitem.'","time":"'.$r.'"}';

}

function getdatagame($data){
	$rs = mysql_query('SELECT * FROM `games` WHERE `data` LIKE "%'.$data.'%" ORDER BY `id` ASC');
	if (mysql_num_rows($rs) == 0){
	   echo '<li><center>За данный день игр небыло </center><li>';
	}
	else{
	while ($row = mysql_fetch_array($rs)) {
		$game = $row["id"];
		$lastwinner = $row["userid"];
		$winnercost = $row["cost"];
		$winnerpercent = $row["percent"];
		$winneravatar = fetchinfo("avatarfull", "account", "steamid", $lastwinner);
		$winnername = fetchinfo("personaname", "account", "steamid", $lastwinner);
		$gamejack = 'jack'.$row["id"];	
		$wuserid = fetchinfo("status", "queue", "unic",$gamejack);
		$status= '';
		if ($wuserid == 'active') $status= '  <span class="order-status sended">В процессе</span>';
		else if (stristr($wuserid, "sent")) {
			$wuseridf = fetchinfo("tradeStatus", "queue", "unic",$gamejack);
			if($wuseridf == '8'){
					$status= '  <span class="order-status sended">Принят</span>';
			}else if($wuseridf == '0'){
					$status= '  <span class="order-status sended">Отправлен</span>';
			}else 	$status= '  <span class="order-status sended">Ошибка</span>';
		
			
		}
		echo '<li>
                    <div class="visual"> <img src="' . $winneravatar . '" height="123" width="124"> <span class="gamenumid">#'.$game.'</span></div>
                    <div class="list-name">
                    <ul>
                        <li>
                            <p> Никнейм: <span class="nick">'.$winnername.'</span>
                            </p>
                        </li>
                        <li>
                            <p> Шанс победителя: <span class="pers">'.round($winnerpercent).'%</span>
                            </p>
                        </li>
                        <li>
                             <p> Сумма джекпота: <span class="pers">'.round($winnercost).' руб</span>
                            </p>
                        </li>
                        <li>
                             <p> Статус обмена: <span class="stat">
                    											 '.$status.'																									</span> </p>
                         </li>
                    </ul>
                    </div>
                    <div class="stuffs">
                    <ul>';
		$rs2 = mysql_query("SELECT * FROM `gamejack` WHERE `thisitem`='yes' AND `game`='$game'");
		while ($row2 = mysql_fetch_array($rs2)) {
			echo '
			<li style="border:2px solid '.$row2["itemtype"].';">
			<a href="javascript:;">
			    <div class="icon"><img class="tooltipanim" title="' . $row2["item"] . '" src="' . $row2["image"] . '/100fx100f">
			    </div> <span><span class="item-price" style="display: inline;">' . $row2["value"] . '</span> Руб</span>
			</a>
			</li>';
		}

		$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `thisitem`='no' AND `game`='$game'");
		while ($row34 = mysql_fetch_array($rs4)) {
			echo '
			<li>
			<a href="javascript:;">
			    <div class="icon"><img class="tooltipanim" title="Card ' . $row34["value"] . '" src="/style/images/card.png">
			    </div> <span><span class="item-price" style="display: inline;">' . $row34["value"] . '</span> Руб</span>
			</a>
			</li>';
		}

		echo '</ul></div><a class="more" href="/game/'.$game.'"></a></li>';
	}
	}
}
function historypages($page){
	$gamenum = fetchinfo("value", "info", "name", "current_game");
	$per_page = 5;
	$start = abs($page * $per_page);
	$rs = mysql_query("SELECT * FROM `games` WHERE `id` < $gamenum ORDER BY `id` DESC LIMIT $start,$per_page");
	while ($row = mysql_fetch_array($rs)) {
		$game = $row["id"];
		$data = $row["data"];
		$lastwinner = $row["userid"];
		$winnercost = $row["cost"];
		$winnerpercent = $row["percent"];
		$winneravatar = fetchinfo("avatarfull", "account", "steamid", $lastwinner);
		$winnername = fetchinfo("personaname", "account", "steamid", $lastwinner);
		$gamejack = 'jack'.$row["id"];	
		$wuserid = fetchinfo("status", "queue", "unic",$gamejack);
		$status= '';
		if ($wuserid == 'active') $status= '  <span class="order-status sended">В процессе</span>';
		else if (stristr($wuserid, "sent")) {
			$wuseridf = fetchinfo("tradeStatus", "queue", "unic",$gamejack);
			if($wuseridf == '8'){
					$status= '  <span class="order-status sended">Принят</span>';
			}else if($wuseridf == '0'){
					$status= '  <span class="order-status sended">Отправлен</span>';
			}else 	$status= '  <span class="order-status sended">Ошибка</span>';
		
			
		}
		echo '<li>
                    <div class="visual"> <img src="' . $winneravatar . '" height="123" width="124"> <span class="gamenumid">#'.$game.'</span><span class="gamenumdata">'. date('H:i-d.m.Y', strtotime($data)).'</span></div>
                    <div class="list-name">
                    <ul>
                        <li>
                            <p> Никнейм: <span class="nick"> <a href="/profile/'.$row["steamid"].'">'.$winnername.'</a></span>
                            </p>
                        </li>
                        <li>
                            <p> Шанс победителя: <span class="pers">'.round($winnerpercent).'%</span>
                            </p>
                        </li>
                        <li>
                             <p> Сумма джекпота: <span class="pers">'.round($winnercost).' руб</span>
                            </p>
                        </li>
                        <li>
                             <p> Статус обмена: <span class="stat">
                    											 '.$status.'																									</span> </p>
                         </li>
                    </ul>
                    </div>
                    <div class="stuffs">
                    <ul>';
		$rs2 = mysql_query("SELECT * FROM `gamejack` WHERE `thisitem`='yes' AND `game`='$game' ORDER BY `value` DESC");
		while ($row2 = mysql_fetch_array($rs2)) {
			echo '
			<li style="border:2px solid '.$row2["itemtype"].';">
			<a href="javascript:;">
			    <div class="icon"><img class="tooltipanim" title="' . $row2["item"] . '" src="' . $row2["image"] . '/100fx100f">
			    </div> <span><span class="item-price" style="display: inline;">' . $row2["value"] . '</span> Руб</span>
			</a>
			</li>';
		}

		$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `thisitem`='no' AND `game`='$game' ORDER BY `value` DESC");
		while ($row34 = mysql_fetch_array($rs4)) {
			echo '
			<li>
			<a href="javascript:;">
			    <div class="icon"><img class="tooltipanim" title="Card ' . $row34["value"] . '" src="/style/images/card.png">
			    </div> <span><span class="item-price" style="display: inline;">' . $row34["value"] . '</span> Руб</span>
			</a>
			</li>';
		}

		echo '</ul></div><a class="more" href="/game/'.$game.'"></a></li>';
	}
}

function playergame(){
	$gamenum = fetchinfo("value", "info", "name", "current_game");
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	$rs = mysql_query("SELECT * FROM `gamejack` WHERE `game`='$gamenum' GROUP BY `userid`");
	if (mysql_num_rows($rs) == 0){
	   echo '';
	}
	else{
		while ($row = mysql_fetch_array($rs)){
			$avatar = $row["avatar"];
			$userid = $row["userid"];
			$username = fetchinfo("personaname", "account", "steamid", $userid);
			$rs2 = mysql_query("SELECT SUM(value) AS value FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum'");
			$row = mysql_fetch_assoc($rs2);
			$sumvalue = $row["value"];			
			echo '	
													<div class="block"><div class="chance">' . round($row["value"] * 100 / $bank, 1) . "%" . '</div><img src="' . $avatar . '" alt="" title=""></div>
																
	';
		}
	}
}
function lastwinner(){
	$gamenum = fetchinfo("value", "info", "name", "current_game");
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	$lastgame = fetchinfo("value","info","name","current_game");
	$lastwinner = fetchinfo("userid","games","id",$lastgame-1); 
	$winneravatar = fetchinfo("avatarfull","account","steamid",$lastwinner);
	$winnername = fetchinfo("personaname","account","steamid",$lastwinner);

	$winnerpercent = round(fetchinfo("percent","games","id",$lastgame-1),1);
	$winnercost = fetchinfo("cost","games","id",$lastgame-1);
	
	echo'<span id="winavatar">
<img src="'.$winneravatar.'" alt="" title=""></span>
			<ul>
				<li id="winidrest"><a href="/profile/'.$lastwinner.'">'.$winnername.'</a></li>
				<li id="winmoner">Выигрыш: '.round($winnercost).' руб.</li>
				<li id="winchancet">Шанс: '.$winnerpercent.'%</li>
			</ul>';
}

function steamstus(){
	$url = "http://is.steam.rip/api/v1/?request=SteamStatus";
	$stat = curl_get_contents($url);
	$stat = str_replace("normal", "<font color='green'>Нормально</font>", $stat);
	$stat = str_replace("delayed", "<font color='orange'>Медленно</font>", $stat);
	echo $stat;
}
function allgamestat(){
			$session=$_SERVER['REMOTE_ADDR'];
            $time=time();
            $time_check=$time-600; //SET TIME 10 Minute
		    $tbl_name="user_status_online";
			$sql="SELECT * FROM $tbl_name WHERE session='$session'";
            $result=mysql_query($sql);
			$count=mysql_num_rows($result);
			if($count=="0"){
                 $sql1="INSERT INTO $tbl_name(session, time)VALUES('$session', '$time')";
                 $result1=mysql_query($sql1);
            }
			else {
                  $sql2=("UPDATE $tbl_name SET time='$time' WHERE session = '$session'");
                  $result2=mysql_query($sql2);
            }
			$sql3="SELECT * FROM $tbl_name";
$result3=mysql_query($sql3);
$count_user_online=mysql_num_rows($result3);
 $fake = fetchinfo("value","info", "name", "fakeonline");
 if($fake>0) $count_user_online=$count_user_online+$fake;
// if over 10 minute, delete session 
$sql4="DELETE FROM $tbl_name WHERE time<$time_check";
$result4=mysql_query($sql4);
											$result = mysql_query("SELECT id FROM games WHERE `data` >= CURDATE()");
											$today = mysql_num_rows($result);
											$resulta = mysql_query("SELECT id FROM games WHERE `data` >= CURDATE()");
											$todaypl = mysql_num_rows($resulta);
											$result = mysql_query("SELECT MAX(cost) AS cost FROM games WHERE `data` >= CURDATE()");
						                    $row = mysql_fetch_assoc($result);
											$item = round($row["cost"]);

						$result = mysql_query("SELECT MAX(cost) AS cost FROM games");
						$row = mysql_fetch_assoc($result);
						$maxcost =  $row["cost"];
						$maxcostf = round($maxcost,2);
							if (isset($_SESSION['steamid'])){
		                 	$steamid = $_SESSION['steamid'];
				            $balans = fetchinfo("money","account", "steamid", $steamid);
							}else $balans=0;
		echo '{"online":'.$count_user_online.',"balans":"'.round($balans).'","today":'.$today.',"itemsall":'.$item.',"maxwin":'.$maxcostf.'}';
}
function statejson($gamenum ){
    $rs = mysql_query("SELECT * FROM `gamejack` WHERE `game`='$gamenum' GROUP BY `userid` ORDER BY `id` DESC");
	$lastgame = fetchinfo("value","info","name","current_game");
	$lastwinner = fetchinfo("userid","games","id",$gamenum ); 
	$winneravatar = fetchinfo("avatarfull","account","steamid",$lastwinner);
	$winnername = fetchinfo("personaname","account","steamid",$lastwinner);
	$winnerpercent = round(fetchinfo("percent","games","id",$gamenum),1);
	$winnercost = fetchinfo("cost","games","id",$gamenum);
    echo'{"win_id":"'.$lastwinner.'","win_name":"'.$winnername.'","win_avatar":"'.$winneravatar.'","win_percent":"'.$winnerpercent.'","win_cost":"'.round($winnercost,2).'"}';
}
function buycard ($cardvalue){
	if($cardvalue>1){	
	$gamenum = fetchinfo("value", "info", "name", "current_game");
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	$avatar = $_SESSION['avatarfull'];
	$steamid = $_SESSION['steamid'];
	$steamname = $_SESSION['personaname'];
	$maxitems = fetchinfo("value", "info", "name", "maxitems");
	$fuck = mysql_query("SELECT * FROM `gamejack` WHERE `userid` = '$steamid' AND `game` = '$gamenum'");
    if(mysql_num_rows($fuck)< $maxitems){
	  if ($_SESSION['money'] >= $cardvalue) {
	     $newbankcard = $bank+$cardvalue;
		 $RemoveMoney = $_SESSION['money'] -$cardvalue;
		 $mov = mt_rand(1111111111111111,9999999999999999);
         mysql_query("INSERT INTO gamejack (userid, username, item, itemtype, value, avatar, card, thisitem, `from`, `to` ,game, tradeid) VALUES ('$steamid', '$steamname', 'Card', 'rgb(255,255,255)', '$cardvalue', '$avatar', '$cardvalue', 'no', '$bank', '$newbankcard', '$gamenum', '$mov')")or die(mysql_error());		
	     mysql_query("UPDATE account SET money=$RemoveMoney, hisgames =concat(`hisgames`, '$gamenum') WHERE `steamid` = '$steamid'");
		 mysql_query("UPDATE account SET hisgames =concat(`hisgames`, ',$gamenum,') WHERE `steamid` = '$steamid'");
		 mysql_query("UPDATE games SET cost=cost+$cardvalue,itemsnum=itemsnum+1 WHERE `id` = '$gamenum'");
		 echo'Карточка куплена и выставлена в игру';
		 
	  }
	  else{
		  echo'Недостаточно денег на счету';
	  }
    }
	else{
		 echo'Вы выставили максимум вещей';
	}
	}else{
		echo'Минимум 1 рубль';
	}
}
function getgame($msg,$gamenum){
	
	
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	$winname = fetchinfo("winner", "games", "id", $gamenum);
	$useridwin = fetchinfo("userid", "games", "id", $gamenum);
	$avatarfull = fetchinfo("avatarfull", "account", "steamid", $useridwin);
	$percentwin = fetchinfo("percent", "games", "id", $gamenum);
    $winid = fetchinfo("cost", "games", "id", $gamenum);
			
	
	echo '
	
	<header class="head">
			<h2>'.$msg['histgame'].' #'.$gamenum.'</h2>
		</header>
	
	<div class="history">
		<ul>
			<li>
				<div class="visual">
					<img src="'.$avatarfull.'" height="123" width="124" >
				</div>
				<div class="list-name">
					<ul>
						<li>
							<p> Никнейм: <a href="/profile/'.$useridwin.'"><span class="nick">'.$winname.'</span></a></p>
						</li>
						<li>
							<p> Шанс победителя <span class="pers">'.round($percentwin).'%</span></p>
						</li>
						<li>
							<p> Сумма джекпота: <span class="pers">'.round($winid).' руб</span></p>
						</li>
						<li>
														<p>
								Статус обмена:
								<span class="stat">
																			 Отправлен 																	</span>
							</p>
						</li>
					</ul>
				</div>
				<div class="stuffs">
					<ul>';
					$rs3 = mysql_query("SELECT * FROM `gamejack` WHERE  `thisitem`='yes' AND `game` = '$gamenum'");
			    while ($row2 = mysql_fetch_array($rs3)){
				 echo '
							<li>
	<a href="javascript:;">

		<div class="icon"><img class= "tooltipanim"  title="' . $row2["item"] . '" src="' . $row2["image"] . '/100fx100f"></div>
		<span><span class="item-price" style="display: inline;">' . $row2["value"] . '</span> Руб</span>
	</a>
</li>
                   ';
				}
				$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `thisitem`='no' AND `game` = '$gamenum'");
			    while ($row34 = mysql_fetch_array($rs4)){
				 echo '
 <li>
	<a href="javascript:;">

		<div class="icon"><img class= "tooltipanim"  title="Card ' . $row34["value"] . '" src="/style/images/card.png"></div>
		<span><span class="item-price" style="display: inline;">' . $row34["value"] . '</span> Руб</span>
	</a>
</li>';
				}
					
					
					echo'
					
					
									

											</ul>
				</div>
			</li>
		</ul>
	</div>
	
	
	
	<div class="history-match-detail">
		<div class="list" style="margin-top: 0px;">
			<div class="chat-block">
			<h2>Список вложений</h2>
				<div class="chat-cover" style="overflow-y: scroll;">
					<ul style="transform: translateZ(0px) translateY(-46px);margin-top: 40px;">';
						$rs = mysql_query("SELECT * FROM `gamejack` WHERE `game`='$gamenum'  ORDER BY `id` DESC")or die(mysql_error());
	                  while ($row = mysql_fetch_array($rs)){
								echo '<li>
									<p>
																					<span class="nick">'.$row['username'].'</span>
											внёс
																				'.$row['item'].'
										на сумму
										<span class="price">'.$row['value'].' руб</span>
										
									</p>
								</li>';
					  }
															echo'
																		</ul>
				</div>
			</div>
		</div>
		<div class="invest-list">
			<ul>';
			$rs = mysql_query("SELECT * FROM `gamejack` WHERE `game`='$gamenum' GROUP BY `tradeid` ORDER BY `id` DESC")or die(mysql_error());
	if (mysql_num_rows($rs) == 0){
	}
	else{
		while ($row = mysql_fetch_array($rs)){
			$avatar = $row["avatar"];
			$userid = $row["userid"];
		
			$tradeid = $row["tradeid"];
			$username = fetchinfo("personaname", "account", "steamid", $userid);
			$rs2 = mysql_query("SELECT SUM(value) AS value FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum'");
			$sd = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum' ORDER BY `to` DESC");
			$rows = mysql_fetch_assoc($rs2);
			$sows = mysql_fetch_assoc($sd);
			$sumvalue = $rows["value"];
			$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum'");
			
			
			

			echo '	

		<li>
						<div class="ava_holder">
							<div class="ava">
								<img src="' . $avatar . '" height="59" width="59" alt="">
							</div>
							<div class="rang">
								<img src="/images/csbets/rang.png" height="26" width="79" alt="">
							</div>
						</div>
						<div class="invest-holder">
							<p><span class="nick">	<a href="/profile/'.$userid.'" class="username " >' . $username . ' </a></span> внёс '.mysql_num_rows($rs4).' предметов на сумму <span class="price">' . round($sumvalue, 2) . ' руб</span> <span class="pers">(' . round($rows["value"] * 100 / $bank, 1) . ' %)</span></p>
							<ul class="stuffs">
									
	
						    			
			
			
			';
			    $rs3 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `thisitem`='yes' AND `game`='$gamenum' AND `tradeid`='$tradeid'");
			    while ($row33 = mysql_fetch_array($rs3)){
				 echo '
				 							
									<li style="border:2px solid '.$row33["itemtype"].'">
										<a href="javascript:;">

											<div class="icon"><img class="tooltipanim" src="' . $row33["image"] . '/140fx70f" title="' . $row33["item"] . '"></div>
											<span><span class="item-price" style="display: inline;">' . $row33["value"] . '</span> Руб</span>
										</a>
									</li>

				 
				 
				 
				 
				 
				 
                    ';
				}
			$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `thisitem`='no'  AND `game`='$gamenum' AND `tradeid`='$tradeid'");
			    while ($row34 = mysql_fetch_array($rs4)){
				 echo '
				  				
									<li class="border-color-01">
										<a href="javascript:;">

											<div class="icon"><img class="tooltipanim" src="\style\images\card.png" title="' . $row34["item"] . '"></div>
											<span><span class="item-price" style="display: inline;">' . $row34["value"] . '</span> Руб</span>
										</a>
									</li>
			
                     ';
				}

			echo '	</ul>
						</div>
					</li>
							
		';
		}echo'</ul>';
	}
			
			
			
			
			
			

		
	
}
function itemsingame(){
    $gamenum = fetchinfo("value", "info", "name", "current_game");
    $bank = fetchinfo("cost", "games", "id", $gamenum);
	if (!isset($_SESSION["steamid"])) $admin = 0;
	else $admin = fetchinfo("admin", "account", "steamid", $_SESSION["steamid"]);
	$ls = 0;
	$rs = mysql_query("SELECT * FROM `gamejack` WHERE `game`='$gamenum' GROUP BY `tradeid` ORDER BY `id` DESC")or die(mysql_error());
	if (mysql_num_rows($rs) == 0){
	}
	else{
		while ($row = mysql_fetch_array($rs)){
			$ls++;
			$avatar = $row["avatar"];
			$userid = $row["userid"];
			$tradeid = $row["tradeid"];
			$username = fetchinfo("personaname", "account", "steamid", $userid);
			$rs2 = mysql_query("SELECT SUM(value) AS value FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum'");
			$sd = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum' ORDER BY `to` DESC");
			$rows = mysql_fetch_assoc($rs2);
			$sows = mysql_fetch_assoc($sd);
			$sumvalue = $rows["value"];
			$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `game`='$gamenum'");
			if ($admin > 0) $admtext = "<a style=\"color: #FF0000\" href=\"setwinner.php?user=$userid\"> (Победитель)</a>";
			else $admtext = "";
			$result = mysql_query("SELECT * FROM `gamejack` WHERE `tradeid` = '$tradeid' AND `game`='$gamenum' ORDER BY `from` ASC");
			$rowf = mysql_fetch_assoc($result);
			$from = round($rowf["from"]);
			$result = mysql_query("SELECT * FROM `gamejack` WHERE `tradeid` = '$tradeid' AND `game`='$gamenum' ORDER BY `to` DESC");
			$rowf = mysql_fetch_assoc($result);
			$to = round($rowf["to"]);
			echo '
			
			
			
			
			<li class="selector-rate">
	<div class="ava_holder">
		<div class="ava">
			<img class="selector-rate-depositor-image" src="' . $avatar . '"  height="59" width="59">
		</div>
	</div>
	<div class="invest-holder">
		<p><span class="nick selector-current-item-depositor" ><a style="color:red;" href="/profile/'.$userid.'">' . $username . '</a>'.$admtext   .'</span> внёс <span class="selector-rate-items-count">'.mysql_num_rows($rs4).'</span> предметов на сумму <span class="price"><span class="selector-curren-item-price">' . round($sumvalue, 2) . '</span> руб.</span> <span class="pers">(<span class="selector-chance">' . round($rows["value"] * 100 / $bank, 1) . '</span> %)</span><span style="right: 0px;color: red;float:right;">Билеты: с <font color="#54c74c">#'.$from.'</font> по <font color="#54c74c">#'.$to.'</font></span></span></p>
		<ul class="stuffs selector-items first second">';
			    $rs3 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `thisitem`='yes' AND `game`='$gamenum' AND `tradeid`='$tradeid'");
			    while ($row33 = mysql_fetch_array($rs3)){
				 echo '
				 <li style="border: 2px solid '. $row33["itemtype"] .'" data-item-id="">
	<a href="javascript:;">
		<span class="tooltip">
			<span class="text selector-current-item-name item-name">' . $row33["item"] . '</span>
		</span>
		<div class="icon"><img class="selector-current-item-image" src="' . $row33["image"] . '/140fx70f" alt="' . $row33["item"] . '"></div>
		<span><span class="selector-current-item-price item-price" style="display: inline;">' . round($row33["value"] ,2). '</span> руб.</span>
	</a>
</li>';
				}
			$rs4 = mysql_query("SELECT * FROM `gamejack` WHERE `userid`='$userid' AND `thisitem`='no'  AND `game`='$gamenum' AND `tradeid`='$tradeid'");
			    while ($row34 = mysql_fetch_array($rs4)){
				 echo '
				  
				 <li style="border: 2px solid '. $row34["itemtype"] .'" data-item-id="">
	<a href="javascript:;">
		<span class="tooltip">
			<span class="text selector-current-item-name item-name">' . $row34["item"] . '-' . $row34["value"] . '</span>
		</span>
		<div class="icon"><img class="selector-current-item-image" src="/style/images/card.png" alt="' . $row34["item"] . '"></div>
		<span><span class="selector-current-item-price item-price" style="display: inline;">' . $row34["value"] . '</span> руб.</span>
	</a>
</li>';
				}

			echo '	</ul>
	</div>
</li>
			';
		}
	}

	echo "<script>if(sound){if(bets < $ls) { $('#newitem')[0].play();} bets = $ls;}</script>";




}
?>