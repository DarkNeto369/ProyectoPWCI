<?php

namespace Controllers;

use Models\Usuario;

class PerfilController
{
    // Mostrar los datos del perfil
    public function mostrar()
    {
        try {
            $idUsuario = $_SESSION['user_id'] ?? null;

            if (!$idUsuario) {
                http_response_code(401);
                exit('Debes iniciar sesión para consultar tu perfil.');
            }

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorId($idUsuario);

            if (!$usuario) {
                http_response_code(404);
                exit('Usuario no encontrado.');
            }

            require __DIR__ . '/../views/perfil.php';

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            http_response_code(500);
            exit('Ocurrio un error al cargar el perfil.');
        }
    }

    // Actualizar los datos del perfil
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Metodo no permitido.');
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (!$idUsuario) {
            http_response_code(401);
            exit('Debes iniciar sesión para actualizar tu perfil.');
        }

        try {
            $usuarioModel = new Usuario();

            // Buscar al usuario que inició sesión
            $usuario = $usuarioModel->buscarPorId($idUsuario);

            if (!$usuario) {
                http_response_code(404);
                exit('Usuario no encontrado.');
            }

            // Recibir los datos del formulario
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $genero = $_POST['genero'] ?? '';
            $fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
            $correo = trim($_POST['correo'] ?? '');
            $contra = $_POST['contra'] ?? '';

            // Validar los campos obligatorios
            if (
                $nombre === '' ||
                $apellido === '' ||
                $correo === '' ||
                !filter_var($correo, FILTER_VALIDATE_EMAIL)
            ) {
                $_SESSION['mensaje_perfil'] = 'Completa los campos obligatorios y proporciona un correo valido.';
                $_SESSION['tipo_mensaje'] = 'danger';

                header('Location: /ProyectoPWCI/public/perfil');
                exit;
            }

            // Validar el género
            if (!in_array($genero, ['Hombre', 'Mujer', 'Otro'], true)) {
                $_SESSION['mensaje_perfil'] = 'El género seleccionado no es valido.';
                $_SESSION['tipo_mensaje'] = 'danger';

                header('Location: /ProyectoPWCI/public/perfil');
                exit;
            }

            // Validar la fecha de nacimiento
            $fechaNacimiento = $fechaNacimiento !== ''
                ? $fechaNacimiento
                : null;

            if ($fechaNacimiento !== null) {
                $fecha = \DateTime::createFromFormat(
                    '!Y-m-d',
                    $fechaNacimiento
                );

                if (
                    !$fecha ||
                    $fecha->format('Y-m-d') !== $fechaNacimiento
                ) {
                    $_SESSION['mensaje_perfil'] = 'La fecha de nacimiento no es valida.';
                    $_SESSION['tipo_mensaje'] = 'danger';

                    header('Location: /ProyectoPWCI/public/perfil');
                    exit;
                }
            }

            // Comprobar que el correo no pertenezca a otro usuario
            $usuarioExistente = $usuarioModel->buscarPorCorreo($correo);

            if (
                $usuarioExistente &&
                $usuarioExistente['id_usuario'] != $idUsuario
            ) {
                $_SESSION['mensaje_perfil'] = 'Ese correo ya está registrado por otro usuario.';
                $_SESSION['tipo_mensaje'] = 'danger';

                header('Location: /ProyectoPWCI/public/perfil');
                exit;
            }

            // Procesar la imagen de perfil
            $imagenPerfil = null;

            if (
                isset($_FILES['imagen_perfil']) &&
                $_FILES['imagen_perfil']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                if ($_FILES['imagen_perfil']['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['mensaje_perfil'] = 'Ocurrio un error al subir la imagen.';
                    $_SESSION['tipo_mensaje'] = 'danger';

                    header('Location: /ProyectoPWCI/public/perfil');
                    exit;
                }

                // Formatos permitidos
                $tiposPermitidos = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                $tipoImagen = mime_content_type(
                    $_FILES['imagen_perfil']['tmp_name']
                );

                if (!isset($tiposPermitidos[$tipoImagen])) {
                    $_SESSION['mensaje_perfil'] = 'El formato de imagen no es valido. Usa JPG, PNG o WEBP.';
                    $_SESSION['tipo_mensaje'] = 'danger';

                    header('Location: /ProyectoPWCI/public/perfil');
                    exit;
                }

                // Carpeta donde se guardan las imágenes
                $carpeta = dirname(__DIR__) . '/public/uploads/perfiles/';

                if (!is_dir($carpeta)) {
                    if (!mkdir($carpeta, 0775, true)) {
                        throw new \RuntimeException(
                            'No se pudo crear la carpeta de imagenes.'
                        );
                    }
                }

                // Crear un nombre único para la imagen
                $nombreImagen = uniqid('perfil_', true) . '.' .
                    $tiposPermitidos[$tipoImagen];

                // Guardar la imagen en el servidor
                if (!move_uploaded_file(
                    $_FILES['imagen_perfil']['tmp_name'],
                    $carpeta . $nombreImagen
                )) {
                    throw new \RuntimeException(
                        'No se pudo guardar la imagen.'
                    );
                }

                // Ruta que se almacenará en MySQL
                $imagenPerfil = 'uploads/perfiles/' . $nombreImagen;
            }

            // Preparar los datos para el modelo
            $datos = [
                'id_usuario' => $idUsuario,
                'imagen_perfil' => $imagenPerfil,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'genero' => $genero,
                'fecha_nacimiento' => $fechaNacimiento,
                'correo' => $correo,
                'contra' => $contra !== ''
                    ? password_hash($contra, PASSWORD_DEFAULT)
                    : null
            ];

            // Actualizar mediante el modelo
            $usuarioModel->actualizarPerfil($datos);

            $_SESSION['mensaje_perfil'] = 'Perfil actualizado correctamente.';
            $_SESSION['tipo_mensaje'] = 'success';

            header('Location: /ProyectoPWCI/public/perfil');
            exit;

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $_SESSION['mensaje_perfil'] = 'Ocurrio un error al actualizar el perfil.';
            $_SESSION['tipo_mensaje'] = 'danger';

            header('Location: /ProyectoPWCI/public/perfil');
            exit;
        }
    }
}