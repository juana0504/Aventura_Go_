document.addEventListener('DOMContentLoaded', () => {

    const botonesVer = document.querySelectorAll('.btn-ver');

    botonesVer.forEach(boton => {
        boton.addEventListener('click', () => {

            const id = boton.getAttribute('data-id');

            if (!id) {
                alert('ID del proveedor no encontrado');
                return;
            }

            fetch(`${BASE_URL}/administrador/ver-proveedor-hotelero?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {

                    if (!data || data.error) {
                        throw new Error('Datos inválidos');
                    }

                    // LOGO
                    const logo = document.getElementById('modal-logo');
                    if (logo) {
                        logo.src = `${BASE_URL}/public/uploads/hoteles/${data.logo}`;
                    }

                    // ESTADO Y FECHA
                    document.getElementById('modal-status').textContent = data.estado ?? '';
                    document.getElementById('modal-fecha-registro').textContent = data.fecha_registro ?? '';

                    // INFORMACIÓN DEL ESTABLECIMIENTO
                    document.getElementById('modal-nombre-establecimiento').textContent = data.nombre_establecimiento ?? '';
                    document.getElementById('modal-email').textContent = data.email ?? '';
                    document.getElementById('modal-telefono').textContent = data.telefono ?? '';
                    document.getElementById('modal-tipo-establecimiento').textContent = data.tipo_establecimiento ?? '';

                    // REPRESENTANTE
                    document.getElementById('modal-representante').textContent = data.nombre_representante ?? '';
                    document.getElementById('modal-identificacion').textContent = data.identificacion ?? '';
                    document.getElementById('modal-email-repre').textContent = data.email_representante ?? '';
                    document.getElementById('modal-telefono-repre').textContent = data.telefono_representante ?? '';

                    // UBICACIÓN
                    document.getElementById('modal-departamento').textContent = data.departamento ?? '';
                    document.getElementById('modal-ciudad').textContent = data.ciudad ?? '';
                    document.getElementById('modal-direccion').textContent = data.direccion ?? '';

                    // HABITACIONES Y SERVICIOS
                    document.getElementById('modal-tipo-habitacion').textContent = data.tipo_habitacion ?? '';
                    document.getElementById('modal-max-huesped').textContent = data.max_huespedes ?? '';
                    document.getElementById('modal-servicios').textContent = data.servicios ?? '';

                    // DOCUMENTACIÓN Y PAGOS
                    document.getElementById('modal-nit').textContent = data.nit ?? '';
                    document.getElementById('modal-camara').textContent = data.camara_comercio ?? '';
                    document.getElementById('modal-licencia').textContent = data.licencia ?? '';
                    document.getElementById('modal-metodos-pago').textContent = data.metodos_pago ?? '';

                })
                .catch(error => {
                    console.error(error);
                    alert('Error al cargar la información del proveedor');
                });

        });
    });

});
