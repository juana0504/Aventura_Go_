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

                // Campos principales (IDs tal como están en el modal)
                document.getElementById('modal-empresa').textContent = data.nombre_empresa ?? '-';
                document.getElementById('modal-nit').textContent = data.nit_rut ?? 'No especificado';
                document.getElementById('modal-email').textContent = data.email ?? '-';
                document.getElementById('modal-telefono').textContent = data.telefono ?? '-';
                document.getElementById('modal-descripcion').textContent = data.descripcion ?? 'Sin descripción disponible';

                // Representante
                document.getElementById('modal-representante').textContent = data.nombre_representante ?? '-';
                document.getElementById('modal-identificacion').textContent = data.identificacion_representante ?? '-';
                document.getElementById('modal-email-repre').textContent = data.email_representante ?? '-';
                document.getElementById('modal-telefono-repre').textContent = data.telefono_representante ?? '-';

                // Ubicación
                document.getElementById('modal-departamento').textContent = data.departamento ?? '-';
                document.getElementById('modal-ciudad').textContent = data.ciudad ?? '-';
                document.getElementById('modal-direccion').textContent = data.direccion ?? '-';

                //Fecha de registro
                const fecha = data.created_at ?? null;
                document.getElementById('modal-fecha-registro').textContent = fecha ? ('Registrado el: ' + fecha) : '';

                // Estado / badge
                const badge = document.getElementById('modal-status');
                const estado = (data.estado ?? data.estado_proveedor ?? '').toString().toLowerCase();
                badge.textContent = (data.estado ?? data.estado_proveedor ?? 'Desconocido').toString();
                badge.className = estado === 'activo' || estado === 'active' ? 'status-badge badge-activo' :
                                estado === 'inactivo' || estado === 'inactive' ? 'status-badge badge-inactivo' :
                                'status-badge badge-pendiente';

                // Actividades (array o string separado por comas)
                const actividadesContainer = document.getElementById('modal-actividades');
                actividadesContainer.innerHTML = '';
                let actividades = data.actividades ?? data.actividad ?? '';
                if (Array.isArray(actividades)) {
                    actividades = actividades.join(',');
                }
                if (actividades && actividades.toString().trim() !== '') {
                    actividades.toString().split(',').forEach(a => {
                        if (a.trim()) {
                            const span = document.createElement('span');
                            span.className = 'badge-servicio';
                            span.textContent = a.trim();
                            actividadesContainer.appendChild(span);
                        }
                    });
                } else {
                    actividadesContainer.innerHTML = '<span class="badge-servicio">No especificadas</span>';
                }

                // Imágenes: logo y foto de actividades (rutas públicas relativas)
                const logoEl = document.getElementById('modal-logo');
                const fotoActEl = document.getElementById('modal-foto-actividades');
                const fotoRepreEl = document.getElementById('modal-img-repre');

                if (data.logo && data.logo !== '') {
                    logoEl.src = `/aventura_go/public/uploads/turistico/${data.logo}`;
                } else {
                    logoEl.src = `/aventura_go/public/assets/img/default-proveedor.jpg`;
                }

                if (data.foto_actividades && data.foto_actividades !== '') {
                    fotoActEl.src = `/aventura_go/public/uploads/turistico/actividades/${data.foto_actividades}`;
                } else {
                    fotoActEl.src = `/aventura_go/public/assets/img/default-proveedor.jpg`;
                }

                if (data.foto_representante && data.foto_representante !== '') {
                    fotoRepreEl.src = `/aventura_go/public/uploads/usuario/${data.foto_representante}`;
                } else {
                    fotoRepreEl.src = `/aventura_go/public/assets/img/default-proveedor.jpg`;
                }

                // Mostrar el modal (id tal como en tu vista)
                const modalEl = document.getElementById('verProveedorModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

            } catch (err) {
                console.error('Error en fetch/parse:', err);
            }
        });
    });
});
