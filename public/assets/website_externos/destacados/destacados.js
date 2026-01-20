// menu hamburguesa
const toggle = document.getElementById('menu-toggle');
const nav = document.getElementById('navbarNav');

toggle.addEventListener('click', () => {
    nav.classList.toggle('show');
});



// =====================================================
// SECCIÓN 1: CARGA Y BÚSQUEDA DE TOURS
// =====================================================
document.addEventListener('DOMContentLoaded', () => {
  const contenedor = document.getElementById('contenedor-tours');
  const botonBuscar = document.querySelector('.btn-buscar');
  const inputBusqueda = document.getElementById('input-busqueda');

  let toursGuardados = []; // guardaremos los tours cargados

  // Cargar tours desde el JSON
  fetch('../assets/website_externos/destacados/tours.json')
    .then(response => {
      if (!response.ok) throw new Error("Error al cargar el JSON");
      return response.json();
    })
    .then(tours => {
      toursGuardados = tours; // guardamos para poder filtrar después
      mostrarTours(toursGuardados);
    })
    .catch(error => console.error("Error cargando los tours:", error));

  // Función para mostrar los tours
  function mostrarTours(lista) {
    contenedor.innerHTML = ''; // limpiar
    if (lista.length === 0) {
      contenedor.innerHTML = '<p>No se encontraron resultados.</p>';
      return;
    }

    lista.forEach(tour => {
      const card = document.createElement('div');
      card.classList.add('tarjeta-tour');

      card.innerHTML = `
        <img src="${tour.img}" alt="${tour.titulo}">
        <div class="tour-info">
          <h3>${tour.titulo}</h3>
          <div class="tour-rating">
            ⭐⭐⭐⭐⭐ <span>(1 Review)</span>
          </div>
          <p><strong>${tour.tipo}</strong></p>
          <p>${tour.descripcion}</p>
          <p class="tour-precio">${tour.precio}</p>
        </div>
      `;
      contenedor.appendChild(card);
    });
  }

  // Evento para buscar
  botonBuscar.addEventListener('click', () => {
    const texto = inputBusqueda.value.toLowerCase().trim();
    const filtrados = toursGuardados.filter(tour =>
      tour.titulo.toLowerCase().includes(texto) ||
      tour.tipo.toLowerCase().includes(texto)
    );
    mostrarTours(filtrados);
  });
});


// =====================================================
// SECCIÓN 2: CALENDARIO - CONFIGURACIÓN GENERAL
// =====================================================
const today = new Date(); // Fecha actual real
today.setHours(0, 0, 0, 0); // Normalizar horas

// Rango de años: año actual + 2 años posteriores
const currentYear = today.getFullYear();
const maxYear = currentYear + 2;

// Variables de estado del calendario
let currentDate = new Date();
let startDate = null;
let endDate = null;
let selectingStart = true; // true = eligiendo fecha de entrada, false = salida

// Elementos del DOM - Calendario
const calendar = document.getElementById("calendar");
const openBtn = document.getElementById("openCalendarBtn");
const dateText = document.getElementById("dateText");
const currentLabel = document.getElementById("currentLabel");
const calendarDays = document.getElementById("calendarDays");
const monthGrid = document.getElementById("monthGrid");
const yearGrid = document.getElementById("yearGrid");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

// Meses en español
const months = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];


// =====================================================
// SECCIÓN 3: FUNCIONES DE FORMATO Y ACTUALIZACIÓN
// =====================================================
function formatDate(d) {
  return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
}

// Calcular noches
function getNights() {
  if (!startDate || !endDate) return 0;
  const diff = endDate - startDate;
  return diff / (1000 * 60 * 60 * 24);
}

// Actualizar texto del botón
function updateButtonText() {
  if (!startDate && !endDate) {
    dateText.textContent = "Fijar fecha";
    return;
  }
  if (startDate && !endDate) {
    dateText.textContent = `${formatDate(startDate)} — Selecciona salida`;
    return;
  }
  const nights = getNights();
  dateText.textContent = `${formatDate(startDate)} — ${formatDate(endDate)} · ${nights} noches`;
}


