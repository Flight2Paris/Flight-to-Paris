<?php

class controller_layout {

	public function home( ) {	
		$view = Flight::View();
		$nodes = model_node::getLatest();
		$view->set('nodes',$nodes);
		$view->set('random',model_node::get_random_spam());
		Flight::render('home_get', null, 'layout');
	}
}
