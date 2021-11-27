

			<div class="content">
					<div class="top-gamers">
		<ul>
		
		<?php 
		$i = 0;
		
		while ($thistop = mysql_fetch_array($CountFetchArray)) {
			$i++;
			$win = mysql_query("SELECT * FROM `games` WHERE `userid`='{$thistop["steamid"]}'"); 
			echo '
				<li>
				
									<div class="visual">
						<img src="'.$thistop["avatarfull"].'" alt="3oJIoToJIoJI" title="3oJIoToJIoJI" height="91" width="91">
					</div>
					<div class="list-name">
						<ul>
							<li>
								<p>'.$msg['steamn'].': <span class="nick">'.$thistop["personaname"].'</span></p>
							</li>
							<li>
								<p>'.$msg['Win_a_victory'].' <span class="pers">' . mysql_num_rows($win) . '</span></p>
							</li>
							<li>
								<p>'.$msg['all_money'].':  <span class="pers">'.$thistop["won"].' руб.</span></p>
							</li>
						</ul>
					</div>
					<a class="steam" href="https://steamcommunity.com/profiles/'.$thistop["steamid"].'" target="_blank">
						<i class="icon-steam"></i>
					</a>
					<div class="rate bg-col1">
						<span >'.$i.'</span>
					</div>
				
				
				
				
				
				
				
			</li>';	
		}
		?>		
</ul>
</div>
	</div>		