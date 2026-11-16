<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis cursos - Instructor</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/mis-cursos.css">

</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="container cursos-container">

        <div class="cursos-panel">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>
                    <h2 class="main-title" id="tituloCursos">
                        Mis cursos
                    </h2>

                    <p class="subtitle mb-0" id="descripcionCursos">
                        Cursos que has creado como instructor.
                    </p>
                </div>

                <a
                    href="/ProyectoPWCI/public/crear-curso"
                    class="btn btn-crear-curso"
                >
                    + Crear curso
                </a>

            </div>

            <hr>

            <div id="listaCursos" class="row g-4"></div>

            <div id="mensajeVacio" class="alert alert-info d-none mt-4">
                Cargando tus cursos...
            </div>

        </div>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/mis-cursos-instructor.js"></script>

</body>

</html>
