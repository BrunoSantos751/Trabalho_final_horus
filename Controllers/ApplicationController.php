<?php
require_once __DIR__ . './../model/Login.php';

abstract class ApplicationController {
    protected $html;

    public static function return_home() {
        if (!Login::isLoggedIn()) {
            header("Location: /login");
            exit();
        }
    }

    protected function setHtml($html){
        $this->html = file_get_contents($html);   
        $this->html = str_replace("{{header}}", file_get_contents('Layout/html/application/header.html'), $this->html);
    }

    abstract function show();
}