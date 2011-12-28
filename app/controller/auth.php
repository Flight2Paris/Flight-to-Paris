<?php

class controller_auth {

	public function login() {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
		$data = Flight::request()->data;
		$user = model_user::getByUsername($data['username']);
		$auth = model_auth::getByUserId($user->id);
		if ( $auth->checkPassword($data['password']) ) {
			$auth->login();
		} else {
			Flight::set('error','@#$%^&*!');
		}
		Flight::redirect(View::makeUri('/'));
	}

}
