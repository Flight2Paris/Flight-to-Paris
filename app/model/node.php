<?php

require_once('score.php');

use Hybrid\Cache as HybridCache;

class model_node {

    public static function getByUri( $uri ) {

        $cache = new HybridCache(__METHOD__, $uri);

        $node = $cache->getCacheOr(function ($cache) USE ($uri) {
    		return Model::factory('node')->where('uri', $uri)->find_one();
        });

		return $node;
	}

    public static function getByContent( $content ) {

        $cache = new HybridCache(__METHOD__,$content);

        $node = $cache->getCacheOr(function ($cache) USE ($content) {
    		return Model::factory('node')->where('content',$content)->find_one();
        });

        return $node;

	}

	public static function search($query=null,$before=0,$after=0,$skip=0, $count = null) {
		$before = (int)$before;
		$after = (int)$after;
		$skip = abs((int)$skip);
		$query = trim($query);
        $count = (int) $count;

        $count = $count ? $count : PAGESIZE;
        if ($count > MAX_PAGESIZE) $ount = MAX_PAGESIZE;

        $cache = new HybridCache(__METHOD__,func_get_args());
        
        $res = $cache->getCacheOr(function ($cache) use ($before, $after, $skip, $query, $count) {
			$score = '(LOG(COALESCE(score.score, 0)+2)*172800)';
            $q = 'SELECT node.uri, UNIX_TIMESTAMP(node.created)+'.$score.' AS powa FROM node LEFT JOIN score ON (score.uri = node.uri) WHERE 1';

            if ( $before > 0 ) {
                $q .= ' AND UNIX_TIMESTAMP(node.created) < '.$before;
            }
            if ( $after > 0 ) {
                $q .= ' AND UNIX_TIMESTAMP(node.created) > '.$after;
            }

            if ( $query ) {
				if ( mb_substr_count($query, '') < 5 ) {
                	$q .= ' AND content LIKE '.ORM::get_db()->quote('%'.mb_ereg_replace('\s+','%', $query).'%');
				} else {
                	$q .= ' AND content LIKE '.ORM::get_db()->quote('%'.$query.'%');
				}
            }

            $q .= ' ORDER BY powa DESC';
            $q .= ' LIMIT '.$skip.','.$count;

            $nodes = ORM::for_table('node')->raw_query($q)->find_many();
            $res = array();
            foreach ( $nodes as $val ) {
                $res[] = model_node::getByUri($val->uri);
            }
            return $res;

        });

        return $res;

	}

	public static function getByAuthor($author, $limit = 30) {
		$q = "SELECT `to` FROM `link` WHERE `type` = '".AUTHOR_URI."' AND `from` = '".$author->uri."' ORDER BY created DESC LIMIT $limit";
		$nodes = ORM::for_table('node')->raw_query($q)->find_many();	
		$res = array();
        foreach ( $nodes as $val ) {
            $res[] = model_node::getByUri($val->to);
        }
        return $res;
	}

}

class node extends Model {
	public function getTitle() {
		$lines = explode("\n",trim($this->content));
		$title = trim(array_shift($lines));
		if ( mb_strlen($title) < 100 ) { 
			$title .= ' - '.trim(array_shift($lines));
		}
		return $title;
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
		$replyTo = Model::factory('link')->where('from',$this->uri)->where('type',REPLY_URI)->order_by_asc('created')->find_one();
		return (bool)$replyTo;
	}

	public function getReplyTo() {
		$return = array();
		$replyTo = Model::factory('link')->where('from',$this->uri)->where('type',REPLY_URI)->order_by_asc('created')->find_one();
		return model_node::getByUri($replyTo->to);
	}

	public function getAuthor() {
		$link = Model::factory('link')->where('to',$this->uri)->where('type', AUTHOR_URI)->find_one();
		return model_user::getByUri($link->from);
	}

	public function getScore() {
		$score = model_score::getByUri($this->uri);
		if ( ! $score ) {
			$score = model_score::newScoreForUri($this->uri);
		}
		return $score;
	}

	public function increaseScore($amount = 1 ) {
			$score = $this->getScore();
			$score->score += $amount;
			$score->save();
	}

	public function decreaseScore($amount = 1 ) {
			$score = $this->getScore();
			$score->score -= $amount;
			$score->save();
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
