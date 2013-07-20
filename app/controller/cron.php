<?php

class controller_cron {
	public function cron() {

		$users = model_user::getAllAuthorsFromLastMonth();
		// Now points are delivered when promoted
	}
}
