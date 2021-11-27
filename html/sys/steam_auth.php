<?php
function login(){
   include "openid.php";
   $openid = new LightOpenID('http://'.$_SERVER['HTTP_HOST']);
    if(!$openid->mode) {

            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());

	}
    elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } 
    else 
    {
        if($openid->validate()) 
        {
                $id = $openid->identity;
                // identity is something like: http://steamcommunity.com/openid/id/76561198110720048
                // we only care about the unique account ID at the end of the URL.
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
                
                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=975C08CE912527A770E124C9E815E971&steamids=$matches[1]";
				$json_decoded = json_decode(curl_get_contents($url));
                 
				  header("Location: http://".$_SERVER['HTTP_HOST']);
                 
                foreach ($json_decoded->response->players as $player)
                {
                     $_SESSION['steamid'] = $player->steamid;
		             $_SESSION['personaname'] = $player->personaname;
		             $_SESSION['profileurl'] = $player->profileurl;
		             $_SESSION['avatar'] = $player->avatar;
		             $_SESSION['avatarfull'] = $player->avatarfull;
					 	$steamid = mysql_query("SELECT * FROM account WHERE steamid = '$player->steamid'");
	$row = mysql_fetch_assoc($steamid); 
	
	if($row>1){
	    mysql_query("UPDATE account SET personaname='$player->personaname', avatar='$player->avatar', avatarfull='$player->avatarfull' WHERE steamid='".$_SESSION["steamid"]."'");
	}
	else{
	   if ($player->steamid != $row[steamid]) 
		 {	
	       if ( isset( $_COOKIE['signup_ref'] ) ) {
			    $ref = fetchinfo("steamid", "account", "id", $_COOKIE['signup_ref']);
				$mnr = fetchinfo("value", "info", "name",  "refmoney");
				mysql_query("UPDATE account SET `money`=`money`+'$mnr' WHERE id='".$_COOKIE['signup_ref']."'");
			    $date = date('Y-m-d H:i:s');
				insertinventory($player->steamid);
				mysql_query("INSERT INTO account (steamid, personaname, profileurl, avatar, avatarfull, bonus, datareg,ref) VALUES ('$player->steamid', '$player->personaname', '$player->profileurl', '$player->avatar' , '$player->avatarfull', '0', '$date', '$ref')");
		   }else{
			    $date = date('Y-m-d H:i:s');
				insertinventory($player->steamid);
				$InsertIntoAccount = "INSERT INTO account (steamid, personaname, profileurl, avatar, avatarfull, bonus, datareg) VALUES ('$player->steamid', '$player->personaname', '$player->profileurl', '$player->avatar' , '$player->avatarfull', '0', '$date')";
				mysql_query($InsertIntoAccount);
		   }
		  }
        }

                }
				  
 
        } 
        else 
        {
                echo "User is not logged in.\n";
        }
		
		
    }
}
?>