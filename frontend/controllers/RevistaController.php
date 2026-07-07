<?php
require_once __DIR__ . '/../models/Revista.php';

class RevistaController {

    //imprime: pagina de detalle completo de una revista
    public function detalle(): void {
        $id = (int)($_GET['id'] ?? 0);

        //consultar: obtener revista por id desde tabla revistas
        $revista = Revista::obtenerPorId(getDB(), $id);

        if (!$revista) {
            http_response_code(404);
            require __DIR__ . '/../views/pages/404.php';
            return;
        }

        require __DIR__ . '/../views/pages/detalle.php';
    }
}