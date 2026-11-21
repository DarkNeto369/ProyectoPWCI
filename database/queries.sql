-- DROP DATABASE proyectopwci;

USE proyectopwci;

SELECT * FROM usuarios;
SELECT * FROM cursos;
SELECT * FROM niveles_curso;
SELECT * FROM inscripciones_cursos;
SELECT * FROM pagos_cursos;

SELECT
    id_curso,
    titulo,
    id_instructor
FROM cursos
WHERE id_curso = 5;


USE proyectopwci;

INSERT INTO usuarios (
    imagen_perfil,
    nombre,
    apellido,
    rol,
    correo,
    contra
)
VALUES (
    NULL,
    'Administrador',
    'Principal',
    'administrador',
    'admin@proyectopwci.com',
    '$2y$10$foCHqW9EQmAOE8LeXkq9k.X3n5kczYehgPgS6JnqdJQDvCyweNL6e'
);

USE proyectopwci;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE progreso_niveles;
TRUNCATE TABLE mensajes;
TRUNCATE TABLE comentarios;
TRUNCATE TABLE calificaciones;
TRUNCATE TABLE pagos_cursos;
TRUNCATE TABLE inscripciones_cursos;
TRUNCATE TABLE niveles_curso;
TRUNCATE TABLE intentos_login;
TRUNCATE TABLE cursos;
TRUNCATE TABLE usuarios;

SET FOREIGN_KEY_CHECKS = 1;