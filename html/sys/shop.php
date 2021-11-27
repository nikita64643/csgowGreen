<?php
function shop(){
	$rs3 = mysql_query("SELECT * FROM `shop_content`");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo '		
			<div class="short"  data-name="' . $row33["title"] . '" data-price="' . $row33["price"] . '">
				<div class="picture"><img src="' . $row33["img"] . '" width ="76px" height="76px;" alt="" title="" /></div>
				<ul>
					<li>' . $row33["title"] . '</li>
					<li> </li>
					<span>' . $row33["lod"] . '</span>
					<li>Цена в Steam: <span>' . $row33["steam_price"] . ' руб.</span></li>				
				</ul>
				<div class="right">
					<div class="pricegg">' . $row33["price"] . ' <span>руб.</span></div>
											<a onclick="shopitems(\''.$row33["id"].'\')" class="by buyItem md-trigger"  data-modal="shopconf">Купить</a>
				</div>
			</div>			
	           <!-- </item> -->'; 
	     } 
		
	}
}
function cart (){
	$usertd = $_SESSION["steamid"];
	$rs3 = mysql_query("SELECT * FROM `shop_cart` WHERE steamid='$usertd'");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h2>В данный момент ваша корзина пуста</h2></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
	            echo'<div id="lenth" class="deposit-item rare up-rare">
                    <div class="deposit-item-wrap">
                       <div class="img-wrap">
                              <img src="' . $row33["img"] . '">
                       </div>
                    <div class="name">' . $row33["title"] . '</div>
                 
                    </div>
                    </div>';
		 }
	}
}
function lastitems($msg){
		$rs3 = mysql_query("SELECT * FROM `shop_content` ORDER BY `price` DESC LIMIT 6");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo ' 
                <div li="asd" title="' . $row33["title"] . '" class="short tooltipanim">
					<a href="/shop"><img src="' . $row33["img"] . '" width ="71px" height="62px" alt="" title=""></a>
					<div class="pricef">' . round($row33["price"]) . 'Р</div>
				</div>		
	           <!-- </item> -->'; 
	     } 
		 echo '<div class="buttons" style="    display: block;margin-top: 170px;margin-left: 150px;"> 
				<a class="skins" href="/shop">' .$msg["referality5"]. '</a>		
				</div>';
		
	}
}
function itemdeteil($id) {
	$rs3 = mysql_query("SELECT * FROM `shop_content` WHERE `id`='$id'");
	$row33 = mysql_fetch_array($rs3);
	echo'
	
	<div class="detailed-info">
            <div class="detailed-info-body">
                <div class="detailed-info-body-left">
                    <div class="detailed-image">
                        <img src="'.$row33["img"].'">
                    </div>
                </div>
                <div class="detailed-info-body-right">
                    <h2 class="name">'.$row33["title"].'</h2>
                    <div class="detailed-info-desc-wrap">
                        <div class="detailed-info-desc">
                            <dl>
                                <dt>Редкость</dt>
                                <dd class="rarity">'.$row33["rarity"].'</dd>
                            </dl>
                        </div>
                        <div class="detailed-info-desc">
                            <dl>
                                <dt>Качество</dt>
                                <dd class="type2">'.$row33["lod"].'</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="detailed-info-price-wrap">
                        <div class="detailed-info-price">
                            <dl>
                                <dt>
                                <div class="detailed-steam-price steamPrice">'.$row33["steam_price"].' <span>руб</span></div>
                                </dt>
                                <dd>цена в steam</dd>
                            </dl>
                        </div>
                        <div class="detailed-info-price">
                            <dl>
                                <dt class="detailed-our-price ourPrice">'.$row33["price"].' <span>руб</span></dt>
                                <dd>наша цена</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detailed-info-footer">
                <div class="detailed-info-footer-left">
                    <div class="detailed-info-checkbox">
                        <input id="agreement" type="checkbox" checked="checked">
                        <label for="agreement">
                            Я согласен с <a href="/about" style="color:#fff;">условиями</a> и подтверждаю, <br>что не имею ограничений на обмен в Steam.
                        </label>
                    </div>
                    <div class="detailed-info-time">
                        Вы должны будете принять обмен в течении <span>1 часа</span>
                    </div>
                </div>
                <div class="detailed-info-footer-right">
                    <div href="#" class="buy-btn md-close " onclick="buyitem(\''.$id.'\')">Купить</div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>	
	';
}
function namesearch($search_string){
  $search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
  if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$rs3 = mysql_query('SELECT * FROM `shop_content` WHERE `title` LIKE "%'.$search_string.'%" LIMIT 100');
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>Товар не найден</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo '		
				<div class="short" data-name="' . $row33["title"] . '" data-price="' . $row33["price"] . '">
				<div class="picture"><img src="' . $row33["img"] . '" width ="76px" height="76px;" alt="" title="" /></div>
				<ul>
					<li>' . $row33["title"] . '</li>
					<li> </li>
					<span>' . $row33["lod"] . '</span>
					<li>Цена в Steam: <span>' . $row33["price"] . ' руб.</span></li>				
				</ul>
				<div class="right">
					<div class="pricegg">' . $row33["price"] . ' <span>руб.</span></div>
											<a onclick="shopitems(\''.$row33["id"].'\')" class="by buyItem md-trigger"  data-modal="shopconf">Купить</a>
				</div>
			</div>			
	           <!-- </item> -->'; 
	     } 
		
	}
  }else {
	  shop();
  }
}
function buymarket($item){
	if (isset($_SESSION['steamid'])) {
		$money = fetchinfo("price","shop_content","id",$item);
		$title = fetchinfo("market_name","shop_content","id",$item);
       if(strlen($title) > 3){
		$img = fetchinfo("img","shop_content","id",$item);
		if($_SESSION['money'] >= $money){
			$tokken = fetchinfo("linkid", "account", "steamid", $_SESSION['steamid']);
		  if(strlen($tokken)>5){
			$RemoveMoney = $_SESSION['money'] - $money;
			$SteamIdSession = $_SESSION['steamid'];
			$tradelink = fetchinfo("linkid","account","steamid",$SteamIdSession);
			$token = substr(strstr($tradelink, 'token='),6);
			mysql_query("UPDATE account SET money=$RemoveMoney WHERE `steamid` = '$SteamIdSession'");
     		mysql_query("INSERT INTO shop (steamid, token, items, status) VALUES ('$SteamIdSession', '$token', '$title', 'active')");		
			mysql_query("INSERT INTO shop_cart (steamid, title, img) VALUES ('$SteamIdSession', '$title', '$img')");
			mysql_query("DELETE FROM shop_content WHERE `id` = '$item'");
			echo 'Вы успешно купили!';
		  }	else echo 'Нету трейд ссылки!Укажите в настройках!';	
		}
		else{
		   echo 'У вас не хватает денег!Пополните баланс и попробуйте сново!';
		}
		}else{
			echo'Возможно товар уже куплен!';
		}		
	}
	else{
		echo 'Авторизируйтесь для покупки';
	}
		   
}
function search($fromf,$tof){
	$rs3 = mysql_query("SELECT * FROM `shop_content` WHERE `price` <= '$tof' AND `price` >= '$fromf' LIMIT 100");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>Товар не найден</h1></center>";
	else{
		 while ($row33 = mysql_fetch_array($rs3)){
				  echo '			
				<div class="short" data-price="' . $row33["price"] . '">
				<div class="picture"><img src="' . $row33["img"] . '" width ="76px" height="76px;" alt="" title="" /></div>
				<ul>
					<li>' . $row33["title"] . '</li>
					<li> </li>
					<span>базового класса</span>
					<li>Цена в Steam: <span>' . $row33["price"] . ' руб.</span></li>				
				</ul>
				<div class="right">
					<div class="pricegg">' . $row33["price"] . ' <span>руб.</span></div>
					<a onclick="shopitems(\''.$row33["id"].'\')" class="by buyItem md-trigger"  data-modal="shopconf">Купить</a>
				</div>
			</div>			
	<!-- </item> -->'; 
	     } 	
	}  
}
?>