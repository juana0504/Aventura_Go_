// console.log("modal_actividad.js cargado");

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.btn-ver').forEach(btn => {

        btn.addEventListener('click', () => {

            const idActividad = btn.dataset.id;

            fetch(`${BASE_URL}/proveedor/consultar-actividad-id?id=${idActividad}`)
            .then(res => res.json())
            .then(data => {

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    /* ===============================
                       HEADER
                    =============================== */
                    document.getElementById('modal-nombre').textContent = data.nombre;

                    const badge = document.getElementById('modal-estado-header');
                    badge.textContent = data.estado;
                    badge.className =
                        `badge ${data.estado === 'ACTIVO' ? 'bg-success' : 'bg-danger'}`;
                   
                        // 🔓 botón cerrar
                    document.querySelectorAll('.btn-close').forEach(btn => {
                        btn.style.display = 'inline-block';
                    });

                    /* ===============================
                       FECHA (TU FORMATO)
                    =============================== */
                    const f = new Date(data.created_at);
                    const meses = ["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"];
                    const dia = f.getDate().toString().padStart(2, '0');
                    const mes = meses[f.getMonth()];
                    const anio = f.getFullYear();
                    const hora = f.toTimeString().split(' ')[0];

                    document.getElementById('modal-fecha-registro').textContent =
                        `Registrado el: ${dia}-${mes}-${anio} a las ${hora}`;

                    /* ===============================
                       IMAGEN PRINCIPAL
                    =============================== */
                    const imgPrincipal = data.imagen_principal
                        ? `${BASE_URL}/public/uploads/turistico/actividades/${data.imagen_principal}`
                        : `${BASE_URL}/public/uploads/turistico/actividades/actividad_default.png`;

                    document.getElementById('modal-imagen-principal').src = imgPrincipal;

                    /* ===============================
                       GALERÍA
                    =============================== */
                    const galeria = document.getElementById('modal-galeria');
                    galeria.innerHTML = '';

                    if (data.imagenes && data.imagenes.length > 0) {
                        data.imagenes.forEach(img => {
                            const thumb = document.createElement('img');
                            thumb.src = `${BASE_URL}/public/uploads/turistico/actividades/${img}`;
                            thumb.classList.add('img-thumbnail');
                            thumb.style.width = '70px';
                            thumb.style.cursor = 'pointer';

                            thumb.addEventListener('click', () => {
                                document.getElementById('modal-imagen-principal').src = thumb.src;
                            });

                            galeria.appendChild(thumb);
                        });
                    }

                    /* ===============================
                       DATOS
                    =============================== */
                    document.getElementById('modal-departamento').textContent = data.departamento;
                    document.getElementById('modal-ciudad').textContent = data.ciudad;
                    document.getElementById('modal-ubicacion').textContent = data.ubicacion;
                    document.getElementById('modal-cupos').textContent = data.cupos;
                    document.getElementById('modal-precio').textContent =
                        Number(data.precio).toLocaleString('es-CO');

                    document.getElementById('modal-descripcion').textContent =
                        data.descripcion ?? 'Sin descripción';

                    document.getElementById('modal-estado-texto').textContent = data.estado;

                /* ===============================
                BOTONES ACTIVAR / PAUSAR
                =============================== */
                const btnActivar = document.getElementById('btn-activar');
                const btnDesactivar = document.getElementById('btn-desactivar');

                // 🔁 RESET SIEMPRE (CLAVE)
                btnActivar.style.display = 'none';
                btnDesactivar.style.display = 'none';

                // ID
                btnActivar.dataset.id = data.id_actividad;
                btnDesactivar.dataset.id = data.id_actividad;

                console.log('DATA COMPLETA →', data);

                // 🔀 MOSTRAR SEGÚN ESTADO REAL
                if (data.estado === 'ACTIVO') {
                    btnDesactivar.style.display = 'inline-block';
                }

                if (data.estado === 'INACTIVO') {
                    btnActivar.style.display = 'inline-block';
                }

                })
                .catch(err => {
                    console.error(err);
                    alert('Error al cargar el detalle de la actividad');
            });
        });
    });

    /* ===============================
       ACTIVAR / PAUSAR (TU CONTROLLER REAL)
    =============================== */
    document.getElementById('btn-activar').addEventListener('click', e => {
        location.href =
            `${BASE_URL}/proveedor/actividadTuristica?accion=activar&id=${e.target.dataset.id}`;
    });

    document.getElementById('btn-desactivar').addEventListener('click', e => {
        location.href =
            `${BASE_URL}/proveedor/actividadTuristica?accion=desactivar&id=${e.target.dataset.id}`;
    });
});
