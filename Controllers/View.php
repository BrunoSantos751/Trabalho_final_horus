<?php

require_once './model/Caracteristicas.php';
require_once './model/Contatos.php';
require_once './model/Preferencias.php';
require_once './model/Testemunhos.php';

class View extends ApplicationController {

    public function __construct()  {
        $this->setHtml('Layout/index.html');
    }

    public function loadCaracteristicas() {
        try {
            $caracteristicas = Caracteristicas::all();
            $items = '';
            foreach ($caracteristicas as $caracteristica) {
                $item = file_get_contents('Layout/item_caracteristica.html');
                $item = str_replace('{titulo_caracticasHome}', $caracteristica['titulo'], $item);
                $item = str_replace('{descricao_caracticasHome}', $caracteristica['descricao'], $item);
                $items.= $item;
            }
            $this->html = str_replace('{caracteristicas}', $items, $this->html);
        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show() {

        $preferencias = Preferencias::all();

        $this->html = str_replace('{titulo_landing}', $preferencias[0]['titulo_landing'], $this->html);
        $this->html = str_replace('{favicon}', $preferencias[0]['favicon'], $this->html);
        $this->html = str_replace('{logo_cabecalho}', $preferencias[0]['logo_cabecalho'], $this->html);
        $this->html = str_replace('{facebook}', $preferencias[0]['facebook'], $this->html);
        $this->html = str_replace('{instagram}', $preferencias[0]['instagram'], $this->html);
        $this->html = str_replace('{imagem_secaoHome}', $preferencias[0]['imagem_secaoHome'], $this->html);
        $this->html = str_replace('{titulo_secaoHome}', $preferencias[0]['titulo_secaoHome'], $this->html);
        $this->html = str_replace('{subtitulo_secaoHome}', $preferencias[0]['subtitulo_secaoHome'], $this->html);
        $this->html = str_replace('{titulo_secaoLojaApp}', $preferencias[0]['titulo_secaoLojaApp'], $this->html);
        $this->html = str_replace('{subtitulo_secaoLojaAPP}', $preferencias[0]['subtitulo_secaoLojaAPP'], $this->html);
        $this->html = str_replace('{link_AppStore}', $preferencias[0]['link_AppStore'], $this->html);
        $this->html = str_replace('{image_AppStore}', $preferencias[0]['image_AppStore'], $this->html);
        $this->html = str_replace('{link_GooglePlay}', $preferencias[0]['link_GooglePlay'], $this->html);
        $this->html = str_replace('{image_GooglePlay}', $preferencias[0]['image_GooglePlay'], $this->html);
        $this->html = str_replace('{imagem_secaoLojaApp}', $preferencias[0]['imagem_secaoLojaApp'], $this->html);
        $this->html = str_replace('{telefone_contato}', $preferencias[0]['telefone_contato'], $this->html);
        $this->html = str_replace('{logo_rodape}', $preferencias[0]['logo_rodape'], $this->html);
        $this->html = str_replace('{mensagem_rodape}', $preferencias[0]['mensagem_rodape'], $this->html);
        $this->html = str_replace('{url_rodape}', $preferencias[0]['url_rodape'], $this->html);
        $this->html = str_replace('{mensagem_powered}', $preferencias[0]['mensagem_powered'], $this->html);

        $this->loadCaracteristicas();
        print $this->html;
    }
}
