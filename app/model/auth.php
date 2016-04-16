<?php

class model_auth {

	public static function getByUserId( $user_id ) {
		$auth = Model::factory('auth')->where('user_id', $user_id)->find_one();
		return $auth;
	}

	public static function getCurrent() {
		if ( isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 ) {
			$auth = Model::factory('auth')->where('user_id', $_SESSION['user_id'])->find_one();
			self::updateCookie();
		} else {
			$auth = new auth;
		}
		return $auth;
	}

	public static function increaseFailed( $user_id ) {
		$auth = self::getByUserId( $user_id );
		$auth->failed = $auth->failed + 1;
		$auth->save();
	}

	public static function clearFailed( $user_id ) {
		$auth = self::getByUserId( $user_id );
		$auth->failed = 0;
		$auth->save();
	}
}

class auth extends Model {
	public function __construct() {
		//@TODO use https
		self::updateCookie();
	}

	// Me arrepiento de cuando decidi usar cammelCase
	public static function updateCookie() {
		session_set_cookie_params( 15*24*60*60, '/', DOMAIN, false, true );
		session_start();
	}

	public function checkPassword($password) {
		if ( ! $this->password && sha1($password) == $this->old_password ) {
			$this->old_password = null;
			$this->changePassword($password);
			return true;
		} else {
			$salt = $this->getSalt();
			$hash = $this->getHash();

			return ($hash == $this->hash($salt,$password));
		}
	}

	public function changePassword($password) {
		$salt = self::genSalt();
		$this->password = $salt.self::hash($salt,$password);
		$this->save();
	}

	public static function hash($salt, $pass) {
		return hash( 'sha256', hash('sha256',$salt) . hash('sha256',$pass) );
	}

	private function getSalt() {
		return substr($this->password,0,16);
	}

	private function getHash() {
		return substr($this->password,16,64);
	}

	public static function genSalt() {
		return substr(uniqid('',true),0,16);
	}

	public function login() {
		$_SESSION['logged'] = true;
		$_SESSION['user_id'] = $this->user_id;
		$this->last_login = date('Y-m-d H:i:s');
		$this->save();
	}

	public static function isLoggedIn() {
		return $_SESSION['logged'];
	}

	public static function getUser() {
		return model_user::getById($_SESSION['user_id']);
	}
}
