<?php

require_once('score.php');

class model_node {

	public static function getByUri( $uri ) {
		$node = Model::factory('node')->where('uri', $uri)->find_one();
		return $node;
	}

	public static function getByContent( $content ) {
		$node = Model::factory('node')->where('content',$content)->find_one();
		return $node;
	}

	public static function getLatest( ) {
		$nodes = Model::factory('node')->order_by_desc('created')->limit(50)->find_many();
		return $nodes;
	}

	public static function search($query) { 
		$nodes = Model::factory('node')->where_like('content','%'.$query.'%')->order_by_desc('created')->limit(50)->find_many();
		return $nodes;
	}

	public static function get_random_spam() {
		$nodes = Model::factory('node')->where_like('content','%#spam%')->order_by_desc('created')->limit(50)->find_many();
		shuffle($nodes);
		shuffle($nodes); // now it's more random :trollface:
		return array_pop($nodes);
	}
}

class node extends Model {
	public function getReplies() {
		$return = array();
		$replies = Model::factory('link')->where('to',$this->uri)->where('type',View::makeUri('/reply'))->order_by_asc('created')->limit(50)->find_many();
		foreach ( $replies as $reply ) {
			$return[] = model_node::getByUri($reply->from);
		}
		return $return;
	}

	public function getAuthor() {
		$link = Model::factory('link')->where('to',$this->uri)->where('type',View::makeUri('/author'))->find_one();
		return model_user::getByUri($link->from);
	}

	public function getScore() {
		$score = model_score::getByUri($this->uri);
		if ( ! $score ) {
			$score = model_score::newScoreForUri($this->uri);
		}
		return $score;
	}
}

/* 
	License:
		All of this was stolen from somewhere a long long 
	time ago and modified randomly to add "features".

	If it works don't touch it.
*/
class e {

        //const $codeset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //readable character set excluded (0,O,1,l)
        const codeset = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";

        static function encode($n){
            $base = strlen(self::codeset);
            $converted = '';

            while ($n > 0) {
                $converted = substr(self::codeset, bcmod($n,$base), 1) . $converted;
                $n = self::bcFloor(bcdiv($n, $base));
            }

            return $converted ;
        }

        static function decode($code){
            $base = strlen(self::codeset);
            $c = '0';
            for ($i = strlen($code); $i; $i--) {
                $c = bcadd($c,bcmul(strpos(self::codeset, substr($code, (-1 * ( $i - strlen($code) )),1))
                        ,bcpow($base,$i-1)));
            }

            return bcmul($c, 1, 0);
        }

	static function sql($string) { return mysql_real_escape_string( $string); }
	static function html($string) { return htmlentities($string); }
        static private function bcFloor($x)
        {
            return bcmul($x, '1', 0);
        }

        static private function bcCeil($x)
        {
            $floor = bcFloor($x);
            return bcadd($floor, ceil(bcsub($x, $floor)));
        }

        static private function bcRound($x)
        {
            $floor = bcFloor($x);
            return bcadd($floor, round(bcsub($x, $floor)));
        }
    }
