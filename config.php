<?php

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


define ( 'DOMAIN', 'aza.com' );

ORM::configure('mysql:host=localhost;dbname=esfriki');
ORM::configure('username', 'root');
ORM::configure('password', '');


/****  AND DOWN THE RABBIT HOLE  ****/



define ( 'PAGESIZE', 30 );



## LINK TYPES DON'T CHANGE IF YOU WANT TO SINC RELATIONS ##

define ( 'REPLY_URI', 'http://esfriki.com/reply');
define ( 'AUTHOR_URI', 'dc:creator' );

$allowed_formats = array('html','rss','json','rdf','md');
