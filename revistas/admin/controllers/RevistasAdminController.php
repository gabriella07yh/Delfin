<?php
class RevistasAdminController {

    public function dashboard(): void {
        $pdo        = getDB();
        $total      = (int)$pdo->query('SELECT COUNT(*) FROM revistas')->fetchColumn();
        $sugerencias= (int)$pdo->query('SELECT COUNT(*) FROM sugerencias')->fetchColumn();
        $temas      = (int)$pdo->query('SELECT COUNT(*) FROM temas')->fetchColumn();
        $indexaciones=(int)$pdo->query('SELECT COUNT(*) FROM indexaciones')->fetchColumn();
        require __DIR__ . '/../views/dashboard.php';
    }

    public function lista(): void {
        $q    = trim($_GET['q'] ?? '');
        $pdo  = getDB();
        if ($q) {
            $stmt = $pdo->prepare(
                'SELECT r.*, t.tema FROM revistas r
                 LEFT JOIN temas t ON t.id = r.id_tema
                 WHERE r.titulo_revista LIKE ? OR t.tema LIKE ?
                 ORDER BY r.titulo_revista ASC'
            );
            $stmt->execute(["%$q%", "%$q%"]);
        } else {
            $stmt = $pdo->query(
                'SELECT r.*, t.tema FROM revistas r
                 LEFT JOIN temas t ON t.id = r.id_tema
                 ORDER BY r.titulo_revista ASC'
            );
        }
        $revistas = $stmt->fetchAll();
        require __DIR__ . '/../views/revistas-lista.php';
    }

    public function formNueva(): void {
        $pdo       = getDB();
        $temas     = $pdo->query('SELECT * FROM temas ORDER BY tema ASC')->fetchAll();
        $indexs    = $pdo->query('SELECT * FROM indexaciones ORDER BY indexacion ASC')->fetchAll();
        $revista   = null;
        $selTemas  = [];
        $selIndexs = [];
        require __DIR__ . '/../views/revista-form.php';
    }

    public function formEditar(): void {
        $id  = (int)($_GET['id'] ?? 0);
        $pdo = getDB();
        $stmt = $pdo->prepare('SELECT * FROM revistas WHERE id = ?');
        $stmt->execute([$id]);
        $revista = $stmt->fetch();
        if (!$revista) { header('Location: index.php?ruta=/revistas'); exit; }

        $temas  = $pdo->query('SELECT * FROM temas ORDER BY tema ASC')->fetchAll();
        $indexs = $pdo->query('SELECT * FROM indexaciones ORDER BY indexacion ASC')->fetchAll();

        $stmt2 = $pdo->prepare('SELECT id_tema FROM revista_tema WHERE id_revista = ?');
        $stmt2->execute([$id]);
        $selTemas = array_column($stmt2->fetchAll(), 'id_tema');

        $stmt3 = $pdo->prepare('SELECT id_indexacion FROM revista_indexacion WHERE id_revista = ?');
        $stmt3->execute([$id]);
        $selIndexs = array_column($stmt3->fetchAll(), 'id_indexacion');

        require __DIR__ . '/../views/revista-form.php';
    }

    public function guardar(): void {
        $pdo = getDB();
        $id  = (int)($_POST['id'] ?? 0);

        $datos = [
            'titulo_revista' => trim($_POST['titulo_revista'] ?? ''),
            'id_tema'        => (int)($_POST['id_tema']       ?? 0),
            'cuartil'        => $_POST['cuartil']              ?? 'SIN ASIGNAR',
            'idioma'         => $_POST['idioma']               ?? 'Espanol',
            'costo'          => (float)($_POST['costo']        ?? 0),
            'open_access'    => !empty($_POST['open_access'])  ? 1 : 0,
            'arbitrada'      => !empty($_POST['arbitrada'])    ? 1 : 0,
            'descripcion'    => trim($_POST['descripcion']     ?? ''),
            'enlace'         => trim($_POST['enlace']          ?? ''),
        ];

        if ($id) {
            //actualizar: UPDATE revista existente
            $sql = 'UPDATE revistas SET titulo_revista=?,id_tema=?,cuartil=?,idioma=?,costo=?,open_access=?,arbitrada=?,descripcion=?,enlace=? WHERE id=?';
            $pdo->prepare($sql)->execute([...array_values($datos), $id]);
            // limpiar y re-insertar temas e indexaciones
            $pdo->prepare('DELETE FROM revista_tema WHERE id_revista = ?')->execute([$id]);
            $pdo->prepare('DELETE FROM revista_indexacion WHERE id_revista = ?')->execute([$id]);
        } else {
            //agregar: INSERT nueva revista
            $sql = 'INSERT INTO revistas (titulo_revista,id_tema,cuartil,idioma,costo,open_access,arbitrada,descripcion,enlace) VALUES (?,?,?,?,?,?,?,?,?)';
            $pdo->prepare($sql)->execute(array_values($datos));
            $id = (int)$pdo->lastInsertId();
        }

        // insertar temas adicionales
        $stmtT = $pdo->prepare('INSERT IGNORE INTO revista_tema (id_revista, id_tema) VALUES (?, ?)');
        foreach ((array)($_POST['temas'] ?? []) as $tid) {
            $stmtT->execute([$id, (int)$tid]);
        }
        // insertar indexaciones
        $stmtI = $pdo->prepare('INSERT IGNORE INTO revista_indexacion (id_revista, id_indexacion) VALUES (?, ?)');
        foreach ((array)($_POST['indexaciones'] ?? []) as $iid) {
            $stmtI->execute([$id, (int)$iid]);
        }

        header('Location: index.php?ruta=/revistas&ok=1');
        exit;
    }

    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            getDB()->prepare('DELETE FROM revistas WHERE id = ?')->execute([$id]);
        }
        header('Location: index.php?ruta=/revistas&del=1');
        exit;
    }
}
