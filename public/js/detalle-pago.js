

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