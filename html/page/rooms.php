<link href="/style/css/room.css" rel="stylesheet">
 <script type="text/javascript" src="/style/js/rooms.js"></script>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
<div class="content">
<header class="head">
			<h2>Rooms</h2>
		</header>
<?php if(isset($match)){
	gameroom($match); 
	echo'<script type="text/javascript">
	
	</script>';
}
else{	?>
		
<?php allrooms(); }?>
		
		</div>




</div>
				 
			