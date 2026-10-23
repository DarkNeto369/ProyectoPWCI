

const tipoUsuario = "usuario";



const cursosComprados = [

    {
        id: 1,
        titulo: "Desarrollo Web Completo",
        instructor: "Juan Pérez",
        imagen: "https://picsum.photos/400/225?random=1",
        precio: 499
    },

    {
        id: 2,
        titulo: "JavaScript desde Cero",
        instructor: "María López",
        imagen: "https://picsum.photos/400/225?random=2",
        precio: 399
    },

    {
        id: 3,
        titulo: "Bootstrap 5",
        instructor: "Carlos Hernández",
        imagen: "https://picsum.photos/400/225?random=3",
        precio: 299
    }

];


const cursosPublicados = [

    {
        id: 10,
        titulo: "Desarrollo Web Completo",
        instructor: "Yo",
        imagen: "https://picsum.photos/400/225?random=4",
        precio: 599
    },

    {
        id: 11,
        titulo: "Curso de JavaScript",
        instructor: "Yo",
        imagen: "https://picsum.photos/400/225?random=5",
        precio: 449
    }

];


const listaCursos = document.getElementById("listaCursos");
const mensajeVacio = document.getElementById("mensajeVacio");

const tituloCursos = document.getElementById("tituloCursos");
const descripcionCursos = document.getElementById("descripcionCursos");
const etiquetaUsuario = document.getElementById("tipoUsuario");



let cursos = [];


if (tipoUsuario === "usuario") {

    cursos = cursosComprados;

    tituloCursos.textContent = "Mis cursos";
    descripcionCursos.textContent =
        "Cursos que has comprado y puedes comenzar a estudiar.";

    etiquetaUsuario.textContent = "Usuario";
    etiquetaUsuario.className = "badge bg-primary";

}


else if (tipoUsuario === "instructor") {

    cursos = cursosPublicados;

    tituloCursos.textContent = "Mis cursos";
    descripcionCursos.textContent =
        "Cursos que has publicado como instructor.";

    etiquetaUsuario.textContent = "Instructor";
    etiquetaUsuario.className = "badge bg-success";

}



function mostrarCursos() {

    listaCursos.innerHTML = "";


    if (cursos.length === 0) {

        mensajeVacio.classList.remove("d-none");

        return;
    }


    mensajeVacio.classList.add("d-none");


    cursos.forEach(curso => {

        const columna = document.createElement("div");

        columna.className = "col-12 col-md-6 col-lg-4";


        columna.innerHTML = `

            <a
                href="detalle-curso.html?id=${curso.id}"
                class="curso-link"
            >

                <div class="card curso-card">

                    <img
                        src="${curso.imagen}"
                        class="card-img-top curso-imagen"
                        alt="${curso.titulo}"
                    >

                    <div class="card-body">

                        <h5 class="card-title">
                            ${curso.titulo}
                        </h5>

                        <p class="card-text text-muted mb-2">
                            Instructor: ${curso.instructor}
                        </p>

                        <p class="fw-bold mb-0">
                            $${curso.precio}
                        </p>

                    </div>

                </div>

            </a>

        `;


        listaCursos.appendChild(columna);

    });

}


mostrarCursos();
