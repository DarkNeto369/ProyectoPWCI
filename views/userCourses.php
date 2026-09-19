<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis cursos</title>

    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-emerald-100 min-h-screen">

    <?php include 'inc/header.php'; ?>

    <!-- Contenido -->
    <main class="container mx-auto px-6 py-10 bg-emerald-100">

        <!-- Título -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800 text-center">
                Mis cursos
            </h1>
        </div>

        <!-- Cursos -->
        <div id="contenedorCursos"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        </div>

    </main>

    <script src="../public/js/header.js"></script>
    <script src="../public/js/userCourses.js"></script>

</body>
</html>