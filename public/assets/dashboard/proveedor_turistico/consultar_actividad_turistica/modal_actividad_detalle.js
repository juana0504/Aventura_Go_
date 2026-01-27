document.addEventListener('DOMContentLoaded', () => {

    // 🔹 OJO: tu botón usa la clase .btn-ver (no .btn-ver-actividad)
    document.querySelectorAll('.btn-ver').forEach(btn => {

        btn.addEventListener('click', () => {

            const idActividad = btn.dataset.id;

            fetch(`${BASE_URL}/app/controllers/proveedor_turistico/actividadDetalle.php?id=${idActividad}`)
                .then(res => res.json())
                .then(data => {

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    /* ===============================
                       ENCABEZADO DEL MODAL
                    =============================== */

                    // Título = nombre de la actividad
                    document.querySelector('#modalActividad .modal-title').textContent =
                        `Detalle: ${data.nombre}`;

                    // Estado + fecha (se agrega como texto debajo del título)
                    let infoHeader = document.getElementById('modal-info-header');
                    if (!infoHeader) {
                        infoHeader = document.createElement('small');
                        infoHeader.id = 'modal-info-header';
                        infoHeader.className = 'text-muted d-block mt-1';
                        document.querySelector('#modalActividad .modal-title')
                            .after(infoHeader);
                    }

                    infoHeader.textContent =
                        `Estado: ${data.estado} | Registrado el: ${data.created_at}`;

                    /* ===============================
                       IMAGEN
                    =============================== */
                    const imagen = data.imagen
                        ? `${BASE_URL}/public/uploads/turistico/actividades/${data.imagen}`
                        : `${BASE_URL}/public/uploads/turistico/actividades/actividad_default.png`;

                    document.getElementById('modal-imagen').src = imagen;

                    /* ===============================
                       DATOS PRINCIPALES
                    =============================== */
                    document.getElementById('modal-nombre').textContent = data.nombre;
                    document.getElementById('modal-destino').textContent = data.id_ciudad;
                    document.getElementById('modal-ubicacion').textContent = data.ubicacion;
                    document.getElementById('modal-cupos').textContent = data.cupos ?? 'N/A';
                    document.getElementById('modal-precio').textContent =
                        Number(data.precio).toLocaleString('es-CO');
                    document.getElementById('modal-estado').textContent = data.estado;

                    /* ===============================
                       DESCRIPCIÓN
                    =============================== */
                    document.getElementById('modal-descripcion').textContent =
                        data.descripcion ?? 'Sin descripción';

                    /* ===============================
                       BOTONES ACTIVAR / PAUSAR
                    =============================== */
                    document.getElementById('btn-activar').style.display =
                        data.estado === 'INACTIVO' ? 'inline-block' : 'none';

                    document.getElementById('btn-desactivar').style.display =
                        data.estado === 'ACTIVO' ? 'inline-block' : 'none';

                })
                .catch(err => {
                    console.error(err);
                    alert('Error al cargar el detalle de la actividad');
                });

        });

    });

});
