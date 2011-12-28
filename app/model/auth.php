<?php

class model_auth {

	public static function getByUserId( $user_id ) {
		$auth = Model::factory('auth')->where('user_id', $user_id)->find_one();
		return $auth;
	}
}

class auth extends Model {
	public function checkPassword($password) {
		$salt = substr($this->password,0,16);
		$pass = substr($this->password,16,64);
		return substr($this->password,16,64) == hash('sha256',hash('sha256',$salt).hash('sha256',$password));
	}

	public function login() {
	}

	public static function isLoggedIn() {}

	public static function getUser() {}
}
