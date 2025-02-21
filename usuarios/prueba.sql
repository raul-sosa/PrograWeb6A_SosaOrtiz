DROP DATABASE IF EXISTS prueba;

CREATE DATABASE prueba;

USE prueba;

CREATE TABLE usuarios (
	id INT NOT NULL AUTO_INCREMENT,
	nombres VARCHAR(100) NOT NULL,
	apellidos VARCHAR(100) NOT NULL,
	usuario VARCHAR(100) NOT NULL,
	correo VARCHAR(100) NOT NULL,
	password VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
);


CREATE USER 'nuevo_usuario'@'localhost' IDENTIFIED BY 'nueva_contraseña';
GRANT ALL PRIVILEGES ON prueba.* TO 'nuevo_usuario'@'localhost';
FLUSH PRIVILEGES;