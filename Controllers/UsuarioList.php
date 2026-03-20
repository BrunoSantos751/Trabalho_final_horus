<?php
require_once './model/Usuarios.php';
require_once './Controllers/ApplicationController.php';

class UsuarioList extends ApplicationController {
    
    public function __construct() {
        $this->setHtml('Layout/html/usuarios/list_usuarios.html');
    }

    public function delete($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            $result = Usuarios::delete($id);
            header("Location: index.php?class=UsuarioList");
            exit;
        }
    }
    public function edit($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            header("Location: index.php?class=UsuarioForm&method=edit&id=$id");
            exit;
        }
    }

    public function load() {
        try {
            $usuarios = Usuarios::all();
            $items = '';
            
            $isAdmin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1;

        foreach ($usuarios as $usuario) {
            $item = file_get_contents('Layout/html/usuarios/item.html');
            
            if ($isAdmin) {
                $botao_editar = "<td align='center'><a href='index.php?class=UsuarioForm&method=edit&id={$usuario['id']}'><img src='images/admin/editar.png' style='width:24px'></a></td>";
                $botao_remover = "<td align='center'><a href='index.php?class=UsuarioList&method=delete&id={$usuario['id']}'><img src='images/admin/excluir.png' style='width:24px'></a></td>";
            } else {
                $botao_editar = "";
                $botao_remover = "";
            }

            $item = str_replace('{botao_editar}', $botao_editar, $item);
            $item = str_replace('{botao_remover}', $botao_remover, $item);
            $item = str_replace('{id}', $usuario['id'], $item);
            $item = str_replace('{email}', $usuario['email'], $item);
            $item = str_replace('{criado_em}', $usuario['created_at'], $item);
            $items.= $item;
        }
        $this->html = str_replace('{items}', $items, $this->html);
        
        $th_editar = $isAdmin ? "<th> editar </th>" : "";
        $th_remover = $isAdmin ? "<th> remover </th>" : "";
        $this->html = str_replace('{th_editar}', $th_editar, $this->html);
        $this->html = str_replace('{th_remover}', $th_remover, $this->html);
        
        $botoes_inserir = "";
        if ($isAdmin) {
            $botoes_inserir = "<button onclick=\"window.location='index.php?class=UsuarioForm'\"><img src='images/admin/sinal-de-mais.png' style='width:24px; vertical-align: middle;'> Inserir</button>";
        }
        $this->html = str_replace('{botoes_inserir}', $botoes_inserir, $this->html);

        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }
    public function show() {
        $this->load();
        print $this->html;
    }
}