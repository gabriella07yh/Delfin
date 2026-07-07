<?php
require_once __DIR__ . '/../models/Revista.php';

class HomeController {

    //imprime: pagina principal con buscador y revistas destacadas
    public function index(): void {
        //consultar: revistas con confiabilidad 5 para seccion destacadas
        $destacadas = Revista::destacadas(getDB());
        require __DIR__ . '/../views/pages/home.php';
    }

    //imprime: pagina acerca del proyecto
    public function acerca(): void {
        require __DIR__ . '/../views/pages/acerca.php';
    }
}