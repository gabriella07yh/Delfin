<?php
require_once __DIR__ . '/../models/Revista.php';
require_once __DIR__ . '/../config/app.php';

class BuscarController {

    public function index(): void {
        if (!session_id()) session_start();
        $lang = Revista::idioma();
        $t    = Revista::$textos[$lang];

        $filtros = [
            'q'          => trim($_GET['q']          ?? ''),
            'cuartil'    => (array)($_GET['cuartil'] ?? []),
            'costo'      => trim($_GET['costo']       ?? ''),
            'open_access'=> !empty($_GET['open_access']),
            'espanol'    => !empty($_GET['espanol']),
            'indexacion' => trim($_GET['indexacion']  ?? ''),
            'tema'       => trim($_GET['tema']        ?? ''),
            'orden'      => trim($_GET['orden']       ?? 'cuartil'),
        ];

        $pagina       = max(1, (int)($_GET['p'] ?? 1));
        $pdo          = getDB();
        $revistas     = Revista::obtenerTodas($pdo, $filtros, $pagina);
        $total        = Revista::contar($pdo, $filtros);
        $totalPaginas = (int)ceil($total / ITEMS_POR_PAGINA);
        $conteos      = Revista::conteos($pdo);
        $temas        = Revista::temas($pdo);

        require __DIR__ . '/../views/pages/buscar.php';
    }
}
