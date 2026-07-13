-- seed.sql — datos de muestra para desarrollo local
-- para produccion usar: setup_completo.sql + ScriptInsercionDatos.sql

-- importar setup_completo.sql primero, luego este archivo
-- solo si quieres datos de prueba rapidos en local

INSERT IGNORE INTO temas (tema) VALUES
('Medicine'),('Nursing'),('Psychology'),('Public Health');

INSERT IGNORE INTO indexaciones (indexacion) VALUES
('Scopus'),('PubMed/MEDLINE'),('Web of Science'),('SciELO'),('DOAJ'),('Latindex');

INSERT IGNORE INTO administrador (nombre_usuario, contrasena) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- contrasena por defecto: password
-- CAMBIAR antes de subir a produccion con:
-- echo password_hash('tu_contrasena', PASSWORD_BCRYPT);
