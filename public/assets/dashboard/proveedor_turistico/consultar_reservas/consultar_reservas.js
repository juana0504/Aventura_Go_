/**
 * Gestión de Reservas - Proveedor Turístico
 */
document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. FILTROS RÁPIDOS (Vía URL) ---
    const filtroBtns = document.querySelectorAll('.filtro-btn');
    
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filtro = this.dataset.filter;
            // Redirigimos para que el backend procese la consulta y el PDF sea consistente
            window.location.href = `${BASE_URL}/proveedor/consultar-reservas?filtro=${filtro}`;
        });
    });

    // --- 2. BUSCADOR EN TIEMPO REAL (Filtro visual) ---
    const inputBuscador = document.querySelector('.search-container input');
    if (inputBuscador) {
        inputBuscador.addEventListener('keyup', function() {
            const busqueda = this.value.toLowerCase();
            const filas = document.querySelectorAll('table tbody tr');

            filas.forEach(fila => {
                // Si es la fila de "No hay registros", la saltamos
                if (fila.cells.length <= 1) return;

                const textoFila = fila.textContent.toLowerCase();
                fila.style.display = textoFila.includes(busqueda) ? '' : 'none';
            });
        });
    }
});

// --- 3. FUNCIONES DE ACCIÓN (Confirmar / Cancelar) ---

/**
 * Confirma una reserva pendiente
 * @param {number} id - ID de la reserva
 */
function confirmarReserva(id) {
    if (confirm('¿Está seguro de confirmar esta reserva?\n\nEl turista será notificado y se esperará su asistencia.')) {
        window.location.href = `${BASE_URL}/proveedor/consultar-reservas?accion=confirmar&id=${id}`;
    }
}

/**
 * Cancela una reserva pendiente
 * @param {number} id - ID de la reserva
 */
function cancelarReserva(id) {
    const motivo = prompt('Por favor, indique el motivo de la cancelación (opcional):');
    if (motivo !== null) {
        if (confirm('¿Confirmar la cancelación definitiva de esta reserva?')) {
            window.location.href = `${BASE_URL}/proveedor/consultar-reservas?accion=cancelar&id=${id}&motivo=${encodeURIComponent(motivo)}`;
        }
    }
}

/**
 * Helper para formatear moneda local (COP)
 */
function number_format(number) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    }).format(number);
}