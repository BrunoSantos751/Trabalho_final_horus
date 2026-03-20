<?php
require_once 'model/Usuarios.php';
spl_autoload_register(function ($class) {

    $path = __DIR__ . "/Controllers/{$class}.php";
    if (file_exists($path)) {
        require_once $path;
    }
});


$authorizedClass = ['View', 'LoginController', 'ContatoController'];

$classe = $_GET['class'] ?? Null;


if (empty($classe)) {
    header("Location: index.php?class=View");
    exit;
}


$method = $_GET['method'] ?? null;

/*
|--------------------------------------------------------------------------
| ROUTE: CONTROLLERS
|--------------------------------------------------------------------------
*/

if ($classe) {

    if (!class_exists($classe)) {
        http_response_code(404);
        exit("Classe não encontrada");
    }


    if (!in_array($classe, $authorizedClass)) {

        $session = $_SESSION['user_id'] ?? null;

        if (empty($session)) {
            $msgError = "precisa esta logado";
        }

        if (empty(Usuarios::find($session))) {
            unset($_SESSION['user_id']);
            $msgError = "Falha na autenticação";
        }
        if (isset($msgError)) {
            header("location: /index.php?class=LoginController");
            exit($msgError);
        }
    }

    $pagina = new $classe($_REQUEST);

    if ($method) {

        if (!method_exists($pagina, $method)) {
            http_response_code(404);
            exit("Método não encontrado");
        }

        $pagina->$method($_REQUEST);
    }

    if (method_exists($pagina, 'processMessages')) {
        $pagina->processMessages();
    }

    if (method_exists($pagina, 'show')) {
        $pagina->show();
    }

    exit;
}


echo "Página não encontrada";
