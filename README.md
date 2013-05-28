
          .___.    .   ,    ,      .__           
          [__ |* _ |_ -+-  -+- _   [__) _.._.* __
          |   ||(_][ ) |    | (_)  |   (_][  |_) 
                ._|                              

    Flight - Mike Cao // http://flightphp.com MIT
    Paris&Idiorm - Jamie Matthews // http://j4mie.github.com/idiormandparis BSD
    PHP Markdown - Michel Fortin // http://github.com/wolfie/php-markdown 
    Flight to Paris - Aza // http://esfriki.com GPLv3
    Playa - Aza // http://playa.esfriki.com GPLv3
    Chuck Not Captcha - Aza // http://cnc.esfriki.com GPLv3

# Installation

## Dependencies

* PHP >=5.3
* gd2 (for the captcha)
* bcmath
* pdo_mysql (MySQL driver for PDO)

## Optional dependencies

* phpredis (for redis cache)
* memcache (for memcache cache)


## Geting source 

Get the source of master branch.

```
$ git clone https://github.com/rata0071/Flight-to-Paris.git
```

## Install GIT dependencies

```
$ git submodule init
$ git submodule update
```

## Copy configuration skel file

```
$ cp config.php.dist config.php
```

## Install Data Schema

In MySQL, create schema:

```
mysql> create schema f2p;
```

Load schema structure dump

```
$ mysql -uroot -p  < flight2paris.sql
```

## Test it!

You can test it with build-in PHP http server (you need define 'DOMAIN' with the port, example: _'localhost:8000'_)

```
$ php -S localhost:8000
```
