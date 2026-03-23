<?php
require_once './model/Login.php';
require_once './Controllers/ApplicationController.php';

class LoginController extends ApplicationController {

    protected $html;

    public function __construct()
    {
        $this->setHtml('Layout/html/login/login.html');
    }

    public function login($request){
        
        if (Login::login($request)) {
            if ($_SESSION['first_login'] ?? false) {
                header("Location: index.php?class=GuiaController");
            } else {
                header("Location: index.php?class=ListController");
            }
            exit;
        } else {
            $_SESSION['erro'] = "Email ou senha incorretos. Tente novamente.";
            header("Location: index.php?class=LoginController");
            exit;
        }
    }

    public function logout() {
        Login::logout();
        header('location: /index.php?class=LoginController');
        exit;
    }

    public function show() {
        if (Login::isLoggedIn()) {
            header("Location: index.php?class=ListController");
            exit;
        }
        $this->processMessages();
        echo $this->html;
    }
}