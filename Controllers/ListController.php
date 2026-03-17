<?php
require_once __DIR__ . '/ApplicationController.php';
class ListController extends ApplicationController {
    private $html;
    public function __construct()
    {
        $this->html = file_get_contents('Layout/html/lists/index.html');   
    }

    public function list_usarios() {
    }

    public function show() {
        ApplicationController::return_home();
        $this->html = str_replace("{{header}}", file_get_contents('Layout/html/application/header.html'), $this->html);
        echo $this->html;
    }
}