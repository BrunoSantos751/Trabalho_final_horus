<?php
require_once './model/Login.php';

abstract class ApplicationController {
    protected $html;
    protected array|string|null $data = [];


    protected function setHtml($html){
        $this->html = file_get_contents($html);   
        $this->html = str_replace("{{header}}", file_get_contents('Layout/html/application/header.html'), $this->html);
    }

    abstract function show();
}