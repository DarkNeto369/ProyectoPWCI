<?php

namespace Models;

use Core\App;
use Core\Database;

class Curso
{
    private $tabla = 'cursos';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Agregar curso mediante el stored procedure
    public function agregar($datos)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen,
            :numero_nivel,
            :nombre_nivel,
            :video
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_curso' => null,
            'id_instructor' => $datos['id_instructor'] ?? null,
            'id_usuario' => null,
            'categoria' => $datos['categoria'] ?? null,
            'titulo' => $datos['titulo'] ?? null,
            'descripcion' => $datos['descripcion'] ?? null,
            'costo' => $datos['costo'] ?? null,
            'imagen' => $datos['imagen'] ?? null,
            'numero_nivel' => null,
            'nombre_nivel' => null,
            'video' => null
        ]);

        $curso = $resultado->first();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $curso;
    }

    // Agregar un nivel mediante el stored procedure
    public function agregarNivel($idCurso, $nivel)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen,
            :numero_nivel,
            :nombre_nivel,
            :video
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 6,
            'id_curso' => $idCurso,
            'id_instructor' => null,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null,
            'numero_nivel' => $nivel['numero_nivel'],
            'nombre_nivel' => $nivel['nombre'],
            'video' => $nivel['video']
        ]);

        $resultadoNivel = $resultado->first();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $resultadoNivel;
    }

    // Agregar curso y todos sus niveles en una transacción
    public function agregarConNiveles($datosCurso, $niveles)
    {
        $conexion = $this->conn->connection;

        try {

            // Iniciar transacción
            $conexion->beginTransaction();

            // Registrar el curso
            $curso = $this->agregar($datosCurso);

            $idCurso = (int) ($curso['id_curso'] ?? 0);

            if ($idCurso <= 0) {
                throw new \Exception(
                    'No se pudo recuperar el ID del curso.'
                );
            }

            // Registrar los niveles
            foreach ($niveles as $nivel) {
                $this->agregarNivel($idCurso, $nivel);
            }

            // Confirmar todos los cambios
            $conexion->commit();

            return [
                'id_curso' => $idCurso,
                'mensaje' => 'Curso y niveles agregados correctamente.',
                'total_niveles' => count($niveles)
            ];

        } catch (\Throwable $e) {

            // Revertir cambios si ocurre un error
            if ($conexion->inTransaction()) {
                $conexion->rollBack();
            }

            throw $e;
        }
    }

    // Recuperar los cursos recientes
    public function obtenerRecientes()
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen,
            :numero_nivel,
            :nombre_nivel,
            :video
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_curso' => null,
            'id_instructor' => null,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null,
            'numero_nivel' => null,
            'nombre_nivel' => null,
            'video' => null
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Recuperar los cursos de un instructor
    public function obtenerPorInstructor($id_instructor)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen,
            :numero_nivel,
            :nombre_nivel,
            :video
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 3,
            'id_curso' => null,
            'id_instructor' => $id_instructor,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null,
            'numero_nivel' => null,
            'nombre_nivel' => null,
            'video' => null
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Recuperar el detalle de un curso y sus niveles
    public function obtenerDetalle($id_curso)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen,
            :numero_nivel,
            :nombre_nivel,
            :video
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 5,
            'id_curso' => $id_curso,
            'id_instructor' => null,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null,
            'numero_nivel' => null,
            'nombre_nivel' => null,
            'video' => null
        ]);

        // Primer resultado: datos generales del curso
        $curso = $resultado->first();

        // Segundo resultado: niveles del curso
        $niveles = [];

        if ($this->conn->statement->nextRowset()) {
            $niveles = $this->conn->statement->fetchAll(
                \PDO::FETCH_ASSOC
            );
        }

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return [
            'curso' => $curso,
            'niveles' => $niveles
        ];
    }


    public function obtenerMejorValorados()
    {
        $this->conn->query(
            "CALL sp_cursos(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                7,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ]
        );

        $cursos = $this->conn->get();

        while ($this->conn->statement->nextRowset()) {}

        return $cursos;
    }
}