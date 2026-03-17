<?php
require_once __DIR__ . '/ApplicationController.php';
class ListController extends ApplicationController {
    private $html;

    public function list_usarios() {
        $usuarioList = new UsuarioList();
        $usuarioList->show();
        return;
    }

    public function show() {
        ApplicationController::return_home();
        echo $this->html;
    }
}