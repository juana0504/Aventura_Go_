const modoOscuroBtn = document.getElementById('modoOscuroBtn');
const notificacionesBtn = document.getElementById('notificacionesBtn');

// Prevenir que los botones envíen el formulario
modoOscuroBtn.addEventListener('click', (e) => {
    e.preventDefault();
    document.body.classList.toggle('modo-oscuro');
});

notificacionesBtn.addEventListener('click', (e) => {
    e.preventDefault();
    alert("Tienes nuevas reservas, verifica");
});

// --------------------------------------------------
// lógica para filtros del dashboard
// --------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    const aplicarBtn = document.getElementById('aplicar-filtros-proveedor');
    const limpiarBtn = document.getElementById('limpiar-filtros-proveedor');
    const tipoSelect = document.getElementById('filtro-tipo-proveedor');
    const mesContainer = document.getElementById('filtro-mes-container-proveedor');
    const anioContainer = document.getElementById('filtro-anio-container-proveedor');
    const tablaReservas = document.getElementById('tabla-reservas-proveedor');

    // mostrar/ocultar mes y año
    if (tipoSelect) {
        tipoSelect.addEventListener('change', () => {
            const tipo = tipoSelect.value;
            if (tipo === 'mes') {
                mesContainer.style.display = 'flex';
                anioContainer.style.display = 'flex';
            } else {
                mesContainer.style.display = 'none';
                anioContainer.style.display = 'flex';
            }
        });
    }

    function filtrarTablaProveedor() {
        if (!tablaReservas) return;
        const tipo = tipoSelect ? tipoSelect.value : 'anio';
        const año = document.getElementById('filtro-anio-proveedor').value;
        const mes = document.getElementById('filtro-mes-proveedor').value;

        // Construir URL del endpoint
        let url = PROVEEDOR_DASHBOARD_DATA_URL.replace('/data', '/filtrarReservas');
        
        const params = [];
        params.push('tipo=' + tipo);
        if (año) params.push('anio=' + año);
        if (mes && tipo === 'mes') params.push('mes=' + mes);

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        console.log('Llamando a:', url);

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Error en la respuesta: ' + res.status);
                return res.json();
            })
            .then(datos => {
                console.log('Datos recibidos:', datos);
                actualizarTablaReservas(datos.reservas || []);
            })
            .catch(err => console.error('Error filtrando reservas:', err));
    }

    function actualizarTablaReservas(reservas) {
        if (!tablaReservas) return;
        const tbody = tablaReservas.querySelector('tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (!reservas || reservas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay reservas con estos filtros.</td></tr>';
            return;
        }

        reservas.forEach(r => {
            const row = document.createElement('tr');
            const estadoColor = r.estado === 'confirmada' ? 'bg-success' 
                : (r.estado === 'pendiente' ? 'bg-warning text-dark' : 'bg-secondary');
            
            const precio = parseFloat(r.precio) || 0;
            
            row.innerHTML = `
                <td>${r.nombre_turista}</td>
                <td>${r.fecha}</td>
                <td>${r.nombre_actividad}</td>
                <td>${r.cantidad_personas}</td>
                <td>$${precio.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td><span class="badge ${estadoColor}">${r.estado}</span></td>
            `;
            tbody.appendChild(row);
        });
    }

    function limpiarTablaProveedor() {
        if (!tablaReservas) return;
        document.getElementById('filtro-anio-proveedor').value = '';
        document.getElementById('filtro-mes-proveedor').value = '';
        if (mesContainer) mesContainer.style.display = 'none';
        filtrarTablaProveedor();
    }

    if (aplicarBtn) aplicarBtn.addEventListener('click', filtrarTablaProveedor);
    if (limpiarBtn) limpiarBtn.addEventListener('click', limpiarTablaProveedor);

    // toggle filtros
    const btnFiltrar = document.getElementById('btn-filtrar');
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', (e) => {
            e.preventDefault();
            const cont = document.getElementById('filtros-reservas');
            if (cont) {
                const hidden = cont.style.display === 'none';
                cont.style.display = hidden ? 'block' : 'none';
                if (hidden) filtrarTablaProveedor();
            }
        });
    }
});

