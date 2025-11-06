const modoOscuroBtn = document.getElementById('modoOscuroBtn');
const notificacionesBtn = document.getElementById('notificacionesBtn');
const input = document.getElementById('buscarReserva');
const contenedor = document.getElementById('reservasContainer');
let reservas = [];

// MODO OSCURO 
modoOscuroBtn.addEventListener('click', () => {
    document.body.classList.toggle('modo-oscuro');
});

// NOTIFICACIONES
notificacionesBtn.addEventListener('click', () => {
    alert("Tienes nuevas reservas, verifica");
});

//CARGAR JSON 
fetch('../../assets/data/historial_reservas.json')
    .then(res => res.json())
    .then(data => {
        reservas = data;
        mostrarReservas(reservas);
    })
    .catch(error => console.error("Error cargando JSON:", error));

//  MOSTRAR RESERVAS PANEL DERECHO
function mostrarReservas(lista) {
    contenedor.innerHTML = '';

    lista.forEach(r => {
        const div = document.createElement('div');
        div.classList.add('reserva');
        div.innerHTML = `
        <button class="ver" data-id="${r.id}">Ver</button>
        <p><strong>Fecha:</strong> ${r.fecha}</p>
        <p><strong>${r.lugar}</strong></p>
        <p><strong>$${r.precio.toLocaleString()}</strong></p>
        `;
        contenedor.appendChild(div);
    });
}

// FILTRAR LAS RESERVAS
function filtrarReservas() {
    const filtro = input.value.toLowerCase();
    const filtradas = reservas.filter(r =>
        r.lugar.toLowerCase().includes(filtro) ||
        r.fecha.includes(filtro)
    );
    mostrarReservas(filtradas);
}

input.addEventListener('keyup', filtrarReservas);


// MODAL QUE MUESTRA EL DETALLE RESERVA EN EL BOTON VER
(function () {
    const modal = document.getElementById('modalReserva');
    if (!modal) return;
    const cerrarModal = modal.querySelector('.cerrar');

    function mostrarDetalleReserva(reserva) {
        document.getElementById('numReserva').textContent = reserva.id ?? '';
        document.getElementById('nombreUsuario').textContent = reserva.nombre ?? '';
        document.getElementById('identificacionUsuario').textContent = reserva.identificacion ?? '';
        document.getElementById('fechaReserva').textContent = reserva.fecha ?? '';
        document.getElementById('destinoReserva').textContent = reserva.lugar ?? '';
        document.getElementById('actividadReserva').textContent = reserva.actividad ?? '';
        document.getElementById('precioReserva').textContent = `$${reserva.precio.toLocaleString()}`;
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    }

    function cerrar() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }

    cerrarModal.addEventListener('click', cerrar);

    window.addEventListener('click', function (e) {
        if (e.target === modal) cerrar();
    });

    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrar();
    });

    // Escucha clicks en cualquier botón "ver"
    document.addEventListener('click', function (e) {
        const el = e.target.closest && e.target.closest('.ver');
        if (!el) return;
        const idReserva = el.dataset.id;
        if (!idReserva) return;

        // Buscar en el arreglo global ya cargado
        const reserva = reservas.find(r => String(r.id) === String(idReserva));
        if (reserva) {
            mostrarDetalleReserva(reserva);
            return;
        }

        // Si no existe, hace fetch al JSON (por seguridad)
        fetch('../../assets/data/historial_reservas.json')
            .then(res => res.json())
            .then(data => {
                const reserva = data.find(r => String(r.id) === String(idReserva));
                if (reserva) mostrarDetalleReserva(reserva);
            })
            .catch(err => console.error('Error al leer historial_reservas.json:', err));
    });
})();
