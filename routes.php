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

// Rutas de la API propia de cursos
$router->post('/api/cursos', 'controllers/api/cursos/agregar.php');

$router->get('/api/cursos', 'controllers/api/cursos/recientes.php');

$router->get('/api/cursos/instructor', 'controllers/api/cursos/instructor.php');

$router->get('/api/cursos/detalle', 'controllers/api/cursos/detalle.php');

// PayPal
$router->post('/api/paypal/prueba', 'test/prueba_paypal.php');

$router->get('/paypal/retorno', 'controllers/paypal/retorno.php');





// Cualquier usuario con sesión iniciada
//$router->get('/mis-cursos', 'controllers/mis_cursos.php')->only('auth');

// Solo administradores
$router->get('/administracion', 'controllers/administracion.php')->only('administrador');

// Solo instructores
$router->get('/mis-cursos-instructor', 'Controllers/mis-cursos-instructor.php')->only('instructor');

$router->get('/prueba-acceso', 'test/prueba_acceso.php')->only('auth');

$router->get('/prueba-admin', 'test/prueba_admin.php')->only('administrador');


$router->get('/main', 'views/main.php')->only('auth');

$router->get('/detalle-curso', 'views/detalle-curso.php')->only('auth');

$router->get('/detalle-pago', 'views/detalle-pago.php')->only('auth');

$router->get('/detalle-curso-instructor', 'views/detalle-curso-instructor.php')->only('instructor');








$router->get('/cerrar-sesion', 'controllers/cerrar-sesion.php');


// Crear curso (Solo instructores)
$router->get('/crear-curso', 'views/crear-curso.php')->only('instructor');

    // Registrar la compra de un curso (Solo estudiantes)
$router->post('/api/compras', 'controllers/comprar-curso.php')->only('estudiante');

// Mis cursos (Solo estudiantes)
$router->get('/mis-cursos', 'views/mis-cursos.php')->only('estudiante');

$router->get('/api/mis-cursos', 'controllers/api/cursos/mis-cursos.php')->only('estudiante');



// Obtener los niveles de un curso inscrito
$router->get('/api/cursos/niveles', 'controllers/api/cursos/obtener-niveles.php')
    ->only('estudiante');

// Marcar un nivel como completado
$router->post('/api/cursos/completar-nivel', 'controllers/api/cursos/completar-nivel.php')
    ->only('estudiante');

    // Aula virtual del estudiante
$router->get('/aula-virtual', 'views/aula-virtual.php')->only('estudiante');

// Mostrar diploma del estudiante
$router->get('/diploma', 'views/diploma.php')->only('estudiante');

// Obtener los datos del diploma
$router->get('/api/cursos/diploma', 'controllers/api/cursos/diploma.php')



    ->only('estudiante');

    // Mensajes privados
$router->get('/mensajes', 'views/mensajes.php')->only('auth');

$router->get('/api-mensajes', 'controllers/mensajes.php')->only('auth');
$router->post('/api-mensajes', 'controllers/mensajes.php')->only('auth');




// API de comentarios
$router->post('/api/comentarios', 'controllers/api/comentarios/registrar.php')
    ->only('estudiante');

$router->get('/api/comentarios', 'controllers/api/comentarios/obtener.php');

$router->post('/api/comentarios/eliminar', 'controllers/api/comentarios/eliminar.php')
    ->only('administrador');


    // API de calificaciones
$router->post('/api/calificaciones', 'controllers/api/calificaciones/registrar.php')
    ->only('estudiante');

$router->get('/api/calificaciones', 'controllers/api/calificaciones/promedio.php');



$router->get('/api/cursos/mejor-valorados', 'controllers/api/cursos/mejor-valorados.php');








// Reporte de ventas (Solo instructores)
$router->get('/reporte-ventas', 'views/reporte-ventas.php')
    ->only('instructor');

// Datos del reporte de ventas
$router->get('/reporte-ventas/datos', 'controllers/ventas/obtener.php')
    ->only('instructor');

// Categorías del reporte de ventas
$router->get('/reporte-ventas/categorias', 'controllers/ventas/categorias.php')
    ->only('instructor');
