
let contadorNiveles = 0;

const maxNiveles = 3;

const agregarNivelBtn = document.getElementById("agregarNivel");
const nivelesContainer = document.getElementById("nivelesContainer");

// Imagen del curso
const imagenInput = document.getElementById("imagen");
const vistaPreviaImagen = document.getElementById("vistaPreviaImagen");

let imagenURL = null;


// Vista previa de la imagen

imagenInput.addEventListener("change", function () {

    const archivo = this.files[0];

    if (!archivo) {
        vistaPreviaImagen.style.display = "none";
        return;
    }

    if (!archivo.type.startsWith("image/")) {
        alert("Selecciona una imagen válida.");
        this.value = "";
        vistaPreviaImagen.style.display = "none";
        return;
    }

    if (imagenURL) {
        URL.revokeObjectURL(imagenURL);
    }

    imagenURL = URL.createObjectURL(archivo);

    vistaPreviaImagen.src = imagenURL;
    vistaPreviaImagen.style.display = "block";

});


// Agregar nivel

agregarNivelBtn.addEventListener("click", function () {

    if (contadorNiveles >= maxNiveles) {
        alert("Solo puedes agregar un máximo de 3 niveles.");
        return;
    }

    contadorNiveles++;

    const nivel = document.createElement("div");

    nivel.classList.add("level-card");

    nivel.setAttribute("data-nivel", contadorNiveles);

    nivel.innerHTML = `

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <span class="level-number">
                    ${contadorNiveles}
                </span>

                <strong>
                    Nivel ${contadorNiveles}
                </strong>
            </div>

            <button
                type="button"
                class="btn btn-outline-danger btn-sm eliminarNivel"
            >
                Eliminar
            </button>

        </div>

        <!-- Nombre del nivel -->

        <div class="mb-3">

            <label class="form-label">
                Nombre del nivel
            </label>

            <input
                type="text"
                class="form-control nombreNivel"
                placeholder="Ej. Introducción a HTML"
            >

        </div>

        <!-- Video -->

        <div class="mb-3">

            <label class="form-label">
                Video del nivel
            </label>

            <input
                type="file"
                class="form-control videoInput"
                accept="video/*"
            >

        </div>

        <video class="video-preview" controls></video>

        <!-- Estado -->

        <div class="mt-3 estadoNivel">

            <span class="text-muted">
                <span class="me-1">○</span>
                Video pendiente
            </span>

        </div>
    `;

    nivelesContainer.appendChild(nivel);


    // Vista previa del video

    const videoInput = nivel.querySelector(".videoInput");
    const videoPreview = nivel.querySelector(".video-preview");

    let videoURL = null;

    videoInput.addEventListener("change", function () {

        const archivo = this.files[0];

        if (!archivo) {
            return;
        }

        if (!archivo.type.startsWith("video/")) {
            alert("Selecciona un archivo de video válido.");
            this.value = "";
            return;
        }

        if (videoURL) {
            URL.revokeObjectURL(videoURL);
        }

        videoURL = URL.createObjectURL(archivo);

        videoPreview.src = videoURL;
        videoPreview.style.display = "block";

    });


    // Terminar video

    videoPreview.addEventListener("ended", function () {

        const estado = nivel.querySelector(".estadoNivel");

        estado.innerHTML = `

            <span class="completed">

                <span class="completed-icon">
                    ✓
                </span>

                ✓ Video completado

            </span>

        `;

    });


    // Eliminar nivel

    const eliminarBtn = nivel.querySelector(".eliminarNivel");

    eliminarBtn.addEventListener("click", function () {

        if (videoURL) {
            URL.revokeObjectURL(videoURL);
        }

        nivel.remove();

        contadorNiveles--;

        actualizarNumeros();
        actualizarBoton();

    });

    actualizarBoton();

});


// Actualizar números

