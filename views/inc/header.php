<header class="bg-emerald-500 text-emerald-950 shadow-md border-b border-emerald-300">
    <div class="container-fluid px-4 py-3 flex items-center justify-between gap-4">            

        <a href="main.php" class="text-3xl font-bold tracking-wider text-slate-800! no-underline! cursor-pointer shrink-0">
            Cursos
        </a>

        <form class="flex max-w-md w-full gap-2 my-0" id="search-form">
            <input 
                type="search" 
                placeholder="Buscar curso" 
                class="w-full px-4 py-2 bg-rose-100 text-sm text-emerald-950 placeholder-emerald-600 rounded-lg border border-emerald-300 focus:outline-none focus:border-rose-400 transition-colors"
            />

            <button 
                type="submit" 
                class="px-4 py-2 bg-rose-400 hover:bg-rose-500 text-white font-medium text-sm rounded-lg transition-colors shrink-0"
            >
                Buscar
            </button>
        </form>

        <div class="relative shrink-0">

            <button 
                id="profileBtn" 
                class="w-15 h-15 rounded-full! overflow-hidden border-2 border-slate-800 hover:border-rose-500 focus:outline-none transition-all"
            >
                <img 
                    src="../assets/img/user_default.png" 
                    alt="Avatar de usuario" 
                    class="w-full h-full object-cover"
                />
            </button>

            <div 
                id="profileMenu" 
                class="hidden absolute right-0 mt-2 w-48 bg-emerald-50 rounded-lg shadow-xl border border-emerald-200 py-1 z-50"
            >

                <a 
                    href="userCourses.php" 
                    class="block px-4 py-2 text-sm text-slate-800! hover:bg-emerald-100 hover:text-emerald-950 no-underline! transition-colors"
                >
                    Mis cursos
                </a>

                <a
                    href="profile.html" 
                    class="block px-4 py-2 text-sm text-slate-800! hover:bg-emerald-100 hover:text-emerald-950 no-underline! transition-colors"
                >
                    Mis mensajes
                </a>

                <a
                    href="profile.html" 
                    class="block px-4 py-2 text-sm text-slate-800! hover:bg-emerald-100 hover:text-emerald-950 no-underline! transition-colors"
                >
                    Crear curso
                </a>

                <a
                    href="profile.html" 
                    class="block px-4 py-2 text-sm text-slate-800! hover:bg-emerald-100 hover:text-emerald-950 no-underline! transition-colors"
                >
                    Ventas
                </a>

                <a 
                    href="profile.html" 
                    class="block px-4 py-2 text-sm text-slate-800! hover:bg-emerald-100 hover:text-emerald-950 no-underline! transition-colors"
                >
                    Perfil
                </a>

                <hr class="my-1 border-emerald-200" />

                <a 
                    href="loginSignup.php" 
                    class="block px-4 py-2 text-sm text-rose-600! hover:bg-rose-50 hover:text-rose-600 no-underline! transition-colors"
                >
                    Cerrar sesión
                </a>

            </div>
        </div>

    </div>
</header>