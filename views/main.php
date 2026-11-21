
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cursos</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <div class="container mt-5">

        <h3 class="mb-4">Cursos Recientes</h3>

        <div id="mensajeCursos" class="alert alert-info" role="status">
            Cargando cursos...
        </div>

        <div id="cursosCarousel" class="carousel slide">

            <div class="carousel-inner" id="listaCursos">
                <!-- JavaScript insertará aquí los cursos -->
            </div>

            <!-- Controles -->
            <button
                class="carousel-control-prev d-none"
                id="btnCursosAnterior"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">

                <span class="btn btn-dark">&#10094;</span>
                <span class="visually-hidden">Anterior</span>
            </button>

            <button
                class="carousel-control-next d-none"
                id="btnCursosSiguiente"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">

                <span class="btn btn-dark">&#10095;</span>
                <span class="visually-hidden">Siguiente</span>
            </button>

        </div>

        <h3 class="mb-4 mt-5">Cursos mejor valorados</h3>

        <div id="mensajeMejorValorados" class="alert alert-info" role="status">
            Cargando cursos mejor valorados...
        </div>

        <div id="mejorValoradosCarousel" class="carousel slide">

            <div class="carousel-inner" id="listaMejorValorados">
                <!-- JavaScript insertará aquí los cursos -->
            </div>

            <!-- Controles -->
            <button
                class="carousel-control-prev d-none"
                id="btnMejorValoradosAnterior"
                type="button"
                data-bs-target="#mejorValoradosCarousel"
                data-bs-slide="prev">

                <span class="btn btn-dark">&#10094;</span>
                <span class="visually-hidden">Anterior</span>
            </button>

            <button
                class="carousel-control-next d-none"
                id="btnMejorValoradosSiguiente"
                type="button"
                data-bs-target="#mejorValoradosCarousel"
                data-bs-slide="next">

                <span class="btn btn-dark">&#10095;</span>
                <span class="visually-hidden">Siguiente</span>
            </button>

        </div>

    </div>

    <?php include 'inc/footer.php'; ?>

    <!-- Bootstrap JavaScript -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript de cursos -->
    <script src="../public/js/main.js"></script>

    <!--<script src="../public/footer.js"></script>-->

</body>
</html>
