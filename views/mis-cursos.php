<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis cursos</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/mis-cursos.css">
</head>

<body>

    <!-- HEADER -->
    <header class="bg-dark text-white py-3 mb-4">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">

                <h1 class="h4 mb-0">
                    Mi plataforma
                </h1>

                <span id="tipoUsuario" class="badge bg-primary">
                    Usuario
                </span>

            </div>

        </div>
    </header>


    <!-- CONTENIDO -->
    <main class="container">

        <div class="mb-4">
            <h2 id="tituloCursos">
                Mis cursos
            </h2>

            <p class="text-muted" id="descripcionCursos">
                Cursos que has comprado.
            </p>
        </div>


        <!-- LISTA DE CURSOS -->
        <div id="listaCursos" class="row g-4">

            <!--
                Los cursos serán agregados mediante JavaScript.
                PDatos vendrán de la API.
            -->

        </div>


        <!-- MENSAJE CUANDO NO HAY CURSOS -->
        <div id="mensajeVacio" class="alert alert-info d-none">
            No tienes cursos para mostrar.
        </div>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/mis-cursos.js"></script>

</body>

</html>