// =====================================================
// SECCIÓN 4: CALENDARIO - ABRIR/CERRAR
// =====================================================
openBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  calendar.classList.toggle("hidden");
  openBtn.setAttribute("aria-expanded", calendar.classList.contains("hidden") ? "false" : "true");
  showMonth();
});

// Cierra calendario si clic fuera
document.addEventListener("click", (e) => {
  if (!calendar.contains(e.target) && !openBtn.contains(e.target)) {
    calendar.classList.add("hidden");
    openBtn.setAttribute("aria-expanded", "false");
  }
});


// =====================================================
// SECCIÓN 5: CALENDARIO - MOSTRAR DÍAS
// =====================================================
function showMonth() {
  monthGrid.classList.add("hidden");
  yearGrid.classList.add("hidden");
  calendarDays.classList.remove("hidden");

  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();

  currentLabel.textContent = `${months[month]} ${year}`;

  calendarDays.innerHTML = "";

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  // Espacios iniciales
  for (let i = 0; i < firstDay; i++) {
    calendarDays.innerHTML += `<div></div>`;
  }

  // Crear días
  for (let d = 1; d <= daysInMonth; d++) {
    const dayDate = new Date(year, month, d);
    dayDate.setHours(0, 0, 0, 0);

    let disabled = dayDate < today; // Bloquea días pasados

    // Bloquear si supera los 2 años
    if (year > maxYear || (year === maxYear && month > 11)) {
      disabled = true;
    }

    const isSelected =
      startDate && dayDate.getTime() === startDate.getTime() ||
      endDate && dayDate.getTime() === endDate.getTime();

    calendarDays.innerHTML += `
      <div class="day ${disabled ? "disabled" : ""} ${isSelected ? "selected" : ""}"
      data-day="${d}"
      data-month="${month}"
      data-year="${year}">
      ${d}
      </div>`;
  }
}


// =====================================================
// SECCIÓN 6: CALENDARIO - SELECCIÓN DE DÍAS
// =====================================================
calendarDays.addEventListener("click", (e) => {
  if (!e.target.classList.contains("day") || e.target.classList.contains("disabled")) return;

  const d = parseInt(e.target.dataset.day);
  const m = parseInt(e.target.dataset.month);
  const y = parseInt(e.target.dataset.year);

  const selected = new Date(y, m, d);
  selected.setHours(0, 0, 0, 0);

  if (selectingStart) {
    startDate = selected;
    endDate = null;
    selectingStart = false;
  } else {
    if (selected <= startDate) {
      startDate = selected;
      endDate = null;
    } else {
      endDate = selected;
      selectingStart = true;
      calendar.classList.add("hidden"); // cerrar calendario
    }
  }

  updateButtonText();
  showMonth();
});


// =====================================================
// SECCIÓN 7: CALENDARIO - VISTA DE MESES
// =====================================================
currentLabel.addEventListener("click", () => {
  if (!calendarDays.classList.contains("hidden")) {
    showMonths();
  } else if (!monthGrid.classList.contains("hidden")) {
    showYears();
  }
});

function showMonths() {
  calendarDays.classList.add("hidden");
  yearGrid.classList.add("hidden");
  monthGrid.classList.remove("hidden");

  monthGrid.innerHTML = "";
  for (let i = 0; i < 12; i++) {
    const disabled = currentDate.getFullYear() === currentYear && i < today.getMonth();

    monthGrid.innerHTML += `
      <div class="month-cell ${disabled ? "disabled" : ""}" data-month="${i}">
      ${months[i]}
      </div>`;
  }
}

monthGrid.addEventListener("click", (e) => {
  if (!e.target.classList.contains("month-cell") || e.target.classList.contains("disabled")) return;

  const m = parseInt(e.target.dataset.month);
  currentDate.setMonth(m);

  showMonth();
});


// =====================================================
// SECCIÓN 8: CALENDARIO - VISTA DE AÑOS
// =====================================================
function showYears() {
  calendarDays.classList.add("hidden");
  monthGrid.classList.add("hidden");
  yearGrid.classList.remove("hidden");

  yearGrid.innerHTML = "";
  for (let y = currentYear; y <= maxYear; y++) {
    yearGrid.innerHTML += `<div class="year-cell" data-year="${y}">${y}</div>`;
  }
}

