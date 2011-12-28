<?php

class model_user {

	public static function getByUsername( $username ) {
		return Model::factory('user')->where('username', $username)->find_one();
	}

}

class user extends Model {
	
}
