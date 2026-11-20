<?php
$tipo = $_GET['tipo'] ?? 'instructor';
$usuarios = $usuarios ?? [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de usuarios</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/reporte-usuarios.css">
</head>

<body>

    <?php include 'inc/header.php'; ?>

    <main class="container reporte-container">

        <div class="encabezado-reporte">
            <h1>Reporte de usuarios</h1>
            <p>Consulta la información de instructores y estudiantes activos.</p>
        </div>

        <section class="seccion-reporte">

            <form method="GET" action="/ProyectoPWCI/public/reporte-usuarios">

                <div class="filtro-reporte">
                    <label for="tipo" class="form-label">
                        Tipo de usuario
                    </label>

                    <select
                        name="tipo"
                        id="tipo"
                        class="form-select"
                        onchange="this.form.submit()"
                    >
                        <option value="instructor"
                            <?= $tipo === 'instructor' ? 'selected' : '' ?>>
                            Instructores
                        </option>

                        <option value="estudiante"
                            <?= $tipo === 'estudiante' ? 'selected' : '' ?>>
                            Estudiantes
                        </option>
                    </select>
                </div>

            </form>

            <div class="table-responsive">

                <table class="table tabla-reporte">

                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de ingreso</th>

                            <?php if ($tipo === 'instructor'): ?>

                                <th>Cursos ofrecidos</th>
                                <th>Total de ganancias</th>

                            <?php else: ?>

                                <th>Cursos inscritos</th>

                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($usuarios)): ?>

                            <tr>
                                <td colspan="<?= $tipo === 'instructor' ? 5 : 4 ?>"
                                    class="text-center">
                                    No hay usuarios activos para mostrar.
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($usuarios as $usuario): ?>

                                <tr>
                                    <td>
                                        <?= htmlspecialchars($usuario['usuario']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($usuario['nombre']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($usuario['fecha_ingreso']) ?>
                                    </td>

                                    <?php if ($tipo === 'instructor'): ?>

                                        <td>
                                            <?= (int) $usuario['cursos_ofrecidos'] ?>
                                        </td>

                                        <td>
                                            <?= '$' . number_format(
                                                (float) $usuario['total_ganancias'],
                                                2
                                            ) . ' MXN' ?>
                                        </td>

                                    <?php else: ?>

                                        <td>
                                            <?= (int) $usuario['cursos_inscritos'] ?>
                                        </td>

                                    <?php endif; ?>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>