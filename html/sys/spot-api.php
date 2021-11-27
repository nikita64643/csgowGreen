<?php
include("lib/RandomDotOrg.php");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_GET['pagespot'])) {
    $page = $_GET['pagespot'] - 1;
    historyspotpages($page);
}
function historyspotpages($page){
	$per_page = 5;
	$start = abs($page * $per_page);
	$rs = mysql_query("SELECT * FROM `spotinfo` ORDER BY `game` DESC LIMIT $start,$per_page");
	while ($row = mysql_fetch_array($rs)) {
		if (strlen($row["winner"]) > 5) {
			$lastwinner = $row["winner"];
			$winnercost = $row["value"];
			$winneravatar = fetchinfo("avatarfull", "account", "steamid", $lastwinner);
			$winnername = fetchinfo("personaname", "account", "steamid", $lastwinner);
			$game = $row["game"];
			$mest = mysql_query("SELECT * FROM `spotgames` WHERE `steamid`='$lastwinner' AND `game`='$game'");
			echo '<div class="short">
			<div class="top">
				<div class="avatar"><img src="' . $winneravatar . '" alt="" title=""></div>
				<ul>
			
					<li><a href="/profile/' .$lastwinner.'" data-profile="76561198133151686">' . $winnername . '</a></li>
					<li>Выигрыш: <span>' . round($winnercost, 2) . ' руб.</span> </li>
			<li>Купил мест: <span>' . mysql_num_rows($mest) . '%</span></li>
				</ul>
					<div class="h-blanks">';
		$wuserid = '';
		if ($wuserid == 'active') echo '  <span class="order-status sended">В ожидании отправки</span>';
		if ($wuserid == 'sent') echo '  <span class="order-status sended">Выигрыш отправлен</span>';
		echo ' ИГРА <span>#' . $row["game"] . '</span><br /><a href="/game/6475">Посмотреть полную историю игры</a><br /><span class="com">Выигрыш с учётом коммисии</span></div></div><div class="items">';		
			echo '<div class="itm">
					<img class="itemd tooltipanim" title="' . $row["item"] . '" src="' . $row["img"] . '" width="60" height= "59">
					<div class="price">' . $row["value"] . ' руб.</div></div>';
			echo '</blockquote></div></div></div>';
		}
	}
}
function spot() {
    $rs = mysql_query("SELECT * FROM `spotinfo` ORDER BY `id` DESC") or die(mysql_error());
    while ($row = mysql_fetch_array($rs)) {
        $game     = $row["game"];
        $rsf      = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' AND `steamid`='1'");
        $vsego    = $row["mest"];
        $svobodno = mysql_num_rows($rsf);
        $zanato   = $vsego - $svobodno;
        $proz     = $zanato * 100 / $vsego;
        echo '    <div class="lottery-item">
            <div class="jprice lot-price" style="width: 64px;" data-toggle="tooltip" data-placement="top" title="Купить билеты"><span>' . $row["qual"] . ' <u>руб</u></span></div>
            <div class="jprice lot-places" style="width: 79px;" data-toggle="tooltip" data-placement="top" title="Купить билеты"><span>' . $row["mest"] . ' <u>мест</u></span></div>
            <div class="lottery-item-image">
                <a href="/spot/'.$game.'"  data-toggle="modal" data-target="#spotgame"><img src="' . $row["img"] . '" style="padding-top:30px;"></a>
            </div>
            <div class="lottery-item-desc">
                <ul>
                    <li class="name">' . $row["item"] . '</li>
                    <li class="exterior WearCategory4 Rarity_Ancient_Weapon">' . $row["rarity"] . '</li>
                    <!--
                    <li class="rarity Rarity_Ancient_Weapon">' . $row["info"] . '</li>
                    -->
                    <li class="steamPrice" style="padding-right: 0px">Цена в стиме <span style="float: right; font-size: 14px; line-height: 14px; color: #fff;">' . $row["value"] . ' <span style="font-size: 10px;">руб</span></span></li>
                </ul>
                <div class="progress">
                    <div class="progress-bar " style="width: ' . $proz . '%;"></div>
                </div>
                <div class="places">Осталость мест: <span>' . $svobodno . '</span></div>
            </div>
            
            <a href="/spot/'.$game.'"  data-toggle="modal" data-target="#spotgame" class="participate">Купить за ' . $row["qual"] . ' руб</a>
            
        </div>';
    }
}
function getwinner($mest, $game) {
    $random    = new RandomDotOrg('718b47a4-8c49-471f-8064-0d0269902cf7'); // API key
    $signed    = $random->Rand_om(1, $mest); // выбрать число от 1 до 100 
    $randoms   = $signed['random']['data'][0];
    $tabs      = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' AND `mesto`='$randoms'");
    $tab       = mysql_fetch_assoc($tabs);
    $winner    = $tab["steamid"];
    $ra        = $random->encodeJson($signed['random'], true);
    $sig       = $signed['signature'];
    $items     = fetchinfo("market_name", "spotinfo", "game", "$game");
    $tradelink = fetchinfo("linkid", "account", "steamid", "$winner");
    $token     = substr(strstr($tradelink, 'token='), 6);
    mysql_query("UPDATE spotinfo SET winner='$winner',signatura='$sig',random='$ra',randomslot='$randoms' WHERE `game` = '$game'") or die(mysql_error());
    mysql_query("INSERT INTO `queue` (`id`,`userid`,`token`,`items`,`status`) VALUES ('','$winner','$token','$items','active')");
}
function buyspot($mesto, $game) {
	if(isset($_SESSION['steamid'])){
	$SteamIdSession= $_SESSION['steamid'];
	$CurrentUserName =  $_SESSION['personaname'];
    if (isset($SteamIdSession)) {
        $zena   = fetchinfo("qual", "spotinfo", "game", "$game");
        $avatar = $_SESSION['avatarfull'];
        $rs = mysql_query("SELECT * FROM `spotgames` WHERE `mesto` = '$mesto' AND `game` = '$game'") or die(mysql_error());
        $zan9to = $rs["steamid"];
        if (strlen($zan9to) > 5)
            echo 'Данное место уже куплено';
        else {
            if ($_SESSION['money'] >= $zena) {
                $RemoveMoney = $_SESSION['money'] - $zena;
                $date        = date('Y-m-d H:i:s');
                mysql_query("UPDATE account SET money=$RemoveMoney,mest=mest+1 WHERE `steamid` = '$SteamIdSession'") or die(mysql_error());
                mysql_query("UPDATE spotgames SET steamid='$SteamIdSession',avatar='$avatar',name='$CurrentUserName',data='$date' WHERE `mesto` = '$mesto' AND `game` = '$game'") or die(mysql_error());
                echo 'Место успешно куплено и занято!';
            } else
                echo 'Недостаточно денег';
        }
    } else echo 'Авторизируйтесь для участия в игре!';
	}else{
		echo'Авторизируйтесь ';
	}
}
function lastspot($msg){
		$rs3 = mysql_query("SELECT * FROM `spotinfo` LIMIT 6");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo ' 
                <div class="short tooltipanim " title="' . $row33["item"] . '" >
					<a href="/shop"><img src="' . $row33["img"] . '" width ="71px" height="62px" alt="" title=""></a>
					<div class="pricef">' . $row33["mest"] . ' мест</div>
				</div>		
	           <!-- </item> -->'; 
	     } 
		 echo '<div class="buttons" style="    display: block;margin-top: 170px;margin-left: 150px;"> 
				<a class="skins" href="/spot">' . $msg["spotes1"] . '</a>		
				</div>';
		
	}
}
function spotgame($game) {
	if(isset($_SESSION['steamid'])){
		$SteamIdSession= $_SESSION['steamid'];
		$rsg      = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' AND `steamid`='$SteamIdSession'");
		$vi= mysql_num_rows($rsg);
	}else{
		$vi = 0;
	}
    $rs = mysql_query("SELECT * FROM `spotinfo` WHERE `game`='$game'") or die(mysql_error());
    $rsf      = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' AND `steamid`='1'");

    $row      = mysql_fetch_array($rs);
    $vsego    = $row["mest"];
    $svobodno = mysql_num_rows($rsf);
    $zanato   = $vsego - $svobodno;
    $width    = $zanato * 100 / $vsego;
    echo '
		<header class="head">
			<h2>Розыгрывается ' . $row["item"] . '</h2>
		</header>


	
     <div class="about" style=" padding: 0; ">
     <span class="wineinf">
      Победитель: будет объявлен через <span class="wineinfs">' . $svobodno . '</span> мест. </span>
     <span class="wineinf2">Вы занимаете <span class="mez">'.$vi.'</span> мест для этого предмета.</span>
     <div class="giveaway"><img src="' . $row["img"] . '" title ="' . $row["item"] . '" height="85px" width="85px"  class="tooltipanim giveaway_subject"></div>
     <div class="panel"><span class="gusers" style=" margin-left: 130px; ">Всего <span id="gusersgi">' . $zanato . '</span> мест занято</span>
     <span id="offgamess"><a class="add" id="add_to_giveaway" >Всего ' . $svobodno . ' свободно</a></span>
';
 $bank = fetchinfo("winner", "spotinfo", "game", $game);
if (strlen($bank) > 5) {
 $name   = fetchinfo("personaname", "account", "steamid", $bank);
 $winner = $name;
}
else $winner = 'не выбран';
echo'<span class="gusers2">Победитель: '.$winner.'. </span></div> ';
   
    if ($svobodno == 0 && strlen($bank) < 5)
        getwinner($vsego, $game);
    if (strlen($bank) > 5) {
        $avatar = fetchinfo("avatarfull", "account", "steamid", $bank);
        $name   = fetchinfo("personaname", "account", "steamid", $bank);
        $ra     = fetchinfo("random", "spotinfo", "game", $game);
        $sig    = fetchinfo("signatura", "spotinfo", "game", $game);
        $slot   = fetchinfo("randomslot", "spotinfo", "game", $game);
        echo '         <div class="definition-winner completed completed-badge ">
                    <div class="winner-result">
                        <div class="winner-block">
                            <img src="' . $avatar . '" />
                        </div>

                        <div class="gratters-block">
                            <p>Предмет достался участнику -<a target="_blank" href="/profile/'.$bank.'">' . $name . '</a></p>
                        </div>
                        <div class="fairplayblock">
                            <button data-modal="#fairplay" class="fairplaybtn">Честная игра</button> Победное место <span class="fairplayplace">' . $slot . '</span>
                                <form action="https://api.random.org/verify" method="post" target="_blank" style="display: inline;">
                                    <img src="/style/img/byrandomorg.png" style="float: right;margin-top: 4px;" />
                                      <input type=\'hidden\' name=\'format\' value=\'json\' />
                                    <input type="hidden" name="random" value=\'' . $ra . '\' />
                                    <input type="hidden" name="signature" value=\'' . $sig . '\' />
                                    <button class="fairplaycheck">проверить</button>
                                </form>
                            
                                                    </div>
                    </div>
                </div>';
    }
	echo '<div id="lotUsers" class="usersbox" style="overflow:hidden">
<p class="title-work">Места</p>';
    $rs = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' ORDER BY `id` ASC") or die(mysql_error());
    while ($row = mysql_fetch_array($rs)) {
		$id=$row['steamid'];
		$name = fetchinfo("personaname", "account", "steamid", "$id");
        $img = $row["avatar"];
        if (strlen($img) > 5)echo '<div class="lottery-member  tooltipanim" title="Место занято ' . $name . '"><a target="_blank"><img src="' . $img . '"><div>' . $row["mesto"] . '</div></a></div>';
        else echo '     <div class="lottery-member empty tooltipanim" title="Купить ' . $row["mesto"] . ' место"><a target="_blank"><img src="' . $img . '"><div onclick="buyMesto(' . $row["mesto"] . ', ' . $game . ')">' . $row["mesto"] . '</div></a></div>';
   


   }
    echo '
        
        </div>
<p class="title-work" style="margin-top:10px;" >Участники</p>
        <div id="lotLogs" class="members-log">
        
        <div class="scroller-content">
        ';
    $rsw = mysql_query("SELECT * FROM `spotgames` WHERE `game`='$game' ORDER BY `data` DESC") or die(mysql_error());
    while ($rof = mysql_fetch_array($rsw)) {
        if (strlen($rof["steamid"]) > 5) {
            echo '    
        <div class="members-log-item"><i class="fa fa-calendar-plus-o"></i>' . $rof["data"] . ' <a data-dismiss="modal" target="_blank" onclick="getProf(\'' . $rof["steamid"] . '\')" id="opprof" data-toggle="modal" data-target="#opprofile">
        <a href="/profile/'.$rof["steamid"].'">' . $rof["name"] . '</span></a> занял место ' . $rof["mesto"] . '</div>
        
            ';
        }
    }
	echo '</div></div>';
}