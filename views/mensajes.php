
<?php
$rolUsuario = $_SESSION['rol'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mensajes privados</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/mensajes.css">
    <link rel="stylesheet" href="../public/css/footer.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="mensajes-pagina">

        <div class="container py-4">

            <div class="mensajes-container">

                <h2 class="main-title">Mensajes privados</h2>

                <p class="subtitle">
                    Comunícate con tus instructores y estudiantes.
                </p>

                <div class="mensajes-panel">

                    <!-- Panel izquierdo -->
                    <section class="conversaciones">

                        <h5 class="seccion-titulo" id="tituloLista">
                            <?= $rolUsuario === 'estudiante'
                                ? 'Mis cursos'
                                : 'Conversaciones'
                            ?>
                        </h5>

                        <div id="listaConversaciones">

                            <div class="mensaje-vacio">
                                <p>Cargando...</p>
                            </div>

                        </div>

                    </section>

                    <!-- Panel derecho -->
                    <section class="chat-container">

                        <div class="chat-header">

                            <div>

                                <h5 id="nombreContacto">
                                    Selecciona un curso
                                </h5>

                                <small id="nombreCurso">
                                    Curso
                                </small>

                            </div>

                        </div>

                        <div id="mensajesChat" class="chat-mensajes">

                            <div class="chat-vacio">
                                <p>
                                    Selecciona un curso o una conversación
                                    para comenzar.
                                </p>
                            </div>

                        </div>

                        <form id="formularioMensaje" class="chat-formulario">

                            <input
                                type="text"
                                id="inputMensaje"
                                class="form-control"
                                placeholder="Escribe un mensaje..."
                                autocomplete="off"
                                disabled
                            >

                            <button
                                type="submit"
                                id="btnEnviarMensaje"
                                class="btn btn-enviar"
                                disabled
                            >
                                Enviar
                            </button>

                        </form>

                    </section>

                </div>

            </div>

        </div>

    </main>

    <?php include 'inc/footer.php'; ?>

    <script>
        window.ID_USUARIO = <?= json_encode($_SESSION['user_id'] ?? null) ?>;
        window.ROL_USUARIO = <?= json_encode($rolUsuario) ?>;
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/mensajes.js"></script>

</body>
</html>
