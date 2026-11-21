
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear curso</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/crear-curso.css">
</head>

<body>

    <!-- Header -->
    <?php include 'inc/header.php'; ?>

    <main class="container course-container">

        <div class="card course-card">

            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-5">
                    <h2 class="main-title">Crear nuevo curso</h2>
                    <!--<p class="subtitle">
                        Comparte tus conocimientos y crea una experiencia de aprendizaje.
                    </p>-->
                </div>

                <!-- Información del curso -->

                <h5 class="section-title mb-3">
                    Información del curso
                </h5>

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">
                        Categoría
                    </label>

                    <select id="categoria" class="form-select">
                        <option value="">Selecciona una categoría</option>
                        <option value="programacion">Programación</option>
                        <option value="diseno">Diseño</option>
                        <option value="marketing">Marketing</option>
                        <option value="fotografia">Fotografía</option>
                        <option value="negocios">Negocios</option>
                        <option value="idiomas">Idiomas</option>
                    </select>
                </div>

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">
                        Título del curso
                    </label>

                    <input
                        type="text"
                        id="titulo"
                        class="form-control"
                    >
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        class="form-control"
                        rows="5"
                    ></textarea>
                </div>

                <!-- Imagen del curso -->
                <div class="mb-4">
                    <label for="imagen" class="form-label">
                        Imagen del curso
                    </label>

                    <input
                        type="file"
                        id="imagen"
                        class="form-control"
                        accept="image/*"
                    >

                    <div class="mt-3 text-center">
                        <img
                            id="vistaPreviaImagen"
                            src=""
                            alt="Vista previa del curso"
                            style="display: none; max-width: 300px; max-height: 180px; object-fit: cover; border-radius: 10px;"
                        >
                    </div>
                </div>

                <!-- Costo -->
                <div class="mb-4">
                    <label for="costo" class="form-label">
                        Costo
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">$</span>

                        <input
                            type="number"
                            id="costo"
                            class="form-control"
                            placeholder="0.00"
                            min="0"
                            step="0.01"
                        >

                        <span class="input-group-text">MXN</span>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Niveles -->

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

                    <div>
                        <h5 class="section-title mb-1">
                            Niveles del curso
                        </h5>

                        <small class="text-muted">
                            Puedes agregar hasta 3 niveles.
                        </small>
                    </div>

                    <button
                        type="button"
                        id="agregarNivel"
                        class="btn btn-agregar-nivel"
                    >
                        + Agregar nivel
                    </button>

                </div>

                <!-- Aquí aparecerán los niveles -->
                <div id="nivelesContainer"></div>

                <!-- Guardar -->

                <div class="d-grid mt-5">

                    <button
                        type="button"
                        id="guardarCurso"
                        class="btn btn-crear-curso btn-lg"
                    >
                        Crear curso
                    </button>

                </div>

            </div>
        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/crear-curso.js"></script>

</body>
</html>
