console.log('modal_reserva.js CARGADO');

document.addEventListener('DOMContentLoaded', () => {

    const botonesVer = document.querySelectorAll('.btn-ver-reserva');
    const modal = document.getElementById('modalReserva');

    if (!modal) return;

    const modalBootstrap = new bootstrap.Modal(modal);

    botonesVer.forEach(btn => {
        btn.addEventListener('click', () => {

            const idReserva = btn.dataset.id;

            fetch(`${BASE_URL}/turista/obtener-reserva?id=${idReserva}`)
                .then(response => response.json())
                .then(data => {

                    // HEADER
                    document.getElementById('modal-nombre-actividad').textContent =
                        data.nombre_actividad;

                    document.getElementById('modal-estado').textContent =
                        data.estado;

                    document.getElementById('modal-fecha-reserva').textContent =
                        `Fecha: ${data.fecha}`;

                    // INFO
                    document.getElementById('modal-proveedor').textContent =
                        data.proveedor;

                    document.getElementById('modal-fecha').textContent =
                        data.fecha;

                    document.getElementById('modal-personas').textContent =
                        data.cantidad_personas;

                    document.getElementById('modal-total').textContent =
                        Number(data.precio).toLocaleString('es-CO');

                    document.getElementById('modal-estado-texto').textContent =
                        data.estado;

                    document.getElementById('modal-descripcion').textContent =
                        data.descripcion;

                    // IMÁGENES
                    const imgPrincipal = document.getElementById('modal-imagen-principal');
                    const galeria = document.getElementById('modal-galeria');

                    galeria.innerHTML = '';

                    if (data.imagenes && data.imagenes.length > 0) {

                        const principal = data.imagenes.find(img => img.es_principal == 1)
                            || data.imagenes[0];

                        imgPrincipal.src =
                            `${BASE_URL}/public/uploads/turistico/actividades/${principal.imagen}`;

                        data.imagenes.forEach(img => {
                            const miniatura = document.createElement('img');
                            miniatura.src =
                                `${BASE_URL}/public/uploads/turistico/actividades/${img.imagen}`;
                            miniatura.width = 60;
                            miniatura.classList.add('rounded');
                            galeria.appendChild(miniatura);
                        });

                    } else {
                        imgPrincipal.src = '';
                    }

                    // FOOTER (acciones)
                    const btnConfirmar = document.getElementById('btn-confirmar');
                    btnConfirmar.dataset.id = data.id_reserva;

                    if (data.estado === 'pendiente') {
                        btnConfirmar.style.display = 'inline-block';
                        btnCancelar.style.display = 'inline-block';
                    } else {
                        btnConfirmar.style.display = 'none';
                        btnCancelar.style.display = 'none';
                    }

                    modalBootstrap.show();
                })
                .catch(error => {
                    console.error('Error al cargar la reserva:', error);
                });

        });
    });

});


document.addEventListener('click', function (e) {

    if (e.target.id === 'btn-confirmar') {

        const idReserva = e.target.dataset.id;

        if (!idReserva) return;

        if (!confirm('¿Confirmar esta reserva?')) return;

        fetch(`${BASE_URL}/turista/confirmar-reserva`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id_reserva=${idReserva}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                alert('Reserva confirmada');
                location.reload();
            } else {
                alert(data.error);
            }
        });
    }

});


document.addEventListener('DOMContentLoaded', function () {
    const filtrosBtn = document.querySelectorAll('.filtro-btn');
    const filasReservas = document.querySelectorAll('tbody tr');

    filtrosBtn.forEach(btn => {
        btn.addEventListener('click', function () {
            // 1. Gestionar clase 'active' en los botones
            filtrosBtn.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filtro = this.getAttribute('data-filter').toLowerCase();

            // 2. Lógica de filtrado
            filasReservas.forEach(fila => {
                // Obtenemos el texto de la columna de estado (columna 7)
                const celdaEstado = fila.querySelector('td:nth-child(7)');
                if (!celdaEstado) return; // Saltar si es la fila de "No hay reservas"

                const estadoTexto = celdaEstado.textContent.trim().toLowerCase();

                // Reglas de visualización
                if (filtro === 'all') {
                    fila.style.display = '';
                } else if (filtro === 'activo') {
                    // Se consideran activos los estados 'confirmada'
                    fila.style.display = (estadoTexto === 'confirmada') ? '' : 'none';
                } else if (filtro === 'inactivo') {
                    // Se consideran inactivos los estados 'cancelada'
                    fila.style.display = (estadoTexto === 'cancelada') ? '' : 'none';
                } else if (filtro === 'pendiente') {
                    fila.style.display = (estadoTexto === 'pendiente') ? '' : 'none';
                }
            });
        });
    });
});