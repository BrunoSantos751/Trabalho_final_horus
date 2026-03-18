<?php

require_once __DIR__ . '/../model/Preferencias.php';

class PreferenciaForm extends ApplicationController {
    protected $html;

        public function __construct() {
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
            'titulo_secaoLojaApp' => null,
            'subtitulo_secaoLojaApp' => null,
            'link_AppStore' => null,
            'imagem_secaoLojaApp' => null,
            'imagem_AppStore' => null,
            'imagem_GooglePlay' => null,
            'link_GooglePlay' => null,
            'telefone_contato' => null,
            'logo_rodape' => null,
            'mensagem_rodape' => null,
            'url_rodape' => null,
            'mensagem_powered' => null
        ];
    }

    public function edit($param) {
        try {
            $id = (int) $param['id'];
            $preferencia = Preferencias::find($id);
            $this->data = $preferencia;
        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($request) {
        $preferencia = new Preferencias($request);
        var_dump($preferencia);
        $preferencia->save();
    }


    public function show() {
        $isEdit = !empty($this->data['id']);

        $titulo = $isEdit ? 'Editar preferências' : 'Cadastro de preferências';
        $hidden = $isEdit ? '' : 'hidden';
        $code_label = $isEdit ? 'Código :' : '';

        $this->html = str_replace('{titulo}', $titulo, $this->html);
        $this->html = str_replace('{acao}', $acao, $this->html);
        $this->html = str_replace('{hidden_id}', $hidden, $this->html);
        $this->html = str_replace('{code_label}', $code_label, $this->html);

        // Substituir os campos específicos de preferências
        foreach ($this->data as $key => $value) {
            $this->html = str_replace('{' . $key . '}', $value ?? '', $this->html);
        }

        print $this->html;
    }

}