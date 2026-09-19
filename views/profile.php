<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>

    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-emerald-100 min-h-screen">

    <?php include 'inc/header.php'; ?>

    <!-- Contenido -->
    <main class="container mx-auto px-4 py-10">

        <div class="max-w-xl mx-auto">

            <div class="bg-emerald-200 rounded-2xl shadow-lg overflow-hidden">

                <!-- Encabezado -->
                <div class="bg-emerald-500 px-6 py-8 text-center">

                    <h1 class="text-3xl font-bold text-emerald-950">
                        Perfil
                    </h1>

                </div>


                <!-- Formulario -->
                <form id="perfilForm" class="p-6 sm:p-8">

                    <!-- Imagen -->
                    <div class="flex flex-col items-center mb-8">

                        <div class="relative">

                            <img id="profilePreview"
                                 src="../assets/img/user_default.png"
                                 alt="Imagen de perfil"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-rose-400 shadow-md">

                            <label for="profileImage"
                                   class="absolute bottom-0 right-0 bg-rose-500 hover:bg-rose-600 text-white w-10 h-10 rounded-full flex items-center justify-center cursor-pointer shadow-md transition">

                                ✎

                            </label>

                        </div>

                        <input type="file"
                               id="profileImage"
                               accept="image/*"
                               class="hidden">

                    </div>


                    <!-- Nombre de usuario -->
                    <div class="mb-5">

                        <label for="username"
                               class="block text-base font-semibold text-slate-700 mb-2">
                            Nombre de Usuario
                        </label>

                        <input type="text"
                               id="username"
                               value="Usuario"
                               class="w-full px-4 py-3 border border-rose-400 rounded-lg
                                      focus:outline-none focus:ring-2 focus:ring-rose-400
                                      focus:border-rose-400 transition bg-emerald-100">

                    </div>

                    <div class="mb-5">

                        <label for="username"
                               class="block text-base font-semibold text-slate-700 mb-2">
                            Correo electrónico
                        </label>

                        <input type="email"
                               id="email"
                               value="Correo electrónico"
                               class="w-full px-4 py-3 border border-rose-400 rounded-lg
                                      focus:outline-none focus:ring-2 focus:ring-rose-400
                                      focus:border-rose-400 transition bg-emerald-100">

                    </div>


                    <!-- Contraseña -->
                    <div class="mb-6">

                        <label for="password"
                               class="block text-base font-semibold text-slate-700 mb-2">
                            Contraseña
                        </label>

                        <input type="password"
                               id="password"
                               placeholder="Nueva contraseña"
                               class="w-full px-4 py-3 border border-rose-400 rounded-lg
                                      focus:outline-none focus:ring-2 focus:ring-rose-400
                                      focus:border-rose-400 transition bg-emerald-100">



                    </div>


                    <!-- Botón -->
                    <button type="submit"
                            class="w-full bg-rose-500 hover:bg-rose-400
                                   text-white font-bold py-3 px-6 rounded-lg
                                   transition duration-200 shadow-md hover:shadow-lg">

                        Guardar cambios

                    </button>


                    <!-- Mensaje -->
                    <p id="message"
                       class="hidden text-center mt-4 font-semibold">
                    </p>

                </form>

            </div>

        </div>

    </main>

    <script src="../public/js/header.js"></script>
    <script src="../public/js/userCourses.js"></script>

</body>
</html>