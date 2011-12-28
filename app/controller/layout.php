<?php

class controller_layout {

	public function home( ) {	
		Flight::render('home_get', null, 'layout');
	}
}
