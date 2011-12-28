<?php

class controller_auth {

	public function login() {
		$data = Flight::request()->data;
		$user = model_user::getByUsername($data['username']);
		if ( $user ) {
			$auth = model_auth::getByUserId($user->id);
			if ( $auth->checkPassword($data['password']) ) {
				$auth->login();
			} else {
				Flight::set('login-error','@#$%^&*!');
			}
		} else {
			Flight::set('login-error','@#$%^&*!');
		}

		Flight::render('layout','home');
	}

}
