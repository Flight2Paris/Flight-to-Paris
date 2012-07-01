<?php

class model_user {

	public static function getByUsername( $username ) {
		return Model::factory('user')->where('username', $username)->find_one();
	}

	public static function getByUri( $uri ) {
		return Model::factory('user')->where('uri', $uri)->find_one();
	}

	public static function getById( $id ) {
		return Model::factory('user')->where('id', $id)->find_one();
	}

	public static function canRegister( $username ) {
		$user = Model::factory('user')->where('username',$username)->find_one();
		return !$user;
	}

	public static function getLeaders( $limit ) {
		$leaders = Model::factory('user')->order_by_desc('score')->limit($limit)->find_many();
		return $leaders;
	}
}

class user extends Model {
	
}
