<?php
function allrooms() {
    $rs = mysql_query("SELECT * FROM `rooms` ORDER BY `id` DESC") or die(mysql_error());
    while ($row = mysql_fetch_array($rs)) {
	$name     = fetchinfo("personaname", "account", "steamid", $row['odmin']);
	$avatar = fetchinfo("avatarfull", "account", "steamid", $row['odmin']);
	
	
        echo '    
		
		<div class="matchmain">
<div class="matchheader">
<div class="whenm">' . $row["name"] . ' ' . $row["data"] . '<span style="color: #72A326; text-shadow: 1px 1px 0px #4A7010; font-weight: bold;"> LIVE</span>
<span style="font-weight: bold; color: #D12121">&nbsp;&nbsp;</span>
<span class="la-time-match"></span><div class="la-match-info" style="display: none;"></div></div>
<div class="eventm">' . $row["mindeposit"] . '<span style="font-size: 8px;vertical-align: top;line-height: 1;margin-left: 7px; display: inline-block;margin-top: 2px;">руб</span></div>
</div>
<div class="match" style="background-image: url(http://csgolounge.com/img/events/b6b339db8ab74472839d7eb2eb73847e.jpg?1426001306)">
  <div class="matchleft">
    <a href="/rooms/'.$row["id"].'">
    <div style="width: 45%; float: left; text-align: right">
      <div class="team" style="float: right; background: url(\''.$avatar.'\')  100% 100% no-repeat;background-size: 60px 50px;"></div>
      <div class="teamtext"><b>'.$name .'</b></div>
    </div>
    <div style="width: 10%; float: left; text-align: center;    color: #000; margin-top: 0.6em" class="la-bo">Best of 3</div>
    <div style="width: 45%; float: left; text-align: left">
         ';
	  if(strlen($row['player2'])>5){
		  echo'<div class="team" style="float: left; background: url(\'/style/images/_Unknown.png\')  100% 100% no-repeat;background-size: 60px 50px;"></div>
  <div class="teamtext"><b>TStorm</b>';
	  }else{
		   echo'<div class="team" style="float: left; background: url(\'/style/images/_Unknown.png\')  100% 100% no-repeat;background-size: 60px 50px;"></div>
  <div class="teamtext"><b>???</b>';
	  }
	  echo'
	  </div>
    </div>
    </a>
  </div>
</div>
</div>';
    }
}
function gameroom($id){
	echo '<section>
	<button id="rock" data-play="rock"><i class="fa fa-hand-rock-o"></i><span>Rock</span></button>
	<button id="paper" data-play="paper"><i class="fa fa-hand-paper-o"></i><span>Paper</span></button>
	<button id="scissors" data-play="scissors"><i class="fa fa-hand-scissors-o"></i><span>Scissors</span></button>
	<button id="lizard" data-play="lizard"><i class="fa fa-hand-lizard-o"></i><span>Lizard</span></button>
	<button id="spock" data-play="spock"><i class="fa fa-hand-spock-o"></i><span>Spock</span></button>
	<div class="result"></div>
</section>
<aside>
	<div class="legend">
		<div class="me">
			<div>Я</div>
		</div>
		<div class="cpu">
			<div>Враг</div>
		</div>
	</div>
	<div class="addscore">
	
	</div>
	<div class="scoreboard">
		<div class="win">
			<span>0</span>
			<div>wins</div>
		</div>
		<div class="tie">
			<span>0</span>
			<div>ties</div>
		</div>
		<div class="loss">
			<span>0</span>
			<div>losses</div>
		</div>
		<div class="move">
			<span>0</span>
			<div>total</div>
		</div>
	</div>
</aside><sectionitems>
	<div class="legend">
		<div class="me">
			<div>Я</div>
		</div>
		<div class="cpu">
			<div>Враг</div>
		</div>
	</div>
	<div class="myitems">
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>

</div>
<div class="youritems">
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
<div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div><div class="history-item win"><i class="fa fa-hand-paper-o"></i><i class="fa fa-hand-rock-o"></i></div>
v
</div>
</sectionitems>';
}
?>