<?php

class model_score {

	public static function getByUri( $uri ) {
		$score = Model::factory('score')->where('uri', $uri)->find_one();
		return $score;
	}

	public static function newScoreForUri( $uri ) {
		$score = Model::factory('score')->create();
		$score->score = 0;
		$score->uri = $uri;
		$score->save();
		return $score;
	}

}

class score extends Model {
	
}

