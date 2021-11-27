	<div class="content">



<?php
if(isset($steamid)){
	profile($msg,$steamid); 
		echo '<div id="onlyupdate">';
	
	inventory($steamid,$msg);
	echo ' </div>';
}
else{
   if(isset($_SESSION['steamid'])){
	   	profile($msg,$_SESSION['steamid']); 
	echo '<div id="onlyupdate">';
	
	inventory($_SESSION['steamid'],$msg);
	echo ' </div>';
   }else{
	    header("Location: ".$_SERVER['HTTP_REFERER']);
   }

}?>

		


	</div>





			