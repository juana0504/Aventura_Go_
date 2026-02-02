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
