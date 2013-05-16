<?php /*

          .___.    .   ,    ,      .__           
          [__ |* _ |_ -+-  -+- _   [__) _.._.* __
          |   ||(_][ ) |    | (_)  |   (_][  |_) 
                ._|                              

          Flight - Mike Cao // http://flightphp.com MIT
    Paris&Idiorm - Jamie Matthews // http://j4mie.github.com/idiormandparis BSD
	PHP Markdown - Michel Fortin // http://github.com/wolfie/php-markdown 
 Flight to Paris - Aza // http://esfriki.com GPLv3

*/

if ( PHP_SAPI != 'cli' ) {
	echo 'esfriki, ahora a prueba de exos!';
	exit;
}
define ( 'APP_PATH', realpath ( dirname ( __FILE__ ) . '/app' ) );
define ( 'LIB_PATH', realpath ( dirname ( __FILE__ ) . '/lib' ) );

define ( 'FLIGHT_PATH', LIB_PATH . '/flight' );
define ( 'PARIS_PATH', LIB_PATH . '/paris' );
define ( 'MARKDOWN_PATH', LIB_PATH. '/php-markdown' );
define ( 'PLAYA_PATH', LIB_PATH . '/playa' );

require FLIGHT_PATH.'/Flight.php';
require PARIS_PATH.'/paris.php';
require MARKDOWN_PATH.'/markdown.php';
require PLAYA_PATH.'/playa.php';

set_include_path(get_include_path() . PATH_SEPARATOR . FLIGHT_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH . '/model');

Flight::set('flight.lib.path', APP_PATH);
Flight::set('flight.views.path', APP_PATH.'/view');


/****  CONFIGURE YOUR DOMAIN AND DB HERE  ****/ 
define ( 'DOMAIN', 'esfriki.com' );

ORM::configure('mysql:host=db.esfriki.com;dbname=flight2paris');
ORM::configure('username', 'esfriki');
ORM::configure('password', 'esFRIkipaNOTAGAIN');

/****  AND DOWN THE RABBIT HOLE  ****/

Flight::route('.*',array('controller_cron','cron'));

Flight::start();
