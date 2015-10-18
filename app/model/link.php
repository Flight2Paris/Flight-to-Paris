<?php

require_once('node.php');

class model_link {

	public static function getLatest( ) {
		$links = Model::factory('link')->order_by_desc('created')->limit(50)->find_many();
		return $links;
	}

	public static function getDistinctByTypeAndFrom($type, $from) {
		$links = ORM::for_table('link')->distinct()->select('to')->where('type',$type)->where('from',$from)->find_many();
		return $links;
	}

	public static function getDistinctByType($type) {
		$links = ORM::for_table('link')->distinct()->select('to')->where('type',$type)->find_many();
		return $links;
	}
}

class link extends Model {
	
}

