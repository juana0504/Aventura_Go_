/* =============================================
   AVENTURAGO — MODAL DETALLE RESERVA (TURISTA)
============================================= */

document.addEventListener('DOMContentLoaded', () => {

    const botonesVer     = document.querySelectorAll('.btn-ver-reserva');
    const modalEl        = document.getElementById('modalReserva');
    if (!modalEl) return;

    const modalBootstrap = new bootstrap.Modal(modalEl);

    const elNombre      = document.getElementById('modal-nombre-actividad');
    const elEstadoBadge = document.getElementById('modal-estado');
    const elEyebrow     = document.getElementById('modal-fecha-reserva');
    const elProveedor   = document.getElementById('modal-proveedor');
    const elFecha       = document.getElementById('modal-fecha');
    const elPersonas    = document.getElementById('modal-personas');
    const elTotal       = document.getElementById('modal-total');
    const elEstadoText  = document.getElementById('modal-estado-texto');
    const elDesc        = document.getElementById('modal-descripcion');
    const imgPrincipal  = document.getElementById('modal-imagen-principal');
    const galeria       = document.getElementById('modal-galeria');
    const btnCancelar   = document.getElementById('btn-cancelar');
    const btnConfirmar  = document.getElementById('btn-confirmar');

    botonesVer.forEach(btn => {
        btn.addEventListener('click', () => {

            const idReserva = btn.dataset.id;

            /* Resetear modal mientras carga */
            elNombre.textContent      = 'Cargando...';
            elEstadoBadge.textContent = '';
            elEyebrow.textContent     = '';
            elDesc.textContent        = '';
            imgPrincipal.src          = '';
            galeria.innerHTML         = '';
            btnCancelar.style.display = 'none';
            btnConfirmar.style.display = 'none';

            modalBootstrap.show();

            fetch(`${BASE_URL}turista/obtener-reserva?id=${idReserva}`)
                .then(res => {
                    if (!res.ok) throw new Error('Error de red');
                    return res.json();
                })
                .then(data => {
                    if (data.error) {
                        elNombre.textContent = 'Error al cargar los datos';
                        return;
                    }

                    /* ── HEADER ── */
                    elNombre.textContent  = data.nombre_actividad ?? '—';
                    elEyebrow.textContent = `Reserva #${data.id_reserva} · ${data.fecha ?? ''}`;

                    const estadoLabel = ucFirst(data.estado ?? '');
                    elEstadoBadge.textContent = estadoLabel;
                    elEstadoBadge.className   = 'ag-badge mt-1 ' + badgeClass(data.estado);

                    /* ── INFO ── */
                    elProveedor.textContent  = data.proveedor       ?? '—';
                    elFecha.textContent      = data.fecha           ?? '—';
                    elPersonas.textContent   = data.cantidad_personas ?? '—';
                    elTotal.textContent      = numFormat(
                        Number(data.precio) * Number(data.cantidad_personas)
                    );
                    elEstadoText.textContent = estadoLabel;
                    elDesc.textContent       = data.descripcion     ?? 'Sin descripción';

                    /* ── IMÁGENES ── */
                    const esHospedaje = data.tipo_reserva === 'hospedaje';
                    const imgBase = esHospedaje
                        ? `${BASE_URL}public/uploads/hotelero/actividades/`
                        : `${BASE_URL}public/uploads/turistico/actividades/`;

                    galeria.innerHTML = '';
                    if (data.imagenes && data.imagenes.length > 0) {
                        const principal = data.imagenes.find(i => i.es_principal == 1)
                            ?? data.imagenes[0];

                        imgPrincipal.src = imgBase + principal.imagen;

                        data.imagenes.forEach(img => {
                            const miniatura = document.createElement('img');
                            miniatura.src   = imgBase + img.imagen;
                            miniatura.title = 'Ver imagen';
                            miniatura.addEventListener('click', () => {
                                imgPrincipal.src = miniatura.src;
                                galeria.querySelectorAll('img').forEach(t => t.classList.remove('ag-thumb--active'));
                                miniatura.classList.add('ag-thumb--active');
                            });
                            if (img.es_principal == 1) miniatura.classList.add('ag-thumb--active');
                            galeria.appendChild(miniatura);
                        });
                    } else {
                        imgPrincipal.src = '';
                        imgPrincipal.alt = esHospedaje ? 'Sin foto del hospedaje' : 'Sin imagen disponible';
                    }

                    /* ── BOTONES DE ACCIÓN ── */
                    btnCancelar.dataset.id    = data.id_reserva;
                    btnCancelar.dataset.fecha = data.fecha;
                    btnCancelar.dataset.total = Number(data.precio) * Number(data.cantidad_personas);
                    btnConfirmar.style.display = 'none';

                    const cancelable = data.estado === 'pendiente' || data.estado === 'confirmada';
                    btnCancelar.style.display = cancelable ? 'inline-flex' : 'none';
                })
                .catch(err => {
                    console.error('Error al cargar reserva:', err);
                    elNombre.textContent = 'No se pudo cargar la reserva.';
                });
        });
    });

    /* ── CANCELAR RESERVA (AJAX) ── */
    btnCancelar.addEventListener('click', () => {
        const idReserva   = btnCancelar.dataset.id;
        const fechaStr    = btnCancelar.dataset.fecha;   // 'YYYY-MM-DD'
        const totalValor  = Number(btnCancelar.dataset.total) || 0;
        if (!idReserva) return;

        // Política de 24 horas
        const ahora       = new Date();
        const fechaReserva = new Date(fechaStr + 'T00:00:00');
        const diffHoras   = (fechaReserva - ahora) / (1000 * 60 * 60);

        let mensaje;
        if (diffHoras > 24) {
            mensaje = '¿Cancelar esta reserva?\n\n✅ Cancelación sin costo: la fecha de tu reserva es en más de 24 horas.';
        } else if (diffHoras > 0) {
            const penalidad = numFormat(Math.round(totalValor * 0.10));
            mensaje = `¿Cancelar esta reserva?\n\n⚠️ Atención — estás dentro de las últimas 24 horas antes de la reserva.\nSe descontará el 10% del valor total ($${penalidad} COP) como penalidad por cancelación tardía.`;
        } else {
            mensaje = '¿Cancelar esta reserva?\n\n⚠️ La fecha de la reserva ya ha pasado.';
        }

        if (!confirm(mensaje)) return;

        btnCancelar.disabled    = true;
        btnCancelar.textContent = 'Cancelando...';

        fetch(`${BASE_URL}turista/cancelar-reserva`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_reserva=${encodeURIComponent(idReserva)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                modalBootstrap.hide();
                location.reload();
            } else {
                alert(data.error ?? 'No se pudo cancelar la reserva. Intenta de nuevo.');
                btnCancelar.disabled    = false;
                btnCancelar.innerHTML   = '<i class="bi bi-x-lg"></i> Cancelar reserva';
            }
        })
        .catch(() => {
            alert('Error de conexión. Intenta de nuevo.');
            btnCancelar.disabled  = false;
            btnCancelar.innerHTML = '<i class="bi bi-x-lg"></i> Cancelar reserva';
        });
    });

    /* ── HELPERS ── */
    function ucFirst(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    }

    function numFormat(n) {
        return new Intl.NumberFormat('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(n);
    }

    function badgeClass(estado) {
        switch (estado) {
            case 'confirmada': return 'ag-badge--confirmed';
            case 'pendiente':  return 'ag-badge--pending';
            default:           return 'ag-badge--cancelled';
        }
    }

});


/* ── FILTROS DE ESTADO ── */
document.addEventListener('DOMContentLoaded', function () {
    const filtrosBtn    = document.querySelectorAll('.filtro-btn');
    const filasReservas = document.querySelectorAll('tbody tr');

    filtrosBtn.forEach(btn => {
        btn.addEventListener('click', function () {
            filtrosBtn.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filtro = this.getAttribute('data-filter').toLowerCase();

            filasReservas.forEach(fila => {
                const celdaEstado = fila.querySelector('td:nth-child(7)');
                if (!celdaEstado) return;

                const estadoTexto = celdaEstado.textContent.trim().toLowerCase();

                if (filtro === 'all') {
                    fila.style.display = '';
                } else if (filtro === 'activo') {
                    fila.style.display = estadoTexto === 'confirmada' ? '' : 'none';
                } else if (filtro === 'inactivo') {
                    fila.style.display = estadoTexto === 'cancelada' ? '' : 'none';
                } else if (filtro === 'pendiente') {
                    fila.style.display = estadoTexto === 'pendiente' ? '' : 'none';
                }
            });
        });
    });
});
