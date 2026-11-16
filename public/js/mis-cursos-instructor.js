
document.addEventListener('DOMContentLoaded', function () {

    const listaCursos = document.getElementById('listaCursos');
    const mensajeVacio = document.getElementById('mensajeVacio');

    // Endpoint de nuestra API
    const API_URL = '/ProyectoPWCI/public/api/cursos/instructor';

    const IMAGEN_PLACEHOLDER =
        'https://placehold.co/400x225?text=Curso';

    function mostrarMensaje(texto, tipo) {
        mensajeVacio.textContent = texto;
        mensajeVacio.className = 'alert alert-' + tipo + ' mt-4';
    }

    function crearTarjeta(curso) {

        const columna = document.createElement('div');
        columna.className = 'col-12 col-sm-6 col-lg-4 mb-4';

        const tarjeta = document.createElement('div');
        tarjeta.className = 'card h-100';

        const imagen = document.createElement('img');
        imagen.className = 'card-img-top';
        imagen.style.height = '180px';
        imagen.style.objectFit = 'cover';
        imagen.alt = 'Imagen del curso';

        imagen.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        imagen.addEventListener('error', function () {
            imagen.onerror = null;
            imagen.src = IMAGEN_PLACEHOLDER;
        });

        const cuerpo = document.createElement('div');
        cuerpo.className = 'card-body d-flex flex-column';

        const titulo = document.createElement('h5');
        titulo.className = 'card-title';
        titulo.textContent = curso.titulo || 'Curso sin título';

        const categoria = document.createElement('p');
        categoria.className = 'card-text text-muted';
        categoria.textContent = curso.categoria || 'Sin categoría';

        const descripcion = document.createElement('p');
        descripcion.className = 'card-text';
        descripcion.textContent = curso.descripcion || '';

        const precio = document.createElement('strong');
        const costo = Number(curso.costo);

        precio.textContent = Number.isFinite(costo)
            ? costo.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
              })
            : 'Precio no disponible';

        // Botón para consultar el detalle del curso
        const botonDetalle = document.createElement('a');
        botonDetalle.className =
            'btn btn-detalle mt-auto align-self-start';

        botonDetalle.textContent = 'Ver detalle';

        botonDetalle.href =
            '/ProyectoPWCI/public/detalle-curso-instructor?id_curso=' +
            encodeURIComponent(curso.id_curso);

        cuerpo.append(
            titulo,
            categoria,
            descripcion,
            precio,
            botonDetalle
        );

        tarjeta.append(imagen, cuerpo);
        columna.appendChild(tarjeta);

        return columna;
    }

    function mostrarCursos(cursos) {

        listaCursos.replaceChildren();

        if (!Array.isArray(cursos) || cursos.length === 0) {
            mostrarMensaje(
                'Todavía no has creado ningún curso.',
                'info'
            );
            return;
        }

        mensajeVacio.classList.add('d-none');

        cursos.forEach(function (curso) {
            listaCursos.appendChild(crearTarjeta(curso));
        });
    }

    // Consumir API mediante Fetch y Promesas
    fetch(API_URL, {
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

        const cursos = Array.isArray(datos)
            ? datos
            : datos.cursos;

        if (!Array.isArray(cursos)) {
            throw new Error(
                'La respuesta de la API no tiene el formato esperado.'
            );
        }

        mostrarCursos(cursos);
    })
    .catch(function (error) {

        console.error('Error al cargar los cursos:', error);

        mostrarMensaje(
            'No fue posible cargar tus cursos. Intenta nuevamente más tarde.',
            'danger'
        );
    });

});
