<?php 

session_start();

if ( strtolower($_SERVER['REQUEST_METHOD']) == 'get' ) {
	
	$c_width = 370;
	$c_height = 140;

	// Load backgrounds
	$files = array();
	$dir = opendir('.images/backgrounds/');
	while ( $file = readdir($dir)) {
		if ( substr($file, 0, 1) != '.' ) {
			$files[] = $file;
		}
	}
	shuffle($files);

	$back = array_pop($files);
	$front = array_pop($files);

	if ( substr($back,-3,3) == 'jpg' ) {
		$back = imagecreatefromjpeg('.images/backgrounds/'.$back);
	} elseif ( substr($back,-3,3) == 'png' ) {
		$back = imagecreatefrompng('.images/backgrounds/'.$back);
	}

	if ( substr($front,-3,3) == 'jpg' ) {
		$front = imagecreatefromjpeg('.images/backgrounds/'.$front);
	} elseif ( substr($front,-3,3) == 'png' ) {
		$front = imagecreatefrompng('.images/backgrounds/'.$front);
	}

	$image = imagecreatefrompng('.images/template.png');
	ImageCopyResampled($image, $back, 0, 0, rand(0,imagesx($back)-$c_width), rand(0,imagesy($back)-$c_height), $c_width, $c_height, $c_width, $c_height);

	// Load mark
	$files = array();
	$dir = opendir('.images/marks/');
	while ( $file = readdir($dir)) {
		if ( substr($file, 0, 1) != '.' ) {
			$files[] = $file;
		}
	}
	shuffle($files);

	$mark = array_pop($files);
	if ( substr($mark,-3,3) == 'png' ) {
		$mark = imagecreatefrompng('.images/marks/'.$mark);
	}

	// dest image,  effect, ammount
	imagefilter($mark,4,rand(30,150),rand(30,150),rand(30,150));

	$mark_x = rand(0,$c_width-imagesx($mark));
	$mark_y = rand(0,$c_height-imagesy($mark));
	$mark_w = imagesx($mark)+rand(-25,0);
	$mark_h = imagesy($mark)+rand(-25,0);
	$_SESSION['captcha']['x'] = $mark_x + $mark_w/2;
	$_SESSION['captcha']['y'] = $mark_y + $mark_h/2;

	// dest image, source image, dest x, dest y, source x, source y, dest width, dest heigh, source width, source height
	imagecopyresampled($image, $mark, $mark_x, $mark_y, 0, 0, $mark_w, $mark_h, imagesx($mark), imagesy($mark));

	// dest image, source image, dest x, dest y, source x, source y, source width, source height, alpha
	imagecopymerge($image, $front, 0,0,rand(0,imagesx($front)-$c_width), rand(0,imagesy($front)-$c_height),$c_width, $c_height,rand(40,70));

	if ( rand(0,1) ) {
		imagefilter($image,0);
	}

	imagefilter($image,2,rand(0,40));

	header('Content-type: image/png');
	echo imagepng($image, null, 8);

} else {
	echo "wrong request";
}
