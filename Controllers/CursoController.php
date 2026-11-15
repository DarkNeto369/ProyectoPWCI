<?php

namespace Controllers;

use Models\Curso;

class CursoController
{
    // 1. Agregar un curso con sus niveles, videos e imagen
public function agregar()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->responder(405, [
            'error' => 'Metodo no permitido.'
        ]);
    }

    // Obtener el instructor desde la sesión
    $idInstructor = $_SESSION['user_id'] ?? null;

    // Recibir los datos del formulario
    $categoria = trim($_POST['categoria'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $costo = $_POST['costo'] ?? null;

    // Validar instructor
    if (
        $idInstructor === null ||
        !ctype_digit((string) $idInstructor) ||
        (int) $idInstructor <= 0
    ) {
        $this->responder(401, [
            'error' => 'Debes iniciar sesion para agregar un curso.'
        ]);
    }

    // Validar que sea instructor
    if (($_SESSION['rol'] ?? '') !== 'instructor') {
        $this->responder(403, [
            'error' => 'No tienes permisos para agregar cursos.'
        ]);
    }

    // Validar campos del curso
    if ($titulo === '') {
        $this->responder(400, [
            'error' => 'El titulo es obligatorio.'
        ]);
    }

    if ($descripcion === '') {
        $this->responder(400, [
            'error' => 'La descripcion es obligatoria.'
        ]);
    }

    if (
        $costo === null ||
        !is_numeric($costo) ||
        !is_finite((float) $costo) ||
        (float) $costo < 0
    ) {
        $this->responder(400, [
            'error' => 'Debes proporcionar un costo valido.'
        ]);
    }

    // Recibir los niveles
    $niveles = json_decode($_POST['niveles'] ?? '', true);

    if (
        json_last_error() !== JSON_ERROR_NONE ||
        !is_array($niveles) ||
        count($niveles) < 1 ||
        count($niveles) > 3
    ) {
        $this->responder(400, [
            'error' => 'Debes proporcionar entre 1 y 3 niveles validos.'
        ]);
    }

    // Recibir la imagen del curso
    $imagen = $_FILES['imagen'] ?? null;

    if (!$imagen || $imagen['error'] !== UPLOAD_ERR_OK) {
        $this->responder(400, [
            'error' => 'Debes seleccionar una imagen para el curso.'
        ]);
    }

    // Recibir los videos
    $videos = $_FILES['videos'] ?? null;

    if (
        !$videos ||
        !isset($videos['name']) ||
        count($videos['name']) !== count($niveles)
    ) {
        $this->responder(400, [
            'error' => 'Debes proporcionar un video por cada nivel.'
        ]);
    }

    // Carpetas de almacenamiento
    $carpetaVideos = dirname(__DIR__) . '/public/uploads/videos/';
    $carpetaImagenes = dirname(__DIR__) . '/public/uploads/imagen-cursos/';

    // Crear carpeta de videos
    if (
        !is_dir($carpetaVideos) &&
        !mkdir($carpetaVideos, 0775, true)
    ) {
        $this->responder(500, [
            'error' => 'No se pudo crear la carpeta de videos.'
        ]);
    }

    // Crear carpeta de imágenes
    if (
        !is_dir($carpetaImagenes) &&
        !mkdir($carpetaImagenes, 0775, true)
    ) {
        $this->responder(500, [
            'error' => 'No se pudo crear la carpeta de imagenes.'
        ]);
    }

    $videosGuardados = [];
    $imagenGuardada = null;
    $nivelesCurso = [];

    try {

        // Procesar imagen del curso

        if ($imagen['size'] > 5 * 1024 * 1024) {
            throw new \Exception(
                'La imagen debe pesar menos de 5 MB.'
            );
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $tipoImagen = $finfo->file($imagen['tmp_name']);

        $tiposImagenPermitidos = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif'
        ];

        if (!isset($tiposImagenPermitidos[$tipoImagen])) {
            throw new \Exception(
                'La imagen debe ser JPG, PNG, WEBP o GIF.'
            );
        }

        $nombreImagen = 'imagen_' .
            bin2hex(random_bytes(12)) . '.' .
            $tiposImagenPermitidos[$tipoImagen];

        $rutaDestinoImagen = $carpetaImagenes . $nombreImagen;

        if (!move_uploaded_file(
            $imagen['tmp_name'],
            $rutaDestinoImagen
        )) {
            throw new \Exception(
                'No se pudo guardar la imagen del curso.'
            );
        }

        $imagenGuardada = $rutaDestinoImagen;

        $rutaRelativaImagen = 'uploads/imagen-cursos/' . $nombreImagen;


        // Procesar cada nivel y su video

        foreach ($niveles as $indice => $nivel) {

            $nombreNivel = trim($nivel['nombre'] ?? '');

            if ($nombreNivel === '') {
                throw new \Exception(
                    'Todos los niveles deben tener un nombre.'
                );
            }

            $archivo = [
                'name' => $videos['name'][$indice] ?? '',
                'type' => $videos['type'][$indice] ?? '',
                'tmp_name' => $videos['tmp_name'][$indice] ?? '',
                'error' => $videos['error'][$indice] ?? UPLOAD_ERR_NO_FILE,
                'size' => $videos['size'][$indice] ?? 0
            ];

            if ($archivo['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception(
                    'Hubo un problema al recibir el video del nivel ' .
                    ($indice + 1) . '.'
                );
            }

            // Limitar el tamaño a 100 MB
            if ($archivo['size'] > 100 * 1024 * 1024) {
                throw new \Exception(
                    'Cada video debe pesar menos de 100 MB.'
                );
            }

            // Validar formato del video
            $tipo = $finfo->file($archivo['tmp_name']);

            $tiposPermitidos = [
                'video/mp4' => 'mp4',
                'video/webm' => 'webm',
                'video/ogg' => 'ogg',
                'video/quicktime' => 'mov',
                'video/x-msvideo' => 'avi',
                'video/x-matroska' => 'mkv'
            ];

            if (!isset($tiposPermitidos[$tipo])) {
                throw new \Exception(
                    'El archivo del nivel ' . ($indice + 1) .
                    ' no tiene un formato de video permitido.'
                );
            }

            // Crear nombre único para el video
            $nombreArchivo = 'video_' .
                bin2hex(random_bytes(12)) . '.' .
                $tiposPermitidos[$tipo];

            $rutaDestino = $carpetaVideos . $nombreArchivo;

            if (!move_uploaded_file(
                $archivo['tmp_name'],
                $rutaDestino
            )) {
                throw new \Exception(
                    'No se pudo guardar uno de los videos.'
                );
            }

            $rutaRelativa = 'uploads/videos/' . $nombreArchivo;

            $videosGuardados[] = $rutaDestino;

            $nivelesCurso[] = [
                'numero_nivel' => $indice + 1,
                'nombre' => $nombreNivel,
                'video' => $rutaRelativa
            ];
        }


        // Guardar curso y niveles en la base de datos

        $cursoModel = new Curso();

        $datosCurso = [
            'id_instructor' => (int) $idInstructor,
            'categoria' => $categoria !== '' ? $categoria : null,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'costo' => $costo,
            'imagen' => $rutaRelativaImagen
        ];

        $resultado = $cursoModel->agregarConNiveles(
            $datosCurso,
            $nivelesCurso
        );

        $this->responder(201, [
            'mensaje' => 'Curso y niveles agregados correctamente.',
            'curso' => $resultado
        ]);

    } catch (\Throwable $e) {

        // Eliminar videos si ocurre un error
        foreach ($videosGuardados as $ruta) {
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        // Eliminar imagen si ocurre un error
        if (
            $imagenGuardada !== null &&
            file_exists($imagenGuardada)
        ) {
            unlink($imagenGuardada);
        }

        error_log($e->getMessage());

        $this->responder(500, [
            'error' => 'Ocurrio un error al agregar el curso.',
            'detalle' => $e->getMessage()
        ]);
    }
}

    // 2. Obtener los cursos recientes
    public function recientes()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        try {
            $cursoModel = new Curso();
            $cursos = $cursoModel->obtenerRecientes();

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar los cursos recientes.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // 3. Obtener los cursos del instructor que inició sesión
    public function porInstructor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener el ID desde la sesión
        $idInstructor = $_SESSION['user_id'] ?? null;

        if (
            $idInstructor === null ||
            !ctype_digit((string) $idInstructor) ||
            (int) $idInstructor <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para consultar tus cursos.'
            ]);
        }

        // Verificar que sea instructor
        if (($_SESSION['rol'] ?? '') !== 'instructor') {
            $this->responder(403, [
                'error' => 'No tienes permisos para consultar estos cursos.'
            ]);
        }

        try {
            $cursoModel = new Curso();

            $cursos = $cursoModel->obtenerPorInstructor(
                (int) $idInstructor
            );

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar los cursos del instructor.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // 4. Obtener el detalle de un curso y sus niveles
    public function detalle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idCurso = $_GET['id_curso'] ?? null;

        if (
            $idCurso === null ||
            !ctype_digit((string) $idCurso) ||
            (int) $idCurso <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_curso valido.'
            ]);
        }

        try {
            $cursoModel = new Curso();
            $detalle = $cursoModel->obtenerDetalle((int) $idCurso);

            if (
                !isset($detalle['curso']) ||
                $detalle['curso'] === false ||
                $detalle['curso'] === null
            ) {
                $this->responder(404, [
                    'error' => 'El curso no existe.'
                ]);
            }

            $this->responder(200, $detalle);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar el detalle del curso.',
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