
document.addEventListener('DOMContentLoaded', function () {

    const mensajeCurso = document.getElementById('mensajeCurso');
    const detalleCurso = document.getElementById('detalleCurso');

    const courseTitle = document.getElementById('courseTitle');
    const courseCategory = document.getElementById('courseCategory');
    const courseDescription = document.getElementById('courseDescription');
    const courseImage = document.getElementById('courseImage');
    const coursePrice = document.getElementById('coursePrice');
    const levelsContainer = document.getElementById('levelsContainer');

    const API_URL = '/ProyectoPWCI/public/api/cursos/detalle';
    const IMAGEN_PLACEHOLDER = 'https://placehold.co/600x400?text=Curso';

    // Obtener ID del curso desde la URL
    const parametros = new URLSearchParams(window.location.search);
    const idCurso = parametros.get('id_curso');

    function mostrarError(texto) {
        mensajeCurso.textContent = texto;
        mensajeCurso.className = 'alert alert-danger';
    }

    function mostrarCurso(datos) {

        const curso = datos.curso;
        const niveles = datos.niveles;

        if (!curso) {
            mostrarError('No se encontró el curso seleccionado.');
            return;
        }

        // Información general
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

        // Imagen
        courseImage.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        courseImage.onerror = function () {
            this.onerror = null;
            this.src = IMAGEN_PLACEHOLDER;
        };

        // Niveles
        levelsContainer.replaceChildren();

        if (Array.isArray(niveles) && niveles.length > 0) {

            niveles.forEach(function (nivel) {

                const tarjetaNivel = document.createElement('div');
                tarjetaNivel.className = 'level-card';

                const tituloNivel = document.createElement('h5');
                tituloNivel.textContent =
                    'Nivel ' + nivel.numero_nivel + ': ' +
                    (nivel.nombre || 'Sin nombre');

                tarjetaNivel.appendChild(tituloNivel);

                levelsContainer.appendChild(tarjetaNivel);
            });

        } else {

            levelsContainer.textContent =
                'Este curso todavía no tiene niveles registrados.';
        }

        // Mostrar detalle
        mensajeCurso.classList.add('d-none');
        detalleCurso.classList.remove('d-none');
    }

    // Validar ID
    if (!idCurso) {
        mostrarError('No se recibió el ID del curso.');
        return;
    }

    // Consultar API mediante Fetch y Promesas
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
