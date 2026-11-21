DELIMITER //

CREATE PROCEDURE sp_reporte_usuarios(
    IN p_opcion INT
)
BEGIN
    CASE p_opcion

        -- Reporte de instructores
        WHEN 1 THEN
            SELECT
                u.correo AS usuario,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre,
                u.fecha_registro AS fecha_ingreso,
                COUNT(DISTINCT c.id_curso) AS cursos_ofrecidos,
                COALESCE(SUM(p.total_ingresos), 0) AS total_ganancias
            FROM usuarios u
            LEFT JOIN cursos c
                ON u.id_usuario = c.id_instructor
            LEFT JOIN (
                SELECT
                    id_curso,
                    SUM(monto) AS total_ingresos
                FROM pagos_cursos
                WHERE estado = 'completado'
                GROUP BY id_curso
            ) p
                ON c.id_curso = p.id_curso
            WHERE u.rol = 'instructor'
              AND u.estado = 'activo'
            GROUP BY
                u.id_usuario,
                u.correo,
                u.nombre,
                u.apellido,
                u.fecha_registro
            ORDER BY u.nombre;

        -- Reporte de estudiantes
        WHEN 2 THEN
            SELECT
                u.correo AS usuario,
                CONCAT(u.nombre, ' ', u.apellido) AS nombre,
                u.fecha_registro AS fecha_ingreso,
                COUNT(DISTINCT i.id_curso) AS cursos_inscritos
            FROM usuarios u
            LEFT JOIN inscripciones_cursos i
                ON u.id_usuario = i.id_usuario
            WHERE u.rol = 'estudiante'
              AND u.estado = 'activo'
            GROUP BY
                u.id_usuario,
                u.correo,
                u.nombre,
                u.apellido,
                u.fecha_registro
            ORDER BY u.nombre;

    END CASE;
END //

DELIMITER ;