<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle del curso</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/detalle-curso.css">
</head>

<body>

    <!-- Contenedor principal -->
    <div class="container py-5">

        <!-- Información principal del curso -->
        <section class="course-header mb-5">

            <div class="row align-items-center">

                <!-- Información -->
                <div class="col-md-8">

                    <h1 id="courseTitle">
                        Desarrollo Web desde Cero
                    </h1>

                    <p id="courseDescription" class="text-muted">
                        Aprende los fundamentos del desarrollo web utilizando
                        HTML, CSS, Bootstrap y JavaScript.
                    </p>

                    <p class="mb-0">
                        <strong>Curso en línea</strong>
                    </p>

                </div>

                <!-- Precio y botón -->
                <div class="col-md-4 text-md-end mt-4 mt-md-0">

                    <div id="coursePrice" class="price mb-3">
                        $499 MXN
                    </div>

                    <!--  "Continuar curso" si el usuario ya compró -->
                    <button
                        id="buyButton"
                        type="button"
                        class="btn btn-primary btn-lg w-100"
                        onclick="buyCourse()"
                    >
                        Comprar curso
                    </button>

                </div>

            </div>

        </section>


        <!-- Contenido del curso -->
        <section>

            <h2 class="mb-4">
                Contenido del curso
            </h2>


            <!-- Nivel 1 -->
            <div class="level-card">

                <h4>
                    Nivel 1: Introducción al desarrollo web
                </h4>

                <p class="text-muted mb-0">
                    Aprende los conceptos básicos del desarrollo web,
                    la estructura de una página y los fundamentos de HTML.
                </p>

            </div>


            <!-- Nivel 2 -->
            <div class="level-card">

                <h4>
                    Nivel 2: Diseño con CSS y Bootstrap
                </h4>

                <p class="text-muted mb-0">
                    Aprende a darle diseño y estructura a tus páginas
                    utilizando CSS y el framework Bootstrap.
                </p>

            </div>


            <!-- Nivel 3 -->
            <div class="level-card">

                <h4>
                    Nivel 3: JavaScript
                </h4>

                <p class="text-muted mb-0">
                    Aprende los fundamentos de JavaScript y cómo agregar
                    interactividad y comportamiento dinámico a tus páginas.
                </p>

            </div>

        </section>

    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/detalle-curso.js"></script>

</body>
</html>