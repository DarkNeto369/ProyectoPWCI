
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

                        <p id="courseInstructor" class="text-muted">
                            Instructor:
                        </p>

                        <div class="mb-3">
                            <div id="courseStars" class="text-warning fs-4"></div>
                            <small id="courseRating" class="text-muted"></small>
                        </div>

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
            <section class="contenido-section mb-5">

                <div class="section-heading mb-4">
                    <span class="etiqueta-curso">APRENDIZAJE</span>

                    <h2>Contenido del curso</h2>

                    <p>
                        Conoce los niveles que componen este curso.
                    </p>
                </div>

                <div id="levelsContainer"></div>

            </section>

            <!-- Calificaciones -->
            <section class="mb-5" id="calificacionesSection">

                <div class="section-heading mb-4">
                    <span class="etiqueta-curso">OPINIONES</span>
                    <h2>Calificaciones del curso</h2>
                </div>

                <div id="ratingSummary" class="mb-4">
                    <!-- JavaScript insertará el promedio -->
                </div>

                <div id="ratingFormContainer" class="d-none">

                    <h5>Califica este curso</h5>

                    <form id="ratingForm">

                        <div class="mb-3">
                            <label for="ratingSelect" class="form-label">
                                Tu calificación
                            </label>

                            <select id="ratingSelect" class="form-select" required>
                                <option value="">Selecciona una calificación</option>
                                <option value="5">5 - Excelente</option>
                                <option value="4">4 - Muy bueno</option>
                                <option value="3">3 - Bueno</option>
                                <option value="2">2 - Regular</option>
                                <option value="1">1 - Malo</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Enviar calificación
                        </button>

                    </form>

                    <div id="mensajeCalificacion" class="mt-3"></div>

                </div>

            </section>

            <!-- Comentarios -->
            <section class="mb-5" id="comentariosSection">

                <div class="section-heading mb-4">
                    <span class="etiqueta-curso">COMUNIDAD</span>
                    <h2>Comentarios de los estudiantes</h2>
                </div>

                <div id="listaComentarios" class="mb-4">
                    Cargando comentarios...
                </div>

                <div id="comentarioFormContainer" class="d-none">

                    <h5>Deja tu comentario</h5>

                    <form id="comentarioForm">

                        <div class="mb-3">
                            <label for="textoComentario" class="form-label">
                                Escribe tu opinión
                            </label>

                            <textarea
                                id="textoComentario"
                                class="form-control"
                                rows="4"
                                maxlength="2000"
                                required
                                placeholder="Comparte tu experiencia con este curso..."
                            ></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Publicar comentario
                        </button>

                    </form>

                    <div id="mensajeComentario" class="mt-3"></div>

                </div>

            </section>

        </section>

    </main>

    <!-- Identificar el rol de la sesión -->
    <script>
        window.ROL_USUARIO = <?= json_encode($_SESSION['rol'] ?? '') ?>;
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/detalle-curso.js"></script>

</body>
</html>
