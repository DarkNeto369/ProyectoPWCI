
document.addEventListener('DOMContentLoaded', function () {

    // Elementos principales
    const mensajeCurso = document.getElementById('mensajeCurso');
    const detalleCurso = document.getElementById('detalleCurso');

    const courseTitle = document.getElementById('courseTitle');
    const courseCategory = document.getElementById('courseCategory');
    const courseInstructor = document.getElementById('courseInstructor');
    const courseStars = document.getElementById('courseStars');
    const courseRating = document.getElementById('courseRating');
    const courseDescription = document.getElementById('courseDescription');
    const courseImage = document.getElementById('courseImage');
    const coursePrice = document.getElementById('coursePrice');

    const levelsContainer = document.getElementById('levelsContainer');
    const buyButton = document.getElementById('buyButton');

    const ratingSummary = document.getElementById('ratingSummary');
    const ratingFormContainer = document.getElementById('ratingFormContainer');
    const ratingForm = document.getElementById('ratingForm');
    const ratingSelect = document.getElementById('ratingSelect');
    const mensajeCalificacion = document.getElementById('mensajeCalificacion');

    const listaComentarios = document.getElementById('listaComentarios');
    const comentarioFormContainer = document.getElementById('comentarioFormContainer');
    const comentarioForm = document.getElementById('comentarioForm');
    const textoComentario = document.getElementById('textoComentario');
    const mensajeComentario = document.getElementById('mensajeComentario');

    // URLs
    const API_CURSOS = '/ProyectoPWCI/public/api/cursos/detalle';
    const API_COMENTARIOS = '/ProyectoPWCI/public/api/comentarios';
    const API_CALIFICACIONES = '/ProyectoPWCI/public/api/calificaciones';

    const IMAGEN_PLACEHOLDER =
        'https://placehold.co/600x400?text=Curso';

    // Sesión
    const ROL_USUARIO = window.ROL_USUARIO || '';

    const esEstudiante = ROL_USUARIO === 'estudiante';
    const esAdministrador = ROL_USUARIO === 'administrador';

    // Obtener ID del curso
    const parametros = new URLSearchParams(window.location.search);
    const idCurso = parametros.get('id_curso');

    // Comprar curso
    buyButton.addEventListener('click', function () {

        window.location.href =
            '/ProyectoPWCI/public/detalle-pago?id_curso=' +
            encodeURIComponent(idCurso);

    });

    // Mostrar errores del curso
    function mostrarError(mensaje) {
        mensajeCurso.textContent = mensaje;
        mensajeCurso.className = 'alert alert-danger';
        detalleCurso.classList.add('d-none');
    }

    // Mostrar mensajes de formularios
    function mostrarMensaje(elemento, texto, tipo) {
        elemento.textContent = texto;
        elemento.className = 'alert alert-' + tipo + ' mt-3';
    }

    // Realizar solicitudes y convertir respuestas JSON
    function consultarAPI(url, opciones = {}) {

        return fetch(url, opciones)
            .then(function (respuesta) {

                return respuesta.json().catch(function () {
                    return {};
                }).then(function (datos) {

                    if (!respuesta.ok) {
                        throw new Error(
                            datos.error ||
                            datos.mensaje ||
                            'Ocurrió un error en la solicitud.'
                        );
                    }

                    return datos;
                });

            });
    }

    // Mostrar estrellas
    function generarEstrellas(promedio) {

        const cantidad = Math.max(
            0,
            Math.min(5, Math.round(promedio))
        );

        return '★'.repeat(cantidad) + '☆'.repeat(5 - cantidad);
    }

    // Mostrar promedio de calificaciones
    function mostrarPromedio(datos) {

        const promedio = Number(datos.promedio_calificacion ?? datos.promedio ?? 0);
        const total = Number(datos.total_calificaciones || 0);

        courseStars.textContent = generarEstrellas(promedio);

        courseRating.textContent = total > 0
            ? promedio.toFixed(1) + ' / 5 · ' + total +
                (total === 1 ? ' calificación' : ' calificaciones')
            : 'Sin calificaciones todavía';

        ratingSummary.textContent = total > 0
            ? promedio.toFixed(1) + ' de 5 estrellas · ' +
                total + (total === 1 ? ' calificación' : ' calificaciones')
            : 'Este curso todavía no tiene calificaciones.';
    }

    // Consultar promedio actualizado
    function cargarPromedio() {

        return consultarAPI(
            API_CALIFICACIONES + '?id_curso=' + encodeURIComponent(idCurso)
        )
        .then(function (datos) {
            mostrarPromedio(datos);
        })
        .catch(function (error) {
            console.error('Error al cargar las calificaciones:', error);
            mostrarPromedio({
                promedio: 0,
                total_calificaciones: 0
            });
        });
    }

    // Mostrar información del curso
    function mostrarCurso(datos) {

        const curso = datos.curso;
        const niveles = datos.niveles;

        if (!curso) {
            mostrarError('No se encontró la información del curso.');
            return;
        }

        courseTitle.textContent =
            curso.titulo || 'Curso sin título';

        courseCategory.textContent =
            curso.categoria || 'Sin categoría';

        courseInstructor.textContent =
            'Instructor: ' + (curso.nombre_instructor || 'No disponible');

        courseDescription.textContent =
            curso.descripcion || 'Sin descripción disponible.';

        const costo = Number(curso.costo);

        coursePrice.textContent = Number.isFinite(costo)
            ? costo.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            })
            : 'Precio no disponible';

        // Imagen
        courseImage.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        courseImage.onerror = function () {
            courseImage.onerror = null;
            courseImage.src = IMAGEN_PLACEHOLDER;
        };

        // Niveles
        levelsContainer.innerHTML = '';

        if (Array.isArray(niveles) && niveles.length > 0) {

            niveles.forEach(function (nivel) {

                const tarjetaNivel = document.createElement('div');
                tarjetaNivel.className = 'level-card';

                const tituloNivel = document.createElement('h4');

                tituloNivel.textContent =
                    'Nivel ' + nivel.numero_nivel +
                    ': ' + (nivel.nombre || 'Sin nombre');

                tarjetaNivel.appendChild(tituloNivel);
                levelsContainer.appendChild(tarjetaNivel);

            });

        } else {

            levelsContainer.textContent =
                'Este curso todavía no tiene niveles registrados.';
        }

        // Mostrar calificaciones que ya vienen con el curso
        mostrarPromedio(curso);

        // Mostrar formularios según el rol
        if (esEstudiante) {
            ratingFormContainer.classList.remove('d-none');
            comentarioFormContainer.classList.remove('d-none');
        }

        // Mostrar información
        mensajeCurso.classList.add('d-none');
        detalleCurso.classList.remove('d-none');

        // Consultar información adicional
        cargarPromedio();
        cargarComentarios();
    }

    // ==========================================
    // COMENTARIOS
    // ==========================================

    function cargarComentarios() {

        listaComentarios.textContent = 'Cargando comentarios...';

        consultarAPI(
            API_COMENTARIOS + '?id_curso=' + encodeURIComponent(idCurso)
        )
        .then(function (datos) {

            const comentarios = Array.isArray(datos)
                ? datos
                : datos.comentarios;

            if (!Array.isArray(comentarios)) {
                throw new Error('La respuesta de comentarios no es válida.');
            }

            mostrarComentarios(comentarios);

        })
        .catch(function (error) {

            console.error('Error al cargar comentarios:', error);

            listaComentarios.textContent =
                'No fue posible cargar los comentarios.';
        });
    }

    
