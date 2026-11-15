
document.addEventListener('DOMContentLoaded', function () {

    const listaCursos = document.getElementById('listaCursos');
    const mensajeCursos = document.getElementById('mensajeCursos');
    const btnAnterior = document.getElementById('btnCursosAnterior');
    const btnSiguiente = document.getElementById('btnCursosSiguiente');

    const API_URL = '/ProyectoPWCI/public/api/cursos';

    const IMAGEN_PLACEHOLDER =
        'https://placehold.co/400x225?text=Curso';

    function mostrarMensaje(texto, tipo) {
        mensajeCursos.textContent = texto;
        mensajeCursos.className = 'alert alert-' + tipo;
        mensajeCursos.classList.remove('d-none');
    }

    function crearTarjeta(curso) {

        const columna = document.createElement('div');
        columna.className = 'col-12 col-sm-6 col-lg-3 mb-4';

        const tarjeta = document.createElement('div');
        tarjeta.className = 'card h-100';

        const imagen = document.createElement('img');
        imagen.className = 'card-img-top';
        imagen.style.height = '160px';
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
            }) + ' MXN'
            : 'Precio no disponible';

        const botonDetalle = document.createElement('a');
        botonDetalle.className = 'btn btn-detalle mt-auto align-self-start';
        botonDetalle.textContent = 'Ver detalle';

        botonDetalle.href =
            '/ProyectoPWCI/public/detalle-curso?id_curso=' +
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

    function mostrarCursos(lista) {

        listaCursos.innerHTML = '';

        if (lista.length === 0) {
            mostrarMensaje('Todavía no hay cursos disponibles.', 'info');
            btnAnterior.classList.add('d-none');
            btnSiguiente.classList.add('d-none');
            return;
        }

        mensajeCursos.classList.add('d-none');

        // Agrupar los cursos de cuatro en cuatro
        for (let i = 0; i < lista.length; i += 4) {

            const elemento = document.createElement('div');
            elemento.className = 'carousel-item';

            if (i === 0) {
                elemento.classList.add('active');
            }

            const fila = document.createElement('div');
            fila.className = 'row';

            lista.slice(i, i + 4).forEach(function (curso) {
                fila.appendChild(crearTarjeta(curso));
            });

            elemento.appendChild(fila);
            listaCursos.appendChild(elemento);
        }

        // Mostrar controles solamente si hay más de cuatro cursos
        const hayVariasPaginas = lista.length > 4;

        btnAnterior.classList.toggle('d-none', !hayVariasPaginas);
        btnSiguiente.classList.toggle('d-none', !hayVariasPaginas);
    }

    // Consultar la API
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
            'No fue posible cargar los cursos. Intenta nuevamente más tarde.',
            'danger'
        );

        btnAnterior.classList.add('d-none');
        btnSiguiente.classList.add('d-none');
    });

});


