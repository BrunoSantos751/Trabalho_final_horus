<?php
require_once __DIR__ . '/../model/Login.php';
require_once __DIR__ . '/ApplicationController.php';

class LoginController extends ApplicationController {

    protected $html;

    public function __construct()
    {
        $this->setHtml('Layout/html/login/login.html');
    }

    public function login($request){
        $login = new Login($request);
        
        if ($login->login()) {
            header("Location: index.php?class=ListController");
            exit;
        } else {
            $_SESSION['erro'] = "Email ou senha incorretos. Tente novamente.";
            header("Location: index.php?class=LoginController");
            exit;
        }
    }

    public function logout() {
        $login = new Login([]);
        $login->logout();
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