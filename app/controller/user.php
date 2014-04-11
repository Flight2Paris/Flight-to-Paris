<?php

class controller_user {
	public function get($username) {
		$view = Flight::View();
		$user = model_user::getByUsername(urldecode($username));
		Flight::notFoundUnless($user);

		$view->set('user',$user);
       
        $view->set('feeds',Array((object) Array(
            'title' => "Author feed (RSS)",
            'uri'   => $user->uri . "/feed/rss"    
        ), (object) Array(
            'title' => "Author feed (ATOM)",
            'uri'   => $user->uri . "/feed/atom"
        )));

		Flight::render('user_get', null, 'layout');
	}

    public function feed($username,$format) {

        $view = Flight::View();
		$user = model_user::getByUsername(urldecode($username));
		Flight::notFoundUnless($user);

		$view->set('user',$user);
        $view->set('nodes', $user->getNodes());

		Flight::render('user_get_' . $format, null, null);

    }

	public function new_user() {
		Flight::render('user_new', null, 'layout');
	}

	public function create() {
		$data = Flight::request()->data;
		require_once('lib/captcha/captcha.php');

		if ( isset($data['reload-captcha']) ) {
			Flight::redirect( View::makeUri('/u/new') );

		} else if ( ! check() ) {
			Flight::flash('message',array('type'=>'error','text'=>'Y U NO CLICK MEME!'));
			Flight::redirect( View::makeUri('/u/new') );

		} else if ( ! model_user::canRegister( $data['username'] ) ) {
			Flight::flash('message',array('type'=>'error','text'=>'El usuario ya existe o no puede registrarse!'));
			Flight::redirect( View::makeUri('/u/new') );

		} else {
			controller_user::register_user($data);
		}
	}


	public static function register_user($data) {
			$user = Model::factory('user')->create();
			$user->username = $data['username'];
			$user->uri = View::makeUri('/u/'.urlencode($data['username']));
			$user->save();

			if ( $user->id ) {
				$salt = auth::genSalt();
				$auth = Model::factory('auth')->create();
				$auth->password = $salt.auth::hash($salt, $data['password']);
				$auth->user_id = $user->id;
				$auth->save();

				$auth->login();

				Flight::flash('message',array('type'=>'success','text'=>'Te registraste con éxito, ahora gana algunos puntos!'));
				Flight::redirect( View::makeUri('/score') );

			} else {

				Flight::flash('message',array('type'=>'error','text'=>'Algo no andubo. oops!'));
				Flight::redirect( View::makeUri('/u/new') );
			}
	}

	public function pubkey($username) {
		$view = Flight::view();
		$user = model_user::getByUsername(urldecode($username));
		Flight::notFoundUnless($user);

		$view->set('auth',$user->getAuth());

		Flight::render('pubkey', null, 'layout');
	}

	public function follow_page() {
		Flight::render('user_follow', null, 'layout');
	}

	public function follow() {
		$data = Flight::request()->data;
		$url = $data['url'];
		auth::getUser()->follow($url);
		Flight::redirect('/');
	}

	public function new_avatar() {
		Flight::render('user_avatar', null, 'layout');
	}

	public function save_avatar() {
		Flight::redirect('/');
	}
}
