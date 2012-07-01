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

class controller_score {

	public function get() {
		if ( auth::isLoggedIn() ) {
			$user = auth::getUser();
			Flight::set('user',$user);
			if ( strtotime($user->win_last) < time()-60*60*12 ) {
				$user->fibo = 0;
				$user->save();
			}
		}
		Flight::render('score_get',null,'layout');
	}

	public function post() {
		if ( auth::isLoggedIn() ) {
			$data = Flight::request()->data;
			$user = auth::getUser();
			require_once('captcha/captcha.php');
			Flight::set('user',$user);
			if ( isset($data['reload-captcha_x']) ) {
				Flight::render('score_get',null,'layout');
			} else if ( check() ) {
				if ( $user->fibo <= 7 ) {
					$user->score += fibonacci($user->fibo);
					$user->fibo++;
					$user->win_last = date('Y-m-d H:i:s');
					$user->save();
				}
				Flight::render('score_get',null,'layout');
			} else {
				if ( $user->fibo <= 7 ) {
					$user->score -= fibonacci($user->fibo);
					$user->fibo++;
					$user->save();
				}
				Flight::set('error','Y U NO CLICK MEME!');
				Flight::render('score_get',null,'layout');
			}
		}
	}

	public function promote() {
		if ( auth::isLoggedIn() ) {
			$data = Flight::request()->data;
			$user = auth::getUser();
			$node = model_node::getByUri($data['uri']);

			$data['promote'] = intval($data['promote']);

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
		}
		Flight::redirect('/');
	}

}
