
document.addEventListener('DOMContentLoaded', function () {

    const parametros = new URLSearchParams(window.location.search);
    const idInscripcion = parametros.get('id_inscripcion');

    const tituloCurso = document.getElementById('tituloCurso');
    const descripcionCurso = document.getElementById('descripcionCurso');
    const listaNiveles = document.getElementById('listaNiveles');
    const mensajeNiveles = document.getElementById('mensajeNiveles');

    const videoCurso = document.getElementById('videoCurso');
    const nombreNivel = document.getElementById('nombreNivel');
    const btnCompletarNivel = document.getElementById('btnCompletarNivel');
    const mensajeNivel = document.getElementById('mensajeNivel');

    const porcentajeProgreso = document.getElementById('porcentajeProgreso');
    const barraProgreso = document.getElementById('barraProgreso');
    const seccionDiploma = document.getElementById('seccionDiploma');

    let niveles = [];
    let nivelActual = null;

    // Validar el identificador de inscripción
    if (!idInscripcion || !/^[1-9]\d*$/.test(idInscripcion)) {
        mostrarError('No se proporcionó una inscripción válida.');
        return;
    }

    // Obtener los niveles de la inscripción
    fetch('/ProyectoPWCI/public/api/cursos/niveles?id_inscripcion=' + encodeURIComponent(idInscripcion), {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })

    .then(function (respuesta) {

        return respuesta.json().then(function (datos) {

            if (!respuesta.ok) {
                throw new Error(datos.error || 'No se pudieron obtener los niveles.');
            }

            return datos;
        });

    })

    .then(function (datos) {

        niveles = datos.niveles || [];

        if (niveles.length === 0) {
            mostrarError('Este curso todavía no tiene niveles disponibles.');
            return;
        }

        mostrarNiveles();

        // Seleccionar el primer nivel pendiente
        const primerPendiente = niveles.find(function (nivel) {
            return Number(nivel.completado) === 0;
        });

        seleccionarNivel(primerPendiente || niveles[0]);

        actualizarProgreso();

    })

    .catch(function (error) {

        console.error(error);
        mostrarError(error.message);

    });

    // Mostrar los niveles en pantalla
    function mostrarNiveles() {

        listaNiveles.innerHTML = '';

        niveles.forEach(function (nivel) {

            const completado = Number(nivel.completado) === 1;

            const elemento = document.createElement('div');

            elemento.className = 'nivel-item' +
                (completado ? ' completado' : '');

            elemento.dataset.id = nivel.id_nivel;

            elemento.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h3>
                            Nivel ${escaparHTML(nivel.numero_nivel)}:
                            ${escaparHTML(nivel.nombre)}
                        </h3>

                        <small>
                            ${completado ? 'Completado' : 'Pendiente'}
                        </small>
                    </div>

                    <span class="icono-completado">
                        ${completado ? '✓' : '○'}
                    </span>

                </div>
            `;

            elemento.addEventListener('click', function () {
                seleccionarNivel(nivel);
            });

            listaNiveles.appendChild(elemento);

        });

    }

    // Seleccionar un nivel y reproducir su video
    function seleccionarNivel(nivel) {

        nivelActual = nivel;

        nombreNivel.textContent =
            'Nivel ' + nivel.numero_nivel + ': ' + nivel.nombre;

        const rutaVideo = nivel.video.startsWith('http') || nivel.video.startsWith('/')
            ? nivel.video
            : '/ProyectoPWCI/public/' + nivel.video;

        videoCurso.src = rutaVideo;
        videoCurso.load();

        btnCompletarNivel.disabled =
            Number(nivel.completado) === 1;

        mensajeNivel.textContent =
            Number(nivel.completado) === 1
                ? '✓ Este nivel ya está completado.'
                : '';

        document.querySelectorAll('.nivel-item').forEach(function (elemento) {

            elemento.classList.toggle(
                'activo',
                Number(elemento.dataset.id) === Number(nivel.id_nivel)
            );

        });

    }

    // Marcar nivel como completado
    btnCompletarNivel.addEventListener('click', function () {

        if (!nivelActual) {
            return;
        }

        btnCompletarNivel.disabled = true;

        fetch('/ProyectoPWCI/public/api/cursos/completar-nivel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_inscripcion: idInscripcion,
                id_nivel: nivelActual.id_nivel
            })
        })

        .then(function (respuesta) {

            return respuesta.json().then(function (datos) {

                if (!respuesta.ok) {
                    throw new Error(datos.error || 'No se pudo completar el nivel.');
                }

                return datos;
            });

        })

        .then(function (datos) {

            nivelActual.completado = 1;

            mostrarNiveles();
            seleccionarNivel(nivelActual);

            mensajeNivel.textContent = '✓ Nivel completado correctamente.';

            actualizarProgreso();

        })

        .catch(function (error) {

            console.error(error);

            mensajeNivel.textContent = error.message;
            mensajeNivel.classList.add('text-danger');

            btnCompletarNivel.disabled = false;

        });

    });

    // Actualizar el progreso general
    function actualizarProgreso() {

        const total = niveles.length;

        const completados = niveles.filter(function (nivel) {
            return Number(nivel.completado) === 1;
        }).length;

        const progreso = total > 0
            ? (completados / total) * 100
            : 0;

        porcentajeProgreso.textContent = progreso.toFixed(2) + '%';

        barraProgreso.style.width = progreso + '%';
        barraProgreso.setAttribute('aria-valuenow', progreso);

        if (completados === total && total > 0) {

            seccionDiploma.classList.remove('d-none');

            tituloCurso.textContent =
                '¡Curso completado!';

        }

    }

    // Mostrar errores
    function mostrarError(mensaje) {

        mensajeNiveles.textContent = mensaje;
        mensajeNiveles.classList.remove('d-none');

    }

    // Evitar insertar texto de la base de datos como HTML
    function escaparHTML(texto) {

        return String(texto ?? '').replace(/[&<>"']/g, function (caracter) {

            const caracteres = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return caracteres[caracter];

        });

    }

    // Abrir el diploma
    document.getElementById('btnDiploma').addEventListener('click', function () {

        window.location.href =
            '/ProyectoPWCI/public/diploma?id_inscripcion=' +
            encodeURIComponent(idInscripcion);

    });

});
