<?php
require_once __DIR__ . '/../models/Revista.php';
require_once __DIR__ . '/../config/app.php';

class BuscarController {

    public function index(): void {
        $filtros = [
            'q'             => trim($_GET['q']              ?? ''),
            'cuartil'       => $_GET['cuartil']             ?? [],
            'apc_tipo'      => $_GET['apc_tipo']            ?? [],
            'indexaciones'  => $_GET['indexaciones']        ?? [],
            'espanol'       => $_GET['espanol']             ?? '',
            'confiabilidad' => (int)($_GET['confiabilidad'] ?? 0),
            'recomendada'   => (int)($_GET['recomendada']   ?? 0),
            'orden'         => $_GET['orden']               ?? 'confiabilidad',
        ];

        $pagina       = max(1, (int)($_GET['p'] ?? 1));
        $pdo          = getDB();
        //consultar: resultados, total y conteos para los filtros
        $revistas     = Revista::obtenerTodas($pdo, $filtros, $pagina);
        $total        = Revista::contar($pdo, $filtros);
        $totalPaginas = (int)ceil($total / ITEMS_POR_PAGINA);
        $conteos      = Revista::conteos($pdo);

        require __DIR__ . '/../views/pages/buscar.php';
    }
}