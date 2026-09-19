// Simulación de cursos comprados
const cursos = [
    {
        imagen: "../assets/img/1.png",
        titulo: "HTML y CSS desde cero",
        instructor: "Juan Pérez",
        calificacion: 4.8,
        precio: 299
    },
    {
        imagen: "../assets/img/1.png",
        titulo: "JavaScript moderno",
        instructor: "María González",
        calificacion: 4.9,
        precio: 399
    },
    {
        imagen: "../assets/img/1.png",
        titulo: "PHP y MySQL",
        instructor: "Carlos Ramírez",
        calificacion: 4.7,
        precio: 349
    },
    {
        imagen: "../assets/img/1.png",
        titulo: "Tailwind CSS",
        instructor: "Ana López",
        calificacion: 4.8,
        precio: 249
    },
    {
        imagen: "../assets/img/1.png",
        titulo: "Desarrollo Web Full Stack",
        instructor: "Luis Hernández",
        calificacion: 5.0,
        precio: 499
    },
    {
        imagen: "../assets/img/1.png",
        titulo: "Bases de Datos con MySQL",
        instructor: "Sofía Martínez",
        calificacion: 4.6,
        precio: 299
    }
];


const contenedor = document.getElementById("contenedorCursos");
const contador = document.getElementById("contadorCursos");


// Mostrar cantidad de cursos
//contador.textContent = `${cursos.length} cursos adquiridos`;


// Generar tarjetas
cursos.forEach(curso => {

    const tarjeta = document.createElement("article");

    tarjeta.className =
        "bg-white rounded-xl overflow-hidden shadow-md border border-slate-200 " +
        "hover:shadow-xl hover:-translate-y-1 transition duration-300";


    tarjeta.innerHTML = `

        <img
            src="${curso.imagen}"
            alt="${curso.titulo}"
            class="w-full h-60 object-cover"
        >

        <div class="p-5">

            <h2 class="text-xl font-bold text-slate-800 mb-2">
                ${curso.titulo}
            </h2>

            <p class="text-slate-500 mb-3">
                ${curso.instructor}
            </p>

            <div class="flex items-center gap-2 mb-4">

                <span class="text-rose-400 text-lg">
                    ★★★★★
                </span>

                <span class="text-sm text-slate-500">
                    (${curso.calificacion})
                </span>

            </div>

            <div class="flex items-center justify-between">

                <span class="text-xl font-bold text-emerald-600">
                    $${curso.precio} MXN
                </span>

                <button
                    class="bg-emerald-500 hover:bg-emerald-600
                            text-white font-semibold
                            px-4 py-2 rounded-lg
                            transition">
                    Ver curso
                </button>

            </div>

        </div>
    `;


    contenedor.appendChild(tarjeta);

});