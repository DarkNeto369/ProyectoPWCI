<?php

namespace Controllers;

use Models\Inscripcion;
use Models\Curso;
use Models\Pago;
use Core\App;
use Core\PayPal\PayPal;

class InscripcionController
{    
    // 1. Crear una orden de compra mediante PayPal
    public function comprar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener el estudiante desde la sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para comprar un curso.'
            ]);
        }

        // Verificar que sea estudiante
        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden comprar cursos.'
            ]);
        }

        // Recibir los datos enviados en JSON
        $datos = json_decode(file_get_contents('php://input'), true);

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Los datos enviados no son validos.'
            ]);
        }

        $idCurso = $datos['id_curso'] ?? null;

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

            // Recuperar el curso desde la base de datos
            $cursoModel = new Curso();

            $resultadoCurso = $cursoModel->obtenerDetalle(
                (int) $idCurso
            );

            $curso = $resultadoCurso['curso'];

            if (!$curso) {
                $this->responder(404, [
                    'error' => 'El curso no existe.'
                ]);
            }

            // Obtener el precio real del curso
            $monto = $curso['costo'];

            if (!is_numeric($monto) || (float) $monto <= 0) {
                $this->responder(400, [
                    'error' => 'El curso no tiene un precio valido para realizar el pago.'
                ]);
            }

            // Crear la orden en PayPal
            $paypal = App::resolve(PayPal::class);

            $orden = $paypal->crearOrden($monto, 'MXN');

            // Recuperar el enlace para aprobar el pago
            $urlAprobacion = null;

            foreach ($orden['links'] ?? [] as $enlace) {
                if (
                    in_array(
                        $enlace['rel'] ?? '',
                        ['approve', 'payer-action'],
                        true
                    )
                ) {
                    $urlAprobacion = $enlace['href'];
                    break;
                }
            }

            if (!$urlAprobacion) {
                throw new \RuntimeException(
                    'PayPal no proporciono el enlace de aprobacion.'
                );
            }

            // Registrar el pago como pendiente
            $pagoModel = new Pago();

            $pagoModel->registrarPendiente([
                'id_usuario' => (int) $idUsuario,
                'id_curso' => (int) $idCurso,
                'id_instructor' => $curso['id_instructor'] ?? null,
                'id_orden_paypal' => $orden['id'],
                'monto' => $monto,
                'moneda' => 'MXN',
                'forma_pago' => 'PayPal'
            ]);

            // Enviar el enlace al frontend
            $this->responder(201, [
                'mensaje' => 'Orden de compra creada correctamente.',
                'id_orden' => $orden['id'],
                'estado' => 'pendiente',
                'url_aprobacion' => $urlAprobacion
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al crear la orden de compra.'
            ]);
        }
    }


    
