document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('verProveedorModal');

    // Delegación de eventos para botones "ver"
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-ver');
        if (!btn) return;

        const idProveedor = btn.dataset.id;
        if (!idProveedor) return;

        try {
            const response = await fetch(
                `${BASE_URL}/administrador/ver-proveedor-hotelero?id=${idProveedor}`
            );

            if (!response.ok) {
                throw new Error('No se pudo obtener la información');
            }

            const data = await response.json();
            llenarModal(data);

        } catch (error) {
            console.error(error);
            alert('Error al cargar la información del proveedor');
        }
    });

    /* ===============================
       FUNCIONES
    =============================== */

    function llenarModal(data) {

        // Header
        setText('modal-nombre-establecimiento', data.nombre_establecimiento);
        setImg('modal-logo', `${BASE_URL}/public/uploads/hoteles/${data.logo}`);

        // Estado y fecha
        setText('modal-status', data.estado);
        setText('modal-fecha-registro', data.fecha_registro);

        // Información principal
        setText('modal-email', data.email);
        setText('modal-telefono', data.telefono);
        setChips('modal-tipo-establecimiento', data.tipo_establecimiento);

        // Representante
        setText('modal-representante', data.nombre_representante);
        setText('modal-identificacion', data.identificacion_representante);
        setText('modal-email-repre', data.email_representante);
        setText('modal-telefono-repre', data.telefono_representante);

        // Ubicación
        setText('modal-departamento', data.departamento);
        setText('modal-ciudad', data.ciudad);
        setText('modal-direccion', data.direccion);

        // Habitaciones y servicios
        setChips('modal-tipo-habitacion', data.tipo_habitacion);
        setText('modal-max-huesped', data.max_huesped);
        setChips('modal-servicios', data.servicio_incluido);

        // Documentación y pagos
        setText('modal-nit', data.nit_rut);
        setText('modal-camara', data.camara_comercio);
        setText('modal-licencia', data.licencia);
        setChips('modal-metodos-pago', data.metodo_pago);

        // Botones activar / desactivar
        configurarBotonesEstado(data.id, data.estado);
    }

    /* ===============================
       HELPERS
    =============================== */

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value ?? '—';
    }

    function setImg(id, src) {
        const img = document.getElementById(id);
        if (img) img.src = src;
    }

    function setChips(id, values) {
        const container = document.getElementById(id);
        if (!container) return;

        container.innerHTML = '';

        if (!values) {
            container.textContent = '—';
            return;
        }

        // Acepta array o string separado por comas
        const items = Array.isArray(values)
            ? values
            : values.split(',');

        items.forEach(item => {
            const span = document.createElement('span');
            span.className = 'chip';
            span.textContent = item.trim();
            container.appendChild(span);
        });
    }

    function configurarBotonesEstado(id, estado) {
        const btnActivar = document.getElementById('btn-activar-proveedor');
        const btnDesactivar = document.getElementById('btn-desactivar-proveedor');

        btnActivar.style.display = estado === 'ACTIVO' ? 'none' : 'inline-block';
        btnDesactivar.style.display = estado === 'INACTIVO' ? 'none' : 'inline-block';

        btnActivar.onclick = () => cambiarEstado(id, 'ACTIVO');
        btnDesactivar.onclick = () => cambiarEstado(id, 'INACTIVO');
    }

    async function cambiarEstado(id, nuevoEstado) {
        if (!confirm(`¿Seguro que deseas ${nuevoEstado === 'ACTIVO' ? 'activar' : 'desactivar'} este proveedor?`)) {
            return;
        }

        try {
            const response = await fetch(
                `${BASE_URL}/administrador/cambiar-estado-proveedor-hotelero`,
                {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: id,
                        estado: nuevoEstado
                    })
                }
            );

            if (!response.ok) throw new Error();

            location.reload();

        } catch (error) {
            alert('No se pudo cambiar el estado');
        }
    }

});