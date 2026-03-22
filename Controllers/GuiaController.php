<?php
require_once './Controllers/ApplicationController.php';
require_once './model/Usuarios.php';

class GuiaController extends ApplicationController
{
    function __construct()
    {
        $this->setHtml('Layout/html/guia/guia.html');
    }

    public function show()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId) {
            Usuarios::markFirstLoginAsSeen($userId);
            $_SESSION['first_login'] = false;
        }
        echo $this->html;
    }
}
