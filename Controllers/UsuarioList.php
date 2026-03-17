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
            Usuarios::delete($id);
            header("Location: index.php?class=UsuarioList");
            exit;
        }
    }

    public function load() {
        try {
            $usuarios = Usuarios::all();
            $items = '';
        foreach ($usuarios as $usuario) {
            $item = file_get_contents('Layout/html/usuarios/item.html');
            $item = str_replace('{id}', $usuario['id'], $item);
            $item = str_replace('{email}', $usuario['email'], $item);
            $item = str_replace('{criado_em}', $usuario['created_at'], $item);
            $items.= $item;
        }
        $this->html = str_replace('{items}', $items, $this->html);
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