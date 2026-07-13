<?php

class Revista {

    // traduciones ES<->EN para la interfaz
    public static array $textos = [
        'es' => [
            'buscar'          => 'buscar',
            'buscar_placeholder' => 'nombre de revista, area, editorial...',
            'directorio'      => 'directorio de revistas cientificas',
            'sub_hero'        => 'busca revistas verificadas por area, cuartil, costo e indexaciones',
            'destacadas'      => 'revistas destacadas',
            'sin_revistas'    => 'sin revistas disponibles aun.',
            'cuartil'         => 'cuartil',
            'costo'           => 'costo de publicacion',
            'gratuita'        => 'gratuita',
            'con_apc'         => 'con APC',
            'mixta'           => 'mixta',
            'indexaciones'    => 'indexaciones',
            'en_espanol'      => 'acepta en espanol',
            'si'              => 'si',
            'no'              => 'no',
            'sin_cuartil'     => 'sin cuartil',
            'resultados'      => 'revistas encontradas',
            'ordenar'         => 'ordenar:',
            'ord_cuartil'     => 'cuartil Q1 primero',
            'ord_nombre'      => 'nombre A-Z',
            'ord_costo'       => 'menor costo',
            'ord_recientes'   => 'mas recientes',
            'indexada_en'     => 'indexada en',
            'rec_estudiantes' => 'recomendada estudiantes',
            'visitar'         => 'visitar sitio oficial',
            'volver'          => 'volver',
            'area'            => 'area / especialidad',
            'idioma'          => 'idioma',
            'open_access'     => 'acceso abierto',
            'arbitrada'       => 'arbitrada',
            'sin_resultados'  => 'sin resultados para esta busqueda.',
            'buscar_nav'      => 'buscar',
            'acerca_nav'      => 'acerca de',
            'colab_nav'       => 'colaboradores',
            'menu_nav'        => 'menu',
            'idioma_btn'      => 'English',
        ],
        'en' => [
            'buscar'          => 'search',
            'buscar_placeholder' => 'journal name, area, publisher...',
            'directorio'      => 'scientific journals directory',
            'sub_hero'        => 'find verified journals by area, quartile, cost and indexing',
            'destacadas'      => 'featured journals',
            'sin_revistas'    => 'no journals available yet.',
            'cuartil'         => 'quartile',
            'costo'           => 'publication cost',
            'gratuita'        => 'free',
            'con_apc'         => 'with APC',
            'mixta'           => 'hybrid',
            'indexaciones'    => 'indexing',
            'en_espanol'      => 'accepts in spanish',
            'si'              => 'yes',
            'no'              => 'no',
            'sin_cuartil'     => 'no quartile',
            'resultados'      => 'journals found',
            'ordenar'         => 'sort by:',
            'ord_cuartil'     => 'quartile Q1 first',
            'ord_nombre'      => 'name A-Z',
            'ord_costo'       => 'lowest cost',
            'ord_recientes'   => 'most recent',
            'indexada_en'     => 'indexed in',
            'rec_estudiantes' => 'recommended for students',
            'visitar'         => 'visit official site',
            'volver'          => 'back',
            'area'            => 'area / specialty',
            'idioma'          => 'language',
            'open_access'     => 'open access',
            'arbitrada'       => 'peer reviewed',
            'sin_resultados'  => 'no results for this search.',
            'buscar_nav'      => 'search',
            'acerca_nav'      => 'about',
            'colab_nav'       => 'collaborators',
            'menu_nav'        => 'menu',
            'idioma_btn'      => 'Español',
        ],
    ];

