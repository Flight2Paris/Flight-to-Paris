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
define ( 'APP_PATH', realpath ( dirname ( __FILE__ ) . '/app/' ) );
define ( 'FLIGHT_PATH', realpath ( dirname ( __FILE__ ) . '/flight/' ) );
define ( 'PARIS_PATH', realpath ( dirname ( __FILE__ ) . '/paris/' ) );
define ( 'MARKDOWN_PATH', realpath ( dirname ( __FILE__ ) . '/php-markdown/' ) );
define ( 'DOMAIN', 'node.esfriki.com' );

require FLIGHT_PATH.'/Flight.php';
require PARIS_PATH.'/paris.php';
require MARKDOWN_PATH.'/markdown.php';

ORM::configure('mysql:host=localhost;dbname=node');
ORM::configure('username', 'root');
ORM::configure('password', '');

Flight::set('flight.lib.path', APP_PATH);
Flight::set('flight.views.path', APP_PATH.'/view');

Flight::route('GET /',array('controller_layout','home'));

Flight::route('POST /new/?$',array('controller_node','create'));
Flight::route('GET /@id:[a-z0-9_-]+/?$',array('controller_node','get'));

Flight::route('GET /u/new/?$',array('controller_user','new_user'));
Flight::route('POST /u/new/?$',array('controller_user','create'));
Flight::route('GET /u/@username:[a-z0-9_.-]+/?$',array('controller_user','get'));

Flight::route('POST /auth/login/?$',array('controller_auth','login'));

Flight::start();
