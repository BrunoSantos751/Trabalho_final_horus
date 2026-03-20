<?php

require_once './model/Caracteristicas.php';
require_once './model/Contatos.php';
require_once './model/Preferencias.php';
require_once './model/Testemunhos.php';
require_once './model/Aplicativo.php';

class View extends ApplicationController
{

    public function __construct()
    {
        $this->setHtml('Layout/index.html');
    }

    private function getValue($array, $key, $default)
    {
        return isset($array[$key]) && trim($array[$key]) !== '' ? $array[$key] : $default;
    }

    private function getUrl($array, $key, $default)
    {
        $val = $this->getValue($array, $key, $default);
        if ($val !== '#' && !empty($val) && !preg_match('#^https?://#i', $val)) {
            $val = 'https://' . $val;
        }
        return $val;
    }

    public function loadCaracteristicas()
    {
        try {
            $caracteristicas = Caracteristicas::all();
            $items_caracteristica = '';
            foreach ($caracteristicas as $caracteristica) {
                $item_caracteristica = file_get_contents('Layout/item_caracteristicas.html');
                $item_caracteristica = str_replace('{titulo}', $this->getValue($caracteristica, 'titulo', '⚡ Nome da funcionalidade (cadastre no painel)'), $item_caracteristica);
                $item_caracteristica = str_replace('{descricao}', $this->getValue($caracteristica, 'descricao', '📝 Descreva aqui o que essa funcionalidade faz no seu sistema.'), $item_caracteristica);
                $items_caracteristica .= $item_caracteristica;
            }
            // fallback se não tiver NENHUMA caracteristica
            if (empty($items_caracteristica)) {
                $item_caracteristica = file_get_contents('Layout/item_caracteristicas.html');
                $item_caracteristica = str_replace('{titulo}', '⚡ Exemplo de funcionalidade', $item_caracteristica);
                $item_caracteristica = str_replace('{descricao}', '👉 Cadastre características no sistema para exibir aqui.', $item_caracteristica);
                $items_caracteristica .= $item_caracteristica;
            }
            $this->html = str_replace('{caracteristicas_plataforma}', $items_caracteristica, $this->html);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function loadTestemunhos()
    {
        try {
            $testemunhos = Testemunhos::all();
            $items_testemunhos = '';
            foreach ($testemunhos as $testemunho) {
                $item_testemunho = file_get_contents('Layout/item_testemunho.html');
                $item_testemunho = str_replace('{imagem_usuario}', $this->getValue($testemunho, 'foto', 'images/user/img-1.jpg'), $item_testemunho);
                $item_testemunho = str_replace('{nome}', $this->getValue($testemunho, 'nome', '👤 Nome do cliente'), $item_testemunho);
                $item_testemunho = str_replace('{funcao}', $this->getValue($testemunho, 'funcao', '💼 Cargo ou profissão'), $item_testemunho);
                $item_testemunho = str_replace('{titulo_testemunho}', $this->getValue($testemunho, 'titulo', '⭐ Título do depoimento'), $item_testemunho);
                $item_testemunho = str_replace('{descricao_testemunho}', $this->getValue($testemunho, 'descricao', '📝 Escreva aqui a experiência do cliente com seu produto.'), $item_testemunho);
                $item_testemunho = str_replace('{imagem_fundo}', $this->getValue($testemunho, 'imagem_fundo', 'images/img/img-1.png'), $item_testemunho);
                $items_testemunhos .= $item_testemunho;
            }
            // fallback se não tiver NENHUM testemunho
            if (empty($items_testemunhos)) {
                $item_testemunho = file_get_contents('Layout/item_testemunho.html');
                $item_testemunho = str_replace('{imagem_usuario}', 'images/user/img-1.jpg', $item_testemunho);
                $item_testemunho = str_replace('{nome}', '👤 Cliente Exemplo', $item_testemunho);
                $item_testemunho = str_replace('{funcao}', 'Usuário do sistema', $item_testemunho);
                $item_testemunho = str_replace('{titulo_testemunho}', '⭐ Depoimento exemplo', $item_testemunho);
                $item_testemunho = str_replace('{descricao_testemunho}', '👉 Cadastre depoimentos no sistema para exibir aqui.', $item_testemunho);
                $item_testemunho = str_replace('{imagem_fundo}', 'images/img/img-1.png', $item_testemunho);
                $items_testemunhos .= $item_testemunho;
            }
            $this->html = str_replace('{testemunhos}', $items_testemunhos, $this->html);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function loadAplicativos()
    {
        try {
            $aplicativos = Aplicativo::all();
            $esquerda = '';
            $direita = '';
            $i = 0;


            foreach ($aplicativos as $app) {
                if ($i % 2 == 0) {
                    $item = file_get_contents('Layout/item _app_esquerda.html');
                } else {
                    $item = file_get_contents('Layout/item_app_direita.html');
                }

                $item = str_replace('{icon}', $this->getValue($app, 'icon', 'mdi mdi-cellphone'), $item);
                $item = str_replace('{titulo}', $this->getValue($app, 'titulo', '📱 Nome do recurso'), $item);
                $item = str_replace('{descricao}', $this->getValue($app, 'descricao', 'Descrição aqui'), $item);

                if ($i % 2 == 0) {
                    $esquerda .= $item;
                } else {
                    $direita .= $item;
                }

                $i++;
            }

            // fallback se não tiver NENHUM aplicativo
            if (empty($esquerda) && empty($direita)) {
                $item = file_get_contents('Layout/item_app.html');
                $item = str_replace('{icon}', 'mdi mdi-cellphone', $item);
                $item = str_replace('{titulo}', '📱 Exemplo de funcionalidade', $item);
                $item = str_replace('{descricao}', '👉 Cadastre funcionalidades do app para aparecer aqui.', $item);
                $esquerda .= $item;
            }

            $this->html = str_replace('{aplicativos_esquerda}', $esquerda, $this->html);
            $this->html = str_replace('{aplicativos_direita}', $direita, $this->html);

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function loadPreferencias()
    {
        $preferencias = Preferencias::all();
        $p = $preferencias[0] ?? [];

        $this->html = str_replace('{titulo_landing}', $this->getValue($p, 'titulo_landing', '🚀 Nome da sua plataforma (edite em Preferências)'), $this->html);
        $this->html = str_replace('{favicon}', $this->getValue($p, 'favicon', 'images/favicon.png'), $this->html);
        $this->html = str_replace('{logo_cabecalho}', $this->getValue($p, 'logo_cabecalho', 'images/logo.png'), $this->html);
        $this->html = str_replace('{facebook}', $this->getUrl($p, 'facebook', '#'), $this->html);
        $this->html = str_replace('{instagram}', $this->getUrl($p, 'instagram', '#'), $this->html);

        $this->html = str_replace('{imagem_secaoHome}', $this->getValue($p, 'imagem_secaoHome', 'images/features/home-1.png'), $this->html);
        $this->html = str_replace('{titulo_secaoHome}', $this->getValue($p, 'titulo_secaoHome', '💡 Título principal da sua seção Home! <br> clique <a href="index.php?class=LoginController">aqui</a> para acessar o painel admin '), $this->html);
        $this->html = str_replace('{subtitulo_secaoHome}', $this->getValue($p, 'subtitulo_secaoHome', '✏️ Descreva aqui o que sua plataforma faz (edite o subtitulo no painel)'), $this->html);
        $this->html = str_replace('{titulo_caracticasHome}', $this->getValue($p, 'titulo_caracticasHome', '⚙️ Título das Características do sistema'), $this->html);

        $this->html = str_replace('{titulo_testemunhos}', $this->getValue($p, 'titulo_testemunhos', '💬 Depoimentos de clientes (adicione no painel Testemunhos)'), $this->html);

        $this->html = str_replace('{titulo_secaoLojaApp}', $this->getValue($p, 'titulo_secaoLojaApp', '📱 Divulgue seu aplicativo aqui ( seção Loja App)'), $this->html);
        $this->html = str_replace('{subtitulo_secaoLojaAPP}', $this->getValue($p, 'subtitulo_secaoLojaApp', '🔗 Adicione os links da App Store e Google Play'), $this->html);
        $this->html = str_replace('{imagem_secaoLojaApp}', $this->getValue($p, 'imagem_secaoLojaApp', 'images/home-5.png'), $this->html);

        $this->html = str_replace('{link_AppStore}', $this->getUrl($p, 'link_AppStore', '#'), $this->html);
        $this->html = str_replace('{image_AppStore}', $this->getValue($p, 'imagem_AppStore', 'images/img-appstore.png'), $this->html);

        $this->html = str_replace('{link_GooglePlay}', $this->getUrl($p, 'link_GooglePlay', '#'), $this->html);
        $this->html = str_replace('{image_GooglePlay}', $this->getValue($p, 'imagem_GooglePlay', 'images/img-googleplay.png'), $this->html);

        $this->html = str_replace('{telefone_contato}', $this->getValue($p, 'telefone_contato', '📞 (00) 00000-0000 - edite nas Preferências'), $this->html);

        $this->html = str_replace('{logo_rodape}', $this->getValue($p, 'logo_rodape', 'images/logo-footer.png'), $this->html);
        $this->html = str_replace('{mensagem_rodape}', $this->getValue($p, 'mensagem_rodape', '© Sua empresa - personalize esta mensagem rodape no painel'), $this->html);
        $this->html = str_replace('{url_rodape}', $this->getValue($p, 'url_rodape', 'url_rodape'), $this->html);
        $this->html = str_replace('{mensagem_powered}', $this->getValue($p, 'mensagem_powered', '🚀 Desenvolvido com sua plataforma ( mensagem powered )'), $this->html);
    }
    private function loadMensagem()
    {
        if (isset($_GET['erro']) && $_GET['erro'] == 1) {
            $mensagem = "<p class='alert alert-danger' id='msg_alert'> <strong>Ops !</strong> Por favor, preencha os campos obrigatórios.</p>";
        } else if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
            $mensagem = "<p class='alert alert-success' id='msg_alert'> <strong>Obrigado !</strong> Sua Mensagem foi entregue.</p>";
        } else {
            $mensagem = '';
        }
        $this->html = str_replace('{mensagem}', $mensagem, $this->html);
    }

    public function show()
    {
        $this->loadTestemunhos();
        $this->loadCaracteristicas();
        $this->loadAplicativos();
        $this->loadPreferencias();
        $this->loadMensagem();
        print $this->html;
    }
}
