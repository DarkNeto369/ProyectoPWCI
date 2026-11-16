
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del curso - Instructor</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/detalle-curso-instructor.css">

</head>

<body>

    <!-- HEADER -->
    <?php include 'inc/header.php'; ?>

    <main class="container detalle-container">

        <!-- Regresar -->
        <a href="/ProyectoPWCI/public/mis-cursos-instructor"
           class="btn btn-regresar mb-4">
            ← Mis cursos
        </a>

        <!-- Mensaje de carga -->
        <div id="mensajeCurso" class="alert alert-info">
            Cargando información del curso...
        </div>

        <!-- DETALLE DEL CURSO -->
        <section id="detalleCurso" class="detalle-panel d-none">

            <div class="row g-4">

                <!-- Imagen -->
                <div class="col-12 col-lg-5">

                    <img
                        id="courseImage"
                        src=""
                        alt="Imagen del curso"
                        class="imagen-curso"
                    >

                </div>

                <!-- Información -->
                <div class="col-12 col-lg-7">

                    <span id="courseCategory" class="categoria-curso">
                        Categoría
                    </span>

                    <h2 id="courseTitle" class="titulo-curso">
                        Nombre del curso
                    </h2>

                    <p id="courseDescription" class="descripcion-curso">
                        Descripción del curso.
                    </p>

                    <h3 id="coursePrice" class="precio-curso">
                        $0.00 MXN
                    </h3>

                    <!-- Acciones del instructor -->
                    <div class="acciones-curso mt-4">

                        <button
                            type="button"
                            id="modifyButton"
                            class="btn btn-modificar">
                            Modificar curso
                        </button>

                        <button
                            type="button"
                            id="deleteButton"
                            class="btn btn-eliminar">
                            Eliminar curso
                        </button>

                    </div>

                </div>

            </div>

            <hr class="my-5">

            <!-- NIVELES -->
            <div class="niveles-section">

                <h3 class="titulo-niveles">
                    Contenido del curso
                </h3>

                <div id="levelsContainer" class="mt-4">

                    <!-- JavaScript insertará los niveles -->

                </div>

            </div>

        </section>

    </main>

    <!-- Bootstrap JS -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript del detalle del instructor -->
    <script src="../public/js/detalle-curso-instructor.js"></script>

</body>

</html>
