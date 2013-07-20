<?php

require( 'node.php' );

class controller_file {

	public function new_file() {
		Flight::render('file_new', null, 'layout');
	}

	public function upload() {
		if ( ! isset( $_FILES['userfile'] ) ) {
			Flight::flash('message',array('type'=>'error','text'=>'Falló upload.'));
		} elseif ( $_FILES['userfile']['size'] > MAX_UPLOAD_SIZE ) {
			Flight::flash('message',array('type'=>'error','text'=>'Archivo demasiado grande.'));

		} elseif ( $_FILES['userfile']['size'] > ( auth::getUser()->score * 1024 * KB_PER_POINT ) ) {
			Flight::flash('message',array('type'=>'error','text'=>'Necesitas más puntos.'));

		} elseif ( is_uploaded_file( $_FILES['userfile']['tmp_name'] ) && is_writable(UPLOAD_PATH) ) {
			$filename = $_FILES['userfile']['name'];
			$filename = self::sanitizeFilename($filename);
			$filename = self::getFreeFilename($filename);

			if ( move_uploaded_file( $_FILES['userfile']['tmp_name'], UPLOAD_PATH.'/'.$filename ) ) {

				$user = auth::getUser();
				$user->score -= ($_FILES['userfile']['size'] / (1024 * KB_PER_POINT));
				$user->save();

				Flight::flash('message',array('type'=>'success','text'=>'Archivo subido en '.View::makeUri('/f/'.urlencode($filename)).'.'));
				Flight::flash('post',"# \n ". View::makeUri('/f/'.urlencode($filename)) );
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

	public static function sanitizeFilename( $filename ) {
		return preg_replace('/\s+/','_',$filename);
	}
}
