DROP PROCEDURE IF EXISTS sp_cursos;

DELIMITER $$

CREATE PROCEDURE sp_cursos(
    IN p_opcion INT,
    IN p_id_curso INT UNSIGNED,
    IN p_id_instructor INT UNSIGNED,
    IN p_id_usuario INT UNSIGNED,
    IN p_categoria VARCHAR(50),
    IN p_titulo VARCHAR(150),
    IN p_descripcion TEXT,
    IN p_costo DECIMAL(10,2),
    IN p_imagen VARCHAR(255)
)
BEGIN

    CASE p_opcion

        -- 1. Agregar curso
        WHEN 1 THEN

            INSERT INTO cursos (
                id_instructor,
                categoria,
                titulo,
                descripcion,
                costo,
                imagen
            )
            VALUES (
                p_id_instructor,
                p_categoria,
                p_titulo,
                p_descripcion,
                p_costo,
                p_imagen
            );

            SELECT
                LAST_INSERT_ID() AS id_curso,
                'Curso agregado correctamente.' AS mensaje;


        -- 2. Recuperar cursos recientes
        WHEN 2 THEN

            SELECT *
            FROM cursos
            ORDER BY fecha_creacion DESC, id_curso DESC
            LIMIT 10;


        -- 3. Recuperar cursos de un instructor
        WHEN 3 THEN

            SELECT *
            FROM cursos
            WHERE id_instructor = p_id_instructor
            ORDER BY fecha_creacion DESC;


        -- 4. Recuperar cursos comprados por un usuario
        WHEN 4 THEN

            SELECT c.*
            FROM cursos c
            INNER JOIN compras_cursos cc
                ON c.id_curso = cc.id_curso
            WHERE cc.id_usuario = p_id_usuario
            ORDER BY cc.fecha_compra DESC;


        -- 5. Recuperar detalle de un curso
        WHEN 5 THEN

            SELECT *
            FROM cursos
            WHERE id_curso = p_id_curso;

            SELECT *
            FROM niveles_curso
            WHERE id_curso = p_id_curso
            ORDER BY numero_nivel ASC;


        -- Opción inválida
        ELSE

            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Opcion no valida.';

    END CASE;

END $$

DELIMITER ;