<?php

namespace Models;

use Core\App;
use Core\Database;

class ReporteVentas
{
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Obtener el reporte de cursos
    public function obtenerReporte($idInstructor, $categoria)
    {
        $sql = "CALL sp_reporte_ventas(
            :opcion,
            :id_instructor,
            :categoria
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_instructor' => $idInstructor,
            'categoria' => $categoria
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Obtener los ingresos totales
    public function obtenerIngresosTotales($idInstructor)
    {
        $sql = "CALL sp_reporte_ventas(
            :opcion,
            :id_instructor,
            :categoria
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_instructor' => $idInstructor,
            'categoria' => null
        ]);

        $ingresos = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $ingresos;
    }

    // Obtener las categorías disponibles
    public function obtenerCategorias($idInstructor)
    {
        $sql = "CALL sp_reporte_ventas(
            :opcion,
            :id_instructor,
            :categoria
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 3,
            'id_instructor' => $idInstructor,
            'categoria' => null
        ]);

        $categorias = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $categorias;
    }

    // Obtener los ingresos de una categoría
    public function obtenerIngresosCategoria(
        $idInstructor,
        $categoria
    ) {
        $sql = "CALL sp_reporte_ventas(
            :opcion,
            :id_instructor,
            :categoria
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 4,
            'id_instructor' => $idInstructor,
            'categoria' => $categoria
        ]);

        $ingresos = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $ingresos;
    }
}