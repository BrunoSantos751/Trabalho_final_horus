<?php
class LoginForm {
    private $html;
    public function __construct()
    {

        $this->html = file_get_contents('Layout/html/login/login.html');
        
    }




    public function show() {
        echo $this->html;
    }
}