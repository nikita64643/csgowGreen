</div>
	</div>
	<footer id="footer">
		<div class="center">
			<strong class="copy">
					<p>Powered by Steam, a registered trademark of Valve Corporation.</p>
					<em><?php echo $msg['glava3']; ?> <span><?php echo $msg['glava4']; ?></span></em>
			</strong>
			</br><a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/15.png"></a>
			<iframe src="http://www.free-kassa.ru/merchant/forms.php?gen_form=1&targets=На развитие&default-sum=5&button-text=Пожертвовать&encoding=UTF8&type=small&cur=RUR&m=35433&form_id=&id=23562"  width="400" height="240" frameBorder="0" ></iframe>
			<a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/15.png"></a>
		</div>
	</footer>
	<div class="md-modal md-effect-9" id="cards">
		<div class="myprofile-history-title AccountPath">
		 Карточки <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content">	

	<!--<div class="total-cards">У вас 10 карточек, стоимостью в 6580 руб.</div>
	<div class="info-cards">У вас нету карточек для депозита.<br>Купите карточки, чтобы сделать депозит.</div>-->
<div class="box-modal-content">


                <div class="add-balance-block">
                    <div class="balance-item">
                        Ваш баланс:
                                                    <span class="userBalance"><?php echo $_SESSION['money']; ?></span> <div class="price-currency">руб</div>
                                            </div>

                    <span class="icon-arrow-right"></span>
                    <div class="input-group">
                     
                                                <button type="submit" class="btn-add-balance md-trigger" id="addBalanceBtn"  data-modal="pay" onclick="$('#cards').removeClass('md-show');">пополнить</button>
                    </div>

                                        <div class="payment-methods" style="display:none;" id="moneySystems">
                        <div class="payment-title">Выберите способы оплаты</div>
                        <ul class="list-reset">
                            <li><div data-money="qiwi" class="payment-qiwi" title="С помощью Qiwi"><span>Qiwi</span></div></li>
                            <li><div data-money="wm" class="payment-webmoney" title="С помощью Webmoney"><span>Webmoney</span></div></li>
                            <li><div data-money="yd" class="payment-yandex" title="С помощью Yandex Money"><span>Яндекс</span></div></li>
                            <li><div data-money="mob" class="payment-phone" title="С помощью телефона"><span>Телефон</span></div></li>
                            <li><div data-money="card" class="payment-credit-card" title="С помощью кредитной карты"><span>Карточки</span></div></li>
                            <li><div data-money="oth" class="payment-another" title="С помощью других способов"><span>Другие способы</span></div></li>
                        </ul>
                    </div>
                                    </div>

                <div class="cards-block-up-btn">
                    <ul class="list-reset">
                            <li class="up-card-5">
                                <div class="up-price">
                                                                            20<small>руб</small>
                                                                    </div>
                                <span class="icon-up-card-5"></span>
                                <div  class="buy-btn-sm" onclick="addTicket(20);"> Купить </div>
                            </li>
                            <li class="up-card-10">
                                <div class="up-price">
                                                                            50 <small>руб</small>
                                                                    </div>
                                <span class="icon-up-card-5"></span>
                                <div  class="buy-btn-sm" onclick="addTicket(50);"> Купить </div>
                            </li>
                            <li class="up-card-25">
                                <div class="up-price">
                                                                            100 <small>руб</small>
                                                                    </div>
                                <span class="icon-up-card-5"></span>
                                <div onclick="addTicket(100);" class="buy-btn-sm"> Купить </div>
                            </li>
                            <li class="up-card-50">
                                <div class="up-price">
                                                                            200 <small>руб</small>
                                                                    </div>
                                <span class="icon-up-card-5"></span>
                                <div onclick="addTicket(200);" class="buy-btn-sm"> Купить </div>
                            </li>
                            <li class="up-card-100">
                                <div class="up-price">
                                                                            500 <small>руб</small>
                                                                    </div>
                                <span class="icon-up-card-5"></span>
                                <div onclick="addTicket(500);" class="buy-btn-sm"> Купить </div>
                            </li>
                                            </ul>
                </div>
