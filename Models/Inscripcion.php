<?php

namespace Models;

use Core\App;
use Core\Database;
use Models\Pago;

class Inscripcion
{
    private $tabla = 'inscripciones_cursos';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Registrar una inscripción mediante el stored procedure
    public function registrar($idUsuario, $idCurso)
    {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_inscripcion' => null,
            'id_usuario' => $idUsuario,
            'id_curso' => $idCurso,
            'niveles_completados' => null
        ]);

        $inscripcion = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $inscripcion;
    }

    // Confirmar el pago y registrar la inscripción en una transacción
    public function confirmarCompra(
        $idUsuario,
        $idCurso,
        $idOrden,
        $idCaptura
    ) {
        $conexion = $this->conn->connection;

        try {

            // Iniciar transacción
            $conexion->beginTransaction();

            // Recuperar el pago pendiente
            $pagoModel = new Pago();

            $pago = $pagoModel->obtenerPorOrden($idOrden);

            if (!$pago) {
                throw new \RuntimeException(
                    'No se encontró el registro del pago.'
                );
            }

            // Comprobar que el pago corresponda al estudiante y curso
            if (
                (int) $pago['id_usuario'] !== (int) $idUsuario ||
                (int) $pago['id_curso'] !== (int) $idCurso
            ) {
                throw new \RuntimeException(
                    'La orden de pago no corresponde al estudiante o al curso.'
                );
            }

            // Evitar confirmar un pago que ya fue procesado
            if ($pago['estado'] !== 'pendiente') {
                throw new \RuntimeException(
                    'El pago no se encuentra pendiente de confirmación.'
                );
            }

            // Actualizar el pago a completado
            $resultadoPago = $pagoModel->confirmarPago(
                $idOrden,
                $idCaptura
            );

            if (
                !$resultadoPago ||
                (int) $resultadoPago['registros_actualizados'] !== 1
            ) {
                throw new \RuntimeException(
                    'No fue posible confirmar el registro del pago.'
                );
            }

            // Registrar la inscripción del estudiante
            $inscripcion = $this->registrar(
                $idUsuario,
                $idCurso
            );

            // Confirmar ambas operaciones
            $conexion->commit();

            return [
                'pago' => [
                    'id_orden_paypal' => $idOrden,
                    'id_captura_paypal' => $idCaptura,
                    'estado' => 'completado'
                ],
                'inscripcion' => $inscripcion
            ];

        } catch (\Throwable $e) {

            // Revertir cambios si ocurre algún error
            if ($conexion->inTransaction()) {
                $conexion->rollBack();
            }

            throw $e;
        }
    }

    // Recuperar todos los cursos inscritos de un estudiante
    public function obtenerPorUsuario($idUsuario)
    {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_inscripcion' => null,
            'id_usuario' => $idUsuario,
            'id_curso' => null,
            'niveles_completados' => null
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Recuperar el detalle de una inscripción
    public function obtenerDetalle($idInscripcion, $idUsuario)
    {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 3,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_curso' => null,
            'niveles_completados' => null
        ]);

        $inscripcion = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $inscripcion;
    }

    // Actualizar el progreso y la última fecha de acceso
    public function actualizarProgreso(
        $idInscripcion,
        $idUsuario,
        $nivelesCompletados
    ) {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 4,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_curso' => null,
            'niveles_completados' => $nivelesCompletados
        ]);

        $respuesta = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $respuesta;
    }

    // Marcar un curso como completado
    public function completarCurso($idInscripcion, $idUsuario)
    {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 5,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_curso' => null,
            'niveles_completados' => null
        ]);

        $respuesta = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $respuesta;
    }

    // Recuperar los niveles de una inscripción
    public function obtenerNiveles($idInscripcion, $idUsuario)
    {
        $sql = "CALL sp_progreso_niveles(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_nivel
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_nivel' => null
        ]);

        $niveles = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $niveles;
    }

    // Marcar un nivel como completado
    public function marcarNivelCompletado(
        $idInscripcion,
        $idUsuario,
        $idNivel
    ) {
        $sql = "CALL sp_progreso_niveles(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_nivel
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_nivel' => $idNivel
        ]);

        $respuesta = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $respuesta;
    }

    // Obtener los datos del diploma
    public function obtenerDiploma($idInscripcion, $idUsuario)
    {
        $sql = "CALL sp_inscripciones(
            :opcion,
            :id_inscripcion,
            :id_usuario,
            :id_curso,
            :niveles_completados
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 6,
            'id_inscripcion' => $idInscripcion,
            'id_usuario' => $idUsuario,
            'id_curso' => null,
            'niveles_completados' => null
        ]);

        $diploma = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $diploma;
    }
}
