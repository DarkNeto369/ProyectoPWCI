
document.addEventListener('DOMContentLoaded', function () {

    const BASE_URL = '/ProyectoPWCI/public';

    const listaConversaciones = document.getElementById('listaConversaciones');
    const tituloLista = document.getElementById('tituloLista');

    const mensajesChat = document.getElementById('mensajesChat');
    const nombreContacto = document.getElementById('nombreContacto');
    const nombreCurso = document.getElementById('nombreCurso');

    const formularioMensaje = document.getElementById('formularioMensaje');
    const inputMensaje = document.getElementById('inputMensaje');
    const btnEnviarMensaje = document.getElementById('btnEnviarMensaje');

    const ID_USUARIO = Number(window.ID_USUARIO);
    const ROL_USUARIO = window.ROL_USUARIO;

    let conversacionActual = null;

    // Mostrar errores en el panel izquierdo
    function mostrarErrorLista(mensaje) {

        listaConversaciones.innerHTML = '';

        const elemento = document.createElement('div');
        elemento.classList.add('mensaje-vacio');

        const texto = document.createElement('p');
        texto.textContent = mensaje;

        elemento.appendChild(texto);
        listaConversaciones.appendChild(elemento);
    }

    // Crear elemento de texto seguro
    function crearTexto(etiqueta, texto) {

        const elemento = document.createElement(etiqueta);
        elemento.textContent = texto || '';

        return elemento;
    }

    // Cargar cursos
    function cargarCursos() {

        tituloLista.textContent = 'Mis cursos';

        fetch(BASE_URL + '/api/mis-cursos', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {

            return response.json().then(data => {

                if (!response.ok) {
                    throw new Error(
                        data.error || 'No se pudieron obtener tus cursos.'
                    );
                }

                return data;
            });

        })
        .then(data => {

            listaConversaciones.innerHTML = '';

            const cursos = data.cursos;

            if (!Array.isArray(cursos) || cursos.length === 0) {

                mostrarErrorLista('Todavía no estás inscrito en ningún curso.');

                return;
            }

            cursos.forEach(curso => {

                const elemento = document.createElement('div');
                elemento.classList.add('conversacion-item');

                if (
                    conversacionActual &&
                    Number(conversacionActual.id_curso) === Number(curso.id_curso)
                ) {
                    elemento.classList.add('conversacion-activa');
                }

                const titulo = crearTexto(
                    'strong',
                    curso.titulo || 'Curso sin título'
                );

                const instructor = crearTexto(
                    'small',
                    'Contactar al instructor'
                );

                elemento.appendChild(titulo);
                elemento.appendChild(instructor);

                elemento.addEventListener('click', function () {

                    abrirConversacion({
                        id_curso: curso.id_curso,
                        id_contacto: curso.id_instructor,
                        nombre_contacto: 'Instructor del curso',
                        nombre_curso: curso.titulo
                    });

                });

                listaConversaciones.appendChild(elemento);

            });

        })
        .catch(error => {

            console.error('Error al cargar cursos:', error);

            mostrarErrorLista(error.message);

        });

    }

    // Cargar conversaciones
    function cargarConversaciones() {

        tituloLista.textContent = 'Conversaciones';

        fetch(BASE_URL + '/api-mensajes')
            .then(response => {

                return response.json().then(data => {

                    if (!response.ok) {
                        throw new Error(
                            data.error || 'No se pudieron obtener las conversaciones.'
                        );
                    }

                    return data;
                });

            })
            .then(data => {

                listaConversaciones.innerHTML = '';

                const conversaciones = data.conversaciones;

                if (
                    !Array.isArray(conversaciones) ||
                    conversaciones.length === 0
                ) {

                    mostrarErrorLista('Aún no tienes conversaciones.');

                    return;
                }

                conversaciones.forEach(conversacion => {

                    const elemento = document.createElement('div');
                    elemento.classList.add('conversacion-item');

                    if (
                        conversacionActual &&
                        Number(conversacion.id_curso) === Number(conversacionActual.id_curso) &&
                        Number(conversacion.id_contacto) === Number(conversacionActual.id_contacto)
                    ) {
                        elemento.classList.add('conversacion-activa');
                    }

                    const contacto = crearTexto(
                        'strong',
                        `${conversacion.nombre_contacto || 'Usuario'} ${conversacion.apellido_contacto || ''}`.trim()
                    );

                    const curso = crearTexto(
                        'small',
                        conversacion.nombre_curso || 'Curso'
                    );

                    const ultimoMensaje = crearTexto(
                        'p',
                        conversacion.ultimo_mensaje || ''
                    );

                    elemento.appendChild(contacto);
                    elemento.appendChild(curso);
                    elemento.appendChild(ultimoMensaje);

                    elemento.addEventListener('click', function () {

                        abrirConversacion(conversacion);

                    });

                    listaConversaciones.appendChild(elemento);

                });

            })
            .catch(error => {

                console.error('Error al cargar conversaciones:', error);

                mostrarErrorLista(error.message);

            });

    }

    // Abrir conversación
    function abrirConversacion(conversacion) {

        if (!conversacion.id_curso || !conversacion.id_contacto) {

            alert('No se pudo identificar el curso o el contacto.');

            return;
        }

        conversacionActual = conversacion;

        nombreContacto.textContent =
            conversacion.nombre_contacto || 'Contacto';

        nombreCurso.textContent =
            conversacion.nombre_curso || 'Curso';

        mensajesChat.innerHTML = `
            <div class="chat-vacio">
                <p>Cargando mensajes...</p>
            </div>
        `;

        inputMensaje.disabled = false;
        btnEnviarMensaje.disabled = false;

        cargarMensajes();

        if (ROL_USUARIO === 'estudiante') {
            cargarCursos();
        } else {
            cargarConversaciones();
        }

        inputMensaje.focus();

    }

    function cargarMensajes() {

        if (!conversacionActual) return;

        const parametros = new URLSearchParams({
            id_curso: conversacionActual.id_curso,
            id_contacto: conversacionActual.id_contacto
        });

        fetch(BASE_URL + '/api-mensajes?' + parametros.toString())
            .then(response => {

                return response.json().then(data => {

                    if (!response.ok) {
                        throw new Error(
                            data.error || 'No se pudieron obtener los mensajes.'
                        );
                    }

                    return data;
                });

            })
            .then(data => {

                mensajesChat.innerHTML = '';

                if (!data.mensajes || data.mensajes.length === 0) {

                    mensajesChat.innerHTML = `
                        <div class="chat-vacio">
                            <p>Comienza la conversación enviando un mensaje.</p>
                        </div>
                    `;

                    return;
                }

                data.mensajes.forEach(mensaje => {

                    const elemento = document.createElement('div');

                    elemento.classList.add('mensaje-burbuja');

                    if (Number(mensaje.id_remitente) === ID_USUARIO) {
                        elemento.classList.add('mensaje-propio');
                    } else {
                        elemento.classList.add('mensaje-ajeno');
                    }

                    const remitente = crearTexto(
                        'strong',
                        mensaje.nombre_remitente || 'Usuario'
                    );

                    const contenido = crearTexto(
                        'p',
                        mensaje.contenido
                    );

                    const fecha = crearTexto(
                        'small',
                        mensaje.fecha_envio
                            ? new Date(
                                mensaje.fecha_envio.replace(' ', 'T')
                            ).toLocaleString('es-MX')
                            : ''
                    );

                    elemento.appendChild(remitente);
                    elemento.appendChild(contenido);
                    elemento.appendChild(fecha);

                    mensajesChat.appendChild(elemento);

                });

                mensajesChat.scrollTop = mensajesChat.scrollHeight;

            })
            .catch(error => {

                console.error('Error al cargar mensajes:', error);

                mensajesChat.innerHTML = `
                    <div class="chat-vacio">
                        <p>${error.message}</p>
                    </div>
                `;

            });

    }

    // Enviar mensaje
    formularioMensaje.addEventListener('submit', function (e) {

        e.preventDefault();

        if (!conversacionActual) return;

        const contenido = inputMensaje.value.trim();

        if (contenido === '') {
            alert('Escribe un mensaje.');
            return;
        }

        btnEnviarMensaje.disabled = true;

        fetch(BASE_URL + '/api-mensajes', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },

            body: JSON.stringify({

                id_curso: conversacionActual.id_curso,

                id_contacto: conversacionActual.id_contacto,

                contenido: contenido

            })

        })
        .then(response => {

            return response.json().then(data => {

                if (!response.ok) {
                    throw new Error(
                        data.error || 'No se pudo enviar el mensaje.'
                    );
                }

                return data;
            });

        })
        .then(() => {

            inputMensaje.value = '';

            cargarMensajes();

            if (ROL_USUARIO === 'estudiante') {
                cargarCursos();
            } else {
                cargarConversaciones();
            }

        })
        .catch(error => {

            console.error('Error al enviar mensaje:', error);

            alert(error.message);

        })
        .finally(() => {

            btnEnviarMensaje.disabled = !conversacionActual;

            inputMensaje.focus();

        });

    });

    // Cargar según rol
    if (ROL_USUARIO === 'estudiante') {

        cargarCursos();

    } else if (ROL_USUARIO === 'instructor') {

        cargarConversaciones();

    } else {

        mostrarErrorLista('Tu rol no tiene acceso a los mensajes.');

    }

});
