// Imagen de perfil

const profileImage = document.getElementById("profileImage");
const profilePreview = document.getElementById("profilePreview");

profileImage.addEventListener("change", function () {

    const file = this.files[0];

    if (!file) {
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {

        profilePreview.src = event.target.result;

    };

    reader.readAsDataURL(file);

});


// Guardar perfil

const profileForm = document.getElementById("profileForm");
const message = document.getElementById("message");

profileForm.addEventListener("submit", function (event) {

    event.preventDefault();

    // Datos actuales del formulario
    const datos = {

        nombre: document.getElementById("nombre").value,
        apellido: document.getElementById("apellido").value,
        genero: document.getElementById("genero").value,
        fechaNacimiento: document.getElementById("fechaNacimiento").value,
        correo: document.getElementById("correo").value,
        password: document.getElementById("password").value,
        imagen: profileImage.files[0] || null

    };


    console.log("Datos preparados para enviar:", datos);


    // Mensaje temporal
    message.className = "alert alert-success mt-4";
    message.textContent = "Los cambios se han guardado correctamente.";

});