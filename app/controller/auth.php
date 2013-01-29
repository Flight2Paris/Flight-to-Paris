<?php

class controller_auth {

	public function login() {
		$data = Flight::request()->data;
		$user = model_user::getByUsername($data['username']);
		if ( $user ) {
			$auth = model_auth::getByUserId($user->id);
			if ( $auth->checkPassword($data['password']) ) {
				$auth->login();
				model_auth::clearFailed($user->id);
				Flight::redirect(View::makeUri('/'));
			} else {
				Flight::set('error','@#$%^&*!');
				model_auth::increaseFailed($user->id);
			}
		} else {
			Flight::set('error','@#$%^&*!');
		}

		Flight::render('node_search',null,'layout');
	}

	public function logout() {
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		session_regenerate_id(true);
		Flight::render('auth_logout',null,'layout');
	}

	public function change() {
		Flight::render('auth_change',null,'layout');
	}

	public function dochange() {
		$data = Flight::request()->data;
		$auth = model_auth::getCurrent();
		if ( $auth->checkPassword($data['password']) && $data['newpassword'] == $data['repeatpassword'] ) {
			$auth->changePassword($data['newpassword']);
			Flight::redirect(View::makeUri('/'));
		} else {
			Flight::set('error','You did something wrong');
			Flight::render('auth_change',null,'layout');
		}
	}

	public function pubkey() {
		$view = Flight::View();
		$auth = model_auth::getCurrent();
		$view->set('auth',$auth);
		Flight::render('auth_pubkey',null,'layout');
	}

	public function addkey() {
		$data = Flight::request()->data;

		if ( auth::isLoggedIn() ) {

			$auth = model_auth::getCurrent();

			if ( $auth->checkPassword($data['password']) ) {
				$auth->public_key = $data['public_key'];
				$auth->save();
				Flight::redirect( View::makeUri('/auth/pubkey/?ok=1') );
			} else {
				Flight::set('error','@#$%^&*!');
				Flight::render('auth_pubkey',null,'layout');
			}
		} else {
			Flight::redirect( View::makeUri('/u/new') );
		}
	}
}
