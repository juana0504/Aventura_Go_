const valores = {
  adultos: 0,
  ninos: 0,
  bebes: 0,
  mascotas: 0,
  habitaciones: 0
};

const actualizarResumen = () => {
  const totalPersonas = valores.adultos + valores.ninos + valores.bebes;
  const texto = `Total: ${totalPersonas} personas (${valores.adultos} adultos, ${valores.ninos} niño/s), ${valores.mascotas} mascota/s | Total Habitaciones: ${valores.habitaciones}`;
  document.getElementById("resumen-texto").textContent = texto;
};

document.querySelectorAll(".btn-mas, .btn-menos").forEach(boton => {
  boton.addEventListener("click", () => {
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

// Inicializa el texto al cargar
actualizarResumen();
