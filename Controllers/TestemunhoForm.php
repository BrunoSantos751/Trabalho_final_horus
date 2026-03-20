<?php
require_once './model/Testemunhos.php';
require_once './utils/UploadImagem.php';
require_once './Controllers/ApplicationController.php';

class TestemunhoForm extends ApplicationController {

    public function __construct()
    {
        $this->setHtml('Layout/html/testemunhos/cadastro.html');
    }

    function cadastro($request) {
        $this->data = [
            'id'        => $request['id'] ?? null,
            'nome'      => $request['nome'] ?? null,
            'funcao'    => $request['funcao'] ?? null,
            'titulo'    => $request['titulo'] ?? null,
            'descricao' => $request['descricao'] ?? null,
        ];

        $upload = new UploadImagem();
        $isNew  = empty($this->data['id']);

        foreach (['foto', 'imagem_fundo'] as $img) {
            $savedKey = $img . '_salva';
            $savedVal = $request[$savedKey] ?? '';

            if (!empty($_FILES[$img]['name'])) {
                if (!empty($savedVal) && $savedVal !== '__REMOVE__') {
                    UploadImagem::deleteImage('Testemunhos', $this->data['id'], $img);
                }
                try {
                    $this->data[$img] = $upload->uploadImagem($_FILES[$img], 'Testemunhos');
                } catch (Exception $e) {
                    $_SESSION['erro'] = "Erro no upload ($img): " . $e->getMessage();
                    $this->data[$img] = ($savedVal !== '__REMOVE__') ? $savedVal : null;
                    return;
                }
            } elseif ($savedVal === '__REMOVE__') {
                UploadImagem::deleteImage('Testemunhos', $this->data['id'], $img);
                $this->data[$img] = null;
            } else {
                $this->data[$img] = $savedVal ?: null;
            }
        }

        if (empty($this->data['nome']) || empty($this->data['funcao']) || empty($this->data['titulo']) || empty($this->data['descricao'])) {
            $_SESSION['erro'] = "Por favor, preencha todos os campos obrigatórios em texto.";
            return;
        }

        if ($isNew && (empty($this->data['foto']) || empty($this->data['imagem_fundo']))) {
            $_SESSION['erro'] = "É obrigatório enviar as imagens de Foto e Imagem de fundo!";
            return;
        }

        try {
            Testemunhos::save($this->data);
            $_SESSION['sucesso'] = "Testemunho salvo com sucesso!";
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar testemunho: " . $e->getMessage();
        }

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