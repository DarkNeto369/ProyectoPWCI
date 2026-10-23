<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle de pago</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/detalle-pago.css">
</head>

<body>

    <div class="container payment-container">

        <div class="card shadow-sm">

            <!-- Título -->
            <div class="card-header bg-white p-4">
                <h2 class="mb-0">Detalle de pago</h2>
            </div>

            <div class="card-body p-4">

                <div class="row g-4">

                    <!-- Imagen del curso -->
                    <div class="col-md-6">

                        <img
                            src="https://picsum.photos/600/350?random=10"
                            class="course-image rounded"
                            alt="Curso"
                        >

                    </div>

                    <!-- Información del curso -->
                    <div class="col-md-6">

                        <h3 id="courseTitle">
                            Desarrollo Web Completo
                        </h3>

                        <p class="text-muted mt-3">
                            Estás a punto de realizar la compra de este curso.
                        </p>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">

                            <span class="fw-bold">
                                Precio:
                            </span>

                            <span
                                id="coursePrice"
                                class="price"
                            >
                                $499.00 MXN
                            </span>

                        </div>

                        <hr>

                        <button
                            id="confirmButton"
                            class="btn btn-primary btn-lg w-100 mt-3"
                        >
                            Confirmar y pagar con PayPal
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/detalle-pago.js"></script>

</body>
</html>