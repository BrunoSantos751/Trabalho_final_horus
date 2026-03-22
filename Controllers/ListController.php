<?php
require_once './Controllers/ApplicationController.php';
require_once './model/Aplicativo.php';
require_once './model/Testemunhos.php';
require_once './model/Contatos.php';
require_once './model/Usuarios.php';

class ListController extends ApplicationController
{

    function __construct()
    {
        $this->setHtml('Layout/html/list/index_admin.html');
    }

    public function show()
    {
        $this->load();
        echo $this->html;
    }

    private function load()
    {
        try {
            $totalApps = count(Aplicativo::all());
            $totalTestemunhos = count(Testemunhos::all());
            $totalContatos = count(Contatos::all());
            $totalUsuarios = count(Usuarios::all());

            $this->html = str_replace('{totalApps}', $totalApps, $this->html);
            $this->html = str_replace('{totalTestemunhos}', $totalTestemunhos, $this->html);
            $this->html = str_replace('{totalContatos}', $totalContatos, $this->html);
            $this->html = str_replace('{totalUsuarios}', $totalUsuarios, $this->html);

            // Recent contacts
            $contatos = Contatos::all();
            // Sort by id desc
            usort($contatos, function ($a, $b) {
                return $b['id'] - $a['id'];
            });
            $recentes = array_slice($contatos, 0, 5);

            $items = '';
            foreach ($recentes as $c) {
                $items .= "<tr>
                    <td>{$c['nome']}</td>
                    <td>{$c['email']}</td>
                    <td>" . (strlen($c['mensagem']) > 50 ? substr($c['mensagem'], 0, 50) . "..." : $c['mensagem']) . "</td>
                </tr>";
            }

            if (empty($items)) {
                $items = "<tr><td colspan='3'>Nenhum contato recente.</td></tr>";
            }

            $this->html = str_replace('{recentes}', $items, $this->html);
        } catch (Exception $e) {
            // Silently fail or log error
        }
    }
}