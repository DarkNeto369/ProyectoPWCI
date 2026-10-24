<?php

//$router->get('/', 'controllers/main.php');
//$router->get('/pokemon', 'controllers/pokemon.php')->only('auth');
//$router->get('/movies', 'controllers/movies.php')->only('auth');

// Ruta API para buscar películas (Buscar como proteger api)
//$router->get('/movie/search', 'controllers/movies_search_api.php');

//$router->get('/login', 'controllers/auth/login.php');
//$router->post('/login', 'controllers/auth/login.php');

// Mis rutas
$router->post('/registro', 'controllers/registro.php');
$router->post('/login', 'controllers/login.php');

// Cualquier usuario con sesión iniciada
$router->get('/mis-cursos', 'controllers/mis_cursos.php')
    ->only('auth');

// Solo administradores
$router->get('/administracion', 'controllers/administracion.php')
    ->only('administrador');

// Solo instructores
$router->get('/mis-cursos-instructor', 'controllers/mis_cursos_instructor.php')
    ->only('instructor');

$router->get('/prueba-acceso', 'test/prueba_acceso.php')
    ->only('auth');

$router->get('/prueba-admin', 'test/prueba_admin.php')
    ->only('administrador');


$router->get('/main', 'views/main.php')->only('auth');