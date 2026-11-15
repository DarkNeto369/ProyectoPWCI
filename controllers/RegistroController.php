<?php

namespace Controllers;

use Models\Usuario;

class RegistroController
{
    public function registrar()
    {
        // 1. Peticiones POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // 2. Recibir los datos enviados desde Postman o desde la vista
        $tipoContenido = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($tipoContenido, 'multipart/form-data') !== false) {
            $datos = $_POST;
        } else {
            $contenido = file_get_contents('php://input');
            $datos = json_decode($contenido, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
                $this->responder(400, [
                    'error' => 'El JSON enviado no es valido.'
                ]);
            }
        }

        // 3. Validar los campos obligatorios
        $correo = trim($datos['correo'] ?? '');
        $contra = $datos['contra'] ?? '';

        if ($correo === '' || !is_string($correo) ||
            !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un correo valido.'
            ]);
        }

        if (!is_string($contra) || $contra === '') {
            $this->responder(400, [
                'error' => 'La contraseña es obligatoria.'
            ]);
        }

        // 4. Validar los campos opcionales
        $genero = $datos['genero'] ?? null;

        if ($genero !== null &&
            !in_array($genero, ['Hombre', 'Mujer', 'Otro'], true)) {
            $this->responder(400, [
                'error' => 'El genero no es valido.'
            ]);
        }

        $rol = $datos['rol'] ?? null;

        // No registrar administradores públicamente
        if ($rol !== null &&
            !in_array($rol, ['estudiante', 'instructor'], true)) {
            $this->responder(400, [
                'error' => 'El rol no es valido.'
            ]);
        }

        $fechaNacimiento = $datos['fecha_nacimiento'] ?? null;

        if ($fechaNacimiento !== null) {
            $fecha = \DateTime::createFromFormat('!Y-m-d', $fechaNacimiento);

            if (!$fecha || $fecha->format('Y-m-d') !== $fechaNacimiento) {
                $this->responder(400, [
                    'error' => 'La fecha de nacimiento no es valida. Usa AAAA-MM-DD.'
                ]);
            }
        }

        // 5. Modelo
        try {
            $usuarioModel = new Usuario();

            // Comprobar si el correo ya está registrado
            $usuarioExistente = $usuarioModel->buscarPorCorreo($correo);

            if ($usuarioExistente) {
                $this->responder(409, [
                    'error' => 'El correo ya esta registrado.'
                ]);
            }

            error_log("REGISTRO: Entrando al procesamiento de imagen");
            error_log("ARCHIVOS RECIBIDOS: " . print_r($_FILES, true));

            // Procesar imagen de perfil
            $imagenPerfil = null;

            // Carpeta donde se guardarán las imágenes
            $carpeta = dirname(__DIR__) . '/public/uploads/perfiles/';

            if (!is_dir($carpeta)) {
                if (!mkdir($carpeta, 0775, true)) {
                    $this->responder(500, [
                        'error' => 'No se pudo crear la carpeta de imagenes.',
                        'ruta' => $carpeta
                    ]);
                }
            }

            // Comprobar si se recibió una imagen
            if (isset($_FILES['imagen_perfil']) &&
                $_FILES['imagen_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {

                if ($_FILES['imagen_perfil']['error'] !== UPLOAD_ERR_OK) {
                    $this->responder(400, [
                        'error' => 'Error al subir la imagen.',
                        'codigo' => $_FILES['imagen_perfil']['error']
                    ]);
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
                    $this->responder(400, [
                        'error' => 'El formato de imagen no es valido.'
                    ]);
                }

                // Nombre único para evitar archivos repetidos
                $nombreImagen = uniqid('perfil_', true) . '.' . $tiposPermitidos[$tipoImagen];

                // Guardar imagen en el servidor
                if (!move_uploaded_file(
                    $_FILES['imagen_perfil']['tmp_name'],
                    $carpeta . $nombreImagen
                )) {
                    $this->responder(500, [
                        'error' => 'No se pudo guardar la imagen.'
                    ]);
                }

                // Ruta que se guardará en MySQL
                $imagenPerfil = 'uploads/perfiles/' . $nombreImagen;
            }

            // 6. Preparar los datos
            $datosUsuario = [
                'imagen_perfil' => $imagenPerfil,
                'nombre' => $datos['nombre'] ?? null,
                'apellido' => $datos['apellido'] ?? null,
                'genero' => $genero,
                'fecha_nacimiento' => $fechaNacimiento,
                'rol' => $rol,
                'correo' => $correo,
                'contra' => password_hash($contra, PASSWORD_DEFAULT)
            ];

            // 7. Registrar mediante el modelo y el procedimiento almacenado
$usuarioModel->registrar($datosUsuario);

// 8. Buscar al usuario recién registrado
$usuario = $usuarioModel->buscarPorCorreo($correo);

// 9. Iniciar sesión automáticamente
if ($usuario) {
    session_regenerate_id(true);

    $_SESSION['user_id'] = $usuario['id_usuario'];
    $_SESSION['rol'] = $usuario['rol'];
}

// 10. Responder con JSON
$this->responder(201, [
    'mensaje' => 'Usuario registrado correctamente.',
    'usuario' => [
        'id_usuario' => $usuario['id_usuario'],
        'nombre' => $usuario['nombre'],
        'apellido' => $usuario['apellido'],
        'correo' => $usuario['correo'],
        'rol' => $usuario['rol']
    ]
]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al registrar el usuario.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // Enviar respuestas JSON con su código HTTP
    private function responder($codigo, $respuesta)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $respuesta,
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}
