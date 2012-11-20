<?php

class controller_cron {
	public function cron() {

		$users = model_user::getAllAuthorsFromLastMonth();

		foreach ( $users as $user ) {
			$user->score += sqrt($user->getMonthlyScore())/30;
			$user->save();
		}
	}
}
