
document.addEventListener('DOMContentLoaded', function () {

    const courseImage = document.getElementById('courseImage');
    const courseTitle = document.getElementById('courseTitle');
    const courseTitlePayment = document.getElementById('courseTitlePayment');
    const coursePrice = document.getElementById('coursePrice');
    const confirmButton = document.getElementById('confirmButton');

    const API_URL = '/ProyectoPWCI/public/api/cursos/detalle';
    const API_COMPRA = '/ProyectoPWCI/public/api/compras';

    const IMAGEN_PLACEHOLDER = 'https://placehold.co/400x225?text=Curso';

    const parametros = new URLSearchParams(window.location.search);
    const idCurso = parametros.get('id_curso');

    let cursoCargado = false;

    confirmButton.disabled = true;

    if (!idCurso) {
        courseTitle.textContent = 'No se seleccionó ningún curso';
        return;
    }

    // Obtener los datos del curso
    fetch(API_URL + '?id_curso=' + encodeURIComponent(idCurso), {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(respuesta => {
        if (!respuesta.ok) {
            throw new Error('No fue posible obtener los datos del curso.');
        }

        return respuesta.json();
    })
    .then(datos => {

        const curso = datos.curso;

        if (!curso) {
            throw new Error('No se encontró el curso.');
        }

        courseTitle.textContent = curso.titulo || 'Curso sin título';
        courseTitlePayment.textContent = curso.titulo || 'Curso sin título';

        coursePrice.textContent =
            '$' + Number(curso.costo || 0).toFixed(2) + ' MXN';

        courseImage.src = curso.imagen
            ? '/ProyectoPWCI/public/' + curso.imagen
            : IMAGEN_PLACEHOLDER;

        courseImage.onerror = function () {
            this.src = IMAGEN_PLACEHOLDER;
        };

        cursoCargado = true;
        confirmButton.disabled = false;

    })
    .catch(error => {
        console.error('Error al cargar el curso:', error);
        courseTitle.textContent = 'No fue posible cargar el curso';
    });


    // Crear orden de PayPal y redirigir
    confirmButton.addEventListener('click', function () {

        if (!cursoCargado) {
            return;
        }

        confirmButton.disabled = true;
        confirmButton.textContent = 'Conectando con PayPal...';

        fetch(API_COMPRA, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                id_curso: idCurso
            })
        })
        .then(respuesta => {

            return respuesta.json().then(datos => {

                if (!respuesta.ok) {
                    throw new Error(
                        datos.mensaje || 'No fue posible iniciar la compra.'
                    );
                }

                return datos;
            });
        })
        .then(datos => {

            if (!datos.url_aprobacion) {
                throw new Error('PayPal no proporcionó la URL de aprobación.');
            }

            // Redirigir al estudiante a PayPal
            window.location.href = datos.url_aprobacion;

        })
        .catch(error => {

            console.error('Error al iniciar el pago:', error);

            alert(error.message);

            confirmButton.disabled = false;
            confirmButton.textContent = 'Confirmar y pagar con PayPal';

        });

    });

});
