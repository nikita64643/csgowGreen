<?php require_once 'case/case.php'; ?>
<link href="/style/css/stylessss.css" rel="stylesheet">
<script type="text/javascript" src="/style/js/case.js"></script>
<div class="content">
<?php
if(isset($caseid)){
	echo '<div class="store">';
	caseid($caseid); 
	echo '</div>';
}
else{ ?>
<!--<div class="other-title">Открытие кейсов</div>
<div class="store">

		
		</div>-->
        		<div class="h2-gold">
					<span>Кейсы</span>
				</div><br><br>
		<div id="cases">
		<div id="case-inner">
		<?php casef();?>
		</div>
		
		</div>

<?php
}?>


</div>
				 
										

 