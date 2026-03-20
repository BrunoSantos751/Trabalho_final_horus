<?php
require_once './model/Login.php';

abstract class ApplicationController {
    protected $html;
    protected array|string|null $data = [];


    protected function setHtml($html){
        $this->html = file_get_contents($html);   
        $header = file_get_contents('Layout/html/application/header.html');
        
        $mensagem = '';
        if (isset($_SESSION['sucesso'])) {
            $mensagem .= "<div style='background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center; font-weight: bold;'>" . $_SESSION['sucesso'] . "</div>";
            unset($_SESSION['sucesso']);
        }
        if (isset($_SESSION['erro'])) {
            $mensagem .= "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px; text-align: center; font-weight: bold;'>" . $_SESSION['erro'] . "</div>";
            unset($_SESSION['erro']);
        }

        $header = str_replace('{{mensagem}}', $mensagem, $header);
        $this->html = str_replace("{{header}}", $header, $this->html);
    }

    abstract function show();
}