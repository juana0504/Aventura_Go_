// --- Confirmar DESARCHIVAR proveedor ---
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-desarchivar-proveedor').forEach(btn => {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            Swal.fire({
                title: '¿Desarchivar proveedor?',
                html: `<p style="font-size:15px;color:#444;line-height:1.7;">
                    El proveedor <strong>${nombre}</strong> será restaurado al estado <strong>Activo</strong>.<br><br>
                    Sus actividades que fueron pausadas al archivar quedarán <strong>activas nuevamente</strong> y serán visibles para los turistas.
                </p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#1a2b3c',
                confirmButtonText: '&#8635; Sí, desarchivar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = `${window.BASE_URL}administrador/desarchivar-proveedor?accion=desarchivar&id=${id}`;
                }
            });
        });
    });
});

// --- Confirmar ARCHIVAR proveedor ---
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-archivar-proveedor').forEach(btn => {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            Swal.fire({
                title: '¿Archivar proveedor?',
                html: `<p style="font-size:15px;color:#444;line-height:1.7;">
                    El proveedor <strong>${nombre}</strong> será archivado.<br><br>
                    <strong>Todas sus actividades activas quedarán pausadas</strong> de inmediato y no serán visibles para los turistas.<br><br>
                    El proveedor puede ser reactivado en cualquier momento o eliminado definitivamente después de 6 meses.
                </p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#475569',
                cancelButtonColor: '#1a2b3c',
                confirmButtonText: '&#128451; Sí, archivar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = `${window.BASE_URL}administrador/archivar-proveedor?accion=archivar&id=${id}`;
                }
            });
        });
    });
});

// --- Confirmar ELIMINAR proveedor ---
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-eliminar-proveedor').forEach(btn => {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            Swal.fire({
                title: '¿Eliminar definitivamente?',
                html: `<p style="font-size:15px;color:#444;line-height:1.7;">
                    Estás a punto de eliminar al proveedor <strong>${nombre}</strong>.<br><br>
                    <strong style="color:#dc2626;">⚠ Esta acción no se puede deshacer.</strong><br><br>
                    Se eliminarán permanentemente todos sus datos, incluyendo sus actividades registradas, imágenes e historial. No será posible recuperarlos.
                </p>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#1a2b3c',
                confirmButtonText: '&#128465; Sí, eliminar todo',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = `${window.BASE_URL}administrador/eliminar-proveedor?accion=eliminar&id=${id}`;
                }
            });
        });
    });
});

// --- Cargar datos del proveedor y llenar el modal ---
document.addEventListener('DOMContentLoaded', function () {

    const botones = document.querySelectorAll('.btn-ver');

    botones.forEach(boton => {
        boton.addEventListener('click', async function () {

            const id = this.getAttribute('data-id');
            if (!id) {
                console.error('No se encontró data-id en el botón.');
                return;
            }

            try {
                const res = await fetch(`${window.BASE_URL}administrador/consultar-proveedor-id?id=${encodeURIComponent(id)}`);
                if (!res.ok) {
                    console.error('Respuesta HTTP inesperada', res.status);
                    return;
                }

                const data = await res.json();
                if (!data || data.error) {
                    console.error('Error en la respuesta JSON', data?.error ?? data);
                    return;
                }

                // Campos principales
                document.getElementById('modal-empresa').textContent = data.nombre_empresa ?? '-';
                document.getElementById('modal-nit').textContent = data.nit_rut ?? '-';
                document.getElementById('modal-email').textContent = data.email ?? '-';
                document.getElementById('modal-telefono').textContent = data.telefono ?? '-';
                document.getElementById('modal-descripcion').textContent = data.descripcion ?? '-';

                // Representante
                document.getElementById('modal-representante').textContent = data.nombre_representante ?? '-';
                document.getElementById('modal-identificacion').textContent = data.identificacion_representante ?? '-';
                document.getElementById('modal-email-repre').textContent = data.email_representante ?? '-';
                document.getElementById('modal-telefono-repre').textContent = data.telefono_representante ?? '-';

                // Ubicación
                document.getElementById('modal-departamento').textContent = data.departamento ?? '-';
                document.getElementById('modal-ciudad').textContent = data.ciudad ?? '-';
                document.getElementById('modal-direccion').textContent = data.direccion ?? '-';

                // Fecha
                const fecha = data.created_at ?? null;

                if (fecha) {
                    const f = new Date(fecha);
                    const meses = ["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"];

                    const dia = f.getDate().toString().padStart(2, '0');
                    const mes = meses[f.getMonth()];
                    const anio = f.getFullYear();
                    const hora = f.toTimeString().split(' ')[0];

                    document.getElementById('modal-fecha-registro').textContent =
                        `Registrado el: ${dia}-${mes}-${anio} a las ${hora}`;
                } else {
                    document.getElementById('modal-fecha-registro').textContent = '';
                }

                // Estado / badge
                const badge = document.getElementById('modal-status');
                const estado = (data.estado ?? '').toString().toLowerCase();

                badge.textContent = data.estado ?? 'Desconocido';
                badge.className =
                    estado === 'activo' ? 'status-badge badge-activo' :
                    estado === 'inactivo' ? 'status-badge badge-inactivo' :
                    'status-badge badge-pendiente';

                // Actividades
                const actividadesContainer = document.getElementById('modal-actividades');
                actividadesContainer.innerHTML = '';
                let actividades = data.actividades ?? '';

                if (Array.isArray(actividades)) actividades = actividades.join(',');

                if (actividades.trim() !== '') {
                    actividades.split(',').forEach(a => {
                        const span = document.createElement('span');
                        span.className = 'badge-servicio';
                        span.textContent = a.trim();
                        actividadesContainer.appendChild(span);
                    });
                } else {
                    actividadesContainer.innerHTML = '<span class="badge-servicio">No especificadas</span>';
                }

                // Logo
                const logoEl = document.getElementById('modal-logo');
                logoEl.src = data.logo
                    ? `${window.BASE_URL}public/uploads/proveedores/${data.logo}`
                    : `${window.BASE_URL}public/assets/img/default-proveedor.jpg`;

                // // Foto representante
                // const fotoRepreEl = document.getElementById('modal-foto-representante');
                // fotoRepreEl.src = data.foto_representante
                //     ? `/aventura_go/public/uploads/usuario/${data.foto_representante}`
                //     : `/aventura_go/public/assets/img/default-proveedor.jpg`;

                // Mostrar modal (una sola instancia para evitar backdrops duplicados)
                const modalEl = document.getElementById('verProveedorModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                
                // guardamos el id en el modal y en los botones del footer para que sepan qué proveedor están manejando
                modalEl.dataset.id = id; // id viene del fetch que ya hiciste

                // setear los botones del footer con el id y con el estado actual
                // dentro del evento donde ya tienes modalEl
                const btnActivar = modalEl.querySelector('#btn-activar-proveedor');
                const btnDesactivar = modalEl.querySelector('#btn-desactivar-proveedor');
                
                console.log("Llegué a la parte del HREF");
                
                btnActivar.setAttribute('href',
                    `${window.BASE_URL}administrador/cambiar-estado-proveedor?id=${id}&accion=activar`
                );

                btnDesactivar.setAttribute('href',
                    `${window.BASE_URL}administrador/cambiar-estado-proveedor?id=${id}&accion=desactivar`
                );

                console.log("HREF ACTIVAR:", btnActivar.href);
                console.log("HREF DESACTIVAR:", btnDesactivar.href);

                // Mostrar/ocultar botón apropiado según estado actual
                if ((data.estado ?? '').toLowerCase() === 'activo') {
                    btnActivar.style.display = 'none';
                    btnDesactivar.style.display = 'inline-block';
                } else {
                    btnActivar.style.display = 'inline-block';
                    btnDesactivar.style.display = 'none';
                }

            } catch (err) {
                console.error('Error en fetch/parse:', err);
            }
        });
    });
});


// --- CAMBIAR ESTADO (ACTIVAR/DESACTIVAR) ---
document.addEventListener("click", function (e) {

    if (!e.target.classList.contains("btn-estado")) return;

    let id = e.target.dataset.id;
    let estado = e.target.dataset.estado;

    let nuevoEstado = estado === "activo" ? "inactivo" : "activo";

    fetch(`${window.BASE_URL}administrador/cambiar-estado-proveedor`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${id}&estado=${nuevoEstado}`
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            let fila = document.querySelector(`#fila-${id}`);
            let colEstado = fila.querySelector(".col-estado");

            colEstado.textContent = nuevoEstado;

            e.target.dataset.estado = nuevoEstado;

            e.target.textContent = nuevoEstado === "activo" ? "Desactivar" : "Activar";
            e.target.classList.toggle("btn-danger");
            e.target.classList.toggle("btn-success");

        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(err => alert("Error en la petición: " + err));
});





