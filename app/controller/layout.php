<?php

class controller_layout {

	public function home( ) {	
		$view = Flight::View();
		$nodes = model_node::getFeatureds();
		$view->set('nodes',$nodes);

		Flight::render('home_get', null, 'layout');
	}
}
