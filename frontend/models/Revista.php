<?php

class Revista {

    //consultar: revistas con confiabilidad 5 para seccion destacadas
    public static function destacadas(PDO $pdo): array {
        $stmt = $pdo->prepare('SELECT * FROM revistas WHERE confiabilidad = 5 ORDER BY nombre ASC LIMIT 6');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //consultar: revistas con filtros y paginacion desde tabla revistas
    public static function obtenerTodas(PDO $pdo, array $filtros = [], int $pagina = 1): array {
        [$where, $params] = self::construirWhere($filtros);
        $offset = ($pagina - 1) * ITEMS_POR_PAGINA;
        $orden  = self::orden($filtros['orden'] ?? 'confiabilidad');
        $sql    = "SELECT * FROM revistas $where ORDER BY $orden LIMIT " . ITEMS_POR_PAGINA . " OFFSET $offset";
        $stmt   = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    //consultar: total de revistas para calcular paginas
    public static function contar(PDO $pdo, array $filtros = []): int {
        [$where, $params] = self::construirWhere($filtros);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM revistas $where");
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    //consultar: una revista por id desde tabla revistas
    public static function obtenerPorId(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare('SELECT * FROM revistas WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    //agregar: insertar nueva revista en tabla revistas
    public static function crear(PDO $pdo, array $datos): int {
        $sql = 'INSERT INTO revistas (nombre, area, pais, cuartil_sjr, apc_tipo, apc_descripcion,
                indexaciones, editorial, idiomas, tipos_articulos, acceso,
                confiabilidad, recomendada_estudiantes, descripcion, sitio_web)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $pdo->prepare($sql)->execute([
            $datos['nombre']                  ?? '',
            $datos['area']                    ?? '',
            $datos['pais']                    ?? '',
            $datos['cuartil_sjr']             ?? 'S/D',
            $datos['apc_tipo']                ?? 'gratuita',
            $datos['apc_descripcion']         ?? '',
            $datos['indexaciones']            ?? '',
            $datos['editorial']               ?? '',
            $datos['idiomas']                 ?? '',
            $datos['tipos_articulos']         ?? '',
            $datos['acceso']                  ?? 'abierto',
            $datos['confiabilidad']           ?? null,
            $datos['recomendada_estudiantes'] ?? null,
            $datos['descripcion']             ?? '',
            $datos['sitio_web']               ?? '',
        ]);
        return (int)$pdo->lastInsertId();
    }

    //eliminar: borrar revista por id de tabla revistas
    public static function eliminar(PDO $pdo, int $id): void {
        $pdo->prepare('DELETE FROM revistas WHERE id = ?')->execute([$id]);
    }

    //consultar: conteos reales por cuartil, apc y estrellas para el sidebar
    public static function conteos(PDO $pdo): array {
        $c = ['cuartil' => [], 'apc_tipo' => [], 'confiabilidad' => [], 'recomendada' => [], 'espanol' => 0];

        foreach ($pdo->query("SELECT cuartil_sjr, COUNT(*) as n FROM revistas GROUP BY cuartil_sjr")->fetchAll() as $r) {
            $c['cuartil'][$r['cuartil_sjr']] = $r['n'];
        }
        foreach ($pdo->query("SELECT apc_tipo, COUNT(*) as n FROM revistas GROUP BY apc_tipo")->fetchAll() as $r) {
            $c['apc_tipo'][$r['apc_tipo']] = $r['n'];
        }
        foreach ([5, 4, 3] as $n) {
            $c['confiabilidad'][$n] = $pdo->query("SELECT COUNT(*) FROM revistas WHERE confiabilidad >= $n")->fetchColumn();
            $c['recomendada'][$n]   = $pdo->query("SELECT COUNT(*) FROM revistas WHERE recomendada_estudiantes >= $n")->fetchColumn();
        }
        $c['espanol'] = $pdo->query("SELECT COUNT(*) FROM revistas WHERE idiomas LIKE '%spanol%'")->fetchColumn();

        return $c;
    }

    //construir: clausula WHERE dinamica segun filtros activos
    private static function construirWhere(array $filtros): array {
        $where  = [];
        $params = [];

        if (!empty($filtros['q'])) {
            $where[]  = '(nombre LIKE ? OR area LIKE ? OR indexaciones LIKE ? OR editorial LIKE ?)';
            $like     = '%' . $filtros['q'] . '%';
            $params   = array_merge($params, [$like, $like, $like, $like]);
        }
        if (!empty($filtros['cuartil'])) {
            $ph      = implode(',', array_fill(0, count($filtros['cuartil']), '?'));
            $where[] = "cuartil_sjr IN ($ph)";
            $params  = array_merge($params, $filtros['cuartil']);
        }
        if (!empty($filtros['apc_tipo'])) {
            $ph      = implode(',', array_fill(0, count($filtros['apc_tipo']), '?'));
            $where[] = "apc_tipo IN ($ph)";
            $params  = array_merge($params, $filtros['apc_tipo']);
        }
        if (!empty($filtros['indexaciones'])) {
            $partes = [];
            foreach ($filtros['indexaciones'] as $idx) {
                $partes[] = 'indexaciones LIKE ?';
                $params[] = '%' . $idx . '%';
            }
            $where[] = '(' . implode(' OR ', $partes) . ')';
        }
        if (!empty($filtros['espanol'])) {
            $where[]  = "idiomas LIKE ?";
            $params[] = '%spanol%';
        }
        if (!empty($filtros['confiabilidad'])) {
            $where[]  = 'confiabilidad >= ?';
            $params[] = (int)$filtros['confiabilidad'];
        }
        if (!empty($filtros['recomendada'])) {
            $where[]  = 'recomendada_estudiantes >= ?';
            $params[] = (int)$filtros['recomendada'];
        }

        $sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        return [$sql, $params];
    }

    //construir: clausula ORDER BY segun opcion seleccionada
    private static function orden(string $opcion): string {
        return match($opcion) {
            'cuartil'     => "FIELD(cuartil_sjr,'Q1','Q2','Q3','Q4','S/D'), nombre ASC",
            'nombre'      => 'nombre ASC',
            'recomendada' => 'recomendada_estudiantes DESC, nombre ASC',
            'recientes'   => 'fecha_registro DESC',
            default       => 'confiabilidad DESC, nombre ASC',
        };
    }
}