<?php

function caseid($case){
	$cases = mysql_query("SELECT * FROM `case` WHERE `id`='$case'");
	if(mysql_num_rows($cases) == 0)  echo"<center><h1>Такого кейса нет</h1></center>";
	else{
		while ($row333 = mysql_fetch_array($cases)){
			echo '<div class="opencase">
			<div class="opencase-title">'. $row333['name'] .'</div>
			<div class="opencase-top widther">
				<div class="opencase-top-case" style="background-image:url('. $row333['img'] .')"></div>
				<div class="opencase-top-carousel">
					<div class="opencase-top-carousel-line"></div>
					<div class="opencase-top-carousel-selector"></div>
				</div>
			</div>
			<div class="opencase-bottom widther">
				<div style="margin-right: 30px;"><div class="opencase-bottom-open" id="openCase" data-id="'.$row333['id'].'">открыть кейс за '.$row333['price'].' Р.</div></div>
				<div class="opencase-bottom-auth"><a class="opencase-bottom-auth1" href="/steam?login">авторизуйтесь</a></div>
				<div class="opencase-bottom-items">К сожалению в данном кейсе нет вещей, попробуйте позже!</div>
				<div class="opencase-bottom-case">Вы слишком много раз открывали данный кейс.</div>
				<div class="opencase-bottom-case1">Кейс недоступен.</div>
				<div class="opencase-bottom-opening">открываем...</div>
				<div class="opencase-bottom-nofunds">
					<div class="opencase-bottom-nofunds-title">недостаточно средств</div>
					<div class="opencase-bottom-nofunds-subtitle">У вас недостаточно средств для открытия кейса!</div>
					<div class="opencase-bottom-nofunds-add">
						<span class="addmoneys1" style="display: inline-block;">
							<form action="/pay" method="POST">
								<input name="money" type="number" min="0" placeholder="Сумма" class="invoiceMoneys1">
								<button class="refills">Пополнить</button>
							</form>
						</span>
					</div>
				</div>
			</div>
			<div class="opencase-opened none widther">
				<div class="opencase-opened-title">Ваш выигрыш:</div>
				<div class="opencase-opened-image" style="background-image:url(//steamcommunity-a.akamaihd.net/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopuP1FAR17OORIXBD_9W_mY-dqPrxN7LEm1Rd6dd2j6eV8Yijilfi-xJoMGv7LI7Hd1Q4Y1HV-VS8lOnmjJXvu87MzHsyv3Nw-z-DyMkIAv9h/360x360)"></div>
				<div class="opencase-opened-drop">AWP | История о драконе</div>
				
				<div class="opencase-opened-out">Предмет нужно вывести в профиле в течение часа.</div>
				<div class="opencase-opened-actions widther">
					<div class="opencase-opened-actions-one s__again">
						<div class="opencase-opened-actions-one-image"><i class="fa fa-repeat"></i></div>
						<div class="opencase-opened-actions-one-text">Ещё раз</div>
					</div>
					<a class="opencase-opened-actions-one s__sell">
						<div class="opencase-opened-actions-one-image"><i class="fa fa-shopping-bag"></i></div>
						<div class="opencase-opened-actions-one-text">Продать за ?Р</div>
					</a>
					
				</div>
			</div>
			<div class="opencase-dropstitle">Содержимое кейса:</div>
			<div class="items-incase widther">';
$rs3 = mysql_query("SELECT * FROM `caseitems` WHERE `case`='$case'");
if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
else{
	while ($row33 = mysql_fetch_array($rs3)){
		$item = $row33["steam_name"];
		$price= getprice($item.' (Field-Tested)');
		echo '
		<a class="item-incase '.$row33["Quality"].'" target="_blank" style="text-decoration: none;">
			<div class="picture">
				<img src="https://steamcommunity-a.akamaihd.net/economy/image/class/730/'. $row33['avatar'] . '/110fx82f" alt="Дроп">
			</div>
			<div class="descr">
			    <strong>' . $row33["name"] . '</strong>
			</div></a>
		';
	}
}
echo'</div>
			</div>
		</div>
	</section>
	';
}	
}
}
function casef(){
	$rs3 = mysql_query("SELECT * FROM `case`");
	if(mysql_num_rows($rs3) == 0)  echo"<center><h1>В данный момент товары отсутствуют</h1></center>";
	else{
		while ($row33 = mysql_fetch_array($rs3)){

			echo'<a href="/case/'.$row33['id'].'" class="randbox">
			<i class="box"><img src="'.$row33['img'].'" alt="'.$row33['name'].'"></i>
			<span>'.$row33['name'].'</span>
			<strong>'.$row33['price'].' P</strong>
			<span class="view">подробнее</span>
		</a>';
	}	 }
}

?>