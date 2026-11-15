
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis cursos - Instructor</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/mis-cursos.css">

    <style>
        body {
            background: linear-gradient(
                rgb(121, 255, 184),
                rgb(185, 255, 215)
            );
            min-height: 100vh;
        }

        .cursos-container {
            padding-top: 40px;
            padding-bottom: 60px;
        }

        .main-title {
            color: rgb(242, 121, 97);
            font-weight: bold;
        }

        .subtitle {
            color: #555;
        }

        .cursos-panel {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .btn-crear-curso {
            background-color: rgb(29, 179, 102);
            border: none;
            color: white;
        }

        .btn-crear-curso:hover {
            background-color: rgb(39, 212, 123);
            color: white;
        }

        .mensaje-vacio {
            border-left: 5px solid rgb(242, 121, 97);
        }
    </style>

</head>

<body>

    <!-- HEADER -->
    <?php include 'inc/header.php'; ?>


    <!-- CONTENIDO -->
    <main class="container cursos-container">

        <div class="cursos-panel">

            <!-- Título y botón -->

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>
                    <h2 class="main-title" id="tituloCursos">
                        Mis cursos
                    </h2>

                    <p class="subtitle mb-0" id="descripcionCursos">
                        Cursos que has creado como instructor.
                    </p>
                </div>

                <a
                    href="/ProyectoPWCI/public/crear-curso"
                    class="btn btn-crear-curso"
                >
                    + Crear curso
                </a>

            </div>


            <hr>


            <!-- LISTA DE CURSOS -->

            <div id="listaCursos" class="row g-4"></div>

            <div id="mensajeVacio" class="alert alert-info d-none mt-4">
                Cargando tus cursos...
            </div>


            <!-- MENSAJE CUANDO NO HAY CURSOS -->

            <div
                id="mensajeVacio"
                class="alert alert-info mensaje-vacio d-none mt-4"
            >
                Todavía no has creado ningún curso.
            </div>

        </div>

    </main>


    <!-- Bootstrap JS -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript de mis cursos -->
    <script src="../public/js/mis-cursos-instructor.js"></script>

</body>

</html>
