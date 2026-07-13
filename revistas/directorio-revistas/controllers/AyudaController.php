<?php

class AyudaController {

    public function index(): void {
        if (!session_id()) session_start();
        $datos   = [];
        $enviado = false;
        require __DIR__ . '/../views/pages/ayuda.php';
    }

    public function post(): void {
        if (!session_id()) session_start();
        $tipo    = trim($_POST['tipo_problema'] ?? '');
        $nombre  = trim($_POST['nombre']        ?? '');
        $enlace  = trim($_POST['enlace']        ?? '');
        $detalles= trim($_POST['detalles']      ?? '');

        if (!$tipo || !$nombre || !$detalles) {
            $datos   = $_POST;
            $enviado = false;
            require __DIR__ . '/../views/pages/ayuda.php';
            return;
        }

        $pdo = getDB();
        //agregar: INSERT en tabla sugerencias con schema real del equipo
        $pdo->prepare(
            'INSERT INTO sugerencias (tipo_problema, nombre, enlace, detalles)
             VALUES (?, ?, ?, ?)'
        )->execute([$tipo, $nombre, $enlace ?: '', $detalles]);

        $datos   = [];
        $enviado = true;
        require __DIR__ . '/../views/pages/ayuda.php';
    }
}
