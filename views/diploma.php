
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Diploma de finalización</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/diploma.css">
</head>

<body>

    <main class="contenedor-diploma">

        <div class="diploma" id="diploma">

            <div class="contenido-diploma">

                <h1>Diploma de finalización</h1>

                <p class="texto-introductorio">
                    Se otorga el presente reconocimiento a:
                </p>

                <h2 id="nombreEstudiante">Cargando estudiante...</h2>

                <p class="texto-curso">
                    Por haber completado satisfactoriamente el curso:
                </p>

                <h3 id="nombreCurso">Cargando curso...</h3>

                <div class="datos-finales">

                    <div>
                        <strong>Instructor</strong>
                        <p id="nombreInstructor">Cargando instructor...</p>
                    </div>

                    <div>
                        <strong>Fecha de finalización</strong>
                        <p id="fechaTerminacion">Cargando fecha...</p>
                    </div>

                </div>

            </div>

        </div>

        <div class="acciones-diploma">
            <button type="button" class="btn btn-success" onclick="window.print()">
                Imprimir diploma
            </button>

            <a href="/ProyectoPWCI/public/mis-cursos"
               class="btn btn-secondary">
                Volver a mis cursos
            </a>
        </div>

    </main>

    <script src="../public/js/diploma.js"></script>

</body>
</html>
