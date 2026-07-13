<?php
require_once __DIR__ . '/../models/Revista.php';

class RevistaController {

    public function detalle(): void {
        if (!session_id()) session_start();
        $lang    = Revista::idioma();
        $t       = Revista::$textos[$lang];
        $id      = (int)($_GET['id'] ?? 0);
        $revista = Revista::obtenerPorId(getDB(), $id);

        if (!$revista) {
            http_response_code(404);
            require __DIR__ . '/../views/pages/404.php';
            return;
        }
        require __DIR__ . '/../views/pages/detalle.php';
    }
}
