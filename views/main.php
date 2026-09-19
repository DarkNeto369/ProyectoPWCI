<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWCI</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body >
    <?php include 'inc/header.php'; ?>

    <main class="bg-emerald-100">

    <!--Cursos recientes-->

    <div class="container">
        <h3 class="mb-4 p-2 text-center">Cursos recientes</h3>
        <div id="cursosCarousel" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="0" class="active"></button>

            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de HTML y CSS">
                            <div class="card-body">
                                <h5 class="card-title">
                                    HTML y CSS desde cero
                                </h5>
                                <p class="card-text text-muted">
                                    Juan Pérez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.8)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $299 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de JavaScript">
                            <div class="card-body">
                                <h5 class="card-title">
                                    JavaScript para principiantes
                                </h5>
                                <p class="card-text text-muted">
                                    María López
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★☆</span>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $399 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de PHP">
                            <div class="card-body">
                                <h5 class="card-title">
                                    PHP y MySQL
                                </h5>
                                <p class="card-text text-muted">
                                    Carlos Ramírez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.9)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $499 MXN
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anterior -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- Siquiente -->
        <button class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <!--Los mejor valorados-->

            <div class="container my-5">
        <h2 class="mb-4 text-center">Los mejor valorados</h2>
        <div id="cursosCarousel" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="0" class="active"></button>

            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de HTML y CSS">
                            <div class="card-body">
                                <h5 class="card-title">
                                    HTML y CSS desde cero
                                </h5>
                                <p class="card-text text-muted">
                                    Juan Pérez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.8)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $299 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de JavaScript">
                            <div class="card-body">
                                <h5 class="card-title">
                                    JavaScript para principiantes
                                </h5>
                                <p class="card-text text-muted">
                                    María López
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★☆</span>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $399 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de PHP">
                            <div class="card-body">
                                <h5 class="card-title">
                                    PHP y MySQL
                                </h5>
                                <p class="card-text text-muted">
                                    Carlos Ramírez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.9)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $499 MXN
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anterior -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- Siquiente -->
        <button class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <!--Los más vendidos-->

            <div class="container my-5">
        <h2 class="mb-4 text-center">Los más vendidos</h2>
        <div id="cursosCarousel" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="0" class="active"></button>

            <button type="button" data-bs-target="#cursosCarousel"
                    data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de HTML y CSS">
                            <div class="card-body">
                                <h5 class="card-title">
                                    HTML y CSS desde cero
                                </h5>
                                <p class="card-text text-muted">
                                    Juan Pérez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.8)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $299 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de JavaScript">
                            <div class="card-body">
                                <h5 class="card-title">
                                    JavaScript para principiantes
                                </h5>
                                <p class="card-text text-muted">
                                    María López
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★☆</span>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $399 MXN
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="../assets/img/1.png"
                                 class="card-img-top"
                                 alt="Curso de PHP">
                            <div class="card-body">
                                <h5 class="card-title">
                                    PHP y MySQL
                                </h5>
                                <p class="card-text text-muted">
                                    Carlos Ramírez
                                </p>
                                <div class="mb-2">
                                    <span class="text-warning">★★★★★</span>
                                    <small class="text-muted">(4.9)</small>
                                </div>
                                <h5 class="fw-bold">
                                    $499 MXN
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anterior -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- Siquiente -->
        <button class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

    </main>

    <script src="../public/js/header.js"></script>
    <!--<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>-->
</body>
</html>