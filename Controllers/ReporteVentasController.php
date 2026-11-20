<?php

namespace Controllers;

use Models\ReporteVentas;

class ReporteVentasController
{
    // 1. Obtener el reporte de cursos
    public function obtener()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Verificar sesión
        $idInstructor = $_SESSION['user_id'] ?? null;

        if (
            $idInstructor === null ||
            !ctype_digit((string) $idInstructor) ||
            (int) $idInstructor <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        // Verificar que sea instructor
        if (($_SESSION['rol'] ?? '') !== 'instructor') {
            $this->responder(403, [
                'error' => 'Solo los instructores pueden consultar sus reportes.'
            ]);
        }

        // Obtener la categoría seleccionada
        $categoria = trim($_GET['categoria'] ?? 'Todas');

        try {
            $reporteModel = new ReporteVentas();

            // Obtener cursos, alumnos e ingresos
            $cursos = $reporteModel->obtenerReporte(
                (int) $idInstructor,
                $categoria
            );

            // Obtener ingresos totales según el filtro
            if ($categoria === '' || $categoria === 'Todas') {

                $resultado = $reporteModel->obtenerIngresosTotales(
                    (int) $idInstructor
                );

            } else {

                $resultado = $reporteModel->obtenerIngresosCategoria(
                    (int) $idInstructor,
                    $categoria
                );
            }

            $this->responder(200, [
                'cursos' => $cursos,
                'ingresos_totales' => $resultado['ingresos_totales'] ?? 0
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al generar el reporte de ventas.'
            ]);
        }
    }

    // 2. Obtener las categorías disponibles
    public function categorias()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Verificar sesión
        $idInstructor = $_SESSION['user_id'] ?? null;

        if (
            $idInstructor === null ||
            !ctype_digit((string) $idInstructor) ||
            (int) $idInstructor <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        // Verificar que sea instructor
        if (($_SESSION['rol'] ?? '') !== 'instructor') {
            $this->responder(403, [
                'error' => 'Solo los instructores pueden consultar sus categorias.'
            ]);
        }

        try {
            $reporteModel = new ReporteVentas();

            $categorias = $reporteModel->obtenerCategorias(
                (int) $idInstructor
            );

            $this->responder(200, [
                'categorias' => $categorias
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar las categorias.'
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