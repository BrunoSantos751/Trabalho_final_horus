<?php
require_once __DIR__ . './../model/Login.php';
class LoginForm {
    private $html;
    public function __construct()
    {
        $this->html = file_get_contents('Layout/html/usuarios/cadastro.html');   
    }

    function login($request){
        $login = new Login($request);
        $login->login();
    }

    public function show() {
        echo $this->html;
    }
}