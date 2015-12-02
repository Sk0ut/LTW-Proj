<?php
require_once __DIR__ . "/../core/controller.php";

class ErrorCtrl extends Controller {
    public function index() {
        $this->view("error_view");
    }
}

?>
