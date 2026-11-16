
document.addEventListener('DOMContentLoaded', function () {

    const listaCursos = document.getElementById('listaCursos');
    const mensajeVacio = document.getElementById('mensajeVacio');

    // Obtener los cursos inscritos del estudiante
    fetch('/ProyectoPWCI/public/api/mis-cursos', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })

    // Convertir la respuesta a JSON
    .then(function (respuesta) {

        return respuesta.json().then(function (datos) {

            if (!respuesta.ok) {
                throw new Error(datos.error || 'No se pudieron obtener tus cursos.');
            }

            return datos;
        });

    })

    // Mostrar los cursos
    .then(function (datos) {

        const cursos = datos.cursos;

        if (!Array.isArray(cursos) || cursos.length === 0) {
            mensajeVacio.classList.remove('d-none');
            return;
        }

        mensajeVacio.classList.add('d-none');

        cursos.forEach(function (curso) {

            const columna = document.createElement('div');
            columna.className = 'col-md-6 col-lg-4';

            const progreso = Number(curso.progreso) || 0;
            const nivelesCompletados = Number(curso.niveles_completados) || 0;
            const totalNiveles = Number(curso.total_niveles) || 0;

            const imagen = curso.imagen
                ? (curso.imagen.startsWith('http') || curso.imagen.startsWith('/')
                    ? curso.imagen
                    : '/ProyectoPWCI/public/' + curso.imagen)
                : null;

            const costo = Number(curso.costo) || 0;

            const fecha = curso.fecha_inscripcion
                ? new Date(curso.fecha_inscripcion.replace(' ', 'T')).toLocaleDateString('es-MX')
                : 'No disponible';

            columna.innerHTML = `
                <div class="card curso-card h-100">

                    ${
                        imagen
                        ? `<img src="${imagen}" class="card-img-top curso-imagen" alt="Imagen del curso">`
                        : `<div class="curso-imagen bg-light d-flex justify-content-center align-items-center">
                                <span class="text-muted">Sin imagen</span>
                           </div>`
                    }

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">${escaparHTML(curso.titulo)}</h5>

                        <p class="card-text text-muted">
                            ${escaparHTML(curso.descripcion || 'Sin descripción disponible.')}
                        </p>

                        <p class="mb-2">
                            <strong>Inscrito:</strong> ${fecha}
                        </p>

                        <p class="mb-2">
                            <strong>Precio:</strong>
                            ${costo.toLocaleString('es-MX', {
                                style: 'currency',
                                currency: 'MXN'
                            })}
                        </p>

                        <p class="mb-2">
                            <strong>Progreso:</strong> ${progreso.toFixed(2)}%
                        </p>

                        <div class="progress mb-2" role="progressbar"
                             aria-valuenow="${progreso}"
                             aria-valuemin="0"
                             aria-valuemax="100">

                            <div class="progress-bar bg-success"
                                 style="width: ${Math.min(100, Math.max(0, progreso))}%">
                            </div>

                        </div>

                        <small class="text-muted mb-3">
                            ${nivelesCompletados} de ${totalNiveles} niveles completados
                        </small>

                        <span class="badge ${
                            curso.estado === 'completo' ? 'bg-success' : 'bg-primary'
                        } mt-auto align-self-start">

                            ${curso.estado === 'completo' ? 'Curso completado' : 'En progreso'}

                        </span>

                    </div>
                </div>
            `;

            listaCursos.appendChild(columna);

        });

    })

    // Manejar errores
    .catch(function (error) {

        console.error('Error al cargar los cursos:', error);

        listaCursos.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    ${escaparHTML(error.message)}
                </div>
            </div>
        `;

    });

    // Evitar insertar texto de la base de datos como HTML
    function escaparHTML(texto) {

        return String(texto).replace(/[&<>"']/g, function (caracter) {
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

});
