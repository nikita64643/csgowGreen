		<link href="/style/css/double.css"  rel="stylesheet">
	
				<script type="text/javascript" src="/style/js/double.js"></script>
			<div class="game">
   <div class="game bonus-room">
      <div class="game-content">
         <div class="bonus-game-roulette">
            <div class="game-roulette">
               <div>
                  <div class="game-roulette-numbers" style="transition: transform 0ms; display: block; transform: rotate3d(0, 0, 1, 9.92002deg);"></div>
                  <div class="bonus-game-state-container">
                  <div class="wheel_container col s6" style="padding: none;">
                     <object type="image/svg+xml" data="/style/images/wheel.svg" class="wheel" id="wheel">Your browser does not support SVG</object>
                  </div>
                   
                  </div>
                 
               </div>
            </div>
            <div class="game-roulette-history">
               <ul class="game-roulette-history-list">
                  <li class="game-roulette-history-item red">5</li>
                  <li class="game-roulette-history-item red">4</li>
                  <li class="game-roulette-history-item red">7</li>
                  <li class="game-roulette-history-item red">3</li>
                  <li class="game-roulette-history-item black">12</li>
                  <li class="game-roulette-history-item red">4</li>
                  <li class="game-roulette-history-item black">11</li>
                  <li class="game-roulette-history-item zero">0</li>
                  <li class="game-roulette-history-item black">9</li>
                  <li class="game-roulette-history-item red">2</li>
               </ul>
            </div>
         </div>
         <div class="bonus-game-bet-calc">
            <div>
			<?php if (isset($_SESSION['steamid'])) { ?>	
               <div class="bonus-value-container"> <span>Баланс:</span><span class="bonus-user-value"><?php echo $_SESSION['coin']; ?></span><a href="#refill"><span class="sprite add-bonus"></span></a> </div>
			<?php } ?><div class="bonus-game-calc">
                  <ul class="bonus-game-calc-button-list">
                     <li class="bonus-game-calc-button clear"><span class="sprite clear"></span> </li>
                     <li class="bonus-game-calc-button value" data-value="10" data-method="plus">+10 </li>
                     <li class="bonus-game-calc-button value" data-value="100" data-method="plus">+100 </li>
                     <li class="bonus-game-calc-button value" data-value="1000" data-method="plus">+1K </li>
                     <li class="bonus-game-calc-button value" data-value="10000" data-method="plus">+10K </li>
                     <li class="bonus-game-calc-button value" data-value="2" data-method="multiply">x2 </li>
                     <li class="bonus-game-calc-button value" data-value="2" data-method="divide">1/2 </li>
                     <li class="bonus-game-calc-button all">Всё</li>
                  </ul>
                  <div class="bonus-game-bet-input-container">   <input id="bet" class="bonus-game-bet-input" value="0" type="number" min="0" max="250000"> </div>
                  <div class="bonus-game-calc-place-bet-buttons">
                     <p class="place-bet-buttons-text">Поставить:</p>
                     <ul class="place-bet-buttons noselect">
                        <li data-bet-type="red" class="bonus-game-calc-place-bet sprite bonus-red-button noselect">0</li>
                        <li data-bet-type="zero" class="bonus-game-calc-place-bet sprite bonus-zero-button noselect">0</li>
                        <li data-bet-type="black" class="bonus-game-calc-place-bet sprite bonus-black-button noselect">0</li>
                     </ul>
                  </div>
               </div>
               <div class="bonus-game-auth">
                  <div>Авторизируйся, чтобы испытать удачу</div>
                  <a class="btn-yellow auth-link" href="/?login" target=""><span class="icon-steam"></span> Войти через STEAM чтобы играть! </a> 
               </div>
               <div class="bonus-game-bet-info">
                  <p>Общая ставка:</p>
                  <ul class="bonus-game-bet-values">
                     <li data-bet-type="red" class="bonus-game-bet-value-container red">
                        <div class="bonus-game-bet-value-progress" id="red" style="width: 0%;"></div>
                        <div class="bonus-game-bet-value" id="redpoint">0</div>
                     </li>
                     <li data-bet-type="zero" class="bonus-game-bet-value-container zero">
                        <div class="bonus-game-bet-value-progress" id="zero" style="width: 0%;"></div>
                        <div class="bonus-game-bet-value" id="zeropoint">0</div>
                     </li>
                     <li data-bet-type="black" class="bonus-game-bet-value-container black">
                        <div class="bonus-game-bet-value-progress" id="black" style="width: 0%;"></div>
                        <div class="bonus-game-bet-value black" id="blackpoint">0</div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="bonus-game-info">
         <div class="game-title">Игра №<span class="game-num">032523</span></div>
         <div class="game-hash-info">
            <p>Хэш раунда: <span id="roundHash">e5b8f3548d8221668ef5014c3b3fb18e66ad838ecd082f1766e9a45b</span></p>
            <p>Число раунда: <span id="randNum">скрыто</span></p>
         </div>
         <a href="#faq/double/3" class="fairplay">Честная игра</a> 
      </div>
      <div class="game-bets-container">
         <div class="game-bets-list">
            
         </div>
      </div>
   </div>
</div>