<div class="content">
<?php
if(isset($getgame)){
	getgame($msg,$getgame); 
}
else{ ?>
	<header class="head">
			<h2><?php echo $msg['history_igrok']; ?></h2>
		</header>
<div class="history">

		
		
		<?php historypages(0);?>
		
		</div>

<?php
}?></div>