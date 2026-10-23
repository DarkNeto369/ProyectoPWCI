function buyCourse() {

    

    window.location.href = "detalle-pago.php";

}




function changeToPurchasedCourse() {

    const button = document.getElementById("buyButton");

    button.textContent = "Continuar curso";

    button.classList.remove("btn-primary");
    button.classList.add("btn-success");

    button.onclick = function () {

        // Posteriormente llevará al contenido del curso.
        console.log("Continuar curso");

    };

}