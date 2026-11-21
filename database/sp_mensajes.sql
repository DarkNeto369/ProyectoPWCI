DROP PROCEDURE IF EXISTS sp_mensajes;

DELIMITER //

CREATE PROCEDURE sp_mensajes(
    IN p_opcion INT,
    IN p_id_curso INT,
    IN p_id_usuario INT,
    IN p_id_contacto INT,
    IN p_contenido TEXT
)
BEGIN

    DECLARE v_id_instructor INT;
    DECLARE v_rol VARCHAR(30);
    DECLARE v_inscrito INT DEFAULT 0;

    CASE p_opcion

        /* =====================================
           OPCIÓN 1: ENVIAR MENSAJE
        ===================================== */
        WHEN 1 THEN

            IF p_contenido IS NULL OR TRIM(p_contenido) = '' THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El mensaje no puede estar vacío';
            END IF;

            IF p_id_usuario = p_id_contacto THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'No puedes enviarte mensajes a ti mismo';
            END IF;

            SELECT id_instructor
            INTO v_id_instructor
            FROM cursos
            WHERE id_curso = p_id_curso;

            IF v_id_instructor IS NULL THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El curso no tiene instructor';
            END IF;

            SELECT rol
            INTO v_rol
            FROM usuarios
            WHERE id_usuario = p_id_usuario
              AND estado = 'activo';

            IF v_rol IS NULL THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'El usuario remitente no existe o está inactivo';
            END IF;

            /* Verificar inscripción del estudiante */
            IF v_rol = 'estudiante' THEN

                SELECT COUNT(*)
                INTO v_inscrito
                FROM inscripciones_cursos
                WHERE id_usuario = p_id_usuario
                  AND id_curso = p_id_curso;

                IF v_inscrito = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'No estás inscrito en este curso';
                END IF;

                IF p_id_contacto <> v_id_instructor THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Solo puedes contactar al instructor del curso';
                END IF;

            ELSEIF v_rol = 'instructor' THEN

                IF p_id_usuario <> v_id_instructor THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'No eres el instructor de este curso';
                END IF;

                SELECT COUNT(*)
                INTO v_inscrito
                FROM inscripciones_cursos
                WHERE id_usuario = p_id_contacto
                  AND id_curso = p_id_curso;

                IF v_inscrito = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El estudiante no está inscrito en este curso';
                END IF;

            ELSE

                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Rol no autorizado para enviar mensajes';

            END IF;

            INSERT INTO mensajes (
                id_curso,
                id_remitente,
                id_destinatario,
                contenido
            )
            VALUES (
                p_id_curso,
                p_id_usuario,
                p_id_contacto,
                TRIM(p_contenido)
            );

            SELECT
                'Mensaje enviado correctamente' AS mensaje,
                LAST_INSERT_ID() AS id_mensaje;


        /* =====================================
           OPCIÓN 2: OBTENER MENSAJES
        ===================================== */
        WHEN 2 THEN

            SELECT
                m.id_mensaje,
                m.id_curso,
                m.id_remitente,
                m.id_destinatario,
                m.contenido,
                m.fecha_envio,
                u.nombre AS nombre_remitente,
                u.imagen_perfil

            FROM mensajes m

            INNER JOIN usuarios u
                ON u.id_usuario = m.id_remitente

            WHERE m.id_curso = p_id_curso

              AND (
                    (m.id_remitente = p_id_usuario
                     AND m.id_destinatario = p_id_contacto)

                    OR

                    (m.id_remitente = p_id_contacto
                     AND m.id_destinatario = p_id_usuario)
              )

            ORDER BY m.fecha_envio ASC, m.id_mensaje ASC;


        /* =====================================
           OPCIÓN 3: OBTENER CONVERSACIONES
        ===================================== */
        WHEN 3 THEN

            SELECT
                conversacion.id_curso,
                conversacion.id_contacto,
                u.nombre AS nombre_contacto,
                u.apellido AS apellido_contacto,
                u.imagen_perfil,
                c.titulo AS nombre_curso,

                (
                    SELECT m2.contenido
                    FROM mensajes m2
                    WHERE m2.id_curso = conversacion.id_curso
                      AND (
                            (m2.id_remitente = p_id_usuario
                             AND m2.id_destinatario = conversacion.id_contacto)

                            OR

                            (m2.id_remitente = conversacion.id_contacto
                             AND m2.id_destinatario = p_id_usuario)
                      )
                    ORDER BY m2.fecha_envio DESC, m2.id_mensaje DESC
                    LIMIT 1
                ) AS ultimo_mensaje,

                (
                    SELECT m3.fecha_envio
                    FROM mensajes m3
                    WHERE m3.id_curso = conversacion.id_curso
                      AND (
                            (m3.id_remitente = p_id_usuario
                             AND m3.id_destinatario = conversacion.id_contacto)

                            OR

                            (m3.id_remitente = conversacion.id_contacto
                             AND m3.id_destinatario = p_id_usuario)
                      )
                    ORDER BY m3.fecha_envio DESC, m3.id_mensaje DESC
                    LIMIT 1
                ) AS fecha_ultimo_mensaje

            FROM (

                SELECT DISTINCT
                    m.id_curso,

                    CASE
                        WHEN m.id_remitente = p_id_usuario
                        THEN m.id_destinatario
                        ELSE m.id_remitente
                    END AS id_contacto

                FROM mensajes m

                WHERE m.id_remitente = p_id_usuario
                   OR m.id_destinatario = p_id_usuario

            ) AS conversacion

            INNER JOIN usuarios u
                ON u.id_usuario = conversacion.id_contacto

            INNER JOIN cursos c
                ON c.id_curso = conversacion.id_curso

            ORDER BY fecha_ultimo_mensaje DESC;


        ELSE

            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Opción no válida';

    END CASE;

END //

DELIMITER ;

