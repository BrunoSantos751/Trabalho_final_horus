<?php
require_once './model/Testemunhos.php';
require_once './Controllers/ApplicationController.php';

class TestemunhoForm extends ApplicationController {

    public function __construct()
    {
        $this->setHtml('Layout/html/testemunhos/cadastro.html');
    }

    function cadastro($request) {
        $upload = new UploadImagem();

        $foto = null;
        $fundo = null;

        if (!empty($_FILES['foto']['name'])) {
            $foto = $upload->uploadImagem($_FILES['foto'], 'testemunhos');
        }

        if (!empty($_FILES['imagem_fundo']['name'])) {
            $fundo = $upload->uploadImagem($_FILES['imagem_fundo'], 'testemunhos');
        }

        $this->data = [
            'id' => $request['id'] ?? null,
            'nome' => $request['nome'] ?? null,
            'funcao' => $request['funcao'] ?? null,
            'titulo' => $request['titulo'] ?? null,
            'descricao' => $request['descricao'] ?? null,
            'foto' => $foto,
            'imagem_fundo' => $fundo
        ];

        Testemunhos::save($this->data);

        header("Location: index.php?class=TestemunhoList");
        exit;
    }

    public function edit() {
         $id = $_GET['id'] ?? null;
         if ($id) {
             $testemunho = Testemunhos::find($id);
             if ($testemunho) {
                 $this->data = $testemunho;
             } else {
                 header("Location: index.php?class=TestemunhoList");
                 exit;
             }
         } else {
             header("Location: index.php?class=TestemunhoList");
             exit;
         }
    }

    public function show() {
        $this->html = str_replace('{id}', $this->data['id'] ?? '', $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'] ?? '', $this->html);
        $this->html = str_replace('{funcao}', $this->data['funcao'] ?? '', $this->html);
        $this->html = str_replace('{titulo}', $this->data['titulo'] ?? '', $this->html);
        $this->html = str_replace('{descricao}', $this->data['descricao'] ?? '', $this->html);
        $this->html = str_replace('{foto}', $this->data['foto'] ?? '', $this->html);
        $this->html = str_replace('{imagem_fundo}', $this->data['imagem_fundo'] ?? '', $this->html);
        
        echo $this->html;
    }
}