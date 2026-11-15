
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del curso</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/detalle-curso.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="container py-5">

        <a href="/ProyectoPWCI/public/main" class="btn btn-volver mb-4">
            ← Volver a los cursos
        </a>

        <div id="mensajeCurso" class="alert alert-info">
            Cargando información del curso...
        </div>

        <section id="detalleCurso" class="detalle-contenedor d-none">

            <!-- Información principal -->
            <div class="course-header mb-5">

                <div class="row align-items-center g-4">

                    <div class="col-lg-7">

                        <span class="etiqueta-curso">
                            CURSO EN LÍNEA
                        </span>

                        <h1 id="courseTitle" class="course-title mt-3">
                            Nombre del curso
                        </h1>

                        <p id="courseCategory" class="course-category">
                            Categoría
                        </p>

                        <p id="courseDescription" class="course-description">
                            Descripción del curso
                        </p>

                    </div>

                    <div class="col-lg-5">

                        <div class="course-image-container">
                            <img
                                id="courseImage"
                                src="https://placehold.co/600x400?text=Curso"
                                alt="Imagen del curso"
                                class="course-image"
                            >
                        </div>

                    </div>

                </div>

                <div class="row align-items-center mt-4 pt-4 course-footer">

                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Precio del curso</p>

                        <div id="coursePrice" class="price">
                            $0 MXN
                        </div>
                    </div>

                    <div class="col-md-6 mt-3 mt-md-0 text-md-end">

                        <button
                            id="buyButton"
                            type="button"
                            class="btn btn-comprar btn-lg"
                        >
                            Comprar curso
                        </button>

                    </div>

                </div>

            </div>

            <!-- Contenido del curso -->
            <section class="contenido-section">

                <div class="section-heading mb-4">
                    <span class="etiqueta-curso">APRENDIZAJE</span>

                    <h2>Contenido del curso</h2>

                    <p>
                        Conoce los niveles que componen este curso.
                    </p>
                </div>

                <div id="levelsContainer">

                    <!-- Los niveles se cargarán mediante JavaScript -->

                </div>

            </section>

        </section>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/detalle-curso.js"></script>

</body>
</html>
