<?php

class model_node {

	public static function getByUri( $uri ) {
		$node = Model::factory('node')->where('uri', $uri)->find_one();
		return $node;
	}
}

class node extends Model {
	
}
