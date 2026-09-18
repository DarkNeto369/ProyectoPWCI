<header class="bg-slate-900 text-white shadow-md border-b border-slate-800">
        <div class="container-fluid px-4 py-3 flex items-center justify-between gap-4">            
            <a href="#" class="text-2xl font-bold tracking-wider text-indigo-500 hover:text-indigo-400 no-underline shrink-0">
            DevSocial
            </a>
            <form class="flex max-w-md w-full gap-2 my-0" id="search-form">
            <input 
                type="search" 
                placeholder="Buscar curso" 
                class="w-full px-4 py-2 bg-slate-800 text-sm text-slate-100 rounded-lg border border-slate-700 focus:outline-none focus:border-indigo-500 transition-colors"
            />
            <button 
                type="submit" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm rounded-lg transition-colors shrink-0"
                >
                Buscar
            </button>
            </form>
            <div class="relative shrink-0">
            <button 
                id="profileBtn" 
                class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-500 hover:border-indigo-400 focus:outline-none transition-all">
                <img 
                src="https://via.placeholder.com/150" 
                alt="Avatar de usuario" 
                class="w-full h-full object-cover"
                />
            </button>

            <div 
                id="profileMenu" 
                class="hidden absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl border border-slate-700 py-1 z-50">
                <a 
                href="profile.html" 
                class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-700 hover:text-white no-underline transition-colors">
                Mis cursos
                </a>
                <a
                href="profile.html" 
                class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-700 hover:text-white no-underline transition-colors">
                Mis mensajes
                </a>
                <a
                href="profile.html" 
                class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-700 hover:text-white no-underline transition-colors">
                Crear curso
                </a>
                <a
                href="profile.html" 
                class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-700 hover:text-white no-underline transition-colors">
                Ventas
                </a>
                <a 
                href="profile.html" 
                class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-700 hover:text-white no-underline transition-colors">
                Perfil
                </a>
                <hr class="my-1 border-slate-700" />
                <a 
                href="loginSignup.html" 
                class="block px-4 py-2 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 no-underline transition-colors">
                Cerrar sesión
                </a>
            </div>
            </div>

        </div>
    </header>