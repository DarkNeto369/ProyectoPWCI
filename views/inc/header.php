
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

if (empty($usuario['imagen_perfil'])) {
    $imagenPerfil = '../assets/img/user_default.png';
}

// Rol del usuario
$rol = $usuario['rol'] ?? '';
?>

<style>
    /* HEADER: conserva el color original de Bootstrap */
    .navbar {
        min-height: 75px;
        padding: 10px 25px;
    }

    /* LOGO PWCI ACADEMY */
    .navbar-brand {
        text-decoration: none;
        font-size: 1.5rem;
        letter-spacing: -1px;
    }

    .logo-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #064e3b, #14532d);
        color: #d1fae5;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 800;
        box-shadow: 0 3px 8px rgba(6, 78, 59, 0.25);
    }

    .logo-pwci {
        color: #064e3b;
        font-weight: 800;
    }

    .logo-academy {
        color: #15803d;
        font-weight: 400;
    }

    /* IMAGEN DE PERFIL */
    .profile-img {
        width: 43px;
        height: 43px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #166534;
        cursor: pointer;
        transition: box-shadow 0.2s ease;
    }

    .profile-img:hover {
        box-shadow: 0 0 0 4px rgba(22, 101, 52, 0.15);
    }

    /* MENÚ DESPLEGABLE */
    .dropdown-menu {
        border: none;
        border-radius: 12px;
        padding: 8px;
        min-width: 190px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .dropdown-item {
        padding: 9px 12px;
        border-radius: 7px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .dropdown-item:hover {
        background: #dcfce7;
        color: #064e3b;
    }

    .dropdown-divider {
        margin: 6px 0;
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .navbar {
            padding: 10px 15px;
        }

        .navbar-brand {
            font-size: 1.25rem;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
        }
    }
</style>

<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg border-bottom shadow-sm">

        <!-- LOGO PWCI ACADEMY -->
        <a
            class="navbar-brand d-flex align-items-center gap-2"
            href="/ProyectoPWCI/public/main"
        >
            <span class="logo-icon">P</span>

            <span>
                <span class="logo-pwci">PWCI</span>
                <span class="logo-academy">Academy</span>
            </span>
        </a>

        <!-- BÚSQUEDA (DESACTIVADA POR AHORA) -->
        <!--
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
        -->

        <!-- PERFIL -->
        <div class="dropdown ms-auto">

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
                    <a class="dropdown-item" href="/ProyectoPWCI/public/perfil">
                        Mi perfil
                    </a>
                </li>

                <?php if ($rol === 'estudiante'): ?>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/mis-cursos">
                            Mis cursos
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/mensajes">
                            Mensajes
                        </a>
                    </li>

                <?php elseif ($rol === 'instructor'): ?>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/crear-curso">
                            Crear curso
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/mis-cursos-instructor">
                            Mis cursos
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/reporte-ventas">
                            Ventas
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/mensajes">
                            Mensajes
                        </a>
                    </li>

                <?php elseif ($rol === 'administrador'): ?>

                    <li>
                        <a class="dropdown-item" href="/ProyectoPWCI/public/reporte-usuarios">
                            Reporte de usuarios
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
