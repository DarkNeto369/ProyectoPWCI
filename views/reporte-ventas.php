<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de ventas</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/mis-cursos.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="container cursos-container">

        <div class="encabezado-cursos">

            <span class="etiqueta-cursos">
                PANEL DE INSTRUCTOR
            </span>

            <h1>Reporte de ventas</h1>

            <p>
                Consulta los alumnos inscritos y los ingresos generados por tus cursos.
            </p>

        </div>

        <div class="seccion-cursos">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>
                    <h2>Mis ventas</h2>

                    <p class="subtitle mb-0">
                        Resumen de tus cursos e ingresos.
                    </p>
                </div>

                <div class="filtro-categoria">

                    <label for="filtroCategoria" class="form-label">
                        Filtrar por categoría
                    </label>

                    <select id="filtroCategoria" class="form-select">
                        <option value="Todas">Todas las categorías</option>
                        <option value="Programación">Programación</option>
                        <option value="Diseño">Diseño</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Fotografía">Fotografía</option>
                        <option value="Negocios">Negocios</option>
                        <option value="Idiomas">Idiomas</option>
                    </select>

                </div>

            </div>

            <hr>

            <div class="table-responsive">

                <table class="table tabla-ventas align-middle">

                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Alumnos inscritos</th>
                            <th>Ingresos</th>
                        </tr>
                    </thead>

                    <tbody id="tablaVentas">

                        <tr>
                            <td colspan="3" class="text-center">
                                Cargando reporte...
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div id="mensajeVacio" class="alert alert-info d-none mt-4">
                No hay cursos registrados en esta categoría.
            </div>

            <div id="mensajeError" class="alert alert-danger d-none mt-4">
                Ocurrió un error al cargar el reporte.
            </div>

            <div class="total-ventas mt-4">

                <span>Total de ingresos:</span>

                <strong id="ingresosTotales">
                    $0.00
                </strong>

            </div>

        </div>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/reporte-ventas.js"></script>

</body>

</html>