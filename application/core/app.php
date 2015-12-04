<?php

/**
 * Application class
 */
class App {
    /**
     * Controller of the App
     */
    private $controller = "loginCtrl";

    /**
     * Method to call on the controller
     */
    private $method = "index";

    /**
     * Parameters to sent to the function
     */
    private $params = [];

    /**
     * Constructor of App
     */
    public function __construct() {
		$this->loadController();
        require_once "../application/controllers/" . $this->controller . ".php";
        $this->controller = ucfirst($this->controller);
        $this->controller = new $this->controller();
		$this->controller->{$this->method}();
    }
	
	/**
	 * Load error controller on unknown url
	 */
	private function loadErrorController() {
        $this->controller = "errorCtrl";
        $this->method = "index";
	}
	
	/**
	 * Parse url and set the according controller
	 */
	private function loadController() {
		$url = $this->parseUrl();
		if (count($url) > 2) {
			$this->loadErrorController();
			return;
        }
		
	    if (isset($url[0])) {
            $controller = $url[0] . "Ctrl";
            unset($url[0]);
            if (file_exists("../application/controllers/" . $controller . ".php")) {
                $this->controller = $controller;
            } else {
                $this->loadErrorController();
				return;
            }
        }

		require_once "../application/controllers/" . $this->controller . ".php";
		$controller = ucFirst($this->controller);
		$controller = new $controller();
		
		if (isset($url[1])) {
			$method = $url[1];
			unset($url[1]);
			if (is_callable([$controller, $method])) {
				$this->method = $method;
			} else {
				$this->loadErrorController();
			}
		}
	}

    /**
     * Parse the URL from the user
     * @return array with parsed URL
     */
    private function parseUrl() {
        if (isset($_GET["url"])) {
            return $url = explode('/',filter_var(rtrim($_GET["url"], '/'), FILTER_SANITIZE_URL));
        }
		return [];
    }
}
