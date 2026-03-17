<?php
require_once __DIR__ . './../model/Login.php';

abstract class ApplicationController {

    public static function return_home() {
        if (!Login::isLoggedIn()) {
            header("Location: /login");
            exit();
        }
    }
}