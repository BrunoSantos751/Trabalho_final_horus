<?php
require_once './model/Login.php';
require_once './Controllers/ApplicationController.php';

class LoginController extends ApplicationController {

    public function __construct()
    {
        $this->html = file_get_contents('Layout/html/login/login.html');   
    }

    public function login($request){
        $login = new Login($request);
        if ($login->login()) {
            header("Location: index.php?class=ListController");
            exit;
        } else {
            echo "Falha no login. Verifique suas credenciais.";
        }
    }

    public function logout() {
        $login = new Login([]);
        $login->logout();
        
        ApplicationController::return_home();
    }

    public function show() {
        if (Login::isLoggedIn()) {
            header("Location: index.php?class=ListController");
            exit;
        }
        echo $this->html;
    }
}