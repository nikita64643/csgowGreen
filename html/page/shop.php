
<script type="text/javascript" src='/style/js/shop.js'></script>
		<link href="/style/css/shop.css"  rel="stylesheet">
<div class="content">
<?php
if(isset($itemid)){
	itemdeteil($itemid); 
}
else{ ?>

 
							<header class="head">
			<h2>Магазин</h2>
		</header>
<div class="store" style="margin-top: -10px;">
		<div class="bot-sort" style="line-height: 46px;"><center>
			
				<a href="http://steamcommunity.com/profiles/76561198296432309/inventory/" target="_blank" class="inv">Инвентарь бота</a>
			    <a onclick="cart();" data-modal="cart" style="margin-left: 520px;" class=" md-trigger inv">История покупок</a>
			</center>

<div class="selects">

</div>
$games = \DB::table('account')->where('personaname', '=' , $this->personaname)->get();
if($games < 5){ 

return response()->json(['errors'=>'Вы не можете вывести']); 
}
		</div>
		<div class="bot-sort">
			<div class="sum">
				<div>Цена от</div> <input type="text" id="priceFrom" value="" placeholder="0">
				<div>до</div> <input type="text" id="priceTo" value="" placeholder="0">
				<div>руб.</div>
				  <input id="searchInput" type="text" placeholder="Поиск по названию" style="width:200px;">
			</div>

			<div class="selects">
<ul id="navbar-sort" class="list-sorting">
                        <div class="price-check" style="float: left;    margin-left: -20px;"><a href="#" data-type="desc">от дорогих</a></div>
                        <div class="price-check" style="float: right;"><a href="#" data-type="asc">от дешевых</a></div>
                    </ul>
			</div>

		</div>
		
		<div class="store-items" id="items-list">
		<?php shop();?>
		</div>
		
		
		</div>

<?php
}?>
	
	</div>	