<div class="add-balance-block">
 

                    <span class="icon-arrow-right"></span>
                    <div class="input-group" style="margin-left: -5px;">
					
						<input type="text" class="coderefll" name="freepay" id="cardsum" placeholder="Сумма карточки" pattern="^[ 0-9]+$" autocomplete="off">	
                        
					
                                                <button onclick="addTicket($('#cardsum').val());" type="submit" class="btn-add-balance" id="addBalanceBtn" style="float: left;margin-left: 10px;">Выставить</button>
					
				  </div>

                                        <div class="payment-methods" style="display:none;" id="moneySystems">
                        <div class="payment-title">Выберите способы оплаты</div>
                        <ul class="list-reset">
                            <li><div data-money="qiwi" class="payment-qiwi" title="С помощью Qiwi"><span>Qiwi</span></div></li>
                            <li><div data-money="wm" class="payment-webmoney" title="С помощью Webmoney"><span>Webmoney</span></div></li>
                            <li><div data-money="yd" class="payment-yandex" title="С помощью Yandex Money"><span>Яндекс</span></div></li>
                            <li><div data-money="mob" class="payment-phone" title="С помощью телефона"><span>Телефон</span></div></li>
                            <li><div data-money="card" class="payment-credit-card" title="С помощью кредитной карты"><span>Карточки</span></div></li>
                            <li><div data-money="oth" class="payment-another" title="С помощью других способов"><span>Другие способы</span></div></li>
                        </ul>
                    </div>
                                    </div>
                <div class="box-modal-footer">
                    <div class="msg-wrap" style="position: relative;">
                        <div class="close-eto-delo box-modal_close" style="top: 6px; right: 6px; opacity: 0.8;"></div>
                        <div class="msg-green" style="margin-left: 12px;margin-top: 20px;">
                                                            <h2>Для чего нужны карточки ?</h2>
                                <p>Депозит карточками не чем не отличается от депозита скинами CS:GO.</p>
                                <p>То есть, например, если вы внесете депозит карточкой номиналом в 10$, это будет тоже самое, как будто бы вы внесли депозит скинами CS:GO на 10$.</p>
                                <p>Карточки не теряются в стоимости и моментально вносятся в игру без задержек. Вы сможете обменять их в любой момент на скины на странице с обменом карточек: <a href="/shop" style="color:#ffad08;" target="_blank">Магазин</a></p>
                                                    </div>
                    </div>
                </div>
            </div>
    
	
	



		</div></div>	
		
                    <div class="all-smiles-window" class="display: none;">
                        <button id="closebtn" type="button" class="chat-submit-btn">X</button>
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/acute.gif" alt="acute" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/aggressive.gif" alt="aggressive" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/help.gif" alt="help" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/cray.gif" alt="cray" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/bad.gif" alt="bad" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/bb.gif" alt="bb" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/beee.gif" alt="beee" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/drinks.gif" alt="drinks" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/dash2.gif" alt="dash2" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/crazy.gif" alt="crazy" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/gamer3.gif" alt="gamer3" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/fool.gif" alt="fool" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/good.gif" alt="good" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/heat.gif" alt="heat" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/lazy.gif" alt="lazy" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/music2.gif" alt="music2" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/negative.gif" alt="negative" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/nea.gif" alt="nea" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/shok.gif" alt="shok" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/rtfm.gif" alt="rtfm" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/pardon.gif" alt="pardon" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/yahoo.gif" alt="yahoo" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/suicide2.gif" alt="suicide2" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/facepalm.gif" alt="facepalm" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/ok.gif" alt="ok" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/ireful1.gif" alt="ireful1" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/popcorm2.gif" alt="popcorm2" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/russian_ru.gif" alt="russian_ru" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/triniti.gif" alt="triniti" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/skull.gif" alt="skull" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/rofl.gif" alt="rofl" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/this.gif" alt="this" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/sad.gif" alt="sad" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/scare2.gif" alt="scare2" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/cool.gif" alt="cool" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/biggrin.gif" alt="biggrin" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/mad.gif" alt="mad" />
                                    </div>
                                
                                    <div class="smile-item">
                                        <img src="/style/images/smiles/middlefinger.gif" alt="middlefinger" />
                                    </div>
                    </div>

			<div class="md-modal md-effect-9" id="deposit">
		<div class="myprofile-history-title AccountPath">
		<?php echo $msg['Submit_a_game']; ?> <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content"  style="background: white;">	
<div class="info_dialog_content">

<div id="info_dialog_description" class="idd-header">
<?php echo $msg['glava8']; ?>
</div>
<div id="info_dialog_methods" style="text-align:center;overflow:hidden;">
<div class="info_dialog_method idm-option" id="info_dialog_url_web">
<div class="idm-top"><?php echo $msg['glava5']; ?></div>
<div class="idm-icon"></div>
<div class="idm-text">
<span><?php echo $msg['fwer']; ?></span>
<strong><?php echo $msg['rtaw']; ?></strong>
</div>
</div>
<div class="info_dialog_method idm-option" id="info_dialog_url">
<div class="idm-top"><?php echo $msg['glava6']; ?></div>
<div class="idm-icon"></div>
<div class="idm-text">
<span><?php echo $msg['fwer']; ?></span>
<strong><?php echo $msg['rtaw1']; ?></strong>
</div>
</div>
<div class="md-close info_dialog_method idm-option md-trigger" data-modal="cards" onclick="$('#deposit').removeClass('md-show');" >
<div class="idm-top"><?php echo $msg['glava7']; ?></div>
<div class="idm-icon"></div>
<div class="idm-text">
<span><?php echo $msg['fwer1']; ?></span>
<strong><?php echo $msg['rtaw2']; ?></strong>
</div>
</div>
</div>

<div class="info_dialog_warning info_dialog_warning_bot"><?php echo $msg['rtaw3']; ?></div>
</div>
		</div></div>
	<div class="md-modal md-effect-9" id="pay">
		<div class="myprofile-history-title AccountPath">
		<?php echo $msg['refill']; ?> <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content">	
