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

	public static function search($query=null,$before=0,$after=0,$skip=0) {
		$before = (int)$before;
		$after = (int)$after;
		$skip = abs((int)$skip);
		$query = trim($query);
		$q = 'SELECT node.uri FROM node JOIN score ON (score.uri = node.uri) WHERE 1';

		if ( $before > 0 ) {
			$q .= ' AND UNIX_TIMESTAMP(node.created) < '.$before;
		}
		if ( $after > 0 ) {
			$q .= ' AND UNIX_TIMESTAMP(node.created) > '.$after;
		}

		if ( $query ) {
			$q .= ' AND content LIKE '.ORM::get_db()->quote('%'.$query.'%');
		}

		$q .= ' ORDER BY UNIX_TIMESTAMP(node.created) + sqrt(score.score-1)*3600 DESC';
		$q .= ' LIMIT '.$skip.','.PAGESIZE;

		$nodes = ORM::for_table('node')->raw_query($q)->find_many();
		$res = array();
		foreach ( $nodes as $val ) {
			$res[] = self::getByUri($val->uri);
		}
		return $res;
	}

}

class node extends Model {
	public function getTitle() {
		$lines = explode("\n",trim($this->content));
		return array_shift($lines);
	}

	public function getReplies() {
		$return = array();
		$replies = Model::factory('link')->where('to',$this->uri)->where('type',View::makeUri('/reply'))->order_by_asc('created')->limit(50)->find_many();
		foreach ( $replies as $reply ) {
			$return[] = model_node::getByUri($reply->from);
		}
		return $return;
	}

	public function isReply() {
		$return = array();
		$replyTo = Model::factory('link')->where('from',$this->uri)->where('type','http://esfriki.com/reply')->order_by_asc('created')->find_one();
		return (bool)$replyTo;
	}

	public function getReplyTo() {
		$return = array();
		$replyTo = Model::factory('link')->where('from',$this->uri)->where('type','http://esfriki.com/reply')->order_by_asc('created')->find_one();
		return model_node::getByUri($replyTo->to);
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
