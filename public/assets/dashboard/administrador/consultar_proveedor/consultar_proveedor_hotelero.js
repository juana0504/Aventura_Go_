document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('verProveedorModal');

    // Delegación de eventos para botones "ver"
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-ver');
        if (!btn) return;

        const idProveedor = btn.dataset.id;
        if (!idProveedor) return;

        try {
            const response = await fetch(`/aventura_go/administrador/consultar-proveedor-hotelero-id?id=${encodeURIComponent(idProveedor)}`);

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
        setText('modal-nombre-establecimiento', data.nombre_establecimiento ?? '—');
        setImg('modal-logo', `${BASE_URL}/public/uploads/hoteles/${data.logo}`);

        // Estado y fecha
        setText('modal-status', data.estado);
        setText('modal-fecha-registro', data.created_at ?? '—');

        // Información principal
        setText('modal-email', data.email);
        setText('modal-telefono', data.telefono);
        setChips('modal-tipo-establecimiento', data.tipo_establecimiento);
        setText('modal-nombre-establecimiento-card', data.nombre_establecimiento ?? '—');


        // Representante
        setText('modal-representante', data.nombre_representante);
        setText('modal-identificacion', data.identificacion_representante);
        setText('modal-email-repre', data.email_representante);
        setText('modal-telefono-repre', data.telefono_representante);

        // Ubicación
        setText('modal-departamento', data.departamento);
        setText('modal-ciudad', data.ciudad ?? '—');
        setText('modal-direccion', data.direccion);

        // Habitaciones y servicios
        setText('modal-tipo-habitacion', data.tipo_habitacion?.replaceAll(',', ', ') ?? '—');
        setText('modal-max-huesped', data.max_huesped);
        setText('modal-servicios', data.servicio_incluido?.replaceAll(',', ', ') ?? '—');

        // Documentación y pagos
        setText('modal-nit', data.nit_rut);
        setText('modal-camara', data.camara_comercio);
        setText('modal-licencia', data.licencia);
        setText('modal-metodos-pago', data.metodo_pago?.replaceAll(',', ', ') ?? '—');

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

        const modalEl = document.getElementById('verProveedorModal');

        const btnActivar = modalEl.querySelector('#btn-activar-proveedor');
        const btnDesactivar = modalEl.querySelector('#btn-desactivar-proveedor');

        btnActivar.setAttribute(
            'href',
            `/aventura_go/administrador/cambiar-estado-proveedor-hotelero?id=${data.id_proveedor_hotelero}&accion=activar`
        );

        btnDesactivar.setAttribute(
            'href',
            `/aventura_go/administrador/cambiar-estado-proveedor-hotelero?id=${data.id_proveedor_hotelero}&accion=desactivar`
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

});



// --- CAMBIAR ESTADO (ACTIVAR/DESACTIVAR) ---
document.addEventListener("click", function (e) {

    if (!e.target.classList.contains("btn-estado")) return;

    let id = e.target.dataset.id;
    let estado = e.target.dataset.estado;

    let nuevoEstado = estado === "activo" ? "inactivo" : "activo";

    fetch("/aventura_go/administrador/cambiar-estado-proveedor-hotelero", {
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
