<?php
require_once './Controllers/ApplicationController.php';

class GuiaController extends ApplicationController
{
    function __construct()
    {
        $this->setHtml('Layout/html/guia/guia.html');
    }

    public function show()
    {
        echo $this->html;
    }
}
