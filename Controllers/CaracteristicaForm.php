<?php
require_once './model/Caracteristiscas.php';
require_once './Controllers/ApplicationController.php';

class CaracteristicaForm extends ApplicationController {

    public function __construct()
    {
        $this->html = file_get_contents('Layout/html/caracteristicas/cadastro.html');
    }

    function cadastro($request) {
        $this->data = [
            'id' => $request['id'] ?? null,
            'titulo' => $request['titulo'] ?? null, 
            'descricao' => $request['descricao'] ?? null
            ];
        Caracteristicas::save($this->data);
        header("Location: index.php?class=CaracteristicaList");
        exit;
    }

    public function edit() {
         $id = $_GET['id'] ?? null;
         if ($id) {
             $caracteristica = Caracteristicas::find($id);
             if ($caracteristica) {
                 $this->data = $caracteristica;
             } else {
                 header("Location: index.php?class=CaracteristicaList");
                 exit;
             }
         } else {
             header("Location: index.php?class=CaracteristicaList");
             exit;
         }
    }

    public function show() {
        $this->html = str_replace('{id}', $this->data['id'] ?? '', $this->html);
        $this->html = str_replace('{titulo}', $this->data['titulo'] ?? '', $this->html);
        $this->html = str_replace('{descricao}', $this->data['descricao'] ?? '', $this->html);
        echo $this->html;
    }
}