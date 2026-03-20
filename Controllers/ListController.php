<?php
require_once './Controllers/ApplicationController.php';
class ListController extends ApplicationController
{

    function __construct()
    {
        $this->setHtml('Layout/html/list/index_admin.html');
    }

    public function show()
    {
        echo $this->html;
    }
}