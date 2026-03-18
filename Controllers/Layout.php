<?php
require_once './Controllers/ApplicationController.php';
require_once './model/Caracteristicas.php'; 
require_once './model/Contatos.php';
require_once './model/Preferencias.php';
require_once './model/Testemunhos.php';

class Layout extends ApplicationController {

    public function __construct() {
        $this->html = file_get_contents('Layout/index.html');
        $this->load();
    }

    public function load() {
        $classes = ['Preferencias', 'Testemunhos', 'Caracteristicas', 'Contatos'];

        foreach ($classes as $class) {
            array_push($this->data, $class::all());
        }

        foreach ($classes as $class) {
            $items = '';
            foreach ($this->data as $item) {
                if (get_class((object)$item) === $class) {
                    $template = file_get_contents("Layout/html/{$class}/item.html");
                    foreach ($item as $key => $value) {
                        $template = str_replace('{' . $key . '}', $value, $template);
                    }
                    $items .= $template;
                }
            }
            $this->html = str_replace('{' . strtolower($class) . '_items}', $items, $this->html);
        }
    }

    public function show() {
        print $this->html;
    }
}