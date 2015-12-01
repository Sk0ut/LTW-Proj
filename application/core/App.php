<?php

class App {
    /**
     * Controller of the App
     */
    private $controller = "login";

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
        $url = $this->parseUrl();

        if (isset($url[0])) {
            if (file_exists("../application/controllers/" . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once "../application/controllers/" . $this->controller . ".php";

        $this->controller = ucfirst($this->controller);
        $this->controller = new $this->controller();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], [$this->params]);
    }

    /**
     * Parse the URL from the user
     * @return array with parsed URL
     */
    public function parseUrl() {
        if (isset($_GET["url"])) {
            return $url = explode('/',filter_var(rtrim($_GET["url"], '/'), FILTER_SANITIZE_URL));
        }
    }
}
