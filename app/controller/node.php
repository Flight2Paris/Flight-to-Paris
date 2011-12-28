<?php

class controller_node {
	public function get($uri) {
		$view = Flight::View();
		$node = model_node::getByUri('http://esfriki.com/'.$uri);
		if ( $node ) {
			$view->set('node',$node);
			Flight::render('node_get', null, 'layout');
		} else {
			$view->set('uri',$uri);
			Flight::render('node_new', null, 'layout');
		}
	}

	public function create() {
			var_dump(Flight::request()->data);
	}
}
