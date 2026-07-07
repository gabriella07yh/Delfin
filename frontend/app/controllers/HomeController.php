<?php
require_once __DIR__ . '/../models/Revista.php';

class HomeController {

    //imprime: pagina principal con buscador y revistas destacadas
    public function index(): void {
        //consultar: traer revistas destacadas para mostrar en hero (confiabilidad = 5)
        $destacadas = [];

        require __DIR__ . '/../views/pages/home.php';
    }

    //imprime: pagina acerca del proyecto con info del equipo
    public function acerca(): void {
        require __DIR__ . '/../views/pages/acerca.php';
    }
}
