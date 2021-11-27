<?php 
	if (isset($_SESSION["steamid"])){
		?>
<audio id="newitem" src="/style/sounds/msg.mp3" preload="auto"></audio>		
		<div class="content">
					<header class="head">
		<h2><?php echo $msg['setting1']; ?></h2>
	</header>
	<div class="text-boxes">
		<!--h5>Что такое реферальная система?</h5-->
		<p>
			<?php echo $msg['set1']; ?>
			-
			<a class="link" href="http://steamcommunity.com/id/fuckmarkelofff//tradeoffers/privacy#trade_offer_access_url" target="_blank"><?php echo $msg['set2']; ?></a>
			<br>
			<?php echo $msg['set3']; ?>
			-
			<a class="link" href="http://steamcommunity.com/id/fuckmarkelofff//edit/settings" target="_blank"><?php echo $msg['set2']; ?></a>
			<br>
			<br>
							<?php echo $msg['set4']; ?><br>
				1) <?php echo $msg['set5']; ?><br>
				2) <?php echo $msg['set6']; ?>
					</p>
				
	</div>
	<div class="form-link-change">
		
			<input type="hidden" name="_token" value="w0Tx66uzNRXbMVtZyexjzYNUc2kxVHxGUHbiMnFk">
			<fieldset>
				<div class="buttom" onclick= "SaveUrl();" value="Сохранить"><?php echo $msg['set7']; ?></div>
				<input class="change-input save-trade-link-input" type="text" placeholder="Ссылка на обмен" name="tradeurl" value="<?php echo fetchinfo("linkid", "account", "steamid", $_SESSION["steamid"]); ?>" autofocus="">
			</fieldset>
			
		
  <label for="checkboxA" class="toggle-label">Sound</label>
 <label class="toggle">
   <?php if($_COOKIE["sound"]=='true') {
					echo '<input type="checkbox" id="checkboxA" class="checkbox" checked="checked" />';
                }else{
					echo '<input type="checkbox" id="checkboxA" class="checkbox" />';
				} ?>
    
    <span class="toggle-text"></span>
    <span class="toggle-handle"></span>
  </label>
  
  <br />
  
 
			
	
			
	</div>

				</div>
		
		
		
	<?php }
		
		?>