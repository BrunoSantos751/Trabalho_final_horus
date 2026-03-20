<?php
require_once './model/Contatos.php';
require_once './Controllers/ApplicationController.php';

class ContatoList extends ApplicationController {
    
    public function __construct() {
        $this->setHtml('Layout/html/contatos/list_contatos.html');

    }

    public function delete($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            try {
                Contatos::delete($id);
                $_SESSION['sucesso'] = "Contato removido com sucesso!";
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro ao remover contato: " . $e->getMessage();
            }
            header("Location: index.php?class=ContatoList");
            exit;
        }
    }

    public function load() {
        try {
            $contatos = Contatos::all();
            $items = '';
        foreach ($contatos as $contato) {
            $item = file_get_contents('Layout/html/contatos/item.html');
            $item = str_replace('{id}', $contato['id'], $item);
            $item = str_replace('{nome}', $contato['nome'], $item);
            $item = str_replace('{email}', $contato['email'], $item);
            $item = str_replace('{telefone}', $contato['telefone'], $item);
            $item = str_replace('{mensagem}', $contato['mensagem'], $item);
            $item = str_replace('{criado_em}', $contato['created_at'], $item);
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