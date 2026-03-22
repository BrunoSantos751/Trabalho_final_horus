<?php
require_once './model/Login.php';

abstract class ApplicationController
{
    protected $html;
    protected array|string|null $data = [];


    protected function setHtml($html)
    {
        $content = file_get_contents($html);
        $header = file_get_contents('Layout/html/application/header.html');
        $favicon = 'images/admin/favicon_admin.png';

        if (stripos($content, '<!DOCTYPE') === false) {
            $content = str_replace("{{header}}", $header, $content);
            $this->html = $this->wrapInLayout($content, $favicon);
        } else {
            if (strpos($content, 'admin.css') === false) {
                $content = str_replace('</head>', '<link rel="stylesheet" href="Layout/css/admin.css">' . "\n</head>", $content);
            }
            if (strpos($content, 'rel="icon"') === false && strpos($content, 'rel="shortcut icon"') === false) {
                $content = str_replace('</head>', '<link rel="icon" href="' . $favicon . '" type="image/x-icon">' . "\n</head>", $content);
            }
            $content = str_replace("{{header}}", $header, $content);
            $this->html = $content;
        }
    }

    private function wrapInLayout($content, $favicon)
    {
        return '<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<link rel="icon" href="' . $favicon . '" type="image/x-icon">
<link rel="stylesheet" href="Layout/css/materialdesignicons.min.css">
<link rel="stylesheet" href="Layout/css/admin.css">
</head>
<body>
' . $content . '
</body>
</html>';
    }


    public function processMessages()
    {
        $mensagem = '';
        if (isset($_SESSION['sucesso'])) {
            $mensagem .= "<div class='flash-success'>" . $_SESSION['sucesso'] . "</div>";
            unset($_SESSION['sucesso']);
        }
        if (isset($_SESSION['erro'])) {
            $mensagem .= "<div class='flash-error'>" . $_SESSION['erro'] . "</div>";
            unset($_SESSION['erro']);
        }

        $this->html = str_replace("{{mensagem}}", $mensagem, $this->html);

        if (!empty($mensagem) && strpos($this->html, $mensagem) === false) {
            if (strpos($this->html, '<body>') !== false) {
                $this->html = str_replace('<body>', "<body>\n" . $mensagem, $this->html);
            } else {
                $this->html = $mensagem . "\n" . $this->html;
            }
        }
    }

    abstract function show();
}