<?php

function nice_link($url, $anchor=false, $class='') {
	if ( ! $anchor ) {
		$dom = parse_url($url, PHP_URL_HOST);
		$dom = (mb_substr($dom,0,4) == 'www.') ? mb_substr($dom,4) : $dom;
		$rest = mb_substr($url, mb_strpos($url,$dom) + mb_strlen($dom));
		$anchor = '<strong>'.View::e($dom).'</strong>'.View::e($rest);
	}

	return '<a href="'.View::e($url).'" class="'.$class.'">'.$anchor.'</a>';
}

function extract_image_url($text) {
	$rx = '/(?<!["])((https?):(\/\/|\?)[^\s<>]+)/im';
	$m = array();
	if ( preg_match_all($rx, $text, $m) ) {
		return $m[0][0];
	} else {
		return '';
	}
}
