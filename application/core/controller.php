<?php

/**
 * Controller class
 */
class Controller {

    /**
     * Include a model in the controller
     */
    public function model($model, $args = []) {
        if (file_exists(__DIR__ . "/../models/" . $model . ".php"))
            require_once __DIR__ . "/../models/" . $model . ".php";

        return (new ReflectionClass($model))->newInstanceArgs($args);
    }

    /**
     * Include a view in the controller
     */
    public function view($view, $data = []) {
        if (file_exists(__DIR__ . "/../views/" . $view . ".php"))
            require_once __DIR__ . "/../views/" . $view . ".php";
    }
}