<div class="balance">
<div class="add-balance-block">
 

                    <span class="icon-arrow-right"></span>
                    <div class="input-group"style="float: left;    margin-left: -5px;">
					<form method="GET" action="/sys/api.php">
						<?php if($oplata == 1)echo '<input type="text" class="coderefll" name="gdonatepay" id="sum" placeholder="'.$msg['amout'].'" pattern="^[ 0-9]+$" autocomplete="off">';
			            else if($oplata == 2) echo '<input type="text" class="coderefll" name="freepay" id="sum" placeholder="'.$msg['amout'].'" pattern="^[ 0-9]+$" autocomplete="off">';?>	
                        
					
                                                <button type="submit" class="btn-add-balance" id="addBalanceBtn" style="float: left;margin-left: 10px;"><?php echo $msg['refill']; ?></button>
											
                    </form>
				  </div>

                                        <div class="payment-methods" style="display:none;" id="moneySystems">
                        <div class="payment-title">Выберите способы оплаты</div>
                        <ul class="list-reset">
                            <li><div data-money="qiwi" class="payment-qiwi" title="С помощью Qiwi"><span>Qiwi</span></div></li>
                            <li><div data-money="wm" class="payment-webmoney" title="С помощью Webmoney"><span>Webmoney</span></div></li>
                            <li><div data-money="yd" class="payment-yandex" title="С помощью Yandex Money"><span>Яндекс</span></div></li>
                            <li><div data-money="mob" class="payment-phone" title="С помощью телефона"><span>Телефон</span></div></li>
                            <li><div data-money="card" class="payment-credit-card" title="С помощью кредитной карты"><span>Карточки</span></div></li>
                            <li><div data-money="oth" class="payment-another" title="С помощью других способов"><span>Другие способы</span></div></li>
                        </ul>
                    </div>
                                    </div>


	</div>
		</div></div>

	
	<div id="chatContainer" style="">
    <div id="chatHeader"><?php echo $msg['teches9']; ?></div>

    <div id="chatBody" style="display: none;">
	 <div class="chat-prompt" style="">
            <div class="chat-prompt-top">Новости csgow.ru</div>
            <a>
     Обновили дизаин<br>
	 Пополнили игу spots<br>
	 Магазин будет доступин в следующем только месяце<br>
			
			</a>
        </div>
        <div id="chatScroll" class="ps-container ps-active-y">
		
           <div class="chat">
            <div id="chat_area">
			
			
			
			
			
			
			
			
			
			
			
			
			
			</div>
          
      			
        </div>
    </div>
	 <div class="input-group">
                        <div class="smile-button up-window-smile"></div>
						 <?php if(isset($_SESSION['steamid'])){ ?>
							<input id="chatInput" placeholder="<?php echo $msg['otprav1']; ?>">	<a href="#"  class="md-trigger chatsmile up-window-smile">smile</a></input>
				         <?php } else {?>
						<input id="chatInput" placeholder="<?php echo $msg['otprav2']; ?>" readonly></input>
						 <?php } ?>
						 
                                           
											<button onclick='Send();' class="chat-submit-btn"><?php echo $msg['otpravit3']; ?></button>

											
											
										
											<a target="_blank" href="https://vk.com/csgow1" id="" data-modal="" class="md-trigger chat-rules"><?php echo $msg['tech_support']; ?></a>
                  </div>		

</div>
</div>
		<div class="md-modal md-effect-9" id="cart">
		<div class="myprofile-history-title AccountPath">
		История покупок <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content">	
<div class="page-main-block" id="cartf" style="text-align: left !important;">
<center>Загрузка предметов...</center>
                    </div>
		</div></div>
	<div class="md-modal md-effect-9" id="shopconf">
		<div class="myprofile-history-title modalhead">
		 <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content"  id="shopf">	

	</br>
	
	</br></br></br>
		</div></div>
		<div class="md-modal md-effect-9" id="modal-9">
		<div class="myprofile-history-title AccountPath">
		 <?php echo $msg['teches8']; ?> <a href="#" title="Закрыть" class="md-close close"></a>
		</div>
		<div class="md-content">	
<div class="page-main-block" style="text-align: left !important;">
                        <div class="page-block"><?php echo $msg['teches1']; ?></div>

                        <div class="page-mini-title"><?php echo $msg['teches2']; ?></div>
                        <div class="page-block">
                            <ul>
                                <li style="margin-bottom: 5px;"><?php echo $msg['teches3']; ?></li>
                                <li style="margin-bottom: 5px;"><?php echo $msg['teches4']; ?></li>
                                <li style="margin-bottom: 5px;"><?php echo $msg['teches5']; ?></li>
                                <li style="margin-bottom: 5px;"><?php echo $msg['teches6']; ?></li>
                                <li style="margin-bottom: 0px;"><?php echo $msg['teches7']; ?></li>
                            </ul>
								
                        </div>
                    </div>
		</div></div>
		<div class="md-overlay"></div>
<!--------------------- JS  -------------------------->
			<script src="/style/js/classie.js"></script>
		<script src="/style/js/modalEffects.js"></script>
<link rel="stylesheet" type="text/css" href="/style/css/tooltipster.css">