<?php

require_once './model/Preferencias.php';
require_once './utils/UploadImagem.php';

class PreferenciaForm extends ApplicationController {
    protected $html;

        public function __construct() {
        $this->setHtml('Layout/html/preferencias/preferencias_form.html');
        $this->data = [
            'id' => null,
            'titulo_landing' => null,
            'logo_cabecalho' => null,
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'titulo_secaoHome' => null,
            'subtitulo_secaoHome' => null,
            'titulo_caracticasHome' => null,
            'titulo_testemunhos' => null,
            'titulo_secaoLojaApp' => null,
            'subtitulo_secaoLojaApp' => null,
            'link_AppStore' => null,
            'link_GooglePlay' => null,
            'telefone_contato' => null,
            'logo_rodape' => null,
            'mensagem_rodape' => null,
            'url_rodape' => null,
            'mensagem_powered' => null
        ];
        $this->redirect_edit();

    }

    public function redirect_edit(){
        $pref = Preferencias::find();
        $method = $_GET['method'] ?? null;
        
        if (empty($pref) && $method === 'edit') {
            $head = "";
        }

        if (!empty($pref) && $method === null) {
            $head = "&method=edit&id={$pref['id']}";
        }

        if (isset($head)){
            header("location: /index.php?class=PreferenciaForm$head");
            exit;
        }

    }

    public function edit() {
        try {
            $preferencia = Preferencias::find();
            $this->data = $preferencia;
        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($request) {
        $data = [
            'id' => $request['id'] ?? null,
            'titulo_landing' => $request['titulo_landing'] ?? null,
            'facebook' => $request['facebook'] ?? null,
            'twitter' => $request['twitter'] ?? null,
            'instagram' => $request['instagram'] ?? null,
            'titulo_secaoHome' => $request['titulo_secaoHome'] ?? null,
            'subtitulo_secaoHome' => $request['subtitulo_secaoHome'] ?? null,
            'titulo_caracticasHome' => $request['titulo_caracticasHome'] ?? null,
            'titulo_secaoLojaApp' => $request['titulo_secaoLojaApp'] ?? null,
            'subtitulo_secaoLojaApp' => $request['subtitulo_secaoLojaApp'] ?? null,
            'link_AppStore' => $request['link_AppStore'] ?? null,
            'link_GooglePlay' => $request['link_GooglePlay'] ?? null,
            'telefone_contato' => $request['telefone_contato'] ?? null,
            'mensagem_rodape' => $request['mensagem_rodape'] ?? null,
            'url_rodape' => $request['url_rodape'] ?? null,
            'mensagem_powered' => $request['mensagem_powered'] ?? null
        ];

        $upload = new UploadImagem();

        foreach(['imagem_secaoHome', 'imagem_AppStore', 'imagem_GooglePlay', 'imagem_secaoLojaApp', 'logo_rodape', 'favicon', 'logo_cabecalho'] as $img){
            if (!empty($_FILES[$img]['name'])){
                $data[$img] = $upload->uploadImagem($_FILES[$img],'Preferencias');
            }
        }

        $preferencia = new Preferencias;

        $preferencia->save($data);

        echo "operação concluida";

        header("location: /index.php?class=PreferenciaForm");
        exit;

    }


    public function show() {
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