<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login / Registro</title>

    <!-- Bootstrap -->
   <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow">

                    <div class="card-body p-4">

                        <!-- Login -->

                        <div id="loginForm">

                            <h2 class="text-center mb-4">
                                Iniciar sesión
                            </h2>

                            <form method="POST" action="/PruebaPWCI/public/registro-login">

                                <!-- Correo -->
                                <div class="mb-3">
                                    <label for="loginCorreo" class="form-label">
                                        Correo
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        id="loginCorreo"
                                        placeholder="correo@ejemplo.com"
                                        required
                                    >
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">
                                        Contraseña
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="loginPassword"
                                        placeholder="Contraseña"
                                        required
                                    >
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                    onclick = "iniciarSesion(event)"
                                >
                                    Iniciar sesión
                                </button>

                            </form>

                            <div class="text-center mt-3">

                                <span>
                                    ¿No tienes una cuenta?
                                </span>

                                <button
                                    type="button"
                                    class="btn btn-link p-0"
                                    onclick="mostrarRegistro()"
                                >
                                    Registrarse
                                </button>

                            </div>

                        </div>


                        <!-- Registro  -->

                        <div id="registroForm" class="d-none">

                            <h2 class="text-center mb-4">
                                Crear cuenta
                            </h2>

                            <form>

                                <!-- Imagen de perfil -->

                                <div class="text-center mb-4">

                                    <img
                                        id="imagenPreview"
                                        src="https://via.placeholder.com/150"
                                        alt="Imagen de perfil"
                                        class="rounded-circle border mb-3"
                                        width="150"
                                        height="150"
                                        style="object-fit: cover;"
                                    >

                                    <div>
                                        <label
                                            for="imagenPerfil"
                                            class="btn btn-outline-primary"
                                        >
                                            Seleccionar imagen
                                        </label>

                                        <input
                                            type="file"
                                            id="imagenPerfil"
                                            class="d-none"
                                            accept="image/*"
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
                                        placeholder="Nombre"
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
                                        placeholder="Apellido"
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
                                        required
                                    >

                                        <option value="" selected disabled>
                                            Selecciona una opción
                                        </option>

                                        <option value="masculino">
                                            Masculino
                                        </option>

                                        <option value="femenino">
                                            Femenino
                                        </option>

                                        <option value="otro">
                                            Otro
                                        </option>

                                        <option value="prefiero_no_decirlo">
                                            Prefiero no decirlo
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
                                        required
                                    >

                                </div>


                                <!-- Correo -->

                                <div class="mb-3">

                                    <label for="registroCorreo" class="form-label">
                                        Correo
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        id="registroCorreo"
                                        placeholder="correo@ejemplo.com"
                                        required
                                    >

                                </div>


                                <!-- Contraseña -->

                                <div class="mb-3">

                                    <label
                                        for="registroPassword"
                                        class="form-label"
                                    >
                                        Contraseña
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="registroPassword"
                                        placeholder="Contraseña"
                                        required
                                    >

                                </div>


                                <!-- Botón registrar -->

                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                >
                                    Registrarse
                                </button>

                            </form>


                            <div class="text-center mt-3">

                                <span>
                                    ¿Ya tienes una cuenta?
                                </span>

                                <button
                                    type="button"
                                    class="btn btn-link p-0"
                                    onclick="mostrarLogin()"
                                >
                                    Iniciar sesión
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
    
    <script src="../public/js/registro-login.js"></script>

</body>
</html>