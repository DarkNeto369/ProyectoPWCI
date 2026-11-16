
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis cursos</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/mis-cursos.css">
</head>

<body>

    <!-- HEADER COMPARTIDO -->
    <?php include 'inc/header.php'; ?>

    <main class="container mis-cursos-container">

        <!-- ENCABEZADO -->
        <section class="encabezado-cursos">
            <div>
                <span class="etiqueta-cursos">MI APRENDIZAJE</span>

                <h1 id="tituloCursos">
                    Mis cursos
                </h1>

                <p id="descripcionCursos">
                    Continúa aprendiendo y lleva tu conocimiento al siguiente nivel.
                </p>
            </div>
        </section>

        <!-- LISTA DE CURSOS -->
        <section class="seccion-cursos">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Mis inscripciones</h2>
            </div>

            <div id="listaCursos" class="row g-4">

                <!-- Los cursos serán agregados mediante JavaScript -->

            </div>

            <!-- MENSAJE CUANDO NO HAY CURSOS -->
            <div id="mensajeVacio" class="alert alert-info d-none">
                No tienes cursos para mostrar.
            </div>

        </section>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/mis-cursos.js"></script>

</body>
</html>
