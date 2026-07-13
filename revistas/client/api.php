<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../directorio-revistas/config/database.php';

try {
    $pdo  = getDB();
    $stmt = $pdo->query(
        'SELECT r.id, r.titulo_revista, r.cuartil, r.idioma, r.costo,
                r.open_access, r.descripcion, r.enlace,
                t.tema AS area,
                GROUP_CONCAT(DISTINCT i.indexacion ORDER BY i.indexacion SEPARATOR ", ") AS indexaciones
         FROM revistas r
         LEFT JOIN temas t ON t.id = r.id_tema
         LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
         LEFT JOIN indexaciones i ON i.id = ri.id_indexacion
         GROUP BY r.id
         ORDER BY FIELD(r.cuartil,"Q1","Q2","Q3","Q4","SIN ASIGNAR"), r.titulo_revista ASC'
    );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $revistas = array_map(fn($r) => [
        'Titulo'            => $r['titulo_revista'],
        'Area'              => $r['area'] ?? '',
        'Cuartil'           => $r['cuartil'] === 'SIN ASIGNAR' ? 'N/A' : $r['cuartil'],
        'Idiomas'           => $r['idioma'] ?? '',
        'Costo'             => $r['costo'] == 0 ? 'Gratuita' : '$'.number_format((float)$r['costo'],0).' USD',
        'Indexaciones'      => $r['indexaciones'] ?? '',
        'Puntuacion'        => 0,
        'NivelRecomendacion'=> 0,
        'Descripcion'       => $r['descripcion'] ?? '',
        'Url'               => $r['enlace'] ?? '',
    ], $rows);

    echo json_encode($revistas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
