<audio id="newGame" src="/style/sounds/start-game1.mp3" preload="auto"></audio>
<audio id="scrollSlider" src="/style/sounds/start-game.wav" preload="auto"></audio>
<audio id="newitem" src="/style/sounds/msg.mp3" preload="auto"></audio>



  <script type="text/javascript" src="/style/js/jackpot.js"></script>

			<div class="content">
<div data-visible-at-status="opened" style="display: block;">
		<div class="roulette csgoroulette" style="margin-bottom: 42px;">
<div class="progress-bar">
				<div class="progress selector-items-progress" aria-valuemax="100" style="width: 0%;">
					<span class="num"><span class="selector-items-counter">0</span>/100
</span>
				</div>
			</div>
			<div class="holder-left">
				<span class="text"><?php echo $msg['iseri1']; ?> <span class="per"><span class="selector-depositor-chance">0</span>%</span></span>
			</div>
			<div class="holder-right">
				<span class="text"><?php echo $msg['iseri2']; ?> <span class="price">~<span class="selector-current-match-prizepool">0</span> руб</span></span>
			</div>
			<div class="time-holder">
				<span class="text"><?php echo $msg['iseri3']; ?></span>
				 <span class="time"><i onclick="startCountdown();" class="icon-clock"></i><div class="timer--clock">
      <div class="minutes-group clock-display-grp">
         <div class="first number-grp">
            <div class="number-grp-wrp" style="transform: translate3d(0px, 0px, 0px);">
               <div class="num num-0"><p>0</p></div>
               <div class="num num-1"><p>1</p></div>
               <div class="num num-2"><p>2</p></div>
               <div class="num num-3"><p>3</p></div>
               <div class="num num-4"><p>4</p></div>
               <div class="num num-5"><p>5</p></div>
               <div class="num num-6"><p>6</p></div>
               <div class="num num-7"><p>7</p></div>
               <div class="num num-8"><p>8</p></div>
               <div class="num num-9"><p>9</p></div>
            </div>
         </div>
         <div class="second number-grp">
            <div class="number-grp-wrp" style="transform: translate3d(0px, 0px, 0px);">
               <div class="num num-0"><p>0</p></div>
               <div class="num num-1"><p>1</p></div>
               <div class="num num-2"><p>2</p></div>
               <div class="num num-3"><p>3</p></div>
               <div class="num num-4"><p>4</p></div>
               <div class="num num-5"><p>5</p></div>
               <div class="num num-6"><p>6</p></div>
               <div class="num num-7"><p>7</p></div>
               <div class="num num-8"><p>8</p></div>
               <div class="num num-9"><p>9</p></div>
            </div>
         </div>
      </div>
      <div class="clock-separator"><p>:</p></div>
      <div class="seconds-group clock-display-grp">
         <div class="first number-grp">
            <div class="number-grp-wrp" style="transform: translate3d(0px, 0px, 0px);">
               <div class="num num-0"><p>0</p></div>
               <div class="num num-1"><p>1</p></div>
               <div class="num num-2"><p>2</p></div>
               <div class="num num-3"><p>3</p></div>
               <div class="num num-4"><p>4</p></div>
               <div class="num num-5"><p>5</p></div>
               <div class="num num-6"><p>6</p></div>
               <div class="num num-7"><p>7</p></div>
               <div class="num num-8"><p>8</p></div>
               <div class="num num-9"><p>9</p></div>
            </div>
         </div>
         <div class="second number-grp">
            <div class="number-grp-wrp" style="transform: translate3d(0px, 0px, 0px);">
               <div class="num num-0"><p>0</p></div>
               <div class="num num-1"><p>1</p></div>
               <div class="num num-2"><p>2</p></div>
               <div class="num num-3"><p>3</p></div>
               <div class="num num-4"><p>4</p></div>
               <div class="num num-5"><p>5</p></div>
               <div class="num num-6"><p>6</p></div>
               <div class="num num-7"><p>7</p></div>
               <div class="num num-8"><p>8</p></div>
               <div class="num num-9"><p>9</p></div>
            </div>
         </div>
      </div>
   </div></span>
			</div>
			<div class="button-holder">
				<div class="button-wrap">
				 <?php if (isset($_SESSION['steamid'])){
		               $tokken = fetchinfo("linkid", "account", "steamid", $_SESSION['steamid']);
		               if(strlen($tokken) > 5)	echo'<a  href="javascript:;" class="md-trigger btn depositor" data-modal="deposit" target="_blank">Сделать депозит [<span class="selector-depositor-items-counter">0</span>/<span class="selector-depositor-maxitems-counter">0</span>]</a>';
                       else echo' <a class="btn depositor"  href="javascript:;" onclick=\'notradelink();\' target="_blank">Сделать депозит [<span class="selector-depositor-items-counter">0</span>/<span class="selector-depositor-maxitems-counter">0</span>]</a>';
	               }else echo'<a class="btn depositor"  href="/?login" target="_blank">Сделать депозит </a>';?>

					
				</div>
			</div>
		</div>
	</div>	
	
	
	
	<div id="rulka" data-visible-at-status="closed" style="display: none;">
		<div class="roulette csgoroulette" style="margin-bottom: 42px; position: relative; padding-bottom: 20px;">
			<div style="width: 100%; margin-left: -5px; height: 134px; position: relative;">
				<div style="height: 125px; background: #edf1f6; border-top-left-radius: 7px; border-top-right-radius: 7px;">
					<div class="holder selector-depositors-roulette csgo-roulette used">
						<ul class="players done1" style="-moz-transition: 13s ease;-o-transition: 13s ease;-webkit-transition: 13s ease;transition: 13s ease;     backface-visibility: hidden;">
						
						</ul>
					</div>
				</div>
				<div style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: url(/style/images/roulette-arrow.png);"></div>
			</div>
			<div style="position: absolute; bottom: 17px; left: 22px; font-family: Helv5Normal; font-size: 14px; font-weight: bold; color: #48525e;"><?php echo $msg['iseri2']; ?> <span style="color: #ffffff; background: #4caf50; display: inline-block; padding: 10px; border-radius: 7px;"><span class="selector-current-rul-prizepool">0</span><span style="font-size: 8px;vertical-align: top;line-height: 1;margin-left: 7px; display: inline-block;margin-top: 2px;">руб</span></span></div>
			<div style="position: absolute; bottom: 17px; right: 21px; font-family: Helv5Normal; font-size: 14px; font-weight: bold; color: #48525e;"><?php echo $msg['iseri1']; ?> <span style="color: #ffffff; background: #ff8f00; display: inline-block; padding: 10px; border-radius: 7px;"><span class="selector-rul-chance">0</span><span style="font-size: 8px;vertical-align: top;line-height: 1;margin-left: 5px; display: inline-block;margin-top: 2px;">%</span></span></div>
			<div class="button-holder">
				<div class="button-wrap button-wrap2">
					<a id="winbtn" class="btn inactive" href="javascript:;" target="_blank" style="color: #c5d3e6; background: #5e6a79; "><?php echo $msg['det23']; ?></a>
				</div>
			</div>
		</div>
	</div>
	

	

	<div class="part">
	<?php playergame(); ?>
	</div>
	<div class="invest-list selector-rates-block" style="">
		<ul class="selector-rates">
	<?php itemsingame(); ?>
	    </ul>
	</div>
			<div class="shortik belive"><div style="background: transparent;color:#000;vertical-align: top;">
	<div style="box-sizing: border-box; margin: 4px 0; padding: 8px 0; height: 50px; line-height: 36px; background: #ffffff; text-align: left;  font-size: 14px;">
			<img src="/style/images/match-icon-percent.png" style="width: 33px; height: 33px; vertical-align: top;border: 0; margin: 0 22px;"><div style="display: inline-block; width: 1px; height: 30px; background: #eaeaea; margin-top: 2px; vertical-align: top; margin-right: 40px;"></div>
			<?php echo $msg['ad321']; ?> ”<span><?php echo $SaitBrand ; ?></span>” <?php echo $msg['ad322']; ?> <span style="color: #2bbcff; font-weight: bold;"><span>5%</span></span>
		</div>
	

	
			
	<div class="game-start" style="box-sizing: border-box; margin: 3px 0px; padding: 8px 0px; height: 50px; line-height: 36px; text-align: left;  font-size: 14px; background: rgb(255, 255, 255);">
			<img src="/style/images/match-icon-attention.png" style="width: 33px; height: 33px; vertical-align: top;border: 0; margin: 0 22px;"><div style="display: inline-block; width: 1px; height: 30px; background: #eaeaea; margin-top: 2px; vertical-align: top; margin-right: 40px;"></div>
			<span style="color: #34ce80; font-weight: bold;"><?php echo $msg['ramka1']; ?></span> <?php echo $msg['ramka2']; ?> <span style="color: #2bbcff; font-weight: bold;">90+%</span> <?php echo $msg['ramka3']; ?>
		    </div>
		<div style="box-sizing: border-box; margin: 3px 0; padding: 8px 0; height: 50px; line-height: 36px; background: #ffffff; text-align: left;  font-size: 14px;">
			<img src="/style/images/match-icon-knife.png" style="width: 33px; height: 33px; vertical-align: top;border: 0; margin: 0 22px;"><div style="display: inline-block; width: 1px; height: 30px; background: #eaeaea; margin-top: 2px; vertical-align: top; margin-right: 40px;"></div>
			<?php echo $msg['ramka4']; ?> <a style="color: #ff5050; font-weight: bold" href="/shop" target="_blank"><?php echo $msg['ramka5']; ?> </a>
		</div>
	</div></div>
	</div>