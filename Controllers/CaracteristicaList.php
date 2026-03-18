<?php
require_once './model/Caracteristicas.php';
require_once './Controllers/ApplicationController.php';

class CaracteristicaList extends ApplicationController {
    
    public function __construct() {
        $this->setHtml('Layout/html/caracteristicas/list_caracteristicas.html');

    }

    public function delete($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            Caracteristicas::delete($id);
            header("Location: index.php?class=CaracteristicaList");
            exit;
        }
    }

    public function load() {
        try {
            $caracteristicas = Caracteristicas::all();
            $items = '';
        foreach ($caracteristicas as $caracteristica) {
            $item = file_get_contents('Layout/html/caracteristicas/item.html');
            $item = str_replace('{id}', $caracteristica['id'], $item);
            $item = str_replace('{titulo}', $caracteristica['titulo'], $item);
            $item = str_replace('{descricao}', $caracteristica['descricao'], $item);
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