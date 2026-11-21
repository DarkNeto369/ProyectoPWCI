
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
    IN p_imagen VARCHAR(255),
    IN p_numero_nivel TINYINT UNSIGNED,
    IN p_nombre_nivel VARCHAR(150),
    IN p_video VARCHAR(255)
)
BEGIN

    DECLARE v_existe INT DEFAULT 0;

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

            SELECT
                c.*,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre_instructor
            FROM cursos c
            LEFT JOIN usuarios u
                ON c.id_instructor = u.id_usuario
            ORDER BY c.fecha_creacion DESC, c.id_curso DESC
            LIMIT 10;


        -- 3. Recuperar cursos de un instructor
        WHEN 3 THEN

            SELECT
                c.*,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre_instructor
            FROM cursos c
            LEFT JOIN usuarios u
                ON c.id_instructor = u.id_usuario
            WHERE c.id_instructor = p_id_instructor
            ORDER BY c.fecha_creacion DESC;


        -- 4. Recuperar cursos comprados por un usuario
        WHEN 4 THEN

            SELECT
                c.*,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre_instructor
            FROM cursos c
            INNER JOIN compras_cursos cc
                ON c.id_curso = cc.id_curso
            LEFT JOIN usuarios u
                ON c.id_instructor = u.id_usuario
            WHERE cc.id_usuario = p_id_usuario
            ORDER BY cc.fecha_compra DESC;


        -- 5. Recuperar detalle de un curso y sus niveles
        WHEN 5 THEN

            SELECT
                c.*,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre_instructor
            FROM cursos c
            LEFT JOIN usuarios u
                ON c.id_instructor = u.id_usuario
            WHERE c.id_curso = p_id_curso;

            SELECT *
            FROM niveles_curso
            WHERE id_curso = p_id_curso
            ORDER BY numero_nivel ASC;


        -- 6. Agregar nivel a un curso
        WHEN 6 THEN

            -- Validar que exista el curso
            SELECT COUNT(*)
            INTO v_existe
            FROM cursos
            WHERE id_curso = p_id_curso;

            IF v_existe = 0 THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El curso no existe.';
            END IF;

            -- Validar número de nivel
            IF p_numero_nivel IS NULL
                OR p_numero_nivel < 1
                OR p_numero_nivel > 3 THEN

                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El numero de nivel debe estar entre 1 y 3.';
            END IF;

            -- Validar nombre
            IF p_nombre_nivel IS NULL
                OR TRIM(p_nombre_nivel) = '' THEN

                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El nombre del nivel es obligatorio.';
            END IF;

            -- Validar video
            IF p_video IS NULL
                OR TRIM(p_video) = '' THEN

                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'La ruta del video es obligatoria.';
            END IF;

            -- Evitar números de nivel repetidos
            SELECT COUNT(*)
            INTO v_existe
            FROM niveles_curso
            WHERE id_curso = p_id_curso
              AND numero_nivel = p_numero_nivel;

            IF v_existe > 0 THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Este numero de nivel ya existe para el curso.';
            END IF;

            INSERT INTO niveles_curso (
                id_curso,
                numero_nivel,
                nombre,
                video
            )
            VALUES (
                p_id_curso,
                p_numero_nivel,
                TRIM(p_nombre_nivel),
                p_video
            );

            SELECT
                LAST_INSERT_ID() AS id_nivel,
                'Nivel agregado correctamente.' AS mensaje;
                
                
		-- 7. OBTENER LOS CURSOS MEJOR VALORADOS
		WHEN 7 THEN

			SELECT
				c.*,
				CONCAT_WS(' ', u.nombre, u.apellido) AS nombre_instructor,
				AVG(cal.calificacion) AS promedio_calificacion,
				COUNT(cal.id_calificacion) AS total_calificaciones

			FROM cursos c

			LEFT JOIN usuarios u
				ON c.id_instructor = u.id_usuario

			INNER JOIN calificaciones cal
				ON c.id_curso = cal.id_curso

			GROUP BY c.id_curso

			ORDER BY
				promedio_calificacion DESC,
				total_calificaciones DESC

			LIMIT 10;



        -- Opción inválida
        ELSE

            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Opcion no valida.';

    END CASE;

END $$

DELIMITER ;
