<?php

class controller_feed {


    public function all_rss() {
		$nodes = model_node::getFeatureds();
        print_r($nodes);
    }

	public function search() {
		$query = Flight::request()->query['q'];
		$view = Flight::View();

		if ( self::canSearch($query) ) {

			$nodes = model_node::search($query);
			$view->set('nodes',$nodes);

		} else {
			$view->set('error','You are doing it wrong');
		}

		Flight::render('home_get',null,'layout');
	}



}
