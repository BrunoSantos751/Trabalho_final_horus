<?php
require_once './Controllers/ApplicationController.php';

class ContatosForm extends ApplicationController {
    public function __construct()
    {
        $this->setHtml('Layout/html/contatos/cadastro.html');
    }

    public function show() {
        echo $this->html;
    }
}