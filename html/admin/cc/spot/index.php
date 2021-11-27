<?php

@include_once $_SERVER['DOCUMENT_ROOT'].('/sys/api.php');
		if(!isset($_SESSION["steamid"])) {
					steamlogin();
}
else
{
@include_once $_SERVER['DOCUMENT_ROOT'].('/sys/api.php');
$login = $_SESSION["steamid"];
$sql = "SELECT *
FROM `account` WHERE `steamid` LIKE '$login'";
$result = mysql_query($sql);
$row = mysql_fetch_object($result);
if ($row->admin !== '1') {

echo 'Ты посмел зайти в админ панель без админки ? ДикиЙ выезжает за тобой !' ;	

}
else{
	
	
include $_SERVER['DOCUMENT_ROOT'].'/admin/components/head.php';
echo '

			
		
 <!-- Bordered datatable inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Spots Sitting</h6></div>
                <div class="datatable">
                    <form action="/sys/api.php" method="post" target="_blank" class="form-horizontal">
					<input name="act" type="hidden" id="hidden" value="spotadd">
  <div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Game</label>
    <div class="col-sm-11">
      <input class="form-control" name="game" type="text" id="formGroupInputSmall" placeholder="Game">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Market Name</label>
    <div class="col-sm-11">
      <input class="form-control" name="MarketName" type="text" id="formGroupInputSmall" placeholder="Market Name">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Price Steam</label>
    <div class="col-sm-11">
      <input class="form-control" name="value" type="text" id="formGroupInputSmall" placeholder="Price">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Name</label>
    <div class="col-sm-11">
      <input class="form-control" name="item" type="text" id="formGroupInputSmall" placeholder="name">
    </div>
</div><div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Info</label>
    <div class="col-sm-11">
      <input class="form-control" name="info" type="text" id="formGroupInputSmall" placeholder="Тайное">
    </div>
</div><div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Rarity</label>
    <div class="col-sm-11">
      <input class="form-control" name="rarity" type="rarity" id="formGroupInputSmall" placeholder="Прямо с завода">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Slots</label>
    <div class="col-sm-11">
      <input class="form-control" name="mest" type="text" id="formGroupInputSmall" placeholder="mest">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">img</label>
    <div class="col-sm-11">
      <input class="form-control" name="img" type="text" id="formGroupInputSmall" placeholder="images item">
    </div>
</div><div class="form-group form-group-sm">
    <label class="col-sm-1 control-label" for="formGroupInputSmall">Price</label>
    <div class="col-sm-11">
      <input class="form-control" name="qual" type="text" id="formGroupInputSmall" placeholder="qual">
    </div>
</div>

    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                </div>
            </div>
            <!-- /bordered datatable inside panel -->
		
            
         
			
	
             
			
			
			
            <!-- Footer -->
            <div class="footer">
                © Copyright 2015. All rights reserved. <a href="/" title="">EzySkins</a>
            </div>
            <!-- /footer -->

        </div>
    </div>



</body></html>

';



}

}
?>