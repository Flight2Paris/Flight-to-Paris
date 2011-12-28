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
		Flight::request()->data;
	}

}
