<?php

class controller_cron {
	public function cron() {
		self::getFeedsUpdates();

	}

	public static function getFeedsUpdates() {
		$feeds = self::getFeeds();
		// Aca tenes el P2P @b4zz4
		foreach ( $feeds as $feed_url ) {
			$feed = self::parseFeed($feed_url);

			foreach ( $feed->get_items() as $item ) {
				$link = self::clean_permalink($item->get_permalink());
				if ($link) {
					$node = model_node::getByUri( $link );
					if ( ! $node ) {
						$node = Model::factory('node')->create();
						$node->uri = $link;
						$title = self::clean_title($item->get_title());
						$node->content = '# '.self::gimmeMarkdown($title)."\n\n".
							$link."\n\n".
							self::gimmeMarkdown($item->get_description());
						$node->save();
					}
				}
			}
		}
	}

	public static function clean_permalink($link) {
		$link = trim($link);
		$url = parse_url($link);
		if (!$url) return false;

		$qs = $url['query'];
		if ( stripos($qs,'amp;amp') !== false || stripos($qs,'utm_') !== false ) {
			$qs = false;
		}

		$port = $url['port'];
		if ($port == 80) $port = false;

		$link = $url['scheme'].'://'.trim($url['host'],'/');
		if ($port) $link .= ':'.$port;
		$link .= '/'.ltrim($url['path'],'/');
		if ($qs) $link .= '?'.$qs;

		return $link;
	}

	public static function clean_title($title) {
		$title = trim($title);
		$title = ltrim($title,'#');
		return $title;
	}
	public static function gimmeMarkdown($html) {
		$text = '';
		$randomfile = self::putThisInARandomFile($html);
		exec(HTML2TEXT_PATH.'/html2text.py -b 0 '.$randomfile, $text);
		return implode("\n",$text);
	}

	public static function putThisInARandomFile( $text ) {
		$name = '/tmp/'.sha1(microtime());
		file_put_contents($name,$text);
		return $name;
	}

	public static function getFeeds() {
		$links = model_link::getDistinctByType(FOLLOW_URI);
		$feeds = array();
		foreach ( $links as $l ) {
			$feeds[] = $l->to;
		}
		return $feeds;
	}

	public static function parseFeed ( $url ) {
			$feed = new SimplePie();
			$url = self::processFeedUrl($url);
			$feed->set_feed_url($url);
			//$feed->set_item_class();
			$feed->enable_cache(false);
			$feed->set_cache_duration(60*15);
			$feed->set_cache_location('cache');
			$feed->init();
			return $feed;
	}


	public static function processFeedUrl($url) {
		return $url;
	}


}
