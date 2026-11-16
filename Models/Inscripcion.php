<?php

namespace Models;

use Core\App;
use Core\Database;

class Inscripcion
{
    private $tabla = 'inscripciones_cursos';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Registrar una compra mediante el stored procedure
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $inscripcion;
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
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

    while ($this->conn->statement->nextRowset()) {}

    return $diploma;
}
}