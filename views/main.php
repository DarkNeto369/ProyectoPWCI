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

        <h2 class="mb-4">Cursos populares</h2>

        <div id="cursosCarousel" class="carousel slide">

            <div class="carousel-inner">

                <!-- Página 1 -->
                <div class="carousel-item active">
                    <div class="row">

                        <div class="col-md-3">

                            <a href="detalle-curso.php">

                                <div class="card">
                                    <img src="https://picsum.photos/400/225?random=1"
                                        class="card-img-top"
                                        alt="Curso">

                                    <div class="card-body">
                                        <h5 class="card-title">
                                            Desarrollo Web Completo
                                        </h5>

                                        <p class="card-text">
                                            Juan Pérez
                                        </p>

                                        <p class="mb-2">
                                            ⭐⭐⭐⭐⭐
                                        </p>

                                        <strong>$499 MXN</strong>
                                    </div>
                                </div>


                            </a>

                                
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=2"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        JavaScript desde Cero
                                    </h5>

                                    <p class="card-text">
                                        Ana García
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$399 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=3"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Python para Principiantes
                                    </h5>

                                    <p class="card-text">
                                        Carlos López
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$599 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=4"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        React.js Profesional
                                    </h5>

                                    <p class="card-text">
                                        María Torres
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$699 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Página 2 -->
                <div class="carousel-item">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=5"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        HTML y CSS
                                    </h5>

                                    <p class="card-text">
                                        Pedro Ramírez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$299 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=6"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bootstrap 5
                                    </h5>

                                    <p class="card-text">
                                        Laura Martínez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$349 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=7"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Node.js
                                    </h5>

                                    <p class="card-text">
                                        Diego Sánchez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$549 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=8"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bases de Datos
                                    </h5>

                                    <p class="card-text">
                                        Sofía Hernández
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$449 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Flecha izquierda -->
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">

                <span class="btn btn-dark">
                    &#10094;
                </span>

                <span class="visually-hidden">
                    Anterior
                </span>
            </button>

            <!-- Flecha derecha -->
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">

                <span class="btn btn-dark">
                    &#10095;
                </span>

                <span class="visually-hidden">
                    Siguiente
                </span>
            </button>

        </div>





        <h2 class="mb-4">Cursos populares</h2>

        <div id="cursosCarousel" class="carousel slide">

            <div class="carousel-inner">

                <!-- Página 1 -->
                <div class="carousel-item active">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=1"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Desarrollo Web Completo
                                    </h5>

                                    <p class="card-text">
                                        Juan Pérez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$499 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=2"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        JavaScript desde Cero
                                    </h5>

                                    <p class="card-text">
                                        Ana García
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$399 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=3"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Python para Principiantes
                                    </h5>

                                    <p class="card-text">
                                        Carlos López
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$599 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=4"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        React.js Profesional
                                    </h5>

                                    <p class="card-text">
                                        María Torres
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$699 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Página 2 -->
                <div class="carousel-item">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=5"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        HTML y CSS
                                    </h5>

                                    <p class="card-text">
                                        Pedro Ramírez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$299 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=6"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bootstrap 5
                                    </h5>

                                    <p class="card-text">
                                        Laura Martínez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$349 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=7"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Node.js
                                    </h5>

                                    <p class="card-text">
                                        Diego Sánchez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$549 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=8"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bases de Datos
                                    </h5>

                                    <p class="card-text">
                                        Sofía Hernández
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$449 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Flecha izquierda -->
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">

                <span class="btn btn-dark">
                    &#10094;
                </span>

                <span class="visually-hidden">
                    Anterior
                </span>
            </button>

            <!-- Flecha derecha -->
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">

                <span class="btn btn-dark">
                    &#10095;
                </span>

                <span class="visually-hidden">
                    Siguiente
                </span>
            </button>

        </div>



        <h2 class="mb-4">Cursos populares</h2>

        <div id="cursosCarousel" class="carousel slide">

            <div class="carousel-inner">

                <!-- Página 1 -->
                <div class="carousel-item active">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=1"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Desarrollo Web Completo
                                    </h5>

                                    <p class="card-text">
                                        Juan Pérez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$499 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=2"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        JavaScript desde Cero
                                    </h5>

                                    <p class="card-text">
                                        Ana García
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$399 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=3"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Python para Principiantes
                                    </h5>

                                    <p class="card-text">
                                        Carlos López
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$599 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=4"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        React.js Profesional
                                    </h5>

                                    <p class="card-text">
                                        María Torres
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$699 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Página 2 -->
                <div class="carousel-item">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=5"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        HTML y CSS
                                    </h5>

                                    <p class="card-text">
                                        Pedro Ramírez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$299 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=6"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bootstrap 5
                                    </h5>

                                    <p class="card-text">
                                        Laura Martínez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$349 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=7"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Node.js
                                    </h5>

                                    <p class="card-text">
                                        Diego Sánchez
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐⭐
                                    </p>

                                    <strong>$549 MXN</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <img src="https://picsum.photos/400/225?random=8"
                                    class="card-img-top"
                                    alt="Curso">

                                <div class="card-body">
                                    <h5 class="card-title">
                                        Bases de Datos
                                    </h5>

                                    <p class="card-text">
                                        Sofía Hernández
                                    </p>

                                    <p class="mb-2">
                                        ⭐⭐⭐⭐☆
                                    </p>

                                    <strong>$449 MXN</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Flecha izquierda -->
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="prev">

                <span class="btn btn-dark">
                    &#10094;
                </span>

                <span class="visually-hidden">
                    Anterior
                </span>
            </button>

            <!-- Flecha derecha -->
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#cursosCarousel"
                data-bs-slide="next">

                <span class="btn btn-dark">
                    &#10095;
                </span>

                <span class="visually-hidden">
                    Siguiente
                </span>
            </button>

        </div>

    </div>

    <!-- Parte 2 -->



    <!-- Parte 3 -->









    <?php include 'inc/footer.php'; ?>

    <!-- Bootstrap JavaScript -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/footer.js"></script>

</body>
</html>