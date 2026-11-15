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

    const formulario = this;
    const boton = formulario.querySelector('button[type="submit"]');

    const archivoImagen = document.getElementById("imagenPerfil").files[0];

    const datos = {
        nombre: document.getElementById("nombre").value.trim(),
        apellido: document.getElementById("apellido").value.trim(),
        genero: document.getElementById("genero").value,
        fecha_nacimiento: document.getElementById("fechaNacimiento").value,
        rol: document.getElementById("rol").value,
        correo: document.getElementById("registroCorreo").value.trim(),
        contra: document.getElementById("registroPassword").value
    };

    const formularioDatos = new FormData();

    Object.entries(datos).forEach(([campo, valor]) => {
        formularioDatos.append(campo, valor);
    });

    if (archivoImagen) {
        formularioDatos.append("imagen_perfil", archivoImagen);
    }

    boton.disabled = true;
    boton.textContent = "Registrando...";

    fetch(`${API_URL}/registro`, {
        method: "POST",
        credentials: "same-origin",
        body: formularioDatos
    })
    .then(async response => {
        const respuesta = await response.json();

        if (!response.ok) {
            throw new Error(
                respuesta.error ||
                respuesta.mensaje ||
                "No se pudo registrar el usuario."
            );
        }

        return respuesta;
    })
    .then(resultado => {
        mostrarMensaje(
            "mensajeRegistro",
            resultado.mensaje || "Usuario registrado correctamente.",
            "success"
        );

        formulario.reset();

        document.getElementById("imagenPreview").src =
            "https://via.placeholder.com/150";

        console.log("Respuesta del registro:", resultado);
    })
    .catch(error => {
        mostrarMensaje("mensajeRegistro", error.message, "danger");
    })
    .finally(() => {
        boton.disabled = false;
        boton.textContent = "Registrarse";
    });
});
