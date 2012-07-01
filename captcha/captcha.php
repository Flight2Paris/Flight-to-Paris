<?php

function check() {
	if ( isset($_SESSION['captcha']) && 
			isset($_SESSION['captcha']['x']) && 
			isset($_SESSION['captcha']['y']) &&
			isset($_POST['captcha_x']) && 
			isset($_POST['captcha_y']) ) {

		$diff_x = $_SESSION['captcha']['x'] - $_POST['captcha_x'];
		$diff_y = $_SESSION['captcha']['y'] - $_POST['captcha_y'];
		($diff_x < 0)?$diff_x*=-1:'';
		($diff_y < 0)?$diff_y*=-1:'';

		unset($_SESSION['captcha']['x']);
		unset($_SESSION['captcha']['y']);

		if ( sqrt($diff_x*$diff_x+$diff_y*$diff_y) < 35 ) {
			return true;
		} else {
			return false;
		}
	}
}
