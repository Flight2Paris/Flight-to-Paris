<?php

class controller_user {
	public function get($username) {
		$view = Flight::View();
		$user = model_user::getByUsername($username);
		Flight::notFoundUnless($user);

		$view->set('user',$user);

		Flight::render('user_get', null, 'layout');
	}

	public function new_user() {
		Flight::render('user_new', null, 'layout');
	}

	public function create() {
		$data = Flight::request()->data;
		require_once('captcha/captcha.php');
		if ( isset($data['reload-captcha_x']) ) {
			Flight::render('user_new', null, 'layout');
		} else if ( ! check() ) {
				Flight::set('error','Y U NO CLICK MEME!');
				Flight::render('user_new', null, 'layout');
		} else if ( model_user::canRegister( $data['username'] ) ) {

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

				Flight::redirect('/');

			} else {

				Flight::set('error','You probably did something stupid!');
				Flight::render('user_new', null, 'layout');
			}

		} else {

			Flight::set('error','That user already exists!');
			Flight::render('user_new', null, 'layout');
		}
	}

}
