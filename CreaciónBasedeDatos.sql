USE revistas;

	CREATE TABLE revistas(
		id INT PRIMARY KEY AUTO_INCREMENT,
		titulo_revista VARCHAR(100) NOT NULL, 
		tema ENUM('Tecnología', 'Educación','Multidisciplinaria','Salud') NOT NULL,
		cuartil ENUM('Q1','Q2','Q3','Q4', 'SIN ASIGNAR') DEFAULT 'SIN ASIGNAR',
		idioma ENUM('Español', 'Inglés', 'Portugués', 'Francés', 'Otro') NOT NULL,
		costo DECIMAL(10,2) DEFAULT 0,
		puntuacion TINYINT UNSIGNED NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
		nivel_recomendacion TINYINT UNSIGNED NOT NULL CHECK (nivel_recomendacion BETWEEN 1 AND 5),
		descripcion TEXT NOT NULL, 
		enlace VARCHAR(2083)
	);
	
	CREATE TABLE indexaciones(
		id INT PRIMARY KEY AUTO_INCREMENT,
		indexacion VARCHAR(100) NOT NULL
	);
	
	CREATE TABLE revista_indexacion(
		id_revista INT, 
		id_indexacion INT,
		PRIMARY KEY(id_revista, id_indexacion),
		FOREIGN KEY (id_revista) REFERENCES revistas(id) ON DELETE CASCADE,
		FOREIGN KEY (id_indexacion) REFERENCES indexaciones(id) ON DELETE CASCADE 
	);
