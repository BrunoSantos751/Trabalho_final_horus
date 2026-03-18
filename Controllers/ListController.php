<?php
require_once './Controllers/ApplicationController.php';
class ListController extends ApplicationController {

    function __construct() {
        $this->setHtml('Layout/html/list/index.html');
    }

    public function show() {
        ApplicationController::return_home();
        echo $this->html;
    }
}