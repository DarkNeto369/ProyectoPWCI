
document.addEventListener('DOMContentLoaded', function () {

    const mensajeCurso = document.getElementById('mensajeCurso');
    const detalleCurso = document.getElementById('detalleCurso');

    const courseTitle = document.getElementById('courseTitle');
    const courseCategory = document.getElementById('courseCategory');
    const courseDescription = document.getElementById('courseDescription');
    const courseImage = document.getElementById('courseImage');
    const coursePrice = document.getElementById('coursePrice');
    const levelsContainer = document.getElementById('levelsContainer');
    const buyButton = document.getElementById('buyButton');

    const API_URL = '/ProyectoPWCI/public/api/cursos/detalle';

    const IMAGEN_PLACEHOLDER =
        'https://placehold.co/600x400?text=Curso';

    // Obtener el ID del curso desde la URL
    const parametros = new URLSearchParams(window.location.search);
    const idCurso = parametros.get('id_curso');

    buyButton.addEventListener('click', function () {

        window.location.href =
            '/ProyectoPWCI/public/detalle-pago?id_curso=' +
            encodeURIComponent(idCurso);

    });

    function mostrarError(mensaje) {
        mensajeCurso.textContent = mensaje;
        mensajeCurso.className = 'alert alert-danger';
        detalleCurso.classList.add('d-none');
    }

    function mostrarCurso(datos) {

        const curso = datos.curso;
        const niveles = datos.niveles;

        if (!curso) {
            mostrarError('No se encontró la información del curso.');
            return;
        }

        // Información principal
        courseTitle.textContent = curso.titulo || 'Curso sin título';

        courseCategory.textContent =
            curso.categoria || 'Sin categoría';

        courseDescription.textContent =
            curso.descripcion || 'Sin descripción disponible.';

        const costo = Number(curso.costo);

        coursePrice.textContent = Number.isFinite(costo)
            ? costo.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            })
            : 'Precio no disponible';

        // Imagen del curso
        courseImage.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        courseImage.onerror = function () {
            courseImage.onerror = null;
            courseImage.src = IMAGEN_PLACEHOLDER;
        };

        // Mostrar niveles
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

        // Mostrar la información
        mensajeCurso.classList.add('d-none');
        detalleCurso.classList.remove('d-none');
    }

    // Validar que exista el ID
    if (!idCurso) {
        mostrarError('No se especificó el curso que deseas consultar.');
        return;
    }

    // Consultar la API
    fetch(API_URL + '?id_curso=' + encodeURIComponent(idCurso), {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(function (respuesta) {

        if (!respuesta.ok) {
            throw new Error(
                'La API respondió con el código HTTP ' + respuesta.status
            );
        }

        return respuesta.json();
    })
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

