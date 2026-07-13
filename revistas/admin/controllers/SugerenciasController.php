<?php
class SugerenciasController {

    public function lista(): void {
        $pdo      = getDB();
        $tipo     = $_GET['tipo'] ?? '';
        if ($tipo) {
            $stmt = $pdo->prepare('SELECT * FROM sugerencias WHERE tipo_problema = ? ORDER BY fecha_envio DESC');
            $stmt->execute([$tipo]);
        } else {
            $stmt = $pdo->query('SELECT * FROM sugerencias ORDER BY fecha_envio DESC');
        }
        $sugerencias = $stmt->fetchAll();
        require __DIR__ . '/../views/sugerencias.php';
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            getDB()->prepare('DELETE FROM sugerencias WHERE id = ?')->execute([$id]);
        }
        header('Location: index.php?ruta=/sugerencias');
        exit;
    }
}
