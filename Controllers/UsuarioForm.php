<?php
require_once __DIR__ . '/../model/Usuarios.php';
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

        $isEdit = !empty($this->data['id']);

        $titulo = $isEdit ? 'Editar usuário' : 'Cadastro de usuário';
        $acao = $isEdit ? 'ATUALIZAR' : 'CADASTRAR';
        $hidden = $isEdit ? '' : 'hidden';
        $code_label = $isEdit ? 'Código :' : '';
        $senha = $isEdit ? 'SENHA ( Para não alterar deixe em branco ) : ' : 'SENHA :';

        $this->html = str_replace('{titulo}', $titulo, $this->html);
        $this->html = str_replace('{acao}', $acao, $this->html);
        $this->html = str_replace('{hidden_id}', $hidden, $this->html);
        $this->html = str_replace('{code_label}', $code_label, $this->html);
        $this->html = str_replace('{SENHA}', $senha, $this->html);


        $this->html = str_replace('{id}', $this->data['id'] ?? '', $this->html);
        $this->html = str_replace('{email}', $this->data['email'] ?? '', $this->html);
        $this->html = str_replace('{senha}', $this->data['senha'] ?? '', $this->html);

        print $this->html;
    }
}