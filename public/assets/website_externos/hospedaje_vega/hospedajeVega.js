document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedorHospedajes");
  const buscador = document.getElementById("buscador");
  const btnBuscar = document.getElementById("btnBuscar");

  let hospedajes = [];

  // Cargar datos
  fetch("../../assets/data/hospedajeVega.json")
    .then(res => res.json())
    .then(data => {
      hospedajes = data;
      mostrarHospedajes(hospedajes);
    })
    .catch(err => console.error("Error cargando hospedajes:", err));

  function mostrarHospedajes(lista) {
    contenedor.innerHTML = "";

    // Si es resultado de búsqueda con solo 1 tarjeta, usar estilo compacto
    const esBusquedaUnica = lista.length === 1;

    lista.forEach(h => {
      const card = document.createElement("div");
      card.classList.add("card-hospedaje");

      if (esBusquedaUnica) {
        card.classList.add("busqueda-tarjeta");  // clase especial para búsqueda única
      }

      card.innerHTML = `
      <img src="${h.imagen}" alt="Imagen hospedaje">
      <div class="card-body-custom">
        <h5 class="card-titulo">${h.titulo}</h5>
        <p class="card-resena">⭐ ${h.reseñas} (${h.opiniones} opiniones)</p>
        <p>${h.noches} Noches, ${h.dias} Días</p>
        <p class="card-precio">Desde $${h.precio}</p>
      </div>
    `;

      card.addEventListener("click", () => abrirModal(h));
      contenedor.appendChild(card);
    });
  }

  // Modal
  const modalTitulo = document.getElementById("modalTitulo");
  const modalImagen = document.getElementById("modalImagen");
  const modalDescripcion = document.getElementById("modalDescripcion");
  const modalNoches = document.getElementById("modalNoches");
  const modalDias = document.getElementById("modalDias");
  const modalPrecio = document.getElementById("modalPrecio");
  const btnReservar = document.getElementById("btnReservar");

  function abrirModal(h) {
    modalTitulo.textContent = h.titulo;
    modalImagen.src = h.imagen;
    modalDescripcion.textContent = h.descripcion;
    modalNoches.textContent = h.noches;
    modalDias.textContent = h.dias;
    modalPrecio.textContent = h.precio;

    btnReservar.onclick = () => {
      window.location.href = "reservar.html";
    };

    const modal = new bootstrap.Modal(document.getElementById("modalHospedaje"));
    modal.show();
  }

  // Buscar hospedaje
  btnBuscar.addEventListener("click", () => {
    const texto = buscador.value.toLowerCase();
    const filtrados = hospedajes.filter(h =>
      h.titulo.toLowerCase().includes(texto)
    );
    mostrarHospedajes(filtrados);
  });
});

// Dropdown perfil
const profileToggle = document.getElementById('profileToggle');
const profileMenu = document.getElementById('profileMenu');

if (profileToggle && profileMenu) {

    profileToggle.addEventListener('click', function (e) {
        e.stopPropagation();

        profileMenu.style.display =
            profileMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function () {
        profileMenu.style.display = 'none';
    });

}
