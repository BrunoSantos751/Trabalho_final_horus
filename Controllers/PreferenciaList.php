<?php
require_once __DIR__ . '/../model/Preferencias.php';

class PreferenciaList {
    private $html;

    public function __construct() {
        $this->html = file_get_contents('Layout/html/preferencias/list.html');
    }

    public function delete($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            $result = Preferencias::delete($id);
            header("Location: index.php?class=PreferenciaList");
            exit;
        }
    }
    public function edit($request) {
        $id = $request['id'] ?? null;
        if ($id) {
            header("Location: index.php?class=PreferenciaForm&method=edit&id=$id");
            exit;
        }
    }

    function load() {
        try {
            $preferencias = Preferencias::all();
            $items = '';
        foreach ($preferencias as $preferencia) {
            $item = file_get_contents('Layout/html/preferencias/item.html');
            $item = str_replace('{id}', $preferencia['id'], $item);
            $item = str_replace('{titulo_landing}', $preferencia['titulo_landing'], $item);
            $item = str_replace('{favicon}', $preferencia['favicon'], $item);
            $item = str_replace('{logo_cabecalho}', $preferencia['logo_cabecalho'], $item);
            $item = str_replace('{facebook}', $preferencia['facebook'], $item);
            $item = str_replace('{twitter}', $preferencia['twitter'], $item);
            $item = str_replace('{instagram}', $preferencia['instagram'], $item);
            $item = str_replace('{titulo_secaoHome}', $preferencia['titulo_secaoHome'], $item);
            $item = str_replace('{subtitulo_secaoHome}', $preferencia['subtitulo_secaoHome'], $item);
            $item = str_replace('{imagem_secaoHome}', $preferencia['imagem_secaoHome'], $item);
            $item = str_replace('{titulo_caracticasHome}', $preferencia['titulo_caracticasHome'], $item);
            $item = str_replace('{titulo_secaoLojaApp}', $preferencia['titulo_secaoLojaApp'], $item);
            $item = str_replace('{subtitulo_secaoLojaApp}', $preferencia['subtitulo_secaoLojaApp'], $item);
            $item = str_replace('{imagem_secaoLojaApp}', $preferencia['imagem_secaoLojaApp'], $item);
            $item = str_replace('{imagem_AppStore}', $preferencia['imagem_AppStore'], $item);
            $item = str_replace('{imagem_GooglePlay}', $preferencia['imagem_GooglePlay'], $item);
            $item = str_replace('{telefone_contato}', $preferencia['telefone_contato'], $item);
            $item = str_replace('{logo_rodape}', $preferencia['logo_rodape'], $item);
            $item = str_replace('{mensagem_rodape}', $preferencia['mensagem_rodape'], $item);
            $item = str_replace('{url_rodape}', $preferencia['url_rodape'], $item);
            $item = str_replace('{mensagem_powered}', $preferencia['mensagem_powered'], $item);
            $items.= $item;
        }
        $this->html = str_replace('{items}', $items, $this->html);
        }
        catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function show() {
        $this->load();
        print $this->html;
    }

}