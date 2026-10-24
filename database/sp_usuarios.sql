DROP PROCEDURE IF EXISTS sp_usuarios;

DELIMITER $$

CREATE PROCEDURE sp_usuarios(
    IN p_opcion INT,
    IN p_id_usuario INT UNSIGNED,
    IN p_imagen_perfil VARCHAR(255),
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_genero VARCHAR(10),
    IN p_fecha_nacimiento DATE,
    IN p_rol VARCHAR(20),
    IN p_correo VARCHAR(254),
    IN p_contra VARCHAR(255)
)
BEGIN

    CASE p_opcion

        -- Registrar usuario
        WHEN 1 THEN

            INSERT INTO usuarios (
                imagen_perfil,
                nombre,
                apellido,
                genero,
                fecha_nacimiento,
                rol,
                correo,
                contra
            )
            VALUES (
                p_imagen_perfil,
                p_nombre,
                p_apellido,
                p_genero,
                p_fecha_nacimiento,
                p_rol,
                p_correo,
                p_contra
            );
            
		-- Login
		WHEN 2 THEN
			SELECT *
			FROM usuarios
			WHERE correo = p_correo;

        ELSE
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Opcion no valida';

    END CASE;

END $$

DELIMITER ;