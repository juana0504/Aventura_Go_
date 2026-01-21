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
                const res = await fetch(`/aventura_go/administrador/consultar-proveedor-id?id=${encodeURIComponent(id)}`);
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
                    estado === 'ACTIVO' ? 'status-badge badge-activo' :
                    estado === 'INACTIVO' ? 'status-badge badge-inactivo' :
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
                    ? `/aventura_go/public/assets/uploads/turistico/${data.logo}`
                    : `/aventura_go/public/assets/img/default-proveedor.jpg`;

                // // Foto representante
                // const fotoRepreEl = document.getElementById('modal-foto-representante');
                // fotoRepreEl.src = data.foto_representante
                //     ? `/aventura_go/public/uploads/usuario/${data.foto_representante}`
                //     : `/aventura_go/public/assets/img/default-proveedor.jpg`;

                // Mostrar modal
                const modalEl = document.getElementById('verProveedorModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
                
                // guardamos el id en el modal y en los botones del footer para que sepan qué proveedor están manejando
                modalEl.dataset.id = id; // id viene del fetch que ya hiciste

                // setear los botones del footer con el id y con el estado actual
                // dentro del evento donde ya tienes modalEl
                const btnActivar = modalEl.querySelector('#btn-activar-proveedor');
                const btnDesactivar = modalEl.querySelector('#btn-desactivar-proveedor');
                
                console.log("Llegué a la parte del HREF");
                
                btnActivar.setAttribute('href',
                    `/aventura_go/administrador/cambiar-estado-proveedor?id=${id}&accion=activar`
                );

                btnDesactivar.setAttribute('href',
                    `/aventura_go/administrador/cambiar-estado-proveedor?id=${id}&accion=desactivar`
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

    fetch("/aventura_go/administrador/cambiar-estado-proveedor", {
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
