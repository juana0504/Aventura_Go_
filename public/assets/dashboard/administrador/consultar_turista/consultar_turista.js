document.addEventListener("DOMContentLoaded", function () {
    const tablaAdmin = document.getElementById('tablaAdmin');
    const filtroBtns = document.querySelectorAll('.filtro-btn');
    const inputBuscador = document.querySelector('.search-container input'); // Asumiendo clase de buscador_admin.css

    // --- 1. FILTROS RÁPIDOS (ESTADOS) ---
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Actualizar estado visual de los botones
            filtroBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filtro = this.getAttribute('data-filter').toLowerCase();
            const filas = tablaAdmin.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                // Saltar si es la fila de "No hay registros"
                if (fila.cells.length <= 1) return;

                // En tu HTML el estado es la penúltima celda (índice 5)
                const celdaEstado = fila.cells[5].textContent.trim().toLowerCase();

                if (filtro === 'all' || celdaEstado === filtro) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });

    // --- 2. BUSCADOR EN TIEMPO REAL ---
    if (inputBuscador) {
        inputBuscador.addEventListener('keyup', function () {
            const busqueda = this.value.toLowerCase();
            const filas = tablaAdmin.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                if (fila.cells.length <= 1) return;
                
                // Busca en Nombre (celda 1) o Email (celda 4)
                const nombre = fila.cells[1].textContent.toLowerCase();
                const email = fila.cells[4].textContent.toLowerCase();

                if (nombre.includes(busqueda) || email.includes(busqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }

    // --- 3. CONFIRMACIÓN DE ELIMINACIÓN ---
    tablaAdmin.addEventListener('click', function (e) {
        const btnEliminar = e.target.closest('.btn-eliminar');
        if (btnEliminar) {
            const confirmacion = confirm("¿Estás seguro de que deseas eliminar este turista? Esta acción no se puede deshacer.");
            if (!confirmacion) {
                e.preventDefault(); // Cancela la redirección del <a>
            }
        }
    });
});