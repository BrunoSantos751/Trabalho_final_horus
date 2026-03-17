<?php
require_once  './model/Usuarios.php';
require_once './Controllers/ApplicationController.php';

class UsuarioForm extends ApplicationController {

    public function __construct()
    {
        $this->setHtml('Layout/html/usuarios/cadastro.html');
        $this->data = [
            'email' => null,
            'senha' => null
        ];
    }

    public function cadastro($request) {
        $usuario = new Usuarios($request);
        $usuario->save();
    }

    public function show() {
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{senha}', $this->data['senha'], $this->html);
        print $this->html;
    }
}