yearGrid.addEventListener("click", (e) => {
  if (!e.target.classList.contains("year-cell")) return;
  const y = parseInt(e.target.dataset.year);
  currentDate.setFullYear(y);
  showMonths();
});


// =====================================================
// SECCIÓN 9: CALENDARIO - NAVEGACIÓN
// =====================================================
prevBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  if (currentDate < today) currentDate = new Date(today);
  showMonth();
});

nextBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  if (currentDate.getFullYear() > maxYear) currentDate.setFullYear(maxYear);
  showMonth();
});


// =====================================================
// SECCIÓN 10: CONTADOR DE INVITADOS - CONFIGURACIÓN
// =====================================================
const valores = {
  adultos: 0,
  ninos: 0,
  bebes: 0,
  mascotas: 0,
  habitaciones: 0
};

// Elementos del DOM - Invitados
const openGuestBtn = document.getElementById("openGuestCounter");
const guestPanel = document.getElementById("guestPanel");


// =====================================================
// SECCIÓN 11: CONTADOR DE INVITADOS - FUNCIONES
// =====================================================
// Actualiza el resumen dentro del panel
const actualizarResumen = () => {
  const totalPersonas = valores.adultos + valores.ninos + valores.bebes;
  const texto = `Total: ${totalPersonas} personas (${valores.adultos} adultos, ${valores.ninos} niño/s), ${valores.mascotas} mascota/s | Total Habitaciones: ${valores.habitaciones}`;
  document.getElementById("resumen-texto").textContent = texto;
  actualizarResumenBarra();
};

// Actualiza el texto del botón en la barra de búsqueda
const actualizarResumenBarra = () => {
  const totalPersonas = valores.adultos + valores.ninos + valores.bebes;
  const habitaciones = valores.habitaciones;
  const resumen = `${totalPersonas} invitado${totalPersonas !== 1 ? 's' : ''}, ${habitaciones} habitación${habitaciones !== 1 ? 'es' : ''}`;
  document.getElementById("guestSummary").textContent = resumen;
};


// =====================================================
// SECCIÓN 12: CONTADOR DE INVITADOS - EVENTOS
// =====================================================
// Manejo de botones + y -
document.querySelectorAll(".btn-mas, .btn-menos").forEach(boton => {
  boton.addEventListener("click", (e) => {
    e.stopPropagation(); // Evita que se cierre el panel
    const tipo = boton.dataset.tipo;
    const esSuma = boton.classList.contains("btn-mas");

    if (esSuma) {
      valores[tipo]++;
    } else {
      valores[tipo] = Math.max(0, valores[tipo] - 1);
    }

    document.getElementById(tipo).textContent = valores[tipo];
    actualizarResumen();
  });
});

// Abrir/cerrar panel de invitados - SOLO AL HACER CLIC EN EL BOTÓN
openGuestBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  guestPanel.classList.toggle("hidden");
});

// Cerrar panel al hacer clic fuera
document.addEventListener("click", (e) => {
  // Verificar si el clic fue dentro del search-item pero fuera del botón y panel
  const searchItem = openGuestBtn.closest('.search-item');
  
  if (!guestPanel.contains(e.target) && 
      !openGuestBtn.contains(e.target) && 
      !searchItem.contains(e.target)) {
    guestPanel.classList.add("hidden");
  }
  
  // Si el clic fue en el ícono o en otra parte del search-item, no hacer nada
  if (searchItem && searchItem.contains(e.target) && !openGuestBtn.contains(e.target)) {
    guestPanel.classList.add("hidden");
  }
});

// Prevenir que el panel se cierre al hacer clic dentro de él
guestPanel.addEventListener("click", (e) => {
  e.stopPropagation();
});

// Botón confirmar cierra el panel
document.getElementById("btn-confirmar").addEventListener("click", () => {
  guestPanel.classList.add("hidden");
});


// =====================================================
// SECCIÓN 13: INICIALIZACIÓN
// =====================================================
// Inicializar calendario
showMonth();
updateButtonText();

// Inicializar contador de invitados
actualizarResumen();