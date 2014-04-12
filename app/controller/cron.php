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
				$node = model_node::getByUri( $item->get_permalink() );
				if ( ! $node ) {
					$node = Model::factory('node')->create();
					$node->uri = $item->get_permalink();
					$node->content = '# '.$item->get_title()."\n\n".$item->get_permalink()."\n\n".$item->get_description();
					$node->save();
				}
			}
		}
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
			$feed->enable_cache(true);
			$feed->set_cache_duration(60*15);
			$feed->set_cache_location('cache');
			$feed->init();
			return $feed;
	}


	public static function processFeedUrl($url) {
		return $url;
	}
}
