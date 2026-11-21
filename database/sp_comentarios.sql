
DROP PROCEDURE IF EXISTS sp_comentarios;

DELIMITER //

CREATE PROCEDURE sp_comentarios(
    IN p_opcion INT,
    IN p_id_comentario INT UNSIGNED,
    IN p_id_usuario INT UNSIGNED,
    IN p_id_curso INT UNSIGNED,
    IN p_comentario TEXT
)
BEGIN

    CASE p_opcion

        -- 1. REGISTRAR COMENTARIO
        WHEN 1 THEN

            IF NOT EXISTS (
                SELECT 1
                FROM inscripciones_cursos
                WHERE id_usuario = p_id_usuario
                AND id_curso = p_id_curso
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El usuario no esta inscrito en este curso.';
            END IF;

            INSERT INTO comentarios (
                id_usuario,
                id_curso,
                comentario
            )
            VALUES (
                p_id_usuario,
                p_id_curso,
                p_comentario
            );

            SELECT
                'Comentario registrado correctamente.' AS mensaje,
                LAST_INSERT_ID() AS id_comentario;


        -- 2. CONSULTAR COMENTARIOS DE UN CURSO
        WHEN 2 THEN

            SELECT
                c.id_comentario,
                c.id_usuario,
                u.nombre,
                u.apellido,
                CONCAT_WS(' ', u.nombre, u.apellido) AS nombre_usuario,
                u.imagen_perfil,
                c.id_curso,

                CASE
                    WHEN c.eliminado = 1
                    THEN 'Este comentario fue eliminado'
                    ELSE c.comentario
                END AS comentario,

                c.fecha_comentario,
                c.eliminado

            FROM comentarios c

            INNER JOIN usuarios u
                ON c.id_usuario = u.id_usuario

            WHERE c.id_curso = p_id_curso

            ORDER BY c.fecha_comentario DESC;


        -- 3. ELIMINAR COMENTARIO LOGICAMENTE
        WHEN 3 THEN

            UPDATE comentarios
            SET eliminado = 1
            WHERE id_comentario = p_id_comentario
            AND eliminado = 0;

            IF ROW_COUNT() = 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Comentario no encontrado o ya eliminado.';
            END IF;

            SELECT
                'Comentario eliminado correctamente.' AS mensaje;


        ELSE

            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Opcion no valida.';

    END CASE;

END //

DELIMITER ;

