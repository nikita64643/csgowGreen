$(document).ready(function(e) {
	var $rps = false; // Default to true
	var $options;
	var $message;
	var $winCount = 0;
	var $lossCount = 0;
	var $tieCount = 0;
	var $moveCount = 0;
	var $history = {};
	if ($rps == true) {
		$options = ['rock', 'paper', 'scissors'];
	} else {
		$options = ['rock', 'paper', 'scissors', 'lizard', 'spock'];
	}

	$('button').click(function(e) {
		var $this = $(this);
		var $selection = $this.data('play');
		var $play = play($selection);
		$('button').removeClass();
		$this.addClass($play);
		$('.result').empty().html('<div class="animated fadeOutUp">' + $message + '</div>');
	});

	function play($selection) {
		var $winners = {
			rock: ['scissors', 'lizard'],
			paper: ['rock', 'spock'],
			scissors: ['paper', 'lizard'],
			lizard: ['spock', 'paper'],
			spock: ['rock', 'scissors']
		}
		var $cpuPlays = randomPlay($options);
		
// 		console.log('CPU: ' + $cpuPlays, 'Player: ' + $selection);
		
		if ($selection === $cpuPlays) {
			$message = 'tied with ' + $selection;
			$moveCount++;
			$tieCount++;
			recordScore('tie', $selection, $cpuPlays);
			return 'tie';
		}
		
		// Check if player won
		if($winners[$cpuPlays].indexOf($selection) == -1) {
			$message = $selection + ' beat ' + $cpuPlays;
			$moveCount++;
			$winCount++;
			recordScore('win', $selection, $cpuPlays);
			return 'win';
		}
		
		// Check if CPU won
		if($winners[$selection].indexOf($cpuPlays) == -1) {
			$message = $selection + ' lost against ' + $cpuPlays;
			$moveCount++;
			$lossCount++;
			recordScore('loss', $selection, $cpuPlays);
			return 'loss';
		}
		
		return 'none';
	}

	function randomPlay($arr) {
		return $arr[Math.floor(Math.random() * $arr.length)];
	}
	
	function recordScore($type, $player, $cpu) {
		$('.addscore').prepend('<div class="history-item ' + $type + '"><i class="fa fa-hand-' + $player + '-o"></i><i class="fa fa-hand-' + $cpu + '-o"></i></div>');
		$('.scoreboard .win span').text($winCount);
		$('.scoreboard .tie span').text($tieCount);
		$('.scoreboard .loss span').text($lossCount);
		$('.scoreboard .move span').text($moveCount);
	}
});