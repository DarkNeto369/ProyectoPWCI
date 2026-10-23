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
        $resultado = $this->conn->query(
            "SELECT * FROM {$this->tabla} WHERE correo = :correo",
            [
                'correo' => $correo
            ]
        );

        return $resultado->first();
    }

    // Buscar usuario por ID
    public function buscarPorId($id_usuario)
    {
        $resultado = $this->conn->query(
            "SELECT * FROM {$this->tabla} WHERE id_usuario = :id_usuario",
            [
                'id_usuario' => $id_usuario
            ]
        );

        return $resultado->first();
    }

    // Registrar usuario mediante el stored procedure
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
            // Consumir resultados
        }

        return true;
    }

    // Buscar usuario para el login mediante el stored procedure
    public function buscarParaLogin($correo)
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

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_usuario' => null,
            'imagen_perfil' => null,
            'nombre' => null,
            'apellido' => null,
            'genero' => null,
            'fecha_nacimiento' => null,
            'rol' => null,
            'correo' => $correo,
            'contra' => null
        ]);

        $usuario = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $usuario;
    }
}