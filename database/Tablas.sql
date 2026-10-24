CREATE DATABASE IF NOT EXISTS proyectopwci;

USE proyectopwci;

CREATE TABLE IF NOT EXISTS usuarios (

    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    imagen_perfil VARCHAR(255) NULL,    
    nombre VARCHAR(100) NULL,
    apellido VARCHAR(100) NULL,
    genero ENUM('Hombre', 'Mujer', 'Otro') NULL,
    fecha_nacimiento DATE NULL,
    rol ENUM('administrador', 'estudiante', 'instructor') NULL,
    correo VARCHAR(254) NOT NULL UNIQUE,
    contra VARCHAR(255) NOT NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo'

);

CREATE TABLE IF NOT EXISTS intentos_login (
    id_intento INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    intentos_fallidos TINYINT UNSIGNED NOT NULL DEFAULT 0,
    bloqueado TINYINT(1) NOT NULL DEFAULT 0,
    fecha_ultimo_intento DATETIME NULL,

    CONSTRAINT fk_intentos_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE,

    CONSTRAINT uq_intentos_usuario
        UNIQUE (id_usuario)
);

CREATE TABLE cursos (
    id_curso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_instructor INT UNSIGNED NULL,
    categoria VARCHAR(50) NULL,
    titulo VARCHAR(150) NULL,
    descripcion TEXT NULL,
    costo DECIMAL(10,2) NULL,
    imagen VARCHAR(255) NULL,
    fecha_creacion DATETIME NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_cursos_instructor
        FOREIGN KEY (id_instructor)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

CREATE TABLE niveles_curso (
    id_nivel INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_curso INT UNSIGNED NULL,
    numero_nivel TINYINT UNSIGNED NULL,
    nombre VARCHAR(150) NULL,
    video VARCHAR(255) NULL,

    CONSTRAINT fk_niveles_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);