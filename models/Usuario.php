<?php

namespace Models;

use Core\App;
use Core\Database;

class Usuario
{
    private $tabla = 'usuarios';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Buscar usuario por correo
    public function buscarPorCorreo($correo)
    {
        $stmt = $this->conn->query(
            "SELECT * FROM {$this->tabla} WHERE correo = :correo",
            ['correo' => $correo]
        );

        return $stmt->first();
    }

    // Buscar usuario por ID
    public function buscarPorId($id_usuario)
    {
        $stmt = $this->conn->query(
            "SELECT * FROM {$this->tabla} WHERE id_usuario = :id_usuario",
            ['id_usuario' => $id_usuario]
        );

        return $stmt->first();
    }

    // Registrar usuario
    public function registrar($datos)
    {
        $sql = "CALL sp_usuarios(
            :opcion,
            :id_usuario,
            :imagen_perfil,
            :nombre,
            :apellido,
            :genero,
            :fecha_nacimiento,
            :rol,
            :correo,
            :contra
        )";

        $this->conn->query($sql, [
            'opcion' => 1,
            'id_usuario' => null,
            'imagen_perfil' => $datos['imagen_perfil'] ?? null,
            'nombre' => $datos['nombre'] ?? null,
            'apellido' => $datos['apellido'] ?? null,
            'genero' => $datos['genero'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'rol' => $datos['rol'] ?? null,
            'correo' => $datos['correo'],
            'contra' => $datos['contra']
        ]);

        // Liberar los resultados pendientes del procedimiento
        while ($this->conn->statement->nextRowset()) {
            // Consumir los conjuntos de resultados restantes
        }

        return true;
    }
}