<?php
class TemasController {

    public function lista(): void {
        $pdo   = getDB();
        $temas = $pdo->query('SELECT t.*, COUNT(r.id) n FROM temas t LEFT JOIN revistas r ON r.id_tema = t.id GROUP BY t.id ORDER BY t.tema ASC')->fetchAll();
        require __DIR__ . '/../views/temas.php';
    }

    public function guardar(): void {
        $tema = trim($_POST['tema'] ?? '');
        if ($tema) {
            try {
                getDB()->prepare('INSERT INTO temas (tema) VALUES (?)')->execute([$tema]);
            } catch (Exception $e) { /* duplicado, ignorar */ }
        }
        header('Location: index.php?ruta=/temas');
        exit;
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            // solo eliminar si no tiene revistas asociadas
            $n = (int)getDB()->prepare('SELECT COUNT(*) FROM revistas WHERE id_tema = ?')->execute([$id]);
            getDB()->prepare('DELETE FROM temas WHERE id = ?')->execute([$id]);
        }
        header('Location: index.php?ruta=/temas');
        exit;
    }
}
