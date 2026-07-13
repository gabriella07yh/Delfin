<?php
require_once __DIR__ . '/../models/Revista.php';

class HomeController {

    public function index(): void {
        if (!session_id()) session_start();
        $lang       = Revista::idioma();
        $t          = Revista::$textos[$lang];
        $destacadas = Revista::destacadas(getDB());
        require __DIR__ . '/../views/pages/home.php';
    }

    public function acerca(): void {
        if (!session_id()) session_start();
        $lang = Revista::idioma();
        $t    = Revista::$textos[$lang];
        require __DIR__ . '/../views/pages/acerca.php';
    }
}
