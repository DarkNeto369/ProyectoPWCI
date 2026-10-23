let contadorNiveles = 0;

const maxNiveles = 3;

const agregarNivelBtn = document.getElementById("agregarNivel");
const nivelesContainer = document.getElementById("nivelesContainer");


// Agregar nivle

agregarNivelBtn.addEventListener("click", function () {

if (contadorNiveles >= maxNiveles) {
    alert("Solo puedes agregar un máximo de 3 niveles.");
    return;
}

contadorNiveles++;

const nivel = document.createElement("div");

nivel.classList.add("level-card");

nivel.setAttribute(
    "data-nivel",
    contadorNiveles
);

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


    <!-- Video -->

    <video
        class="video-preview"
        controls
    ></video>


    <!-- Estado -->

    <div class="mt-3 estadoNivel">

        <span class="text-muted">
            <span class="me-1">○</span>
            Video pendiente
        </span>

    </div>

`;


nivelesContainer.appendChild(nivel);


// Video

const videoInput =
    nivel.querySelector(".videoInput");

const videoPreview =
    nivel.querySelector(".video-preview");


videoInput.addEventListener("change", function () {

    const archivo = this.files[0];

    if (!archivo) {
        return;
    }

    const videoURL =
        URL.createObjectURL(archivo);

    videoPreview.src = videoURL;

    videoPreview.style.display = "block";

});


// Terminar video

videoPreview.addEventListener("ended", function () {

    const estado =
        nivel.querySelector(".estadoNivel");

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

const eliminarBtn =
    nivel.querySelector(".eliminarNivel");


eliminarBtn.addEventListener("click", function () {

    nivel.remove();

    contadorNiveles--;

    actualizarNumeros();

    actualizarBoton();

});


actualizarBoton();

});


// Actualisar números

function actualizarNumeros() {

const niveles =
    document.querySelectorAll(".level-card");

niveles.forEach(function (nivel, index) {

    const numero = index + 1;

    nivel.setAttribute(
        "data-nivel",
        numero
    );

    nivel.querySelector(
        ".level-number"
    ).textContent = numero;

    nivel.querySelector(
        "strong"
    ).textContent = `Nivel ${numero}`;

});

}


// Actualisar botón

function actualizarBoton() {

if (contadorNiveles >= maxNiveles) {

    agregarNivelBtn.disabled = true;

    agregarNivelBtn.textContent =
        "Máximo de 3 niveles";

} else {

    agregarNivelBtn.disabled = false;

    agregarNivelBtn.textContent =
        "+ Agregar nivel";

}

}


// Guardar curso

document
.getElementById("guardarCurso")
.addEventListener("click", function () {

    const categoria =
        document.getElementById("categoria").value;

    const titulo =
        document.getElementById("titulo").value.trim();

    const descripcion =
        document.getElementById("descripcion").value.trim();

    const costo =
        document.getElementById("costo").value;


    // Validaciones básicas

    if (!categoria) {

        alert("Selecciona una categoría.");
        return;

    }

    if (!titulo) {

        alert("Escribe el título del curso.");
        return;

    }

    if (!descripcion) {

        alert("Escribe una descripción.");
        return;

    }

    if (!costo) {

        alert("Ingresa el costo del curso.");
        return;

    }

    if (contadorNiveles === 0) {

        alert("Debes agregar al menos un nivel.");
        return;

    }


    const niveles =
        document.querySelectorAll(".level-card");


    // Verificar que todos tengan nombre y video

    for (let nivel of niveles) {

        const nombre =
            nivel.querySelector(".nombreNivel").value.trim();

        const video =
            nivel.querySelector(".videoInput").files[0];


        if (!nombre) {

            alert(
                "Todos los niveles deben tener un nombre."
            );

            return;

        }


        if (!video) {

            alert(
                "Todos los niveles deben tener un video."
            );

            return;

        }

    }


    alert(
        "Curso listo para guardar."
    );

        // Conectar formulario con PHP/MySQL.

    

});