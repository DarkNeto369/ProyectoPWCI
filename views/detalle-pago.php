
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle de pago</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/footer.css">
    <link rel="stylesheet" href="../public/css/detalle-pago.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="container py-5">

        <a href="javascript:history.back()" class="btn btn-volver mb-4">
            ← Regresar
        </a>

        <div class="payment-container">

            <div class="payment-heading text-center mb-4">
                <span class="etiqueta-pago">FINALIZAR COMPRA</span>

                <h1>Detalle de pago</h1>

                <p>
                    ¡Ya casi es tuyo! Revisa los datos de tu curso antes de continuar.
                </p>
            </div>

            <div class="payment-card">

                <div class="row g-0">

                    <!-- Imagen del curso -->
                    <div class="col-lg-5">

                        <div class="course-image-container">

                            <img
                                id="courseImage"
                                src="https://placehold.co/600x450?text=Curso"
                                class="course-image"
                                alt="Imagen del curso"
                            >

                        </div>

                    </div>

                    <!-- Información del pago -->
                    <div class="col-lg-7">

                        <div class="payment-info">

                            <span class="etiqueta-curso">
                                TU PRÓXIMO APRENDIZAJE
                            </span>

                            <h2 id="courseTitle">
                                Nombre del curso
                            </h2>

                            <p class="course-description">
                                Estás a punto de adquirir este curso.
                                Una vez completado el pago, podrás comenzar
                                a disfrutar de su contenido.
                            </p>

                            <hr>

                            <div class="payment-detail">

                                <span>Producto</span>

                                <strong id="courseTitlePayment">
                                    Curso seleccionado
                                </strong>

                            </div>

                            <div class="payment-total">

                                <span>Total a pagar</span>

                                <strong id="coursePrice">
                                    $0.00 MXN
                                </strong>

                            </div>

                            <div class="payment-security">
                                <span>🔒</span>

                                <p>
                                    Tu pago será procesado de forma segura
                                    mediante PayPal Sandbox.
                                </p>
                            </div>

                            <button
                                id="confirmButton"
                                type="button"
                                class="btn btn-paypal w-100"
                            >
                                Confirmar y pagar con PayPal
                            </button>

                            <p class="payment-note text-center mt-3">
                                Serás redirigido a PayPal para aprobar tu pago.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <?php include 'inc/footer.php'; ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/detalle-pago.js"></script>

</body>
</html>
