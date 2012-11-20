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
define ( 'PLAYA_PATH', realpath ( dirname ( __FILE__ ) . '/playa/' ) );
define ( 'DOMAIN', 'esfriki.com' );

require FLIGHT_PATH.'/Flight.php';
require PARIS_PATH.'/paris.php';
require MARKDOWN_PATH.'/markdown.php';
require PLAYA_PATH.'/playa.php';

set_include_path(get_include_path() . PATH_SEPARATOR . FLIGHT_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH . '/model/');


ORM::configure('mysql:host=db.esfriki.com;dbname=flight2paris');
ORM::configure('username', 'root');
ORM::configure('password', '');

require APP_PATH.'/model/auth.php';
$auth = new auth;

Flight::set('flight.lib.path', APP_PATH);
Flight::set('flight.views.path', APP_PATH.'/view');

Flight::route('GET /',array('controller_layout','home'));

Flight::route('POST /?$',array('controller_node','create'));
Flight::route('GET /new/?$',array('controller_node','node_new'));
Flight::route('GET /search/?',array('controller_node','search'));

Flight::route('GET /score/?',array('controller_score','get'));
Flight::route('POST /score/?',array('controller_score','post'));
Flight::route('POST /promote/?',array('controller_score','promote'));


Flight::route('GET /u/new/?$',array('controller_user','new_user'));
Flight::route('POST /u/new/?$',array('controller_user','create'));
Flight::route('GET /u/follow/@url$',array('controller_user','follow'));
Flight::route('GET /u/@username/?$',array('controller_user','get'));
Flight::route('GET /u/@username/pubkey/?$',array('controller_user','pubkey'));

Flight::route('POST /auth/login/?$',array('controller_auth','login'));
Flight::route('GET /auth/logout/?$',array('controller_auth','logout'));
Flight::route('GET /auth/changepassword/?$',array('controller_auth','change'));
Flight::route('POST /auth/changepassword/?$',array('controller_auth','dochange'));
Flight::route('GET /auth/pubkey/?.*$',array('controller_auth','pubkey'));
Flight::route('POST /auth/addkey/?$',array('controller_auth','addkey'));

Flight::route('GET /@id:[a-z0-9_-]+(\.(json|rss))?/?$',array('controller_node','get'));

Flight::start();
