CREATE DATABASE revistas;

USE revistas;
	CREATE TABLE temas(
		id INT PRIMARY KEY AUTO_INCREMENT,
		tema VARCHAR(100) NOT NULL UNIQUE
	);

	CREATE TABLE revistas(
		id INT PRIMARY KEY AUTO_INCREMENT, 
		titulo_revista VARCHAR(100) NOT NULL,
		id_tema INT NOT NULL,
		cuartil ENUM('Q1','Q2','Q3','Q4') NOT NULL,
		idioma ENUM('Español','Inglés','Portugués','Francés','Otro') NOT NULL,
		costo DECIMAL(10,2) NOT NULL DEFAULT 0,
		open_access BOOLEAN NOT NULL DEFAULT FALSE,
		arbitrada BOOLEAN NOT NULL DEFAULT FALSE,
		descripicion TEXT NOT NULL,
		enlace VARCHAR(2083) NOT NULL,
	);
	
	CREATE TABLE revista_tema(
		id_revista INT, 
		id_tema INT,
		PRIMARY KEY(id_revista, id_tema),
		FOREIGN KEY (id_revista) REFERENCES revistas(id) ON DELETE CASCADE,
		FOREIGN KEY (id_tema) REFERENCES temas(id) ON DELETE CASCADE
	)

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

		CREATE TABLE administrador(
		nombre_usuario VARCHAR(20) PRIMARY KEY, 
		contrasena VARCHAR(255) NOT NULL 
	);
	

	CREATE TABLE sugerencias(
		id INT PRIMARY KEY AUTO_INCREMENT, 
		tipo_problema ENUM('Revista','Comentario', 'Problema'),
		nombre VARCHAR(80) NOT NULL, 
		enlace VARCHAR(200) default '',
		detalles TEXT NOT NULL,
		fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
	);	