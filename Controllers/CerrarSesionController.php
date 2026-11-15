<?php

namespace Controllers;

class CerrarSesionController
{
    public function cerrar()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /ProyectoPWCI/views/registro-login.php');
        exit;
    }
}