/**
 * Gestión de filtrado dinámico para la tabla de proveedores
 */
document.addEventListener('DOMContentLoaded', function () {
    const filtrosBtn = document.querySelectorAll('.filtro-btn');
    const filasTabla = document.querySelectorAll('#tablaAdmin tbody tr');

    filtrosBtn.forEach(boton => {
        boton.addEventListener('click', function () {
            // 1. Gestionar estado visual de los botones
            filtrosBtn.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // 2. Obtener el criterio de filtrado
            const filtro = this.getAttribute('data-filter').toLowerCase();

            // 3. Filtrar las filas de la tabla
            filasTabla.forEach(fila => {
                // Obtenemos el texto del badge de estado dentro de la fila
                const celdaEstado = fila.querySelector('.col-estado');
                
                if (!celdaEstado) return; // Saltar si es la fila de "No hay registros"

                const estadoTexto = celdaEstado.textContent.trim().toLowerCase();

                // Lógica de visualización
                if (filtro === 'all') {
                    fila.style.display = ''; // Mostrar todos
                } else {
                    // Si el texto del estado coincide con el filtro, se muestra
                    if (estadoTexto === filtro) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none'; // Se oculta
                    }
                }
            });
            
            // 4. Opcional: Mostrar mensaje si no hay resultados tras filtrar
            verificarResultadosVisibles();
        });
    });

    /**
     * Función para mostrar un mensaje si al filtrar no queda ninguna fila visible
     */
    function verificarResultadosVisibles() {
        const cuerpoTabla = document.querySelector('#tablaAdmin tbody');
        const filasVisibles = Array.from(filasTabla).filter(f => f.style.display !== 'none');
        
        // Eliminar mensaje previo si existe
        const mensajePrevio = document.getElementById('sin-resultados');
        if (mensajePrevio) mensajePrevio.remove();

        if (filasVisibles.length === 0) {
            const tr = document.createElement('tr');
            tr.id = 'sin-resultados';
            tr.innerHTML = `<td colspan="8" class="text-center">No se encontraron proveedores con este estado.</td>`;
            cuerpoTabla.appendChild(tr);
        }
    }
});