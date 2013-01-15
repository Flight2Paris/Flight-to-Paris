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

define ( 'APP_PATH', realpath ( dirname ( __FILE__ ) . '/app/' ) );
define ( 'FLIGHT_PATH', realpath ( dirname ( __FILE__ ) . '/flight/' ) );
define ( 'PARIS_PATH', realpath ( dirname ( __FILE__ ) . '/paris/' ) );
define ( 'MARKDOWN_PATH', realpath ( dirname ( __FILE__ ) . '/php-markdown/' ) );
define ( 'PLAYA_PATH', realpath ( dirname ( __FILE__ ) . '/playa/' ) );
define ( 'DOMAIN', 'esfriki.com' );

require FLIGHT_PATH.'/Flight.php';
require PARIS_PATH.'/paris.php';
require MARKDOWN_PATH.'/markdown.php';

set_include_path(get_include_path() . PATH_SEPARATOR . FLIGHT_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH . '/model/');


ORM::configure('mysql:host=db.esfriki.com;dbname=flight2paris');
ORM::configure('username', 'esfriki');
ORM::configure('password', 'esFRIkipaSS1234');


Flight::set('flight.lib.path', APP_PATH);

Flight::route('.*',array('controller_cron','cron'));

Flight::start();
