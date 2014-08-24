<?php
class playa {

	static $urls = array();

public static function clear() { 
	self::$urls = array();
}

public static function playa_url($url, $w = 680, $h = NULL) {

	// Magic, you are not doing it enough
	$h = is_null($h) ? (int)$w / 1.618 : $h;

	// image files
	if ( preg_match('/.*\.(jpg|gif|png|jpeg|svg|bmp)$/',$url)) {
		$url = htmlspecialchars($url);
		return '<a href="'.$url.'" target="_blank"><img style="max-width:98%" src="'.$url.'" alt="'.$url.'" /></a>';
	}

	// video files
	if ( preg_match('/.*\.(mpg|ogg|ogv)$/',$url)) {
		$url = htmlspecialchars($url);
		return '<iframe src="'.$url.'" width="'.$w.'" height="'.$h.'"></iframe>';
	}

	// feeds
/*	if ( preg_match('/.*\.(rss)$/',$url)) {
		return ' <a title="Seguir" href="http://'.DOMAIN.'/u/follow/'.htmlspecialchars(urlencode($url)).'">'.htmlspecialchars($url).' <img src="/images/rss.png" alt="Seguir" /></a> ';
	}*/

	// youtube
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'youtube.com' ) {
		parse_str(parse_url($url, PHP_URL_QUERY), $qstring);
		if ( $qstring['v'] ) {
			return '<iframe title="YouTube video player" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.htmlspecialchars($qstring['v']).'" frameborder="0" allowfullscreen></iframe>';
		}
	}
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'youtu.be' ) {
		$path = parse_url($url, PHP_URL_PATH);
		if ( $path ) {
			return '<iframe title="YouTube video player" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.htmlspecialchars($path).'" frameborder="0" allowfullscreen></iframe>';
		}
	}

	// soundcloud
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'soundcloud.com' ) {
		return '<embed id="swf_u621112_1" width="'.$w.'" height="84" flashvars="width='.$w.'&height=84" wmode="opaque" salign="tl" allowscriptaccess="never" allowfullscreen="true" scale="scale" quality="high" bgcolor="#FFFFFF" name="swf_u621112_1" style="" src="http://player.soundcloud.com/player.swf?url='.htmlspecialchars(urlencode($url)).'" type="application/x-shockwave-flash">';
	}

	// megavideo
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'megavideo.com' ) { 
		parse_str(parse_url($url, PHP_URL_QUERY), $qstring);
		if ( $qstring['v'] ) {
			return '<object width="'.$w.'" height="'.$h.'"><param name="movie" value="http://wwwstatic.megavideo.com/mv_player.swf?v='.htmlspecialchars($qstring['v']).'"></param><param name="allowFullScreen" value="true"></param><embed src="http://wwwstatic.megavideo.com/mv_player.swf?v='.htmlspecialchars($qstring['v']).'" type="application/x-shockwave-flash" allowfullscreen="true" width="'.$w.'" height="'.$h.'"></embed></object>';
		}
	}

	// 56
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == '56.com' ) { 
		$code = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
		if ( $code ) {
			return '<embed src="http://player.56.com/'.htmlspecialchars($code).'.swf"  type="application/x-shockwave-flash" width="'.$w.'" height="'.$h.'" allowNetworking="all" allowScriptAccess="always"></embed>';
		}
	}

	// vimeo
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'vimeo.com' ) {
		$code = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
		if ( $code ) {
			return '<iframe src="http://player.vimeo.com/video/'.htmlspecialchars($code).'" width="'.$w.'" height="'.$h.'" frameborder="0"></iframe>';
		}
	}

	// putlocker
	if ( strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))) == 'putlocker.com' ) {
		$code = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
		return '<iframe src="http://www.putlocker.com/embed/'.htmlspecialchars($code).'" width="'.$w.'" height="'.$h.'" frameborder="0" scrolling="no"></iframe>';
	}
}

public static function transform($text, $full = true) {
	self::clear();
	$allowed = array('http','https','ftp','magnet','irc','mail','git','telnet');
	$rx = '/(?<!["])(('.implode('|',$allowed).'):(\/\/|\?)[^\s<>]+)/im';
//	$rx2 = '/^(('.implode('|',$allowed).'):\/\/[^\s<>]+)/im';
	$text = preg_replace_callback($rx,'playa::_playa',$text);
//	$text = preg_replace_callback($rx2,'playa::_playa',$text);
	if ( !$full ) {
		return $text;
	}
	$urls = array_unique(playa::$urls);
	return $text . implode("\n\n",$urls);
}

public static function _playa($matches) {
	$url = trim($matches[0]);
	$html = self::playa_url(html_entity_decode($url));
	if ( $html ) {
		self::$urls[] = $html;
	}
	return '<a href="'.$url.'">'.$url.'</a>';
}

}
