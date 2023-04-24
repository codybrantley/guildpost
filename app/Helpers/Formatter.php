<?php

class Formatter {
	public static function gold($amount, $named = false, $shorthand = false) {
		if($named) {
			$gold = " gold ";
			$silver = " silver ";
			$copper = " copper ";
		} else {
			$gold = " <img class='coin' src='https://render.guildwars2.com/file/090A980A96D39FD36FBB004903644C6DBEFB1FFB/156904.png'> ";
			$silver = " <img class='coin' src='https://render.guildwars2.com/file/E5A2197D78ECE4AE0349C8B3710D033D22DB0DA6/156907.png'> ";
			$copper = " <img class='coin' src='https://render.guildwars2.com/file/6CF8F96A3299CFC75D5CC90617C3C70331A1EF0E/156902.png'> ";
		}

		$len = strlen($amount);
		if($shorthand) {
			$amount = substr($amount, 0, $len - 4) . $gold;
			return $amount;
		}
		switch($len) {
			case 0:
			case 1:
			case 2:
				$amount = $amount . $copper;
				break;
			case 3:
				$amount = substr($amount, 0, 1) . $silver . substr($amount, 1, 2) . $copper;
				break;
			case 4:
				$amount = substr($amount, 0, 2) . $silver . substr($amount, 2, 2) . $copper;
				break;
			case 5:
				$amount = substr($amount, 0, 1) . $gold . substr($amount, 1, 2) . $silver . substr($amount, 3, 2) . $copper;
				break;
			case 6:
			default:
				$final = $len - 4;
				$amount = substr($amount, 0, $final) . $gold . substr($amount, -4, 2) . $silver . substr($amount, -2, 2) . $copper;
				break;
		}
		return $amount;
	}

	public static function eventDate($start) {
		$time = strtotime($start);
		if(date('i', $time) != '00') {
			$format = 'g:ia';
		} else {
			$format = 'ga';
		}
		return str_replace('m', '', date($format, $time));
	}
}
