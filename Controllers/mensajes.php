<?php

$controlador = new \Controllers\MensajeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador->enviar();
} elseif (isset($_GET['id_curso'], $_GET['id_contacto'])) {
    $controlador->obtenerMensajes();
} else {
    $controlador->obtenerConversaciones();
}