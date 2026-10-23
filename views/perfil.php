<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi perfil</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6">

                <div class="card shadow-sm">

                    <div class="card-body p-4">

                        <h2 class="text-center mb-4">
                            Mi perfil
                        </h2>

                        <!-- Imagen de perfil -->
                        <div class="text-center mb-4">

                            <img
                                id="profilePreview"
                                src="https://via.placeholder.com/150"
                                alt="Imagen de perfil"
                                class="rounded-circle mb-3"
                                width="150"
                                height="150"
                                style="object-fit: cover;"
                            >

                            <div>
                                <label
                                    for="profileImage"
                                    class="btn btn-outline-primary"
                                >
                                    Cambiar imagen
                                </label>

                                <input
                                    type="file"
                                    id="profileImage"
                                    class="d-none"
                                    accept="image/*"
                                >
                            </div>

                        </div>

                        <!-- Formulario -->
                        <form id="profileForm">

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label
                                    for="nombre"
                                    class="form-label"
                                >
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Nombre"
                                    required
                                >
                            </div>

                            <!-- Apellido -->
                            <div class="mb-3">
                                <label
                                    for="apellido"
                                    class="form-label"
                                >
                                    Apellido
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="apellido"
                                    name="apellido"
                                    placeholder="Apellido"
                                    required
                                >
                            </div>

                            <!-- Género -->
                            <div class="mb-3">
                                <label
                                    for="genero"
                                    class="form-label"
                                >
                                    Género
                                </label>

                                <select
                                    class="form-select"
                                    id="genero"
                                    name="genero"
                                    required
                                >
                                    <option value="" selected disabled>
                                        Selecciona una opción
                                    </option>

                                    <option value="hombre">
                                        Hombre
                                    </option>

                                    <option value="mujer">
                                        Mujer
                                    </option>

                                    <option value="otro">
                                        Otro
                                    </option>
                                </select>
                            </div>

                            <!-- Fecha de nacimiento -->
                            <div class="mb-3">
                                <label
                                    for="fechaNacimiento"
                                    class="form-label"
                                >
                                    Fecha de nacimiento
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="fechaNacimiento"
                                    name="fechaNacimiento"
                                    required
                                >
                            </div>

                            <!-- Correo -->
                            <div class="mb-3">
                                <label
                                    for="correo"
                                    class="form-label"
                                >
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="correo"
                                    name="correo"
                                    placeholder="correo@ejemplo.com"
                                    required
                                >
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-3">
                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Nueva contraseña"
                                >

                                <div class="form-text">
                                    Deja este campo vacío si no deseas cambiar tu contraseña.
                                </div>
                            </div>

                            <!-- Botón guardar -->
                            <div class="d-grid mt-4">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Guardar cambios
                                </button>

                            </div>

                        </form>

                        <!-- Mensaje -->
                        <div
                            id="message"
                            class="alert mt-4 d-none"
                            role="alert"
                        ></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="../public/js/perfil.js"></script>

</body>

</html>