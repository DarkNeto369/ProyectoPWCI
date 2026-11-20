
document.addEventListener('DOMContentLoaded', function () {

    const filtroCategoria = document.getElementById('filtroCategoria');
    const tablaVentas = document.getElementById('tablaVentas');
    const ingresosTotales = document.getElementById('ingresosTotales');
    const mensajeVacio = document.getElementById('mensajeVacio');
    const mensajeError = document.getElementById('mensajeError');

    // Formatear cantidades como moneda mexicana
    function formatoMoneda(cantidad) {
        return Number(cantidad).toLocaleString('es-MX', {
            style: 'currency',
            currency: 'MXN'
        });
    }

    // Obtener el reporte de ventas
    function cargarReporte() {

        const categoria = filtroCategoria.value;

        tablaVentas.innerHTML = `
            <tr>
                <td colspan="3" class="text-center">
                    Cargando reporte...
                </td>
            </tr>
        `;

        mensajeVacio.classList.add('d-none');
        mensajeError.classList.add('d-none');

        fetch('/ProyectoPWCI/public/reporte-ventas/datos?categoria=' + encodeURIComponent(categoria))

            .then(response => {

                if (!response.ok) {
                    throw new Error('No se pudo recuperar el reporte.');
                }

                return response.text().then(texto => {
                    console.log('Respuesta del servidor:', texto);
                    return JSON.parse(texto);
                });
            })

            .then(datos => {

                tablaVentas.innerHTML = '';

                // Mostrar los ingresos totales
                ingresosTotales.textContent = formatoMoneda(
                    datos.ingresos_totales
                );

                // Verificar si existen cursos
                if (datos.cursos.length === 0) {

                    mensajeVacio.classList.remove('d-none');

                    return;
                }

                // Crear una fila por cada curso
                datos.cursos.forEach(curso => {

                    const fila = document.createElement('tr');

                    const celdaCurso = document.createElement('td');
                    celdaCurso.textContent = curso.curso;

                    const celdaAlumnos = document.createElement('td');
                    celdaAlumnos.textContent = curso.alumnos;

                    const celdaIngresos = document.createElement('td');
                    celdaIngresos.textContent = formatoMoneda(
                        curso.ingresos
                    );

                    fila.appendChild(celdaCurso);
                    fila.appendChild(celdaAlumnos);
                    fila.appendChild(celdaIngresos);

                    tablaVentas.appendChild(fila);
                });

            })

            .catch(error => {

                console.error(error);

                mostrarError();
            });
    }

    // Mostrar mensaje de error
    function mostrarError() {

        tablaVentas.innerHTML = '';

        ingresosTotales.textContent = formatoMoneda(0);

        mensajeVacio.classList.add('d-none');
        mensajeError.classList.remove('d-none');
    }

    // Cambiar el reporte al seleccionar otra categoría
    filtroCategoria.addEventListener('change', cargarReporte);

    // Cargar el reporte inicial
    cargarReporte();

});
