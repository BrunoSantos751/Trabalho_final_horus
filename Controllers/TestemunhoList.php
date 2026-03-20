<?php
require_once './model/Testemunhos.php';
require_once './Controllers/ApplicationController.php';

class TestemunhoList extends ApplicationController {
    
    public function __construct() {
        $this->setHtml('Layout/html/testemunhos/list_testemunhos.html');

    }

    public function delete($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            try {
                Testemunhos::delete($id);
                $_SESSION['sucesso'] = "Testemunho removido com sucesso!";
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro ao remover testemunho: " . $e->getMessage();
            }
            header("Location: index.php?class=TestemunhoList");
            exit;
        }
    }

    public function load() {
        try {
            $testemunhos = Testemunhos::all();
            $items = '';
        foreach ($testemunhos as $testemunho) {
            $item = file_get_contents('Layout/html/testemunhos/item.html');
            $item = str_replace('{id}', $testemunho['id'], $item);
            $item = str_replace('{nome}', $testemunho['nome'], $item);
            $item = str_replace('{funcao}', $testemunho['funcao'], $item);
            $item = str_replace('{titulo}', $testemunho['titulo'], $item);
            $item = str_replace('{descricao}', $testemunho['descricao'], $item);
            $item = str_replace('{foto}', $testemunho['foto'], $item);
            $item = str_replace('{imagem_fundo}', $testemunho['imagem_fundo'], $item);
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