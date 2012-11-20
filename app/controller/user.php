<?php

class controller_user {
	public function get($username) {
		$view = Flight::View();
		$user = model_user::getByUsername(urldecode($username));
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
				$this->register_user($data);

		} else {

			$user = model_user::getByUsername($data['username']);
			if ( $user ) {
				$auth = model_auth::getByUserId($user->id);
				if ( $auth->checkPassword($data['password']) ) {
					controller_auth::login();
				} else {
					Flight::set('error','El usuario ya existe!');
				}
			}
			Flight::render('user_new', null, 'layout');
		}
	}


	private function register_user($data) {
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
				Flight::redirect('/score?new=1');

			} else {

				Flight::set('error','Algo no anduvo culpa tuya!!');
				Flight::render('user_new', null, 'layout');
			}
	}

	public function pubkey($username) {
		$view = Flight::view();
		$user = model_user::getByUsername(urldecode($username));
		Flight::notFoundUnless($user);

		$view->set('auth',$user->getAuth());

		Flight::render('pubkey', null, 'layout');
	}

	public function follow($url) {
		$url = urldecode($url);
		$view = Flight::view();

		$user = auth::getUser();

		$view->set('user',$user);
		$view->set('url',$url);

		Flight::render('user_follow', null, 'layout');
	}
}
