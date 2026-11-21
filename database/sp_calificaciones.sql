DROP PROCEDURE IF EXISTS sp_calificaciones;

DELIMITER //

CREATE PROCEDURE sp_calificaciones(
    IN p_opcion INT,
    IN p_id_usuario INT UNSIGNED,
    IN p_id_curso INT UNSIGNED,
    IN p_calificacion TINYINT UNSIGNED
)
BEGIN

    CASE p_opcion

        -- 1. REGISTRAR CALIFICACION
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

            IF p_calificacion < 1 OR p_calificacion > 5 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'La calificacion debe estar entre 1 y 5.';
            END IF;

            INSERT INTO calificaciones (
                id_usuario,
                id_curso,
                calificacion
            )
            VALUES (
                p_id_usuario,
                p_id_curso,
                p_calificacion
            );

            SELECT
                'Calificacion registrada correctamente.' AS mensaje,
                LAST_INSERT_ID() AS id_calificacion;


        -- 2. CONSULTAR PROMEDIO DEL CURSO
        WHEN 2 THEN

            SELECT
                p_id_curso AS id_curso,
                COALESCE(ROUND(AVG(calificacion), 2), 0) AS promedio,
                COUNT(*) AS total_calificaciones

            FROM calificaciones

            WHERE id_curso = p_id_curso;


        ELSE

            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Opcion no valida.';

    END CASE;

END //

DELIMITER ;