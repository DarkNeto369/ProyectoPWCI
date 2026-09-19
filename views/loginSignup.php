<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="min-h-screen bg-emerald-300 flex items-center justify-center">

    <main class="w-full max-w-md px-6">
        <section id="login" class="bg-emerald-100 rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center mb-2">
                Iniciar sesión
            </h1>
            <p class="text-gray-500 text-center mb-8">
                
            </p>
            <form id="loginForm" class="space-y-5">

                <div>
                    <label for="loginEmail" class="block text-sm font-medium mb-2">
                        Correo electrónico
                    </label>
                    <input
                        type="email"
                        id="loginEmail"
                        name="email"
                        required
                        class="w-full px-4 py-3 border border-rose-500 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-rose-300"
                        placeholder="Correo electrónico"
                    >
                </div>

                <div>
                    <label for="loginPassword" class="block text-sm font-medium mb-2">
                        Contraseña
                    </label>
                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-rose-500 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-rose-300"
                        placeholder="Contraseña"
                    >
                </div>
                <button
                    type="submit"
                    class="w-full bg-rose-400 text-white py-3 rounded-lg
                           font-semibold hover:bg-rose-300 transition"
                >
                    Iniciar sesión
                </button>

            </form>
            <p class="text-center text-gray-500 mt-6">
                ¿No tienes una cuenta?
                <button
                    id="showRegister"
                    type="button"
                    class="text-rose-400 font-semibold hover:underline"
                >
                    Regístrate
                </button>
            </p>
        </section>


        <section
            id="register"
            class="hidden bg-emerald-100 rounded-2xl shadow-lg p-8"
        >
            <h1 class="text-3xl font-bold text-center mb-2">
                Crear Cuenta
            </h1>
            <p class="text-gray-500 text-center mb-8">
            </p>

            <form id="registerForm" class="space-y-5">
                <div class="flex flex-col items-center">
                    <label for="profileImage" class="cursor-pointer">
                        <img
                            id="profilePreview"
                            src="../assets/img/user_default.png"
                            alt="Imagen de perfil"
                            class="w-32 h-32 rounded-full object-cover
                                   border-4 border-slate-800
                                   hover:opacity-80 transition"
                        >
                    </label>
                    <input
                        type="file"
                        id="profileImage"
                        name="profile_image"
                        accept="image/*"
                        class="hidden"
                    >
                    <p class="text-sm text-gray-500 mt-3">
                        Imagen de perfil
                    </p>
                </div>

                <div>
                    <label
                        for="username"
                        class="block text-sm font-medium mb-2"
                    >
                        Nombre de usuario
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        class="w-full px-4 py-3 border border-rose-500 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-rose-300"
                        placeholder="Nombre de Usuario"
                    >
                </div>

                <div>
                    <label
                        for="registerEmail"
                        class="block text-sm font-medium mb-2"
                    >
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="registerEmail"
                        name="email"
                        required
                        class="w-full px-4 py-3 border border-rose-500 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-rose-300"
                        placeholder="Correo electrónico"
                    >
                </div>

                <div>
                    <label
                        for="registerPassword"
                        class="block text-sm font-medium mb-2"
                    >
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="registerPassword"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-rose-500 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-rose-300"
                        placeholder="Contraseña"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-rose-400 text-white py-3 rounded-lg
                           font-semibold hover:bg-rose-300 transition"
                >
                    Registrarse
                </button>
            </form>


            <p class="text-center text-gray-500 mt-6">
                ¿Ya tienes una cuenta?
                <button
                    id="showLogin"
                    type="button"
                    class="text-rose-400 font-semibold hover:underline"
                >
                    Inicia sesión
                </button>
            </p>
        </section>

    </main>

    <script src="../public/js/loginSignup.js"></script>
</body>
</html>