// 2. Confirmar el pago al regresar de PayPal
public function retorno()
{
    // Recuperar el ID de la orden enviado por PayPal
    $idOrden = $_GET['token'] ?? null;

    if (!$idOrden) {
        $this->responder(400, [
            'error' => 'No se recibio el identificador de la orden.'
        ]);
    }

    // Comprobar que el estudiante siga teniendo sesión
    $idUsuario = $_SESSION['user_id'] ?? null;

    if (
        $idUsuario === null ||
        !ctype_digit((string) $idUsuario) ||
        (int) $idUsuario <= 0
    ) {
        $this->responder(401, [
            'error' => 'Debes iniciar sesion para confirmar la compra.'
        ]);
    }

    if (($_SESSION['rol'] ?? '') !== 'estudiante') {
        $this->responder(403, [
            'error' => 'Solo los estudiantes pueden comprar cursos.'
        ]);
    }

    try {

        $pagoModel = new Pago();

        // Recuperar el registro del pago
        $pago = $pagoModel->obtenerPorOrden($idOrden);

        if (!$pago) {
            $this->responder(404, [
                'error' => 'No se encontro el registro de esta compra.'
            ]);
        }

        // Comprobar que la orden pertenezca al estudiante
        if ((int) $pago['id_usuario'] !== (int) $idUsuario) {
            $this->responder(403, [
                'error' => 'Esta orden no pertenece a tu cuenta.'
            ]);
        }

        // Si el pago ya fue completado, no volver a procesarlo
        if ($pago['estado'] === 'completado') {
            header(
                'Location: /ProyectoPWCI/public/mis-cursos',
                true,
                303
            );
            exit;
        }

        // Consultar la orden directamente en PayPal
        $paypal = App::resolve(PayPal::class);

        $orden = $paypal->consultarOrden($idOrden);

        if (
            ($orden['id'] ?? '') !== $idOrden ||
            !isset($orden['purchase_units'][0]['amount'])
        ) {
            $this->responder(400, [
                'error' => 'La orden de PayPal no es valida.'
            ]);
        }

        // Comprobar el importe y la moneda de la orden
        $importePayPal = $orden['purchase_units'][0]['amount']['value'];
        $monedaPayPal = $orden['purchase_units'][0]['amount']['currency_code'];

        if (
            round((float) $importePayPal, 2) !== round((float) $pago['monto'], 2) ||
            $monedaPayPal !== $pago['moneda']
        ) {
            $this->responder(400, [
                'error' => 'El importe o la moneda del pago no coinciden.'
            ]);
        }

        // Obtener el resultado de la captura
        if (($orden['status'] ?? '') === 'APPROVED') {

            $captura = $paypal->capturarOrden($idOrden);

        } elseif (($orden['status'] ?? '') === 'COMPLETED') {

            // Recuperar una captura que ya se realizó en PayPal
            $captura = $orden;

        } else {

            $this->responder(400, [
                'error' => 'El pago no ha sido aprobado en PayPal.',
                'estado_paypal' => $orden['status'] ?? 'DESCONOCIDO'
            ]);
        }

        // Comprobar que PayPal haya completado el pago
        if (($captura['status'] ?? '') !== 'COMPLETED') {
            $this->responder(400, [
                'error' => 'PayPal no ha confirmado el pago.',
                'estado_paypal' => $captura['status'] ?? 'DESCONOCIDO'
            ]);
        }

        // Recuperar los datos de la captura
        $datosCaptura = $captura['purchase_units'][0]
            ['payments']['captures'][0] ?? null;

        if (
            !$datosCaptura ||
            ($datosCaptura['status'] ?? '') !== 'COMPLETED' ||
            !isset(
                $datosCaptura['id'],
                $datosCaptura['amount']['value'],
                $datosCaptura['amount']['currency_code']
            )
        ) {
            $this->responder(400, [
                'error' => 'No se pudo verificar la captura del pago.'
            ]);
        }

        // Comprobar el importe y la moneda de la captura
        if (
            round((float) $datosCaptura['amount']['value'], 2) !==
                round((float) $pago['monto'], 2) ||
            $datosCaptura['amount']['currency_code'] !== $pago['moneda']
        ) {
            $this->responder(400, [
                'error' => 'El importe o la moneda de la captura no coinciden.'
            ]);
        }

        $idCaptura = $datosCaptura['id'];

        // Confirmar el pago y registrar la inscripción
        $inscripcionModel = new Inscripcion();

        $resultado = $inscripcionModel->confirmarCompra(
            (int) $idUsuario,
            (int) $pago['id_curso'],
            $idOrden,
            $idCaptura
        );

        // Redirigir al estudiante a Mis cursos
        header(
            'Location: /ProyectoPWCI/public/mis-cursos',
            true,
            303
        );
        exit;

    } catch (\Throwable $e) {

        error_log('ERROR PAYPAL RETORNO: ' . $e->getMessage());

        $this->responder(500, [
            'error' => 'Ocurrio un error al confirmar la compra.'
        ]);
    }
}



    // 2. Obtener los cursos inscritos del estudiante
    public function misCursos()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener estudiante desde la sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para consultar tus cursos.'
            ]);
        }

        // Verificar que sea estudiante
        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden consultar sus cursos.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $cursos = $inscripcionModel->obtenerPorUsuario(
                (int) $idUsuario
            );

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al consultar tus cursos.'
            ]);
        }
    }

    // 3. Obtener los niveles de un curso inscrito
    public function obtenerNiveles()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden consultar los niveles.'
            ]);
        }

        $idInscripcion = $_GET['id_inscripcion'] ?? null;

        if (
            $idInscripcion === null ||
            !ctype_digit((string) $idInscripcion) ||
            (int) $idInscripcion <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_inscripcion valido.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $niveles = $inscripcionModel->obtenerNiveles(
                (int) $idInscripcion,
                (int) $idUsuario
            );

            $this->responder(200, [
                'niveles' => $niveles
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al consultar los niveles.'
            ]);
        }
    }

    // 4. Marcar un nivel como completado
    public function marcarNivelCompletado()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden completar niveles.'
            ]);
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Los datos enviados no son validos.'
            ]);
        }

        $idInscripcion = $datos['id_inscripcion'] ?? null;
        $idNivel = $datos['id_nivel'] ?? null;

        if (
            $idInscripcion === null ||
            !ctype_digit((string) $idInscripcion) ||
            (int) $idInscripcion <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_inscripcion valido.'
            ]);
        }

        if (
            $idNivel === null ||
            !ctype_digit((string) $idNivel) ||
            (int) $idNivel <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_nivel valido.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $resultado = $inscripcionModel->marcarNivelCompletado(
                (int) $idInscripcion,
                (int) $idUsuario,
                (int) $idNivel
            );

            $this->responder(200, [
                'mensaje' => 'Nivel marcado como completado.',
                'resultado' => $resultado
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            if ($e->getCode() === '45000') {
                $this->responder(400, [
                    'error' => $e->getMessage()
                ]);
            }

            $this->responder(500, [
                'error' => 'Ocurrio un error al completar el nivel.'
            ]);
        }
    }

    // Obtener los datos del diploma
public function diploma()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $this->responder(405, [
            'error' => 'Método no permitido.'
        ]);
    }

    if (
        !isset($_SESSION['user_id']) ||
        $_SESSION['rol'] !== 'estudiante'
    ) {
        $this->responder(403, [
            'error' => 'No tienes permiso para consultar este diploma.'
        ]);
    }

    $idInscripcion = $_GET['id_inscripcion'] ?? null;

    if (!$idInscripcion || !ctype_digit((string) $idInscripcion)) {
        $this->responder(400, [
            'error' => 'Identificador de inscripción inválido.'
        ]);
    }

    try {

        $modelo = new Inscripcion();

        $diploma = $modelo->obtenerDiploma(
            $idInscripcion,
            $_SESSION['user_id']
        );

        if (!$diploma) {
            $this->responder(404, [
                'error' => 'No se encontraron los datos del diploma.'
            ]);
        }

        $this->responder(200, [
            'mensaje' => 'Datos del diploma obtenidos correctamente.',
            'diploma' => $diploma
        ]);

    } catch (\PDOException $e) {

        $this->responder(400, [
            'error' => $e->getMessage()
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