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

        $html = str_replace('{id}', $this->data['id'], $html);
        $html = str_replace('{titulo}', $this->data['titulo'], $html);
        $html = str_replace('{descricao}', $this->data['descricao'], $html);
        $html = str_replace('{icon}', $this->data['icon'], $html);
        $html = str_replace('{icon_label}', 'Selecione', $html);

        print $html;
    }

    public function edit($request) {
        $id = $request['id'] ?? ($_GET['id'] ?? null);
        if ($id) {
            $aplicativo = Aplicativo::find($id);
            if ($aplicativo) {
                $this->data = $aplicativo;
            }
        }
    }

    public function save($request) {
        var_dump($request['icon']);
        try {

            if (empty($request['titulo']) || empty($request['descricao'])) {
                $_SESSION['erro'] = "Por favor, preencha os campos obrigatórios.";
                header("Location: index.php?class=AplicativoForm");
                exit;
            }

            Aplicativo::save([
                'id' => $request['id'] ?? null,
                'titulo' => $request['titulo'],
                'descricao' => $request['descricao'],
                'icon' => $request['icon']
            ]);

            $_SESSION['sucesso'] = "Aplicativo salvo com sucesso!";
            header("Location: index.php?class=AplicativoList");
            exit;

        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro: " . $e->getMessage();
            header("Location: index.php?class=AplicativoForm");
            exit;
        }
    }
}