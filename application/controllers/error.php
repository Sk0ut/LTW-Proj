<?php
require_once __DIR__ . "/../core/Controller.php";

class Error extends Controller {
    public function index() {
        $this->view("error_view");
    }
}

?>
