
<?php

use Models\Usuario;

// Obtener los datos del usuario que inició sesión
$usuario = null;

if (isset($_SESSION['user_id'])) {
    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->buscarPorId($_SESSION['user_id']);
}

// Imagen de perfil
$imagenPerfil = '../public/' . ($usuario['imagen_perfil'] ?? '');
    ($usuario['imagen_perfil'] ?? '');

if (empty($usuario['imagen_perfil'])) {
    $imagenPerfil = 'https://i.pravatar.cc/100';
}

// Rol del usuario
$rol = $usuario['rol'] ?? '';
?>

<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg border-bottom">

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
                src="<?= htmlspecialchars($imagenPerfil) ?>"
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

                <?php if ($rol === 'estudiante'): ?>

                    <li>
                        <a class="dropdown-item" href="mis-cursos.php">
                            Mis cursos
                        </a>
                    </li>

                <?php elseif ($rol === 'instructor'): ?>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/crear-curso">
                            Crear curso
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="mis-cursos.php">
                            Mis cursos
                        </a>
                    </li>

                <?php elseif ($rol === 'administrador'): ?>

                    <li>
                        <a class="dropdown-item" href="administracion.php">
                            Administración
                        </a>
                    </li>

                <?php endif; ?>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item" href="/ProyectoPWCI/public/cerrar-sesion">
                        Cerrar sesión
                    </a>
                </li>

            </ul>

        </div>

    </nav>
</header>
