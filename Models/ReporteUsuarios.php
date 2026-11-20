<?php

namespace Models;

use Core\App;
use Core\Database;

class ReporteUsuarios
{
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    public function obtenerReporte($opcion)
    {
        $sql = "CALL sp_reporte_usuarios(:opcion)";

        $resultado = $this->conn->query($sql, [
            'opcion' => $opcion
        ]);

        $usuarios = $resultado->get();

        // Consumir los resultados restantes del procedimiento
        while ($this->conn->statement->nextRowset()) {
        }

        return $usuarios;
    }
}