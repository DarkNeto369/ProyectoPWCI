console.log("JavaScript de registro-login cargado");

const API_URL = "/ProyectoPWCI/public";

// Mostrar Login
function mostrarLogin() {
    document.getElementById("loginForm").classList.remove("d-none");
    document.getElementById("registroForm").classList.add("d-none");
}

// Mostrar Registro
function mostrarRegistro() {
    document.getElementById("loginForm").classList.add("d-none");
    document.getElementById("registroForm").classList.remove("d-none");
}

// Vista previa de imagen
document.getElementById("imagenPerfil").addEventListener("change", function (event) {
    const archivo = event.target.files[0];

    if (archivo) {
        const lector = new FileReader();

        lector.onload = function (e) {
            document.getElementById("imagenPreview").src = e.target.result;
        };

        lector.readAsDataURL(archivo);
    }
});

// Mostrar mensajes del backend
function mostrarMensaje(elementoId, mensaje, tipo) {
    const elemento = document.getElementById(elementoId);

    elemento.textContent = mensaje;
    elemento.className = `alert alert-${tipo} mt-3`;
}

// Procesar inicio de sesión
document.getElementById("formLogin").addEventListener("submit", function (event) {
    event.preventDefault();

    const correo = document.getElementById("loginCorreo").value.trim();
    const contra = document.getElementById("loginPassword").value;
    const mensaje = document.getElementById("mensajeLogin");

    mensaje.textContent = "";

    fetch(`${API_URL}/login`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "same-origin",
        body: JSON.stringify({
            correo: correo,
            contra: contra
        })
    })
    .then(response => {
        return response.json().then(datos => ({
            ok: response.ok,
            datos: datos
        }));
    })
    .then(resultado => {
        if (!resultado.ok) {
            throw new Error(
                resultado.datos.error ||
                resultado.datos.mensaje ||
                "No se pudo iniciar sesión."
            );
        }

        mostrarMensaje(
            "mensajeLogin",
            resultado.datos.mensaje || "Inicio de sesión correcto.",
            "success"
        );

        // Página principal con su ruta
        console.log("Respuesta del login:", resultado.datos);

        window.location.href = "/ProyectoPWCI/public/main";

        
    })
    .catch(error => {
        mostrarMensaje("mensajeLogin", error.message, "danger");
    });
});

// Procesar registro
document.getElementById("formRegistro").addEventListener("submit", function (event) {

    event.preventDefault();

    console.log("Formulario de registro interceptado");

    const datos = {
        nombre: document.getElementById("nombre").value.trim(),
        apellido: document.getElementById("apellido").value.trim(),
        genero: document.getElementById("genero").value,
        fecha_nacimiento: document.getElementById("fechaNacimiento").value,
        rol: document.getElementById("rol").value,
        correo: document.getElementById("registroCorreo").value.trim(),
        contra: document.getElementById("registroPassword").value,

        
        imagen_perfil: null
    };

    const mensaje = document.getElementById("mensajeRegistro");
    mensaje.textContent = "";

    fetch(`${API_URL}/registro`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "same-origin",
        body: JSON.stringify(datos)
    })
    .then(response => {
        return response.json().then(datosRespuesta => ({
            ok: response.ok,
            datos: datosRespuesta
        }));
    })
    .then(resultado => {
        if (!resultado.ok) {
            const datosRespuesta = resultado.datos;

            let error = datosRespuesta.error ||
                        datosRespuesta.mensaje ||
                        "No se pudo registrar el usuario.";

            if (Array.isArray(datosRespuesta.errores)) {
                error = datosRespuesta.errores.join(" ");
            }

            throw new Error(error);
        }

        mostrarMensaje(
            "mensajeRegistro",
            resultado.datos.mensaje || "Usuario registrado correctamente.",
            "success"
        );

        console.log("Respuesta del registro:", resultado.datos);
    })
    .catch(error => {
        mostrarMensaje("mensajeRegistro", error.message, "danger");
    });
});