function actualizarNumeros() {

    const niveles = document.querySelectorAll(".level-card");

    niveles.forEach(function (nivel, index) {

        const numero = index + 1;

        nivel.setAttribute("data-nivel", numero);

        nivel.querySelector(".level-number").textContent = numero;

        nivel.querySelector("strong").textContent = `Nivel ${numero}`;

    });

}


// Actualizar botón

function actualizarBoton() {

    if (contadorNiveles >= maxNiveles) {

        agregarNivelBtn.disabled = true;

        agregarNivelBtn.textContent = "Máximo de 3 niveles";

    } else {

        agregarNivelBtn.disabled = false;

        agregarNivelBtn.textContent = "+ Agregar nivel";

    }

}


// Guardar curso

document.getElementById("guardarCurso").addEventListener("click", async function () {

    const botonGuardar = this;

    const categoria = document.getElementById("categoria").value;

    const titulo = document.getElementById("titulo").value.trim();

    const descripcion = document.getElementById("descripcion").value.trim();

    const costo = document.getElementById("costo").value;

    const imagen = imagenInput.files[0];


    // Validaciones del curso

    if (!titulo) {
        alert("Escribe el título del curso.");
        return;
    }

    if (!descripcion) {
        alert("Escribe una descripción.");
        return;
    }

    if (costo === "" || !Number.isFinite(Number(costo)) || Number(costo) < 0) {
        alert("Ingresa un costo válido.");
        return;
    }

    if (!imagen) {
        alert("Selecciona una imagen para el curso.");
        return;
    }

    if (!imagen.type.startsWith("image/")) {
        alert("Selecciona una imagen válida.");
        return;
    }

    const niveles = document.querySelectorAll(".level-card");

    if (niveles.length === 0) {
        alert("Debes agregar al menos un nivel.");
        return;
    }


    // Preparar niveles y videos

    const datosNiveles = [];
    const formData = new FormData();

    for (let i = 0; i < niveles.length; i++) {

        const nivel = niveles[i];

        const nombre = nivel.querySelector(".nombreNivel").value.trim();

        const video = nivel.querySelector(".videoInput").files[0];

        if (!nombre) {
            alert("Todos los niveles deben tener un nombre.");
            return;
        }

        if (!video) {
            alert("Todos los niveles deben tener un video.");
            return;
        }

        datosNiveles.push({
            numero_nivel: i + 1,
            nombre: nombre
        });

        formData.append("videos[]", video);

    }


    // Datos del curso

    formData.append("categoria", categoria);
    formData.append("titulo", titulo);
    formData.append("descripcion", descripcion);
    formData.append("costo", costo);
    formData.append("imagen", imagen);

    // Los niveles se envían como JSON

    formData.append("niveles", JSON.stringify(datosNiveles));


    // Enviar a la API

    try {

        botonGuardar.disabled = true;
        botonGuardar.textContent = "Guardando curso...";

        const respuesta = await fetch(
            "/ProyectoPWCI/public/api/cursos",
            {
                method: "POST",
                body: formData
            }
        );

        const resultado = await respuesta.json();

        if (!respuesta.ok) {
            throw new Error(
                resultado.error || "No se pudo registrar el curso."
            );
        }

        alert(resultado.mensaje || "Curso agregado correctamente.");


        // Limpiar formulario después de guardar

        document.getElementById("titulo").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("costo").value = "";
        document.getElementById("categoria").value = "";

        imagenInput.value = "";
        vistaPreviaImagen.src = "";
        vistaPreviaImagen.style.display = "none";

        if (imagenURL) {
            URL.revokeObjectURL(imagenURL);
            imagenURL = null;
        }

        nivelesContainer.innerHTML = "";

        contadorNiveles = 0;

        actualizarBoton();

    } catch (error) {

        console.error("Error al agregar curso:", error);

        alert(error.message || "Ocurrió un error al comunicarse con la API.");

    } finally {

        botonGuardar.disabled = false;
        botonGuardar.textContent = "Crear curso";

    }

});

