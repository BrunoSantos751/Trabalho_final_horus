<?php

require_once './model/Preferencias.php';
require_once './utils/UploadImagem.php';

class PreferenciaForm extends ApplicationController
{
    protected $html;

    public function __construct()
    {
        $this->setHtml('Layout/html/preferencias/preferencias_form.html');
        $this->data = [
            'id' => null,
            'titulo_landing' => null,
            'favicon' => null,
            'logo_cabecalho' => null,
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'titulo_secaoHome' => null,
            'subtitulo_secaoHome' => null,
            'imagem_secaoHome' => null,
            'titulo_caracticasHome' => null,
            'titulo_testemunhos' => null,
            'titulo_secaoLojaApp' => null,
            'subtitulo_secaoLojaApp' => null,
            'imagem_secaoLojaApp' => null,
            'link_AppStore' => null,
            'imagem_AppStore' => null,
            'link_GooglePlay' => null,
            'imagem_GooglePlay' => null,
            'telefone_contato' => null,
            'logo_rodape' => null,
            'mensagem_rodape' => null,
            'url_rodape' => null,
            'mensagem_powered' => null,
        ];
        $this->redirect_edit();

    }

    public function redirect_edit()
    {
        $pref = Preferencias::find();
        $method = $_GET['method'] ?? null;

        if (empty($pref) && $method === 'edit') {
            $head = "";
        }

        if (!empty($pref) && $method === null) {
            $head = "&method=edit&id={$pref['id']}";
        }

        if (isset($head)) {
            header("location: /index.php?class=PreferenciaForm$head");
            exit;
        }

    }

    public function edit()
    {
        try {
            $preferencia = Preferencias::find();
            $defaults = [
                'id' => null,
                'titulo_landing' => null,
                'favicon' => null,
                'logo_cabecalho' => null,
                'facebook' => null,
                'instagram' => null,
                'titulo_secaoHome' => null,
                'subtitulo_secaoHome' => null,
                'imagem_secaoHome' => null,
                'titulo_caracticasHome' => null,
                'titulo_testemunhos' => null,
                'titulo_secaoLojaApp' => null,
                'subtitulo_secaoLojaApp' => null,
                'imagem_secaoLojaApp' => null,
                'link_AppStore' => null,
                'imagem_AppStore' => null,
                'link_GooglePlay' => null,
                'imagem_GooglePlay' => null,
                'telefone_contato' => null,
                'logo_rodape' => null,
                'mensagem_rodape' => null,
                'url_rodape' => null,
                'mensagem_powered' => null,
            ];
            $this->data = array_merge($defaults, $preferencia ?? []);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($request)
    {
        $this->data = [
            'id' => $request['id'] ?? null,
            'titulo_landing' => $request['titulo_landing'] ?? null,
            'facebook' => $request['facebook'] ?? null,
            'twitter' => $request['twitter'] ?? null,
            'instagram' => $request['instagram'] ?? null,
            'titulo_secaoHome' => $request['titulo_secaoHome'] ?? null,
            'subtitulo_secaoHome' => $request['subtitulo_secaoHome'] ?? null,
            'titulo_caracticasHome' => $request['titulo_caracticasHome'] ?? null,
            'titulo_testemunhos' => $request['titulo_testemunhos'] ?? null,
            'titulo_secaoLojaApp' => $request['titulo_secaoLojaApp'] ?? null,
            'subtitulo_secaoLojaApp' => $request['subtitulo_secaoLojaApp'] ?? null,
            'link_AppStore' => $request['link_AppStore'] ?? null,
            'link_GooglePlay' => $request['link_GooglePlay'] ?? null,
            'telefone_contato' => $request['telefone_contato'] ?? null,
            'mensagem_rodape' => $request['mensagem_rodape'] ?? null,
            'url_rodape' => $request['url_rodape'] ?? null,
            'mensagem_powered' => $request['mensagem_powered'] ?? null,
        ];

        $upload = new UploadImagem();
        $imgFields = [
            'imagem_secaoHome',
            'imagem_AppStore',
            'imagem_GooglePlay',
            'imagem_secaoLojaApp',
            'logo_rodape',
            'favicon',
            'logo_cabecalho'
        ];

        foreach ($imgFields as $img) {
            $savedVal = $request[$img . '_salva'] ?? '';

            if (!empty($_FILES[$img]['name'])) {
                if (!empty($savedVal) && $savedVal !== '__REMOVE__') {
                    UploadImagem::deleteImage('Preferencias', $this->data['id'], $img);
                }
                try {
                    $this->data[$img] = $upload->uploadImagem($_FILES[$img], 'Preferencias');
                } catch (Exception $e) {
                    $_SESSION['erro'] = "Erro no upload ($img): " . $e->getMessage();
                    $this->data[$img] = ($savedVal !== '__REMOVE__') ? $savedVal : null;
                    return;
                }
            } elseif ($savedVal === '__REMOVE__') {
                UploadImagem::deleteImage('Preferencias', $this->data['id'], $img);
                $this->data[$img] = null;
            } else {
                $this->data[$img] = $savedVal ?: null;
            }
        }

        try {
            Preferencias::save($this->data);
            $_SESSION['sucesso'] = "Preferências salvas com sucesso!";
            header("location: /index.php?class=PreferenciaForm");
            exit;
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar preferências: " . $e->getMessage();
        }
    }


    public function show()
    {
        $isEdit = !empty($this->data['id']);

        $titulo = $isEdit ? 'Editar preferências' : 'Cadastro de preferências';

        $code_label = $isEdit ? 'Código :' : '';

        $this->html = str_replace('{titulo}', $titulo, $this->html);
        $this->html = str_replace('{code_label}', $code_label, $this->html);

        // Substituir os campos específicos de preferências
        foreach ($this->data as $key => $value) {
            $this->html = str_replace('{' . $key . '}', $value ?? '', $this->html);
        }

        print $this->html;
    }

}