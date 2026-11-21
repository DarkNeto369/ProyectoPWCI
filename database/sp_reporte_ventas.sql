DELIMITER //

CREATE PROCEDURE sp_reporte_ventas(
    IN p_opcion INT,
    IN p_id_instructor INT,
    IN p_categoria VARCHAR(100)
)
BEGIN

    CASE p_opcion

        -- Reporte de cursos
        WHEN 1 THEN

            SELECT
                c.id_curso,
                c.titulo AS curso,
                COALESCE(i.total_alumnos, 0) AS alumnos,
                COALESCE(p.total_ingresos, 0.00) AS ingresos

            FROM cursos c

            LEFT JOIN (
                SELECT
                    id_curso,
                    COUNT(*) AS total_alumnos
                FROM inscripciones_cursos
                GROUP BY id_curso
            ) i ON c.id_curso = i.id_curso

            LEFT JOIN (
                SELECT
                    id_curso,
                    SUM(monto) AS total_ingresos
                FROM pagos_cursos
                WHERE estado = 'completado'
                GROUP BY id_curso
            ) p ON c.id_curso = p.id_curso

            WHERE c.id_instructor = p_id_instructor
              AND (
                  p_categoria IS NULL
                  OR p_categoria = ''
                  OR p_categoria = 'Todas'
                  OR c.categoria = p_categoria
              )

            ORDER BY c.titulo;


        -- Ingresos totales de todos los cursos
        WHEN 2 THEN

            SELECT
                COALESCE(SUM(p.monto), 0.00) AS ingresos_totales

            FROM pagos_cursos p

            INNER JOIN cursos c
                ON p.id_curso = c.id_curso

            WHERE c.id_instructor = p_id_instructor
              AND p.estado = 'completado';


        -- Categorías disponibles
        WHEN 3 THEN

            SELECT DISTINCT
                categoria

            FROM cursos

            WHERE id_instructor = p_id_instructor
              AND categoria IS NOT NULL

            ORDER BY categoria;


        -- Ingresos totales de una categoría
        WHEN 4 THEN

            SELECT
                COALESCE(SUM(p.monto), 0.00) AS ingresos_totales

            FROM pagos_cursos p

            INNER JOIN cursos c
                ON p.id_curso = c.id_curso

            WHERE c.id_instructor = p_id_instructor
              AND c.categoria = p_categoria
              AND p.estado = 'completado';


    END CASE;

END //

DELIMITER ;