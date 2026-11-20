<?php

use Controllers\PerfilController;

$controlador = new PerfilController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador->actualizar();
} else {
    $controlador->mostrar();
}