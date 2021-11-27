<div class="content">
	<div class="other-title">Просмотр игры за дату</div>
	<div class="history">
<ul class="history-matches">
<?php if(isset($datagame)){ ?>

<?php	getdatagame($datagame); 
}
else{ ?>


		
		
		<?php 
		$date = date('Y-m-d');
		getdatagame($date);?>
		
		

<?php
}?></div></div></div>