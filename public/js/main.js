
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // CONFIGURACIÓN GENERAL
    // ==========================================

    const API_URL = '/ProyectoPWCI/public/api/cursos';

    const IMAGEN_PLACEHOLDER =
        'https://placehold.co/400x225?text=Curso';


    // ==========================================
    // ELEMENTOS DEL CARRUSEL DE CURSOS RECIENTES
    // ==========================================

    const listaCursos = document.getElementById('listaCursos');
    const mensajeCursos = document.getElementById('mensajeCursos');
    const btnAnterior = document.getElementById('btnCursosAnterior');
    const btnSiguiente = document.getElementById('btnCursosSiguiente');


    // ==========================================
    // ELEMENTOS DEL CARRUSEL MEJOR VALORADOS
    // ==========================================

    const listaMejorValorados =
        document.getElementById('listaMejorValorados');

    const mensajeMejorValorados =
        document.getElementById('mensajeMejorValorados');

    const btnMejorAnterior =
        document.getElementById('btnMejorValoradosAnterior');

    const btnMejorSiguiente =
        document.getElementById('btnMejorValoradosSiguiente');


    // ==========================================
    // MENSAJES
    // ==========================================

    function mostrarMensaje(elemento, texto, tipo) {

        elemento.textContent = texto;
        elemento.className = 'alert alert-' + tipo;
        elemento.classList.remove('d-none');
    }


    // ==========================================
    // CREAR TARJETA DE CURSO
    // ==========================================

    function crearTarjeta(curso) {

        const columna = document.createElement('div');
        columna.className = 'col-12 col-sm-6 col-lg-3 mb-4';

        const tarjeta = document.createElement('div');
        tarjeta.className = 'card h-100';

        // Imagen
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


        // Título
        const titulo = document.createElement('h5');

        titulo.className = 'card-title';
        titulo.textContent = curso.titulo || 'Curso sin título';


        // Categoría
        const categoria = document.createElement('p');

        categoria.className = 'card-text text-muted';
        categoria.textContent = curso.categoria || 'Sin categoría';


        // Instructor
        const instructor = document.createElement('p');

        instructor.className = 'card-text mb-2';

        instructor.textContent = 'Instructor: ' +
            (curso.nombre_instructor || 'No disponible');


        // Calificaciones
        const calificaciones = document.createElement('div');

        calificaciones.className = 'mb-2';

        const promedio = Number(curso.promedio_calificacion || 0);

        const totalCalificaciones =
            Number(curso.total_calificaciones || 0);


        // Estrellas
        const estrellas = document.createElement('div');

        estrellas.className = 'text-warning';

        const estrellasRedondeadas = Math.max(
            0,
            Math.min(5, Math.round(promedio))
        );

        estrellas.textContent =
            '★'.repeat(estrellasRedondeadas) +
            '☆'.repeat(5 - estrellasRedondeadas);


        // Promedio
        const puntuacion = document.createElement('small');

        puntuacion.className = 'text-muted';

        puntuacion.textContent = totalCalificaciones > 0
            ? promedio.toFixed(1) + ' / 5 (' +
                totalCalificaciones + ' calificaciones)'
            : 'Sin calificaciones';

        calificaciones.append(estrellas, puntuacion);


        // Descripción
        const descripcion = document.createElement('p');

        descripcion.className = 'card-text';
        descripcion.textContent = curso.descripcion || '';


        // Precio
        const precio = document.createElement('strong');

        const costo = Number(curso.costo);

        precio.textContent = Number.isFinite(costo)
            ? costo.toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            })
            : 'Precio no disponible';


        // Botón de detalle
        const botonDetalle = document.createElement('a');

        botonDetalle.className =
            'btn btn-detalle mt-auto align-self-start';

        botonDetalle.textContent = 'Ver detalle';

        botonDetalle.href =
            '/ProyectoPWCI/public/detalle-curso?id_curso=' +
            encodeURIComponent(curso.id_curso);


        // Agregar elementos
        cuerpo.append(
            titulo,
            categoria,
            instructor,
            calificaciones,
            descripcion,
            precio,
            botonDetalle
        );

        tarjeta.append(imagen, cuerpo);
        columna.appendChild(tarjeta);

        return columna;
    }


    // ==========================================
    // MOSTRAR CURSOS EN CUALQUIER CARRUSEL
    // ==========================================

    function mostrarCursos(
        lista,
        contenedor,
        mensaje,
        anterior,
        siguiente,
        mensajeVacio
    ) {

        contenedor.innerHTML = '';

        if (lista.length === 0) {

            mostrarMensaje(mensaje, mensajeVacio, 'info');

            anterior.classList.add('d-none');
            siguiente.classList.add('d-none');

            return;
        }

        mensaje.classList.add('d-none');


        // Agrupar cursos de cuatro en cuatro
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
            contenedor.appendChild(elemento);
        }


        // Mostrar controles si hay más de cuatro cursos
        const hayVariasPaginas = lista.length > 4;

        anterior.classList.toggle('d-none', !hayVariasPaginas);
        siguiente.classList.toggle('d-none', !hayVariasPaginas);
    }


    // ==========================================
    // CARGAR CURSOS RECIENTES
    // ==========================================

    fetch(API_URL, {

        method: 'GET',

        headers: {
            'Accept': 'application/json'
        }

    })

    .then(function (respuesta) {

        if (!respuesta.ok) {

            throw new Error(
                'La API respondió con el código HTTP ' +
                respuesta.status
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

        mostrarCursos(
            cursos,
            listaCursos,
            mensajeCursos,
            btnAnterior,
            btnSiguiente,
            'Todavía no hay cursos disponibles.'
        );

    })

    .catch(function (error) {

        console.error('Error al cargar los cursos recientes:', error);

        mostrarMensaje(
            mensajeCursos,
            'No fue posible cargar los cursos. Intenta nuevamente más tarde.',
            'danger'
        );

        btnAnterior.classList.add('d-none');
        btnSiguiente.classList.add('d-none');

    });


    // ==========================================
    // CARGAR CURSOS MEJOR VALORADOS
    // ==========================================

    fetch(API_URL + '/mejor-valorados', {

        method: 'GET',

        headers: {
            'Accept': 'application/json'
        }

    })

    .then(function (respuesta) {

        if (!respuesta.ok) {

            throw new Error(
                'La API respondió con el código HTTP ' +
                respuesta.status
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

        mostrarCursos(
            cursos,
            listaMejorValorados,
            mensajeMejorValorados,
            btnMejorAnterior,
            btnMejorSiguiente,
            'Todavía no hay cursos calificados.'
        );

    })

    .catch(function (error) {

        console.error(
            'Error al cargar los cursos mejor valorados:',
            error
        );

        mostrarMensaje(
            mensajeMejorValorados,
            'No fue posible cargar los cursos mejor valorados.',
            'danger'
        );

        btnMejorAnterior.classList.add('d-none');
        btnMejorSiguiente.classList.add('d-none');

    });

});

