<?php
require_once __DIR__ . './../model/Usuarios.php';
require_once __DIR__ . '/ApplicationController.php';

class UsuarioForm extends ApplicationController {
    
    private array|string|null $data;

    public function __construct()
    {
        $this->setHtml('Layout/html/usuarios/cadastro.html');
        $this->data = [
            'email' => null,
            'senha' => null,
            'id' => null
        ];
    }

    public function cadastro($request) {
        $usuario = new Usuarios($request);
        var_dump($usuario);
        $usuario->save();
    }

    public function edit($param) {
        try {
            $id = (int) $param['id'];
            $usuario = Usuarios::find($id);
            $this->data = $usuario;
        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show() {
        $this->html = str_replace('{id}', $this->data['id'] ?? '', $this->html);
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{senha}', $this->data['senha'], $this->html);
        print $this->html;
    }
}