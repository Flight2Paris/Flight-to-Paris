<?php

class controller_node {

	// Show a single node
	public function get($path) {
		$view = Flight::View();
		$layout = 'layout';

		// Get the requested format and URI
		$format = Router::getFormat($path);
		$format = trim($format) ? trim($format) : 'html';

		$path = Router::removeFormat($path);
		$uri = View::makeUri($path);
		$node = model_node::getByUri($uri);

		if ( $node ) {
			$view->set('node',$node);
			$view->set('title',$node->getTitle());
			$template = 'node_get';
		} else {
			$view->set('uri',$uri);
			Flight::Response()->status(404);
			$template = 'node_404';
		}

		if ( Flight::request()->ajax ) {
			$template = $template.'_ajax';
			$layout = null;
		} else {
			$template = $template.'_'.$format;
			if ( $format != 'html' ) {
				$layout = null;
			}
		}

        $view->set('feeds',Array((object) Array(
            'title' => "Node feed (RSS)",
            'uri'   => $node->uri . ".rss"
        ), (object) Array(
            'title' => "Node feed (ATOM)",
            'uri'   => $node->uri . ".atom"    
        )));

		Flight::render($template, null, $layout);
	}

	// Create a new node
	public function create() {
		$data = Flight::request()->data;
		$uri = $data['uri'];

		// If the user isn't logged in cant publish
		if ( ! auth::isLoggedIn() ) {
			Flight::redirect(View::makeUri('/'));
			return;
		}

		$author = auth::getUser();
		if ( $author->score <= 0 ) {
			Flight::redirect(View::makeUri('/score'));
			return;
		}

		// If we can use this uri
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

				self::saveAuthorship($node,$author->uri);

				$author->decreaseScore();
				$node->increaseScore();

				if ( $data['type'] == REPLY_URI ) {
					self::saveResponse($node, $data['to']);
					$to = model_node::getByUri($data['to']);
				}

				if ($to) {
					Flight::redirect($to->uri);
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

	private function saveResponse($node,$toURI) {
		$response = Model::factory('link')->create();
		$response->type = REPLY_URI;
		$response->to = $toURI;
		$response->from = $node->uri;
		$response->save();
	}

	private function saveAuthorship($node,$authorURI) {
		$link = Model::factory('link')->create();
		$link->type = AUTHOR_URI;
		$link->to = $node->uri;
		$link->from = $authorURI;
		$link->save();
	}

	public function search($uri) {
		$view = Flight::View();
        $layout = 'layout';

		$query = Flight::request()->query['q'];
		$after = Flight::request()->query['after'];
		$before = Flight::request()->query['before'];
		$skip = Flight::request()->query['skip'];
		$count = Flight::request()->query['count'];

		$template = 'node_search';

        $format = Router::getFormat($uri);
		$format = trim($format) ? trim($format) : 'html';
        
		if ( $format != 'html' ) {
    		$layout = null;
		}

        if ( empty($query) ) {
            $nodes = model_node::search($query,$before,$after,$skip, $count);
            $view->set('title',SITE_TITLE);
		} else if ( self::canSearch($query) ) {
			$nodes = model_node::search($query,$before,$after,$skip, $count);

            $params = Array(
                'q' => $query,
                'after' => $after,
                'before' => $before,
                'skip' => $skip,
                'count' => $count
            );

            $view->set('feeds',Array(
                (object) Array(
                    'title' => "Search feed (RSS)",
                    'uri'   => View::makeUri("/search.rss?" . http_build_query($params)) 
                ), (object) Array(
                    'title' => "Search feed (ATOM)",
                    'uri'   => View::makeUri("/search.atom?" . http_build_query($params)) 
                )
            ));

           $view->set('title', "$query | ".  SITE_TITLE);
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'You are doing it wrong.'));
		}

		$view->set('nodes',$nodes);		

		if ( Flight::request()->ajax ) {
			$template = $template.'_ajax';
			$layout = null;

			if ( ! count($nodes) ) {
				Flight::halt(204);
			}
		} else {
			$template = $template.'_'.$format;
		}

		$time = ORM::for_table('node')->raw_query('select unix_timestamp() as timestamp')->find_one();
		$view->set('before',$time->timestamp);
		$view->set('after',$time->timestamp);
		$view->set('skip',$skip);
		$view->set('query',$query);

		Flight::render($template,null,$layout);
	}

	private static function canSearch($query) {
		$query = trim($query);
		return ($query && mb_strlen($query) > 2);
	}

	public function preview() {
		$view = Flight::View();

		$markdown = Flight::request()->data['markdown'];

		$view->set('markdown',$markdown);
	
		Flight::render('node_preview_ajax',null,null);
	}

	public function getbyuri() {
		$view = Flight::View();
		$data = Flight::request()->data;
		$uri = $data['uri'];
		$node = model_node::getByUri($uri);
		$view->set('node',$node);
		Flight::render('node_get_ajax',null,null);
	}

}
