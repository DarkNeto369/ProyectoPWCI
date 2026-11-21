DROP PROCEDURE IF EXISTS sp_inscripciones;

DELIMITER //

CREATE PROCEDURE sp_inscripciones(
    IN p_opcion INT,
    IN p_id_inscripcion INT UNSIGNED,
    IN p_id_usuario INT UNSIGNED,
    IN p_id_curso INT UNSIGNED,
    IN p_niveles_completados TINYINT UNSIGNED
)
BEGIN

    CASE p_opcion

        -- 1. Registrar una inscripción (compra)
        WHEN 1 THEN

            IF NOT EXISTS (
                SELECT 1
                FROM usuarios
                WHERE id_usuario = p_id_usuario
                  AND rol = 'estudiante'
                  AND estado = 'activo'
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El estudiante no existe o no está activo';
            END IF;

            IF NOT EXISTS (
                SELECT 1
                FROM cursos
                WHERE id_curso = p_id_curso
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El curso no existe';
            END IF;

            INSERT INTO inscripciones_cursos (
                id_usuario,
                id_curso
            )
            VALUES (
                p_id_usuario,
                p_id_curso
            );

            SELECT
                'Inscripcion registrada correctamente' AS mensaje,
                LAST_INSERT_ID() AS id_inscripcion;


        -- 2. Obtener todos los cursos inscritos (Kardex)
        WHEN 2 THEN

            SELECT
                i.id_inscripcion,
                i.id_usuario,
                i.id_curso,
                c.id_instructor,
                c.titulo,
                c.descripcion,
                c.imagen,
                c.costo,
                i.fecha_inscripcion,
                i.ultima_fecha_acceso,
                i.fecha_terminacion,
                i.niveles_completados,
                (
                    SELECT COUNT(*)
                    FROM niveles_curso n
                    WHERE n.id_curso = i.id_curso
                ) AS total_niveles,
                i.progreso,
                i.estado

            FROM inscripciones_cursos i

            INNER JOIN cursos c
                ON i.id_curso = c.id_curso

            WHERE i.id_usuario = p_id_usuario

            ORDER BY i.fecha_inscripcion DESC;


        -- 3. Obtener detalle de una inscripción
        WHEN 3 THEN

            SELECT
                i.id_inscripcion,
                i.id_usuario,
                i.id_curso,
                c.titulo,
                c.descripcion,
                c.imagen,
                i.fecha_inscripcion,
                i.ultima_fecha_acceso,
                i.fecha_terminacion,
                i.niveles_completados,
                (
                    SELECT COUNT(*)
                    FROM niveles_curso n
                    WHERE n.id_curso = i.id_curso
                ) AS total_niveles,
                i.progreso,
                i.estado

            FROM inscripciones_cursos i

            INNER JOIN cursos c
                ON i.id_curso = c.id_curso

            WHERE i.id_inscripcion = p_id_inscripcion
              AND i.id_usuario = p_id_usuario;


        -- 4. Actualizar progreso y último acceso
        WHEN 4 THEN

            IF NOT EXISTS (
                SELECT 1
                FROM inscripciones_cursos
                WHERE id_inscripcion = p_id_inscripcion
                  AND id_usuario = p_id_usuario
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'La inscripción no existe';
            END IF;

            UPDATE inscripciones_cursos i

            SET
                i.niveles_completados = LEAST(
                    p_niveles_completados,
                    (
                        SELECT COUNT(*)
                        FROM niveles_curso n
                        WHERE n.id_curso = i.id_curso
                    )
                ),

                i.progreso = CASE
                    WHEN (
                        SELECT COUNT(*)
                        FROM niveles_curso n
                        WHERE n.id_curso = i.id_curso
                    ) = 0 THEN 0

                    ELSE ROUND(
                        LEAST(
                            p_niveles_completados,
                            (
                                SELECT COUNT(*)
                                FROM niveles_curso n
                                WHERE n.id_curso = i.id_curso
                            )
                        ) * 100.0 /
                        (
                            SELECT COUNT(*)
                            FROM niveles_curso n
                            WHERE n.id_curso = i.id_curso
                        ),
                        2
                    )
                END,

                i.ultima_fecha_acceso = CURRENT_TIMESTAMP

            WHERE i.id_inscripcion = p_id_inscripcion
              AND i.id_usuario = p_id_usuario
              AND i.estado = 'incompleto';


            SELECT
                'Progreso actualizado correctamente' AS mensaje;


        -- 5. Marcar curso como completado
        WHEN 5 THEN

            IF NOT EXISTS (
                SELECT 1
                FROM inscripciones_cursos
                WHERE id_inscripcion = p_id_inscripcion
                  AND id_usuario = p_id_usuario
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'La inscripción no existe';
            END IF;

            UPDATE inscripciones_cursos i

            SET
                i.niveles_completados = (
                    SELECT COUNT(*)
                    FROM niveles_curso n
                    WHERE n.id_curso = i.id_curso
                ),

                i.progreso = 100.00,
                i.estado = 'completo',
                i.fecha_terminacion = CURRENT_TIMESTAMP,
                i.ultima_fecha_acceso = CURRENT_TIMESTAMP

            WHERE i.id_inscripcion = p_id_inscripcion
              AND i.id_usuario = p_id_usuario
              AND i.estado = 'incompleto'

              AND (
                  SELECT COUNT(*)
                  FROM niveles_curso n
                  WHERE n.id_curso = i.id_curso
              ) > 0;

            SELECT
                'Curso completado correctamente' AS mensaje;


        -- 6. Obtener los datos del diploma
        WHEN 6 THEN

            IF NOT EXISTS (
                SELECT 1
                FROM inscripciones_cursos
                WHERE id_inscripcion = p_id_inscripcion
                  AND id_usuario = p_id_usuario
                  AND estado = 'completo'
            ) THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El curso no está completado o la inscripción no existe';
            END IF;

            SELECT
                CONCAT_WS(' ', estudiante.nombre, estudiante.apellido)
                    AS nombre_estudiante,

                c.titulo AS nombre_curso,

                i.fecha_terminacion,

                CONCAT_WS(' ', instructor.nombre, instructor.apellido)
                    AS nombre_instructor

            FROM inscripciones_cursos i

            INNER JOIN usuarios estudiante
                ON estudiante.id_usuario = i.id_usuario

            INNER JOIN cursos c
                ON c.id_curso = i.id_curso

            LEFT JOIN usuarios instructor
                ON instructor.id_usuario = c.id_instructor

            WHERE i.id_inscripcion = p_id_inscripcion
              AND i.id_usuario = p_id_usuario
              AND i.estado = 'completo';


        ELSE

            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Opcion no valida';

    END CASE;

END //

DELIMITER ;

