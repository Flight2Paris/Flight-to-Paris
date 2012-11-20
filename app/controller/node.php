<?php

class controller_node {
	public function get($uri) {
		$view = Flight::View();
		$format = Router::getFormat($uri);
		$uri = Router::removeFormat($uri);

		$uri = View::makeUri($uri);
		$layout = 'layout';

		$node = model_node::getByUri($uri);

		if ( $node ) {
			$view->set('node',$node);
			$view->set('title',$node->getTitle());
			$template = 'node_get';
		} else {
			$view->set('uri',$uri);
			$template = 'node_new';
		}

		if ( Flight::request()->ajax ) {
			$template = $template.'_ajax';
			$layout = null;
		}

		Flight::render($template, null, $layout);
	}

	public function node_new() {
		$view = Flight::View();
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
			Flight::redirect(View::makeUri('/score'));
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


				// Update author score;
				$author->score -= 1;
				$author->save();

				if ( $data['type'] == 'http://esfriki.com/reply' ) {
					self::saveResponse($node, $data['to']);
					$to = model_node::getByUri($data['to']);
				}

				if ($to) {
					$score = $to->getScore();
					$score->score += 1;
					$score->save();
					Flight::redirect($to->uri);
				} else {
					$score = $node->getScore();
					$score->score += 1;
					$score->save();
					Flight::redirect($node->uri);
				}

			} else {
				Flight::redirect($node->uri);
			}
		} else {
			Flight::redirect($uri);
		}
	}

	private function saveResponse($node,$toURI) {
		$response = Model::factory('link')->create();
		$response->type = 'http://esfriki.com/reply';
		$response->to = $toURI;
		$response->from = $node->uri;
		$response->save();
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

	private static function canSearch($query) {
		return ($query && mb_strlen($query) > 2);
	}


}
