<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_GET['pagespot'])) {
    $page = $_GET['pagespot'] - 1;
    historyspotpages($page);
}
function addpoint($color,$point){
	if(isset($_SESSION['steamid'])){
	$SteamIdSession= $_SESSION['steamid'];


            if ($_SESSION['coin'] >= $point) {
                $RemoveMoney = $_SESSION['coin'] - $point;
                $game     = fetchinfo("value", "info", "name", "double");
				$name = fetchinfo("personaname","account","steamid",$SteamIdSession);
				$avatar = fetchinfo("avatarfull","account","steamid",$SteamIdSession);
				mysql_query("UPDATE `double` SET `$color`=$color + '$point',points=points + $point WHERE `game` = '$game'") or die(mysql_error());
                mysql_query("UPDATE account SET coin=$RemoveMoney WHERE `steamid` = '$SteamIdSession'") or die(mysql_error());
				$winneravatar = fetchinfo("avatarfull", "account", "steamid", $SteamIdSession);
		        $winnername = fetchinfo("personaname", "account", "steamid", $SteamIdSession);		
				mysql_query("INSERT INTO `doublegame` (`steamid`,`color`,`coin`,`game`,`ava`,`name`) VALUES ('$SteamIdSession','$color','$point','$game','$winneravatar','$winnername')");
				$rs = mysql_query("SELECT * FROM `double` WHERE `game`='$game'");
				$row = mysql_fetch_assoc($rs);
				$allpoint= $row['points'];
				$red= $row['red'];
				$zero= $row['zero'];
				$black = $row['black'];
				$redwidth = round($red *100/$allpoint,1);
				$zerowidth = round($zero *100/$allpoint,1);
				$blackwidth = round($black *100/$allpoint,1);

				echo '{"name":"'.$name.'","color":"'.$color.'","point":"'.$point.'","ava":"'.$avatar.'","red":"'.$redwidth.'","zero":"'.$zerowidth.'","black":"'.$blackwidth.'","redpoint": "'.$red.'","blackpoint": "'.$black.'","zeropoint":"'.$zero.'","game":"'. $game.'"}';
							
            } else echo 'Недостаточно денег';
       

	}else{
		echo'Авторизируйтесь ';
	}
}
function allstatdouble(){
	            $game = fetchinfo("value", "info", "name", "double");
				$rs = mysql_query("SELECT * FROM `double` WHERE `game`='$game'");
				$row = mysql_fetch_assoc($rs);
				$allpoint= $row['points'];
				$red= $row['red'];
				$zero= $row['zero'];
				$black = $row['black'];
				$redwidth = round($red *100/$allpoint,1);
				$zerowidth = round($zero *100/$allpoint,1);
				$blackwidth = round($black *100/$allpoint,1);
				$rs = mysql_query("SELECT * FROM `doublegame` WHERE `game`='$game'");
				$stack = array();
				$player = array();
				$progress = array();
				while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                   $stack['players'][] = $row;                 		
				}
				$stack['progress'][]=array('red' => $redwidth,'zero' => $zerowidth,'black' => $blackwidth,'redpoint' => $red,'blackpoint' => $black,'zeropoint' => $zero,'game' => $game);


                echo json_encode($stack);

			
}
