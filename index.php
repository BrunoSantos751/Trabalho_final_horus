<?php

spl_autoload_register(function ($class) {

    $path = __DIR__ . "/classes/{$class}.php";

    if (file_exists($path)) {
        require_once $path;
    }

});

$classe = $_GET['class'] ?? Null;
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

    $pagina = new $classe($_REQUEST);

    if ($method) {

        if (!method_exists($pagina, $method)) {
            http_response_code(404);
            exit("Método não encontrado");
        }

        $pagina->$method($_REQUEST);
    }

    if (method_exists($pagina, 'show')) {
        $pagina->show();
    }

    exit;
}


echo "Página não encontrada";