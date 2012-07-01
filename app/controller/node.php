<?php

class controller_node {
	public function get($uri) {
		$view = Flight::View();
		$uri = View::makeUri($uri);
		$node = model_node::getByUri($uri);

		$view->set('random',model_node::get_random_spam());

		if ( $node ) {
			$view->set('node',$node);
			$view->set('comments',$node->getReplies());
			Flight::render('node_get', null, 'layout');
		} else {
			$view->set('uri',$uri);
			Flight::render('node_new', null, 'layout');
		}
	}

	public function node_new() {
		$view = Flight::View();
		$view->set('random',model_node::get_random_spam());
		Flight::render('node_new', null, 'layout');
	}

	public function create() {
		$data = Flight::request()->data;
		$uri = $data['uri'];

		if ( ! auth::isLoggedIn() ) {
			Flight::redirect(View::makeUri('/'));
			return;
		}

		$author = auth::getUser();
		if ( $author->score <= 0 ) {
			Flight::redirect(View::makeUri('/'));
			return;
		}

		if ( !$uri || !model_node::getByUri($uri) ) {

			$node = model_node::getByContent($data['content']);

			if ( !$node ) {

				$node = Model::factory('node')->create();

				if ( $uri ) $node->uri = $uri;

				$node->content = $data['content'];
				$node->save();

				// Generate short uri
				if ( ! $uri ) {
					$node->uri =  View::makeUri('/'.e::encode($node->id));
					$node->save();
				}

				// Save authorship
				$link = Model::factory('link')->create();

				$link->from = $author->uri;
				$link->type = 'http://esfriki.com/author';
				$link->to = $node->uri;
				$link->save();

				// Update node score;
				$score = $node->getScore();
				$score->score += 1;
				$score->save();

				// Update author score;
				$author->score -= 1;
				$author->save();

				// Save response
				if ( $data['type'] == View::makeUri('/reply') ) {
					$response = Model::factory('link')->create();
					$response->type = View::makeUri('/reply');
					$response->to = $data['to'];
					$response->from = $node->uri;
					$response->save();
					Flight::redirect($response->to);
				} else {
					Flight::redirect($node->uri);
				}

			} else {
				Flight::redirect($node->uri);
			}
		} else {
			Flight::redirect($uri);
		}
	}

	public function search() {
		$query = Flight::request()->query['q'];
		$view = Flight::View();
		if ($query && mb_strlen($query) > 2 ) {
			$nodes = model_node::search($query);
			$view->set('nodes',$nodes);
		} else {
			$view->set('error','You are doing it wrong');
		}
		Flight::render('home_get',null,'layout');
	}
}
