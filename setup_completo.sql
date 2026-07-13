-- ============================================================
-- setup_completo.sql
-- estructura de la base de datos unificada
-- importar UNA vez en phpMyAdmin
-- ============================================================

-- tablas de catalogos
CREATE TABLE IF NOT EXISTS temas (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    tema  VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS indexaciones (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    indexacion VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- tabla principal de revistas
CREATE TABLE IF NOT EXISTS revistas (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    titulo_revista   VARCHAR(300) NOT NULL,
    id_tema          INT          NOT NULL,
    cuartil          ENUM('Q1','Q2','Q3','Q4','SIN ASIGNAR') NOT NULL DEFAULT 'SIN ASIGNAR',
    idioma           ENUM('Espanol','Ingles','Portugues','Frances','Otro') NOT NULL,
    costo            DECIMAL(10,2) NOT NULL DEFAULT 0,
    open_access      BOOLEAN NOT NULL DEFAULT FALSE,
    arbitrada        BOOLEAN NOT NULL DEFAULT FALSE,
    descripcion      TEXT NOT NULL,
    enlace           VARCHAR(2083) NOT NULL,
    FOREIGN KEY (id_tema) REFERENCES temas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- relacion muchos a muchos revista <-> temas
CREATE TABLE IF NOT EXISTS revista_tema (
    id_revista INT NOT NULL,
    id_tema    INT NOT NULL,
    PRIMARY KEY (id_revista, id_tema),
    FOREIGN KEY (id_revista) REFERENCES revistas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tema)    REFERENCES temas(id)    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- relacion muchos a muchos revista <-> indexaciones
CREATE TABLE IF NOT EXISTS revista_indexacion (
    id_revista    INT NOT NULL,
    id_indexacion INT NOT NULL,
    PRIMARY KEY (id_revista, id_indexacion),
    FOREIGN KEY (id_revista)    REFERENCES revistas(id)     ON DELETE CASCADE,
    FOREIGN KEY (id_indexacion) REFERENCES indexaciones(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- administrador (login unico)
CREATE TABLE IF NOT EXISTS administrador (
    nombre_usuario VARCHAR(20) PRIMARY KEY,
    contrasena     VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- usuario admin por defecto (cambiar contrasena antes de produccion)
INSERT IGNORE INTO administrador (nombre_usuario, contrasena)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- sugerencias y contacto
CREATE TABLE IF NOT EXISTS sugerencias (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    tipo_problema ENUM('Revista','Comentario','Problema') NOT NULL,
    nombre        VARCHAR(80)  NOT NULL,
    enlace        VARCHAR(200) DEFAULT '',
    detalles      TEXT         NOT NULL,
    fecha_envio   DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- vista para el directorio avanzado (facilita las consultas PHP)
CREATE OR REPLACE VIEW vista_revistas AS
SELECT
    r.id,
    r.titulo_revista,
    r.cuartil,
    r.idioma,
    r.costo,
    r.open_access,
    r.arbitrada,
    r.descripcion,
    r.enlace,
    t.tema AS tema_principal,
    GROUP_CONCAT(DISTINCT t2.tema ORDER BY t2.tema SEPARATOR ', ') AS todos_temas,
    GROUP_CONCAT(DISTINCT i.indexacion ORDER BY i.indexacion SEPARATOR ', ') AS indexaciones
FROM revistas r
LEFT JOIN temas t           ON t.id = r.id_tema
LEFT JOIN revista_tema rt   ON rt.id_revista = r.id
LEFT JOIN temas t2          ON t2.id = rt.id_tema
LEFT JOIN revista_indexacion ri ON ri.id_revista = r.id
LEFT JOIN indexaciones i    ON i.id = ri.id_indexacion
GROUP BY r.id;
