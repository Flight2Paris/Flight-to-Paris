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
		if ( trim( $username ) ) {
			$user = Model::factory('user')->where('username',$username)->find_one();
			return !$user;
		} else {
			return false;
		}
	}

	public static function getLeaders( $limit ) {
		$leaders = Model::factory('user')->order_by_desc('score')->limit($limit)->find_many();
		return $leaders;
	}


	public static function getAllAuthorsFromLastMonth() {
		$authors = ORM::for_table('node')->raw_query('SELECT DISTINCT user.uri as author FROM node 
				JOIN link ON (
					node.created > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
					link.to = node.uri AND
					link.type = \''. AUTHOR_URI .'\'
				) JOIN user ON (
					user.uri = link.from 
				) JOIN auth ON (
					auth.user_id = user.id AND
					auth.last_login > DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
				)')->find_many();
		$res = array();
		foreach ( $authors as $val ) {
			$res[] = self::getByUri($val->author);
		}
        return $res;
	}

}

class user extends Model {

	public function getMonthlyScore() {
		
			$score = ORM::for_table('link')->raw_query('SELECT SUM(score.score) as mscore FROM link 
				JOIN score ON (
					link.created > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND
					link.type = \''. AUTHOR_URI . '\' AND
					link.from = :user AND
					score.uri = link.to
				) GROUP BY link.from', array('user' => $this->uri) )->find_one();

			return $score->mscore;
	}

	public function getAuth() {
		return Model::factory('auth')->where('user_id',$this->id)->find_one();
	}

	public function getNodes( $limit = 30 ) {
		return model_node::getByAuthor($this, $limit);
	}

	public function decreaseScore( $amount = 1 ) {
			$this->score -= $amount;
			$this->save();
	}

	public function increaseScore( $amount = 1 ) {
			$this->score += $amount;
			$this->save();
	}

	public function follow($uri) {
		$link = Model::factory('link')->create();
		$link->type = FOLLOW_URI;
		$link->to = $uri;
		$link->from = $this->uri;
		$link->save();
	}
}
