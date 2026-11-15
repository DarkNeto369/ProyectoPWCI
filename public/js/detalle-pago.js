

const curso = {
    titulo: "Desarrollo Web Completo",
    imagen: "https://picsum.photos/600/350?random=10",
    precio: 499.00
};


// Mostrar información del curso

document.getElementById("courseTitle").textContent =
    curso.titulo;

document.querySelector(".course-image").src =
    curso.imagen;

document.getElementById("coursePrice").textContent =
    "$" + curso.precio.toFixed(2) + " MXN";


// Botón de confirmación

document.getElementById("confirmButton").addEventListener(
    "click",
    function () {

        alert(
            "Aquí posteriormente se integrará el pago mediante PayPal."
        );

    }
);

document.addEventListener('DOMContentLoaded', function () {

    const courseImage = document.getElementById('courseImage');
    const courseTitle = document.getElementById('courseTitle');
    const courseTitlePayment = document.getElementById('courseTitlePayment');
    const coursePrice = document.getElementById('coursePrice');

    const API_URL = '/ProyectoPWCI/public/api/cursos/detalle';
    const IMAGEN_PLACEHOLDER = 'https://placehold.co/400x225?text=Curso';

    // Obtener el ID del curso desde la URL
    const parametros = new URLSearchParams(window.location.search);
    const idCurso = parametros.get('id_curso');

    if (!idCurso) {
        courseTitle.textContent = 'No se seleccionó ningún curso';
        return;
    }

    // Consultar los datos del curso
    fetch(API_URL + '?id_curso=' + encodeURIComponent(idCurso), {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(respuesta => {
        if (!respuesta.ok) {
            throw new Error('Error HTTP: ' + respuesta.status);
        }

        return respuesta.json();
    })
    .then(datos => {

        const curso = datos.curso;

        if (!curso) {
            throw new Error('No se encontró el curso.');
        }

        // Mostrar información del curso
        courseTitle.textContent = curso.titulo || 'Curso sin título';
        courseTitlePayment.textContent = curso.titulo || 'Curso sin título';

        coursePrice.textContent = '$' + Number(curso.costo || 0).toFixed(2) + ' MXN';

        courseImage.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        courseImage.onerror = function () {
            this.src = IMAGEN_PLACEHOLDER;
        };

    })
    .catch(error => {
        console.error('Error al cargar el curso:', error);
        courseTitle.textContent = 'No fue posible cargar el curso';
    });

});