    // obtener idioma activo desde sesion o GET
    public static function idioma(): string {
        if (!session_id()) session_start();
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['es','en'])) {
            $_SESSION['lang'] = $_GET['lang'];
        }
        return $_SESSION['lang'] ?? 'es';
    }

    // textos del idioma activo
    public static function t(string $clave): string {
        $lang = self::idioma();
        return self::$textos[$lang][$clave] ?? $clave;
    }

    // mapeo de temas: ingles -> espanol para la vista
    public static array $temasES = [
        'Agricultural and Biological Sciences'         => 'Ciencias Agricolas y Biologicas',
        'Arts and Humanities'                          => 'Artes y Humanidades',
        'Biochemistry, Genetics and Molecular Biology' => 'Bioquimica, Genetica y Biologia Molecular',
        'Business, Management and Accounting'          => 'Administracion, Negocios y Contabilidad',
        'Chemical Engineering'                         => 'Ingenieria Quimica',
        'Chemistry'                                    => 'Quimica',
        'Computer Science'                             => 'Ciencias de la Computacion',
        'Decision Sciences'                            => 'Ciencias de la Decision',
        'Dentistry'                                    => 'Odontologia',
        'Earth and Planetary Sciences'                 => 'Ciencias de la Tierra y Planetarias',
        'Economics, Econometrics and Finance'          => 'Economia, Econometria y Finanzas',
        'Energy'                                       => 'Energia',
        'Engineering'                                  => 'Ingenieria',
        'Environmental Science'                        => 'Ciencias Ambientales',
        'Health Professions'                           => 'Profesiones de la Salud',
        'Immunology and Microbiology'                  => 'Inmunologia y Microbiologia',
        'Materials Science'                            => 'Ciencia de Materiales',
        'Mathematics'                                  => 'Matematicas',
        'Medicine'                                     => 'Medicina',
        'Multidisciplinary'                            => 'Multidisciplinaria',
        'Neuroscience'                                 => 'Neurociencias',
        'Nursing'                                      => 'Enfermeria',
        'Pharmacology, Toxicology and Pharmaceutics'   => 'Farmacologia, Toxicologia y Ciencias Farmaceuticas',
        'Physics and Astronomy'                        => 'Fisica y Astronomia',
        'Psychology'                                   => 'Psicologia',
        'Social Sciences'                              => 'Ciencias Sociales',
        'Veterinary'                                   => 'Medicina Veterinaria',
    ];

    // traducir tema al idioma activo
    public static function traducirTema(string $temaEN): string {
        if (self::idioma() === 'en') return $temaEN;
        return self::$temasES[$temaEN] ?? $temaEN;
    }

    //consultar: revistas recientes/destacadas para el home (las primeras 6)
    public static function destacadas(PDO $pdo): array {
        $stmt = $pdo->query(
            'SELECT r.*, t.tema AS tema_principal,
             GROUP_CONCAT(DISTINCT t2.tema ORDER BY t2.tema SEPARATOR ", ") AS todos_temas,
             GROUP_CONCAT(DISTINCT i.indexacion ORDER BY i.indexacion SEPARATOR ", ") AS indexaciones_lista
             FROM revistas r
             LEFT JOIN temas t           ON t.id  = r.id_tema
             LEFT JOIN revista_tema rt   ON rt.id_revista = r.id
             LEFT JOIN temas t2          ON t2.id = rt.id_tema
             LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
             LEFT JOIN indexaciones i    ON i.id  = ri.id_indexacion
             WHERE r.open_access = 1
             GROUP BY r.id
             ORDER BY FIELD(r.cuartil,"Q1","Q2","Q3","Q4","SIN ASIGNAR"), r.titulo_revista ASC
             LIMIT 6'
        );
        return $stmt->fetchAll();
    }

    //consultar: revistas con filtros y paginacion
    public static function obtenerTodas(PDO $pdo, array $filtros = [], int $pagina = 1): array {
        [$where, $params, $having] = self::construirWhere($filtros);
        $offset = ($pagina - 1) * ITEMS_POR_PAGINA;
        $orden  = self::orden($filtros['orden'] ?? 'cuartil');
        $sql = "SELECT r.*, t.tema AS tema_principal,
                GROUP_CONCAT(DISTINCT t2.tema ORDER BY t2.tema SEPARATOR ', ') AS todos_temas,
                GROUP_CONCAT(DISTINCT i.indexacion ORDER BY i.indexacion SEPARATOR ', ') AS indexaciones_lista
                FROM revistas r
                LEFT JOIN temas t           ON t.id  = r.id_tema
                LEFT JOIN revista_tema rt   ON rt.id_revista = r.id
                LEFT JOIN temas t2          ON t2.id = rt.id_tema
                LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
                LEFT JOIN indexaciones i    ON i.id  = ri.id_indexacion
                $where
                GROUP BY r.id
                $having
                ORDER BY $orden
                LIMIT " . ITEMS_POR_PAGINA . " OFFSET $offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    //consultar: total de revistas para paginacion
    public static function contar(PDO $pdo, array $filtros = []): int {
        [$where, $params, $having] = self::construirWhere($filtros);
        $sql = "SELECT COUNT(*) FROM (
                    SELECT r.id
                    FROM revistas r
                    LEFT JOIN temas t           ON t.id  = r.id_tema
                    LEFT JOIN revista_tema rt   ON rt.id_revista = r.id
                    LEFT JOIN temas t2          ON t2.id = rt.id_tema
                    LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
                    LEFT JOIN indexaciones i    ON i.id  = ri.id_indexacion
                    $where GROUP BY r.id $having
                ) sub";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    //consultar: una revista por id con todos sus datos
    public static function obtenerPorId(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare(
            'SELECT r.*, t.tema AS tema_principal,
             GROUP_CONCAT(DISTINCT t2.tema ORDER BY t2.tema SEPARATOR ", ") AS todos_temas,
             GROUP_CONCAT(DISTINCT i.indexacion ORDER BY i.indexacion SEPARATOR ", ") AS indexaciones_lista
             FROM revistas r
             LEFT JOIN temas t           ON t.id  = r.id_tema
             LEFT JOIN revista_tema rt   ON rt.id_revista = r.id
             LEFT JOIN temas t2          ON t2.id = rt.id_tema
             LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
             LEFT JOIN indexaciones i    ON i.id  = ri.id_indexacion
             WHERE r.id = ?
             GROUP BY r.id'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    //consultar: conteos para el sidebar de filtros
    public static function conteos(PDO $pdo): array {
        $c = ['cuartil' => [], 'costo' => [], 'open_access' => [], 'espanol' => 0];
        foreach ($pdo->query("SELECT cuartil, COUNT(*) n FROM revistas GROUP BY cuartil")->fetchAll() as $r) {
            $c['cuartil'][$r['cuartil']] = $r['n'];
        }
        // gratuitas: costo = 0
        $c['costo']['gratuita'] = $pdo->query("SELECT COUNT(*) FROM revistas WHERE costo = 0")->fetchColumn();
        $c['costo']['pago']     = $pdo->query("SELECT COUNT(*) FROM revistas WHERE costo > 0")->fetchColumn();
        $c['open_access'][1]    = $pdo->query("SELECT COUNT(*) FROM revistas WHERE open_access = 1")->fetchColumn();
        $c['espanol']           = $pdo->query("SELECT COUNT(*) FROM revistas WHERE idioma IN ('Espanol','Otro')")->fetchColumn();
        return $c;
    }

    //consultar: lista de temas para el sidebar
    public static function temas(PDO $pdo): array {
        return $pdo->query("SELECT t.tema, COUNT(r.id) n FROM temas t LEFT JOIN revistas r ON r.id_tema = t.id GROUP BY t.id ORDER BY t.tema ASC")->fetchAll();
    }

    //construir: WHERE y HAVING dinamicos
    private static function construirWhere(array $filtros): array {
        $where  = [];
        $having = [];
        $params = [];

        if (!empty($filtros['q'])) {
            $like     = '%' . $filtros['q'] . '%';
            $where[]  = '(r.titulo_revista LIKE ? OR r.descripcion LIKE ? OR t.tema LIKE ?)';
            $params   = array_merge($params, [$like, $like, $like]);
        }
        if (!empty($filtros['cuartil'])) {
            $ph      = implode(',', array_fill(0, count($filtros['cuartil']), '?'));
            $where[] = "r.cuartil IN ($ph)";
            $params  = array_merge($params, $filtros['cuartil']);
        }
        if (!empty($filtros['costo'])) {
            if ($filtros['costo'] === 'gratuita') { $where[] = 'r.costo = 0'; }
            elseif ($filtros['costo'] === 'pago')  { $where[] = 'r.costo > 0'; }
        }
        if (!empty($filtros['open_access'])) {
            $where[] = 'r.open_access = 1';
        }
        if (!empty($filtros['espanol'])) {
            $where[] = "r.idioma IN ('Espanol','Otro')";
        }
        if (!empty($filtros['indexacion'])) {
            $having[] = "indexaciones_lista LIKE ?";
            $params[] = '%' . $filtros['indexacion'] . '%';
        }
        if (!empty($filtros['tema'])) {
            $having[] = "todos_temas LIKE ?";
            $params[] = '%' . $filtros['tema'] . '%';
        }

        $whereSql  = $where  ? 'WHERE '  . implode(' AND ', $where)  : '';
        $havingSql = $having ? 'HAVING ' . implode(' AND ', $having) : '';
        return [$whereSql, $params, $havingSql];
    }

    private static function orden(string $op): string {
        return match($op) {
            'nombre'    => 'r.titulo_revista ASC',
            'costo'     => 'r.costo ASC, r.titulo_revista ASC',
            'recientes' => 'r.id DESC',
            default     => "FIELD(r.cuartil,'Q1','Q2','Q3','Q4','SIN ASIGNAR'), r.titulo_revista ASC",
        };
    }
}
