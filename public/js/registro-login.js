// Mostrar Login
function mostrarLogin() {

    document
        .getElementById("loginForm")
        .classList
        .remove("d-none");

    document
        .getElementById("registroForm")
        .classList
        .add("d-none");
}


// Mostrar Registro
function mostrarRegistro() {

    document
        .getElementById("loginForm")
        .classList
        .add("d-none");

    document
        .getElementById("registroForm")
        .classList
        .remove("d-none");
}


// Vista previa de imagen
document
    .getElementById("imagenPerfil")
    .addEventListener("change", function(event) {

        const archivo = event.target.files[0];

        if (archivo) {

            const lector = new FileReader();

            lector.onload = function(e) {

                document
                    .getElementById("imagenPreview")
                    .src = e.target.result;

            };

            lector.readAsDataURL(archivo);
        }

    });

function iniciarSesion(event) { 
    event.preventDefault();
    window.location.href = "/PruebaPWCI/public/main";
}