
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aula virtual</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/aula-virtual.css">
</head>

<body>
    <?php include 'inc/header.php'; ?>

    <main class="container aula-container">

        <section class="encabezado-aula mb-4">
            <span class="etiqueta-aula">MI APRENDIZAJE</span>

            <<h1 id="tituloCurso">Cargando curso...</h1>

            <!--<p id="descripcionCurso">
                Selecciona un nivel para comenzar a aprender.
            </p>-->

            <!-- PROGRESO GENERAL -->
            <div class="mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Tu progreso</strong>
                    <span id="porcentajeProgreso">0%</span>
                </div>

                <div class="progress">
                    <div
                        id="barraProgreso"
                        class="progress-bar bg-success"
                        role="progressbar"
                        style="width: 0%"
                        aria-valuenow="0"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENIDO DEL CURSO -->
        <div class="row g-4">

            <!-- VIDEO Y NIVEL SELECCIONADO -->
            <section class="col-lg-8">

                <div class="panel-video">

                    <h2 id="nombreNivel" class="h4 mb-3">
                        Selecciona un nivel
                    </h2>

                    <video
                        id="videoCurso"
                        class="video-curso"
                        controls
                        preload="metadata">
                        Tu navegador no soporta la reproducción de videos.
                    </video>

                    <div class="mt-4">
                        <button
                            type="button"
                            id="btnCompletarNivel"
                            class="btn btn-success"
                            disabled>
                            Marcar como completado
                        </button>

                        <span
                            id="mensajeNivel"
                            class="ms-2 text-success">
                        </span>
                    </div>

                </div>

            </section>

            <!-- LISTA DE NIVELES -->
            <aside class="col-lg-4">

                <div class="panel-niveles">

                    <h2 class="h5 mb-3">Contenido del curso</h2>

                    <div id="listaNiveles">

                        <!-- Los niveles se cargarán mediante JavaScript -->

                    </div>

                    <div
                        id="mensajeNiveles"
                        class="alert alert-info d-none mt-3">
                    </div>

                </div>

            </aside>

        </div>

        <!-- DIPLOMA -->
        <section
            id="seccionDiploma"
            class="seccion-diploma text-center mt-4 d-none">

            <h2 class="h3">¡Felicidades!</h2>

            <p>
                Has completado todos los niveles de este curso.
                Ya puedes obtener tu diploma.
            </p>

            <button
                type="button"
                id="btnDiploma"
                class="btn btn-success">
                Obtener diploma
            </button>

        </section>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/aula-virtual.js"></script>

</body>
</html>
