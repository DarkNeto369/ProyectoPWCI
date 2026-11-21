DROP PROCEDURE IF EXISTS sp_progreso_niveles;

DELIMITER $$

CREATE PROCEDURE sp_progreso_niveles(
    IN p_opcion INT,
    IN p_id_inscripcion INT,
    IN p_id_usuario INT,
    IN p_id_nivel INT
)
BEGIN

    DECLARE v_id_curso INT UNSIGNED;
    DECLARE v_total INT DEFAULT 0;
    DECLARE v_completados INT DEFAULT 0;
    DECLARE v_existe INT DEFAULT 0;

    CASE p_opcion

        -- 1. Marcar un nivel como completado
        WHEN 1 THEN

            SELECT COUNT(*)
            INTO v_existe
            FROM inscripciones_cursos
            WHERE id_inscripcion = p_id_inscripcion
              AND id_usuario = p_id_usuario;

            IF v_existe = 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Inscripcion no encontrada.';
            END IF;

            SELECT id_curso
            INTO v_id_curso
            FROM inscripciones_cursos
            WHERE id_inscripcion = p_id_inscripcion
              AND id_usuario = p_id_usuario;

            SELECT COUNT(*)
            INTO v_existe
            FROM niveles_curso
            WHERE id_nivel = p_id_nivel
              AND id_curso = v_id_curso;

            IF v_existe = 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El nivel no pertenece a este curso.';
            END IF;

            INSERT IGNORE INTO progreso_niveles (
                id_inscripcion,
                id_nivel
            )
            VALUES (
                p_id_inscripcion,
                p_id_nivel
            );

            SELECT COUNT(*)
            INTO v_total
            FROM niveles_curso
            WHERE id_curso = v_id_curso;

            SELECT COUNT(*)
            INTO v_completados
            FROM progreso_niveles
            WHERE id_inscripcion = p_id_inscripcion;

            UPDATE inscripciones_cursos
            SET
                niveles_completados = v_completados,
                progreso = CASE
                    WHEN v_total > 0
                    THEN ROUND((v_completados / v_total) * 100, 2)
                    ELSE 0
                END,
                estado = CASE
                    WHEN v_total > 0 AND v_completados >= v_total
                    THEN 'completo'
                    ELSE 'incompleto'
                END,
                fecha_terminacion = CASE
                    WHEN v_total > 0 AND v_completados >= v_total
                    THEN COALESCE(fecha_terminacion, CURRENT_TIMESTAMP)
                    ELSE NULL
                END,
                ultima_fecha_acceso = CURRENT_TIMESTAMP
            WHERE id_inscripcion = p_id_inscripcion;

            SELECT
                'Nivel marcado como completado.' AS mensaje,
                v_completados AS niveles_completados,
                v_total AS total_niveles;

        -- 2. Consultar los niveles y su estado
        WHEN 2 THEN

            SELECT
                n.id_nivel,
                n.numero_nivel,
                n.nombre,
                n.video,
                CASE
                    WHEN pn.id_progreso IS NOT NULL THEN 1
                    ELSE 0
                END AS completado
            FROM inscripciones_cursos i
            INNER JOIN niveles_curso n
                ON n.id_curso = i.id_curso
            LEFT JOIN progreso_niveles pn
                ON pn.id_nivel = n.id_nivel
                AND pn.id_inscripcion = i.id_inscripcion
            WHERE i.id_inscripcion = p_id_inscripcion
              AND i.id_usuario = p_id_usuario
            ORDER BY n.numero_nivel ASC;

        ELSE

            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Opcion no valida.';

    END CASE;

END$$

DELIMITER ;