<?php
/**
 * Flight: An extensible micro-framework.
 *
 * @copyright   Copyright (c) 2011, Mike Cao <mike@mikecao.com>
 * @license     http://www.opensource.org/licenses/mit-license.php
 */
class Router {
    /**
     * Mapped routes.
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Maps a URL pattern to a callback function.
     *
     * @param string $pattern URL pattern to match
     * @param callback $callback Callback function
     */
    public function map($pattern, $callback) {
        list($method, $url) = explode(' ', trim($pattern), 2);

        if (!is_null($url)) {
            foreach (explode('|', $method) as $value) {
                $this->routes[$value][$url] = $callback;
            }
        }
        else {
            $this->routes['*'][$pattern] = $callback;
        }
    }

    /**
     * Tries to match a requst to a route. Also parses named parameters in the url.
     *
     * @param string $pattern URL pattern
     * @param string $url Request URL
     * @param array $params Named URL parameters
     */
    public function match($pattern, $url, array &$params = array()) {
        $ids = array();

        // Build the regex for matching
        $regex = '/^'.implode('\/', array_map(
            function($str) use (&$ids){
                if ($str == '*') {
                    $str = '(.*)';
                }
                else if ($str{0} == '@') {
                    if (preg_match('/@(\w+)(\:([^\/]*))?/i', $str, $matches)) {
                        $ids[$matches[1]] = true;
                        return '(?P<'.$matches[1].'>'.(isset($matches[3]) ? $matches[3] : '[^(\/|\?)]+').')';
                    }
                }
                return $str; 
            },
            explode('/', $pattern)
        )).'\/?(?:\?.*)?$/i';

        // Attempt to match route and named parameters
        if (preg_match($regex, $url, $matches)) {
            if (!empty($ids)) {
                $params = array_intersect_key($matches, $ids);
            }
            return true;
        }

        return false;
    }

    /**
     * Routes the current request.
     *
     * @param object $request Request object
     */
    public function route(&$request) {
        $params = array();
        $routes = ($this->routes[$request->method] ?: array()) + ($this->routes['*'] ?: array());

        foreach ($routes as $pattern => $callback) {
            if ($pattern === '*' || $request->url === $pattern || self::match($pattern, $request->url, $params)) {
                $request->matched = $pattern;
                return array($callback, $params);
            }
        }

        return false;
    }

    /**
     * Gets mapped routes.
     *
     * @return array Array of routes
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Resets the router.
     */
    public function clear() {
        $this->routes = array();
    }


	public static function getExtensionFromUri($uri) {
		return pathinfo(parse_url($uri,PHP_URL_PATH),PATHINFO_EXTENSION);
	}

	public static function isExtensionAllowed($ext) {
		global $allowed_formats;
		return in_array($ext,$allowed_formats);
	}

	public static function getFilenameFromUri($uri) {
		return pathinfo(parse_url($uri,PHP_URL_PATH),PATHINFO_FILENAME);
	}

	public static function getFormat($uri)  {
		$ext = self::getExtensionFromUri($uri);

		if ( self::isExtensionAllowed($ext) ) {
			return $ext;
		}
		else return null;
	}

	public static function removeFormat($uri) {
		$ext = self::getExtensionFromUri($uri);

		if ( self::isExtensionAllowed($ext) ) {
			return self::getFilenameFromUri($uri);
		}
		else return $uri;
	}
}
?>
