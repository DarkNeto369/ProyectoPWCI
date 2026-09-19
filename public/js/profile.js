const profileImage = document.getElementById("profileImage");
const profilePreview = document.getElementById("profilePreview");
const perfilForm = document.getElementById("perfilForm");
const message = document.getElementById("message");


// Vista previa de la imagen
profileImage.addEventListener("change", function () {

    const file = this.files[0];

    if (!file) {
        return;
    }

    if (!file.type.startsWith("image/")) {
        alert("Selecciona una imagen válida.");
        this.value = "";
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        profilePreview.src = e.target.result;
    };

    reader.readAsDataURL(file);

});


// Guardar cambios
perfilForm.addEventListener("submit", function (event) {

    event.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    if (username === "") {

        message.textContent = "El nombre de usuario es obligatorio.";
        message.className = "text-center mt-4 font-semibold text-rose-600";
        return;

    }

    // Aquí posteriormente puedes hacer el fetch() hacia tu API.
    console.log("Usuario:", username);
    console.log("Nueva contraseña:", password);
    console.log("Imagen:", profileImage.files[0]);

    message.textContent = "Cambios guardados correctamente.";
    message.className = "text-center mt-4 font-semibold text-emerald-600";

});