<?php

// Datos del usuario
$usuario = $usuario ?? [];

// Imagen de perfil
$imagenPerfil = !empty($usuario['imagen_perfil'])
    ? '/ProyectoPWCI/public/' . ltrim($usuario['imagen_perfil'], '/')
    : 'https://via.placeholder.com/150';

// Mensajes de sesión
$mensaje = $_SESSION['mensaje_perfil'] ?? null;
$tipoMensaje = $_SESSION['tipo_mensaje'] ?? 'info';

// Limpiar el mensaje después de recuperarlo
unset($_SESSION['mensaje_perfil']);
unset($_SESSION['tipo_mensaje']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi perfil</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/perfil.css">
</head>

<body>

    <!-- Header -->
    <?php require __DIR__ . '/inc/header.php'; ?>

    <main class="container perfil-container">

        <div class="row justify-content-center">

            <div class="col-md-9 col-lg-7">

                <div class="card perfil-card">

                    <!-- Encabezado -->
                    <div class="perfil-encabezado">
                        <h3>Mi perfil</h3>
                        <!--<p>Consulta y actualiza tu información personal</p>-->
                    </div>

                    <div class="card-body p-4 p-md-5">

                        <!-- Mensajes del controlador -->
                        <?php if ($mensaje): ?>

                            <div class="alert alert-<?= htmlspecialchars($tipoMensaje, ENT_QUOTES, 'UTF-8') ?>"
                                 role="alert">

                                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>

                            </div>

                        <?php endif; ?>

                        <!-- Formulario de actualización -->
                        <form
                            id="profileForm"
                            method="POST"
                            action="/ProyectoPWCI/public/perfil"
                            enctype="multipart/form-data"
                        >

                            <!-- Imagen de perfil -->
                            <div class="perfil-imagen text-center mb-4">

                                <img
                                    id="profilePreview"
                                    src="<?= htmlspecialchars($imagenPerfil, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Imagen de perfil"
                                    class="rounded-circle"
                                    width="150"
                                    height="150"
                                >

                                <div class="mt-3">

                                    <label
                                        for="profileImage"
                                        class="btn btn-outline-success"
                                    >
                                        Cambiar imagen
                                    </label>

                                    <input
                                        type="file"
                                        id="profileImage"
                                        name="imagen_perfil"
                                        class="d-none"
                                        accept="image/jpeg, image/png, image/webp"
                                    >

                                </div>

                            </div>

                            <!-- Nombre -->
                            <div class="mb-3">

                                <label for="nombre" class="form-label">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nombre"
                                    name="nombre"
                                    value="<?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    required
                                >

                            </div>

                            <!-- Apellido -->
                            <div class="mb-3">

                                <label for="apellido" class="form-label">
                                    Apellido
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="apellido"
                                    name="apellido"
                                    value="<?= htmlspecialchars($usuario['apellido'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    required
                                >

                            </div>

                            <!-- Género -->
                            <div class="mb-3">

                                <label for="genero" class="form-label">
                                    Género
                                </label>

                                <select
                                    class="form-select"
                                    id="genero"
                                    name="genero"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                        <?= empty($usuario['genero']) ? 'selected' : '' ?>
                                    >
                                        Selecciona una opción
                                    </option>

                                    <option
                                        value="Hombre"
                                        <?= ($usuario['genero'] ?? '') === 'Hombre' ? 'selected' : '' ?>
                                    >
                                        Hombre
                                    </option>

                                    <option
                                        value="Mujer"
                                        <?= ($usuario['genero'] ?? '') === 'Mujer' ? 'selected' : '' ?>
                                    >
                                        Mujer
                                    </option>

                                    <option
                                        value="Otro"
                                        <?= ($usuario['genero'] ?? '') === 'Otro' ? 'selected' : '' ?>
                                    >
                                        Otro
                                    </option>

                                </select>

                            </div>

                            <!-- Fecha de nacimiento -->
                            <div class="mb-3">

                                <label for="fechaNacimiento" class="form-label">
                                    Fecha de nacimiento
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="fechaNacimiento"
                                    name="fecha_nacimiento"
                                    value="<?= htmlspecialchars($usuario['fecha_nacimiento'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    required
                                >

                            </div>

                            <!-- Correo -->
                            <div class="mb-3">

                                <label for="correo" class="form-label">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="correo"
                                    name="correo"
                                    value="<?= htmlspecialchars($usuario['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    required
                                >

                            </div>

                            <!-- Contraseña -->
                            <div class="mb-3">

                                <label for="password" class="form-label">
                                    Nueva contraseña
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="contra"
                                    placeholder="Escribe una nueva contraseña"
                                >

                                <!--<div class="form-text">
                                    Deja este campo vacío si no deseas cambiar tu contraseña.
                                </div>-->

                            </div>

                            <!-- Botón -->
                            <div class="d-grid mt-4">

                                <button
                                    type="submit"
                                    class="btn btn-guardar"
                                >
                                    Guardar cambios
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Vista previa de la imagen -->
    <script>
        document.getElementById('profileImage').addEventListener('change', function(event) {

            const archivo = event.target.files[0];

            if (archivo) {
                const lector = new FileReader();

                lector.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };

                lector.readAsDataURL(archivo);
            }

        });
    </script>

</body>
</html>