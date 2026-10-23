<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg bg-light border-bottom">

        <!-- LOGO -->
        <a class="navbar-brand" href="#">
            <img 
                src="https://via.placeholder.com/100"
                alt="Logo"
                class="logo"
            >
        </a>

        <!-- BÚSQUEDA -->
        <div class="search-container mx-auto">
            <form class="d-flex" role="search">
                <input 
                    class="form-control me-2"
                    type="search"
                    placeholder="¿Qué quieres aprender?"
                    aria-label="Buscar"
                >

                <button class="btn btn-primary" type="submit">
                    Buscar
                </button>
            </form>
        </div>

        <!-- PERFIL -->
        <div class="dropdown">

            <img 
                src="https://i.pravatar.cc/100"
                alt="Perfil"
                class="profile-img dropdown-toggle"
                id="profileDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

            <!-- MENÚ DESPLEGABLE -->
            <ul 
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="profileDropdown"
            >
                <li>
                    <a class="dropdown-item" href="perfil.php">
                        Mi perfil
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="crear-curso.php">
                        Crear curso
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="mis-cursos.php">
                        Mis cursos
                    </a>
                </li>
            </ul>

        </div>

    </nav>
</header>