function mostrarComentarios(comentarios) {

    listaComentarios.innerHTML = '';

    if (comentarios.length === 0) {
        listaComentarios.textContent =
            'Este curso todavía no tiene comentarios.';
        return;
    }

    comentarios.forEach(function (comentario) {

        const tarjeta = document.createElement('div');
        tarjeta.className = 'card mb-3';

        const cuerpo = document.createElement('div');
        cuerpo.className = 'card-body';

        // Encabezado del comentario
        const encabezado = document.createElement('div');
        encabezado.className = 'd-flex align-items-center mb-3';

        // Imagen de perfil
        const imagen = document.createElement('img');

        imagen.className = 'rounded-circle me-3';
        imagen.style.width = '50px';
        imagen.style.height = '50px';
        imagen.style.objectFit = 'cover';
        imagen.alt = 'Foto de perfil';

        const IMAGEN_PERFIL =
            'https://placehold.co/80x80?text=Usuario';

        imagen.src = comentario.imagen_perfil
            ? '/ProyectoPWCI/public/' + comentario.imagen_perfil
            : IMAGEN_PERFIL;

        imagen.onerror = function () {
            imagen.onerror = null;
            imagen.src = IMAGEN_PERFIL;
        };

        // Nombre del estudiante
        const informacionUsuario = document.createElement('div');

        const nombre = document.createElement('h6');
        nombre.className = 'mb-1';

        nombre.textContent =
            comentario.nombre_usuario ||
            comentario.usuario ||
            'Estudiante';

        // Fecha
        const fecha = document.createElement('small');
        fecha.className = 'text-muted';

        fecha.textContent = comentario.fecha_comentario
            ? new Date(
                comentario.fecha_comentario.replace(' ', 'T')
            ).toLocaleString('es-MX')
            : '';

        informacionUsuario.append(nombre, fecha);

        encabezado.append(imagen, informacionUsuario);

        // Texto del comentario
        const texto = document.createElement('p');
        texto.className = 'card-text mt-2';

        const eliminado =
            Number(comentario.eliminado) === 1;

        texto.textContent = eliminado
            ? 'Este comentario fue eliminado'
            : comentario.comentario || '';

        cuerpo.append(encabezado, texto);

        // El administrador puede eliminar comentarios activos
        if (esAdministrador && !eliminado) {

            const botonEliminar = document.createElement('button');

            botonEliminar.type = 'button';
            botonEliminar.className =
                'btn btn-sm btn-outline-danger';

            botonEliminar.textContent = 'Eliminar comentario';

            botonEliminar.addEventListener('click', function () {
                eliminarComentario(comentario.id_comentario);
            });

            cuerpo.appendChild(botonEliminar);
        }

        tarjeta.appendChild(cuerpo);
        listaComentarios.appendChild(tarjeta);

    });
}


    // Registrar comentario
    comentarioForm.addEventListener('submit', function (evento) {

        evento.preventDefault();

        const comentario = textoComentario.value.trim();

        if (!comentario) {
            mostrarMensaje(
                mensajeComentario,
                'Escribe un comentario antes de publicarlo.',
                'warning'
            );
            return;
        }

        consultarAPI(API_COMENTARIOS, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_curso: Number(idCurso),
                comentario: comentario
            })
        })
        .then(function () {

            comentarioForm.reset();

            mostrarMensaje(
                mensajeComentario,
                'Comentario publicado correctamente.',
                'success'
            );

            cargarComentarios();

        })
        .catch(function (error) {

            mostrarMensaje(
                mensajeComentario,
                error.message,
                'danger'
            );

        });
    });

    // Eliminar comentario (administrador)
    function eliminarComentario(idComentario) {

        if (!confirm('¿Deseas eliminar este comentario?')) {
            return;
        }

        consultarAPI(API_COMENTARIOS + '/eliminar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_comentario: Number(idComentario)
            })
        })
        .then(function () {
            cargarComentarios();
        })
        .catch(function (error) {
            alert(error.message);
        });
    }

    // ==========================================
    // CALIFICACIONES
    // ==========================================

    ratingForm.addEventListener('submit', function (evento) {

        evento.preventDefault();

        const calificacion = ratingSelect.value;

        if (!calificacion) {
            mostrarMensaje(
                mensajeCalificacion,
                'Selecciona una calificación.',
                'warning'
            );
            return;
        }

        consultarAPI(API_CALIFICACIONES, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_curso: Number(idCurso),
                calificacion: Number(calificacion)
            })
        })
        .then(function () {

            ratingForm.reset();

            mostrarMensaje(
                mensajeCalificacion,
                'Tu calificación se registró correctamente.',
                'success'
            );

            // Actualizar promedio
            cargarPromedio();

        })
        .catch(function (error) {

            mostrarMensaje(
                mensajeCalificacion,
                error.message,
                'danger'
            );

        });
    });

    // ==========================================
    // CARGAR CURSO
    // ==========================================

    if (!idCurso || !/^[1-9]\d*$/.test(idCurso)) {
        mostrarError('No se especificó un ID de curso válido.');
        return;
    }

    consultarAPI(
        API_CURSOS + '?id_curso=' + encodeURIComponent(idCurso)
    )
    .then(function (datos) {

        mostrarCurso(datos);

    })
    .catch(function (error) {

        console.error('Error al cargar el curso:', error);

        mostrarError(
            'No fue posible cargar la información del curso.'
        );
    });

});
