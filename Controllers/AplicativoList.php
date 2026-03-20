<?php
require_once './model/Aplicativo.php';
require_once './Controllers/ApplicationController.php';

class AplicativoList extends ApplicationController {
    
    public function __construct() {
        $this->setHtml('Layout/html/aplicativos/list.html');
    }

    public function delete($request) {
        $id = $request['id'] ?? ($_GET['id'] ?? null);
        if ($id) {
            Aplicativo::delete($id);
            header("Location: index.php?class=AplicativoList");
            exit;
        }
    }

    public function load() {
        try {
            $aplicativos = Aplicativo::all();
            $items = '';
            foreach ($aplicativos as $app) {
                $item = file_get_contents('Layout/html/aplicativos/item.html');
                $item = str_replace('{id}', $app['id'], $item);
                $item = str_replace('{titulo}', $app['titulo'], $item);
                $item = str_replace('{descricao}', $app['descricao'], $item);
                $item = str_replace('{icon}', $app['icon'], $item);
                $items .= $item;
            }
            $this->html = str_replace('{items}', $items, $this->html);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show() {
        $this->load();
        print $this->html;
    }
}
