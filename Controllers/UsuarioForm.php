<?php
require_once  './model/Usuarios.php';
require_once './Controllers/ApplicationController.php';

class UsuarioForm extends ApplicationController {

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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            die("<script>alert('Acesso negado.'); window.location.href='index.php?class=UsuarioList';</script>");
        }
        $usuario = new Usuarios($request);
        try {
            $usuario->save();
            $_SESSION['sucesso'] = "Usuário salvo com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar usuário: " . $e->getMessage();
        }
        header("Location: index.php?class=UsuarioList");
        exit;
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            die("<script>alert('Acesso negado. Apenas o administrador pode acessar o formulário de usuários.'); window.location.href='index.php?class=UsuarioList';</script>");
        }

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