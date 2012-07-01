<?php
/**
 * Flight: An extensible micro-framework.
 *
 * @copyright   Copyright (c) 2011, Mike Cao <mike@mikecao.com>
 * @license     http://www.opensource.org/licenses/mit-license.php
 */
class View {
    public $path;
    public $template;
    public $data = array();
	public static $mk = false;

    /**
     * Constructor.
     *
     * @param string $path Path to templates directory
     */
    public function __construct($path = null) {
        $this->path = $path ?: (Flight::get('flight.views.path') ?: './views');
    }

    /**
     * Gets a template variable.
     *
     * @param string $key Key
     * @return mixed
     */
    public function get($key) {
        return $this->data[$key];
    }

    /**
     * Sets a template variable.
     *
     * @param mixed $key Key
     * @param string $value Value
     */
    public function set($key, $value = null) {
        // If key is an array, save each key value pair
        if (is_array($key) || is_object($key)) {
            foreach ($key as $k => $v) {
                $this->data[$k] = $v;
            }
        }
        else if (is_string($key)) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Unsets a template variable. If no key is passed in, clear all variables.
     *
     * @param string $key Key
     */
    public function clear($key = null) {
        if (is_null($key)) {
            $this->data = array();
        }
        else {
            unset($this->data[$key]);
        }
    }

    /**
     * Renders a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     */
    public function render($file, $data = null) {
        $this->template = $file.'.php';

        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        }

        extract($this->data);

        $file = $this->path.'/'.$this->template;

        if (!file_exists($file)) {
            throw new Exception("Template file not found: $file.");
        }
        include $file;
    }

	public static function markdown($text, $full = true) {
		if ( ! self::$mk ) self::$mk = new Markdown_Parser;
		$text = self::$mk->transform(trim($text));
		$text = playa::transform($text,$full);
		return $text;
	}

    /**
     * Gets the output of a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     */
    public function fetch($file, $data = null) {
        ob_start();

        $this->render($file, $data);
        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    /**
     * Displays escaped output.
     *
     * @param string $str String to escape
     * @return string Escaped string
     */
    public function e($str) {
        echo htmlentities($str, ENT_QUOTES, "UTF-8");
    }

    /**
     * Checks if a template file exists.
     *
     * @param string $file Template file
     * @return bool Template file exists
     */
    public function exists($file) {
        return file_exists($this->path.'/'.((substr($file, -4) == '.php') ? $file : $file.'.php'));
    }

    /**
     * Loads and executes view helper functions.
     *
     * @param string $name Function name
     * @param array $params Function parameters
     */
    public function __call($name, $params) {
        return Flight::invokeMethod(array('Flight', $name), $params);
    }

    /**
     * Loads view helper classes.
     *
     * @param string $name Class name
     * @return object Class instance
     */
    public function __get($name) {
        return Flight::load($name);
    }

	public function makeUri($uri) {
		if ( strpos($uri, '/') === 0 ) {
			return 'http://'.DOMAIN.$uri;
		} else {
			return 'http://'.DOMAIN.'/'.$uri;
		}
	}
}

