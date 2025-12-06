// Función para abrir el modal con los datos del proveedor
function abrirModalVerProveedor(fila) {
    // Obtener todos los datos de la fila (deberían tener atributos data-*)
    const proveedorData = {
        id: fila.getAttribute('data-id'),
        empresa: fila.getAttribute('data-empresa') || fila.cells[0].textContent.trim(),
        nit: fila.getAttribute('data-nit') || 'No especificado',
        representante: fila.getAttribute('data-representante') || fila.cells[1].textContent.trim(),
        email: fila.getAttribute('data-email') || fila.cells[2].textContent.trim(),
        telefono: fila.getAttribute('data-telefono') || fila.cells[3].textContent.trim(),
        actividades: fila.getAttribute('data-actividades') || 'No especificado',
        descripcion: fila.getAttribute('data-descripcion') || 'Sin descripción disponible',
        departamento: fila.getAttribute('data-departamento') || 'No especificado',
        ciudad: fila.getAttribute('data-ciudad') || fila.cells[4].textContent.trim(),
        direccion: fila.getAttribute('data-direccion') || 'No especificado',
        estado: fila.getAttribute('data-estado') || fila.cells[5].textContent.trim(),
        // Datos adicionales del formulario
        foto: fila.getAttribute('data-foto') || 'default-proveedor.jpg'
    };
    
    // Llenar el modal con los datos
    document.getElementById('modal-empresa').textContent = proveedorData.empresa;
    document.getElementById('modal-nit').textContent = proveedorData.nit;
    document.getElementById('modal-representante').textContent = proveedorData.representante;
    document.getElementById('modal-email').textContent = proveedorData.email;
    document.getElementById('modal-telefono').textContent = proveedorData.telefono;
   // Actividades
    const actividadesContainer = document.getElementById('modal-actividades');
    actividadesContainer.innerHTML = '';
    if (proveedorData.actividades && proveedorData.actividades !== 'No especificado') {
        const actividades = proveedorData.actividades.split(',');
        actividades.forEach(actividad => {
            if (actividad.trim()) {
                const badge = document.createElement('span');
                badge.className = 'badge-servicio';
                badge.textContent = actividad.trim();
                actividadesContainer.appendChild(badge);
            }
        });
    } else {
        actividadesContainer.innerHTML = '<span class="badge-servicio">No especificadas</span>';
    }  
    document.getElementById('modal-descripcion').textContent = proveedorData.descripcion;
    document.getElementById('modal-departamento').textContent = proveedorData.departamento;
    document.getElementById('modal-ciudad').textContent = proveedorData.ciudad;
    document.getElementById('modal-direccion').textContent = proveedorData.direccion;
    
    // Foto del proveedor
    const fotoElement = document.getElementById('modal-foto');
    const fotoUrl = proveedorData.foto.includes('http') ? proveedorData.foto : 
                    `<?= BASE_URL ?>/uploads/proveedores/${proveedorData.foto}`;
    
    fotoElement.src = fotoUrl;
    fotoElement.onerror = function() {
        this.src = '<?= BASE_URL ?>/assets/img/default-proveedor.jpg';
    };
    
    // Estado con badge
    const badgeEstado = document.getElementById('modal-estado');
    badgeEstado.textContent = proveedorData.estado;
    badgeEstado.className = proveedorData.estado.toLowerCase() === 'active' || 
                            proveedorData.estado.toLowerCase() === 'activo' ? 'badge-activo' : 
                            proveedorData.estado.toLowerCase() === 'inactivo' ? 'badge-inactivo' : 
                            'badge-pendiente';
    

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalVerProveedor'));
    modal.show();
}

// Asignar eventos a los botones de "Ver" (ojo)
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los botones de "Ver" (ojo)
    const botonesVer = document.querySelectorAll('.btn-ver');
    
    botonesVer.forEach(boton => {
        boton.addEventListener('click', function() {
            // Obtener la fila padre
            const fila = this.closest('tr');
            
            if (fila) {
                abrirModalVerProveedor(fila);
            }
        });
    });
    
        // Cerrar el modal actual
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalVerProveedor'));
        modal.hide();
    });


// Función para obtener datos del proveedor via AJAX (si necesitas datos completos)
async function cargarDatosProveedor(id) {
    try {
        const response = await fetch(`<?= BASE_URL ?>/administrador/consultar_proveedor/${id}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al cargar datos:', error);
        return null;
    }
}