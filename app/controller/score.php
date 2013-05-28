<?php

function fibonacci($n){
  $a = 0;
  $b = 1;
  for ($i = 0; $i < $n; $i++){
    $sum = $a+$b;
    $a = $b;
    $b = $sum;
  }
  return $b;
}

define( 'FIBOLO', 7 );
define( 'FIBOHI', 17 );

class controller_score {

	public function get() {
		if ( auth::isLoggedIn() ) {
			$view = Flight::View();
			$view->set('new',Flight::request()->query['new']);

			$user = auth::getUser();
			$view->set('user',$user);
			if ( strtotime($user->win_last) < time()-60*60*12 ) {
				$user->fibo = FIBOLO;
				$user->save();
			}
		}
		Flight::render('score_get',null,'layout');
	}

	public function post() {

		if ( auth::isLoggedIn() ) {
			$data = Flight::request()->data;
			$user = auth::getUser();
			require_once('lib/captcha/captcha.php');
			Flight::View()->set('user',$user);

			if ( isset($data['reload-captcha']) ) {
				Flight::redirect( View::makeUri('/score') );

			} else if ( check() ) {
				if ( $user->fibo <= FIBOHI ) {
					$won = fibonacci($user->fibo);
					$user->score += $won;
					$user->fibo++;
					$user->win_last = date('Y-m-d H:i:s');
					$user->save();
					Flight::flash('message',array('type'=>'success','icon'=>'plus-sign','text'=>' '.$won.' !!!'));
				}

				Flight::redirect( View::makeUri('/score') );
			} else {
				if ( $user->fibo <= FIBOHI ) {
					$user->score -= fibonacci($user->fibo);
					$user->fibo++;
					$user->save();
				}

				Flight::flash('message',array('type'=>'error','text'=>'Y U NO CLICK MEME!'));
				Flight::redirect( View::makeUri('/score') );
			}
		}
	}

	public function promote() {
		$data = Flight::request()->data;

		if ( auth::isLoggedIn() ) {
			$user = auth::getUser();
			$node = model_node::getByUri($data['uri']);

			$data['promote'] = abs( (int)$data['promote'] );

			if ( $data['promote'] > $user->score ) {
				$data['promote'] = $user->score;
			}

			if ( $data['promote'] && $node ) {
				$user->score = $user->score - $data['promote'];
				$user->save();
				$score = $node->getScore();
				$score->score = $score->score + $data['promote'];
				$score->save();
			}

			if ( Flight::request()->ajax ) {
				exit;
			} else {
				Flight::redirect('/');
			}

		} else {
			Flight::redirect( View::makeUri('/u/new') );
		}
	}

}
