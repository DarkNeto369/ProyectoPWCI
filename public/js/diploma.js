
document.addEventListener('DOMContentLoaded', function () {

    const parametros = new URLSearchParams(window.location.search);
    const idInscripcion = parametros.get('id_inscripcion');

    const nombreEstudiante = document.getElementById('nombreEstudiante');
    const nombreCurso = document.getElementById('nombreCurso');
    const fechaTerminacion = document.getElementById('fechaTerminacion');
    const nombreInstructor = document.getElementById('nombreInstructor');

    if (!idInscripcion) {
        alert('No se encontró la inscripción.');
        return;
    }

    fetch('/ProyectoPWCI/public/api/cursos/diploma?id_inscripcion=' + encodeURIComponent(idInscripcion))

    .then(function (respuesta) {

        return respuesta.json().then(function (datos) {

            if (!respuesta.ok) {
                throw new Error(datos.error || 'No se pudo cargar el diploma.');
            }

            return datos;
        });

    })

    .then(function (datos) {

        const diploma = datos.diploma;

        nombreEstudiante.textContent = diploma.nombre_estudiante;
        nombreCurso.textContent = diploma.nombre_curso;
        nombreInstructor.textContent = diploma.nombre_instructor || 'No especificado';

        const fecha = new Date(diploma.fecha_terminacion.replace(' ', 'T'));

        fechaTerminacion.textContent = fecha.toLocaleDateString('es-MX', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    })

    .catch(function (error) {

        console.error(error);

        nombreEstudiante.textContent = 'Error al cargar';
        nombreCurso.textContent = error.message;
        nombreInstructor.textContent = '';
        fechaTerminacion.textContent = '';

    });

});
