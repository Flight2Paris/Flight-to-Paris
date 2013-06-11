<?php

class controller_file {

	public function new_file() {
		Flight::render('file_new', null, 'layout');
	}

	public function upload() {

		if ( $_FILES['userfile']['size'] > MAX_UPLOAD_SIZE ) {
			Flight::flash('message',array('type'=>'error','text'=>'Archivo demasiado grande.'));

		} else if ( $_FILES['userfile']['size'] > ( auth::getUser()->score * 1024 * KB_PER_POINT ) ) {
			Flight::flash('message',array('type'=>'error','text'=>'Necesitas más puntos.'));

		} else if ( is_uploaded_file( $_FILES['userfile']['tmp_name'] ) && is_writable(UPLOAD_PATH) ) {
			$filename = self::getFreeFilename($_FILES['userfile']['name']);
			if ( move_uploaded_file( $_FILES['userfile']['tmp_name'], UPLOAD_PATH.'/'.$filename ) ) {

				$user = auth::getUser();
				$user->score -= ($_FILES['userfile']['size'] / (1024 * KB_PER_POINT));
				$user->save();

				Flight::flash('message',array('type'=>'success','text'=>'Archivo subido en '.View::makeUri('/f/'.$filename).'.'));
			} else {
				Flight::flash('message',array('type'=>'error','text'=>'EEERRRRRR!!!!!.'));
			}
		} else {
			Flight::flash('message',array('type'=>'error','text'=>'Permission errr!!!'));
		}
		Flight::render('file_new', null, 'layout');
	}

	public static function getFreeFilename( $name ) {
		$name = trim(basename( $name ));
		if ( file_exists( realpath( UPLOAD_PATH .'/'. $name ) ) ) {
			$i = 0;
			while ( file_exists( realpath( UPLOAD_PATH .'/'. e::encode($i).'-'.$name ) ) ) {
				$i++;
			}
			$name = e::encode($i).'-'.$name;
		}
		return $name;
	}
}
