<?php

class model_auth {

	public static function getByUserId( $user_id ) {
		$auth = Model::factory('auth')->where('user_id', $user_id)->find_one();
		return $auth;
	}
}

class auth extends Model {
	public function checkPassword($password) {
	}

	public function login() {
	}
}
