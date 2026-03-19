<?php

require_once './model/Aplicativo.php';
require_once './Controllers/ApplicationController.php';

class AplicativoForm extends ApplicationController {

    public function __construct() {
        $this->setHtml('Layout/html/aplicativos/form.html');
        $this->data = [
            'id' => null,
            'titulo' => '',
            'descricao' => '',
            'icon' => 'mdi mdi-cellphone'
        ];
    }

    public function show() {
        $html = $this->html;

        $html = str_replace('{titulo}', $this->data['titulo'], $html);
        $html = str_replace('{descricao}', $this->data['descricao'], $html);
        $html = str_replace('{icon}', $this->data['icon'], $html);

        print $html;
    }

    public function save($request) {
        var_dump($request['icon']);
        try {

            if (empty($request['titulo']) || empty($request['descricao'])) {
                header("Location: index.php?class=AplicativoForm&erro=1");
                exit;
            }

            Aplicativo::save([
                'id' => $request['id'] ?? null,
                'titulo' => $request['titulo'],
                'descricao' => $request['descricao'],
                'icon' => $request['icon']
            ]);
            var_dump($request['icon']);

            header("Location: index.php?class=AplicativoForm&sucesso=1");
            exit;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}