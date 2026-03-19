<?php
require_once './model/Contatos.php';

class ContatoController {

    public function __construct($request = null) {}

    public function salvar($request) {
        try {
            $data = [
                'nome' => $request['nome'] ?? '',
                'email' => $request['email'] ?? '',
                'telefone' => $request['telefone'] ?? '',
                'mensagem' => $request['mensagem'] ?? ''
            ];

            
            if (empty($data['nome']) || empty($data['email']) || empty($data['mensagem'])) {
                header("Location: index.php?class=View&erro=1#contact");
                return;
            }

            Contatos::save($data);

          
            header("Location: index.php?class=View&sucesso=1#contact");

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}