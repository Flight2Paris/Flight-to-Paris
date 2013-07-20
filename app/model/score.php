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
	public function __toString() {
		return self::format($this->score);
	}

	public static function format ($score) {
		$sufixi = array('K','M','G','T');
		$decimals = 0;
		while ( $score >= 1000 && count($sufixi) ) {
			$sufix = array_shift($sufixi);
			$score = $score / 1000;
			if ( $sufix == 'M' ) $decimals = 3;
		}
		return number_format($score,$decimals).$sufix; 
	}

	public function raw() {
		return $this->score;
	}
}

