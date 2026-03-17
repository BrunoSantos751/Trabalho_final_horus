<?php
require_once './model/Contatos.php';
require_once './Controllers/ApplicationController.php';

class ContatoForm extends ApplicationController {

    public function __construct()
    {
        $this->setHtml('Layout/html/contatos/cadastro.html');
    }

    function cadastro($request) {
        $this->data = [
            'id' => $request['id'] ?? null,
            'nome' => $request['nome'] ?? null,
            'email' => $request['email'] ?? null,
            'telefone' => $request['telefone'] ?? null,
            'mensagem' => $request['mensagem'] ?? null
        ];
        Contatos::save($this->data);
        header("Location: index.php?class=ContatoList");
        exit;
    }

    public function edit() {
         $id = $_GET['id'] ?? null;
         if ($id) {
             $contato = Contatos::find($id);
             if ($contato) {
                 $this->data = $contato;
             } else {
                 header("Location: index.php?class=ContatoList");
                 exit;
             }
         } else {
             header("Location: index.php?class=ContatoList");
             exit;
         }
    }

    public function show() {
        $this->html = str_replace('{id}', $this->data['id'] ?? '', $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'] ?? '', $this->html);
        $this->html = str_replace('{email}', $this->data['email'] ?? '', $this->html);
        $this->html = str_replace('{telefone}', $this->data['telefone'] ?? '', $this->html);
        $this->html = str_replace('{mensagem}', $this->data['mensagem'] ?? '', $this->html);
        echo $this->html;
    }
}