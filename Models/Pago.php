<?php

namespace Models;

use Core\App;
use Core\Database;

class Pago
{
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Ejecutar el procedimiento almacenado
    private function ejecutarSP($parametros)
    {
        $sql = "CALL sp_pagos_cursos(
            :opcion,
            :id_pago,
            :id_usuario,
            :id_curso,
            :id_instructor,
            :id_orden_paypal,
            :id_captura_paypal,
            :monto,
            :moneda,
            :forma_pago
        )";

        return $this->conn->query($sql, $parametros);
    }

    // 1. Registrar un pago pendiente
    public function registrarPendiente($datos)
    {
        $resultado = $this->ejecutarSP([
            'opcion' => 1,
            'id_pago' => null,
            'id_usuario' => $datos['id_usuario'],
            'id_curso' => $datos['id_curso'],
            'id_instructor' => $datos['id_instructor'],
            'id_orden_paypal' => $datos['id_orden_paypal'],
            'id_captura_paypal' => null,
            'monto' => $datos['monto'],
            'moneda' => $datos['moneda'] ?? 'MXN',
            'forma_pago' => $datos['forma_pago'] ?? 'PayPal'
        ]);

        $pago = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $pago;
    }

    // 2. Buscar un pago mediante la orden de PayPal
    public function obtenerPorOrden($idOrden)
    {
        $resultado = $this->ejecutarSP([
            'opcion' => 2,
            'id_pago' => null,
            'id_usuario' => null,
            'id_curso' => null,
            'id_instructor' => null,
            'id_orden_paypal' => $idOrden,
            'id_captura_paypal' => null,
            'monto' => null,
            'moneda' => null,
            'forma_pago' => null
        ]);

        $pago = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $pago;
    }

    // 3. Confirmar un pago completado
    public function confirmarPago($idOrden, $idCaptura)
    {
        $resultado = $this->ejecutarSP([
            'opcion' => 3,
            'id_pago' => null,
            'id_usuario' => null,
            'id_curso' => null,
            'id_instructor' => null,
            'id_orden_paypal' => $idOrden,
            'id_captura_paypal' => $idCaptura,
            'monto' => null,
            'moneda' => null,
            'forma_pago' => null
        ]);

        $actualizado = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $actualizado;
    }

    // 4. Recuperar las ventas de cada curso del instructor
    public function obtenerVentasPorInstructor($idInstructor)
    {
        $resultado = $this->ejecutarSP([
            'opcion' => 4,
            'id_pago' => null,
            'id_usuario' => null,
            'id_curso' => null,
            'id_instructor' => $idInstructor,
            'id_orden_paypal' => null,
            'id_captura_paypal' => null,
            'monto' => null,
            'moneda' => null,
            'forma_pago' => null
        ]);

        $ventas = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $ventas;
    }

    // 5. Recuperar los ingresos totales del instructor
    public function obtenerIngresosTotales($idInstructor)
    {
        $resultado = $this->ejecutarSP([
            'opcion' => 5,
            'id_pago' => null,
            'id_usuario' => null,
            'id_curso' => null,
            'id_instructor' => $idInstructor,
            'id_orden_paypal' => null,
            'id_captura_paypal' => null,
            'monto' => null,
            'moneda' => null,
            'forma_pago' => null
        ]);

        $ingresos = $resultado->first();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $ingresos;
    }
}