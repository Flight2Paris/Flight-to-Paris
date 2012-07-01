<?php

require_once('node.php');

class model_link {

	public static function getByUri( $uri ) {
		$node = Model::factory('node')->where('uri', $uri)->find_one();
		return $node;
	}

	public static function getByContent( $content ) {
		$node = Model::factory('node')->where('content',$content)->find_one();
		return $node;
	}

	public static function getLatest( ) {
		$nodes = Model::factory('node')->order_by_desc('created')->limit(50)->find_many();
		return $nodes;
	}

	public static function search($query) { 
		$nodes = Model::factory('node')->where_like('content','%'.$query.'%')->order_by_desc('created')->limit(50)->find_many();
		return $nodes;
	}
}

class link extends Model {
	
}

