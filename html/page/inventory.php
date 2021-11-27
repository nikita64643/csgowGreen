
<div class="content bg">
<?php
if(isset($inv)){?>
	<div class="other-title">Инвентарь на <?php echo allprice($inv); ?> руб.</div>

<?php

	inventory($inv); 
}else{ ?>
<script>getinventoryidtrade('<?php echo $_SESSION['steamid'] ?>');</script>
<div class="other-title">Мой инвентарь на <?php echo allprice($_SESSION['steamid']); ?> руб.   </div>


		
		
		<?php 	inventory($_SESSION['steamid']);?>
		
	

<?php
}?>





		


	</div>





			