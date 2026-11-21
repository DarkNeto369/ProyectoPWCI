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

CREATE TABLE inscripciones_cursos (
    id_inscripcion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    id_curso INT UNSIGNED NOT NULL,

    fecha_inscripcion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultima_fecha_acceso DATETIME NULL,
    fecha_terminacion DATETIME NULL,

    niveles_completados TINYINT UNSIGNED NOT NULL DEFAULT 0,
    progreso DECIMAL(5,2) NOT NULL DEFAULT 0.00,

    estado ENUM('incompleto', 'completo')
        NOT NULL DEFAULT 'incompleto',

    CONSTRAINT fk_inscripciones_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_inscripciones_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT uq_usuario_curso
        UNIQUE (id_usuario, id_curso)
);

CREATE TABLE progreso_niveles (
    id_progreso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_inscripcion INT UNSIGNED NOT NULL,
    id_nivel INT UNSIGNED NOT NULL,
    fecha_completado DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_progreso_inscripcion
        FOREIGN KEY (id_inscripcion)
        REFERENCES inscripciones_cursos(id_inscripcion)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_progreso_nivel
        FOREIGN KEY (id_nivel)
        REFERENCES niveles_curso(id_nivel)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT uq_inscripcion_nivel
        UNIQUE (id_inscripcion, id_nivel)
);

CREATE TABLE mensajes (
    id_mensaje INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_curso INT UNSIGNED NOT NULL,
    id_remitente INT UNSIGNED NOT NULL,
    id_destinatario INT UNSIGNED NOT NULL,
    contenido TEXT NOT NULL,
    fecha_envio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_mensajes_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_mensajes_remitente
        FOREIGN KEY (id_remitente)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_mensajes_destinatario
        FOREIGN KEY (id_destinatario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    INDEX idx_mensajes_conversacion (
        id_curso,
        id_remitente,
        id_destinatario,
        fecha_envio
    )
);

CREATE TABLE comentarios (
    id_comentario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    id_curso INT UNSIGNED NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    eliminado TINYINT(1) NOT NULL DEFAULT 0,

    CONSTRAINT fk_comentario_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_comentario_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE calificaciones (
    id_calificacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    id_curso INT UNSIGNED NOT NULL,
    calificacion TINYINT UNSIGNED NOT NULL,
    fecha_calificacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_calificacion_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_calificacion_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT uq_calificacion
        UNIQUE (id_usuario, id_curso),

    CONSTRAINT chk_calificacion
        CHECK (calificacion BETWEEN 1 AND 5)
);

CREATE TABLE pagos_cursos (
    id_pago INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    id_curso INT UNSIGNED NOT NULL,
    id_instructor INT UNSIGNED NULL,

    id_orden_paypal VARCHAR(100) NOT NULL UNIQUE,
    id_captura_paypal VARCHAR(100) NULL,

    monto DECIMAL(10,2) NOT NULL,
    moneda VARCHAR(3) NOT NULL DEFAULT 'MXN',
    forma_pago VARCHAR(30) NOT NULL DEFAULT 'PayPal',

    estado ENUM('pendiente', 'completado', 'cancelado')
        NOT NULL DEFAULT 'pendiente',

    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_pago DATETIME NULL,

    CONSTRAINT fk_pagos_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_pagos_curso
        FOREIGN KEY (id_curso)
        REFERENCES cursos(id_curso)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_pagos_instructor
        FOREIGN KEY (id_instructor)
        REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);