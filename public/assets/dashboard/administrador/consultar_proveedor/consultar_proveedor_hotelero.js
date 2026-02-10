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


document.addEventListener("DOMContentLoaded", function () {
    const tablaAdmin = document.getElementById('tablaAdmin');
    const filtroBtns = document.querySelectorAll('.filtro-btn');

    // --- 1. LÓGICA DE FILTROS DE LA TABLA ---
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Quitar clase active de todos y poner al actual
            filtroBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filtro = this.getAttribute('data-filter').toLowerCase();
            const filas = tablaAdmin.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                // Si la tabla está vacía, ignorar
                if (fila.cells.length <= 1) return;

                const estadoTexto = fila.querySelector('.col-estado').textContent.trim().toLowerCase();
                
                if (filtro === 'all' || estadoTexto.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });

    // --- 2. GESTIÓN DEL MODAL (VER DETALLES) ---
    tablaAdmin.addEventListener('click', function (e) {
        const btnVer = e.target.closest('.btn-ver');
        if (btnVer) {
            const idProveedor = btnVer.getAttribute('data-id');
            cargarDatosProveedor(idProveedor);
        }
    });

    async function cargarDatosProveedor(id) {
        try {
            // URL ajustada a tu estructura de controlador
            const response = await fetch(`${BASE_URL}/app/controllers/administrador/hotelero.php?accion=obtener&id=${id}`);
            if (!response.ok) throw new Error("Error en la comunicación con el servidor");

            const data = await response.json();
            llenarModal(data);
        } catch (error) {
            console.error("Error:", error);
            alert("No se pudo obtener la información detallada.");
        }
    }

    function llenarModal(p) {
        // Cabecera e Imagen
        const logoImg = document.getElementById('modal-logo');
        logoImg.src = p.logo ? `${BASE_URL}/public/uploads/hoteles/${p.logo}` : `${BASE_URL}/public/assets/img/no-image.png`;
        
        document.getElementById('modal-nombre-establecimiento').textContent = p.nombre_establecimiento || 'N/A';
        document.getElementById('modal-status').textContent = p.estado || 'PENDIENTE';
        document.getElementById('modal-status').className = `status-badge badge-${(p.estado || 'pendiente').toLowerCase()}`;
        document.getElementById('modal-fecha-registro').textContent = p.fecha_registro ? `Registrado el: ${p.fecha_registro}` : '';

        // Sección 1: Información del Establecimiento
        document.getElementById('modal-nombre-establecimiento-card').textContent = p.nombre_establecimiento || 'N/A';
        document.getElementById('modal-email').textContent = p.email || 'N/A';
        document.getElementById('modal-telefono').textContent = p.telefono || 'N/A';
        document.getElementById('modal-tipo-establecimiento').textContent = p.tipo_establecimiento || 'N/A';

        // Sección 2: Representante
        document.getElementById('modal-representante').textContent = p.nombre_representante || 'No asignado';
        document.getElementById('modal-identificacion').textContent = p.identificacion || 'N/A';
        document.getElementById('modal-email-repre').textContent = p.email_representante || p.email || 'N/A';
        document.getElementById('modal-telefono-repre').textContent = p.telefono_representante || 'N/A';

        // Sección 3: Ubicación
        document.getElementById('modal-departamento').textContent = p.nombre_departamento || 'N/A';
        document.getElementById('modal-ciudad').textContent = p.nombre_ciudad || 'N/A';
        document.getElementById('modal-direccion').textContent = p.direccion || 'N/A';

        // Sección 4: Habitaciones y Servicios
        document.getElementById('modal-tipo-habitacion').textContent = p.tipo_habitacion || 'N/A';
        document.getElementById('modal-max-huesped').textContent = p.max_huespedes || 'N/A';
        document.getElementById('modal-servicios').textContent = p.servicios_incluidos || 'Ninguno';

        // Sección 5: Documentación
        document.getElementById('modal-nit').textContent = p.nit || 'N/A';
        document.getElementById('modal-camara').textContent = p.camara_comercio ? 'Cargado' : 'No disponible';
        document.getElementById('modal-licencia').textContent = p.licencia_turismo || 'N/A';
        document.getElementById('modal-metodos-pago').textContent = p.metodos_pago || 'No especificado';

        // Configuración de Botones de Acción (Footer)
        const btnActivar = document.getElementById('btn-activar-proveedor');
        const btnDesactivar = document.getElementById('btn-desactivar-proveedor');

        if (p.estado === 'ACTIVO') {
            btnActivar.style.display = 'none';
            btnDesactivar.style.display = 'inline-block';
            btnDesactivar.href = `${BASE_URL}/administrador/cambiar-estado-hotelero?id=${p.id_proveedor_hotelero}&estado=INACTIVO`;
        } else {
            btnActivar.style.display = 'inline-block';
            btnDesactivar.style.display = 'none';
            btnActivar.href = `${BASE_URL}/administrador/cambiar-estado-hotelero?id=${p.id_proveedor_hotelero}&estado=ACTIVO`;
        }
    }
});