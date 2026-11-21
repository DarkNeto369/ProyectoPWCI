DROP PROCEDURE IF EXISTS sp_pagos_cursos;

DELIMITER //

CREATE PROCEDURE sp_pagos_cursos(
    IN p_opcion INT,
    IN p_id_pago INT UNSIGNED,
    IN p_id_usuario INT UNSIGNED,
    IN p_id_curso INT UNSIGNED,
    IN p_id_instructor INT UNSIGNED,
    IN p_id_orden_paypal VARCHAR(100),
    IN p_id_captura_paypal VARCHAR(100),
    IN p_monto DECIMAL(10,2),
    IN p_moneda VARCHAR(3),
    IN p_forma_pago VARCHAR(30)
)
BEGIN

    CASE p_opcion

        -- 1. REGISTRAR PAGO PENDIENTE
        WHEN 1 THEN

            INSERT INTO pagos_cursos (
                id_usuario,
                id_curso,
                id_instructor,
                id_orden_paypal,
                monto,
                moneda,
                forma_pago,
                estado
            )
            VALUES (
                p_id_usuario,
                p_id_curso,
                p_id_instructor,
                p_id_orden_paypal,
                p_monto,
                p_moneda,
                p_forma_pago,
                'pendiente'
            );

            SELECT LAST_INSERT_ID() AS id_pago;


        -- 2. BUSCAR PAGO POR ORDEN PAYPAL
        WHEN 2 THEN

            SELECT *
            FROM pagos_cursos
            WHERE id_orden_paypal = p_id_orden_paypal;


        -- 3. CONFIRMAR PAGO
        WHEN 3 THEN

            UPDATE pagos_cursos
            SET
                estado = 'completado',
                id_captura_paypal = p_id_captura_paypal,
                fecha_pago = CURRENT_TIMESTAMP
            WHERE id_orden_paypal = p_id_orden_paypal
              AND estado = 'pendiente';

            SELECT ROW_COUNT() AS registros_actualizados;


        -- 4. CONSULTAR VENTAS POR CURSO DE UN INSTRUCTOR
        WHEN 4 THEN

            SELECT
                c.id_curso,
                c.titulo,
                COUNT(p.id_pago) AS cursos_vendidos,
                SUM(p.monto) AS total_ingresos
            FROM pagos_cursos p
            INNER JOIN cursos c
                ON p.id_curso = c.id_curso
            WHERE p.id_instructor = p_id_instructor
              AND p.estado = 'completado'
            GROUP BY c.id_curso, c.titulo;


        -- 5. CONSULTAR INGRESOS TOTALES DEL INSTRUCTOR
        WHEN 5 THEN

            SELECT
                COUNT(*) AS total_ventas,
                COALESCE(SUM(monto), 0.00) AS ingresos_totales
            FROM pagos_cursos
            WHERE id_instructor = p_id_instructor
              AND estado = 'completado';


    END CASE;

END //

DELIMITER ;