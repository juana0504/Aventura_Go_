const modoOscuroBtn = document.getElementById('modoOscuroBtn');
const notificacionesBtn = document.getElementById('notificacionesBtn');

// Prevenir que los botones envíen el formulario
modoOscuroBtn.addEventListener('click', (e) => {
    e.preventDefault(); // ← IMPORTANTE: Previene el envío del form
    document.body.classList.toggle('modo-oscuro');
});

notificacionesBtn.addEventListener('click', (e) => {
    e.preventDefault(); // ← IMPORTANTE: Previene el envío del form
    alert("Tienes nuevas reservas, verifica");
});

// filtrar tabla de reservas recientes
const btnFiltrar = document.querySelector('.btn-filtrar');
if (btnFiltrar) {
    btnFiltrar.addEventListener('click', (e) => {
        e.preventDefault();
        const cont = document.getElementById('filtros-reservas');
        if (cont) cont.style.display = cont.style.display === 'none' ? 'block' : 'none';
    });
}


document.addEventListener('DOMContentLoaded', () => {
  const reservasCtx = document.getElementById('reservasChart');
  const gastosCtx = document.getElementById('gastosChart');

  // aplica filtrado sobre tabla si se usa formulario
  const aplicarBtn = document.getElementById('aplicar-filtros');
  const limpiarBtn = document.getElementById('limpiar-filtros');
  const tablaReservas = document.querySelector('.resumen-reservas table');

  function filtrarTabla() {
    if (!tablaReservas) return;
    const año = document.getElementById('filtro-anio').value;
    const filas = Array.from(tablaReservas.tBodies[0].rows);
    filas.forEach(tr => {
      const fecha = tr.cells[1].textContent.trim(); // suposición formato YYYY-MM-DD
      if (año && fecha.indexOf(año) !== 0) {
        tr.style.display = 'none';
      } else {
        tr.style.display = '';
      }
    });
  }

  function limpiarTabla() {
    if (!tablaReservas) return;
    document.getElementById('filtro-anio').value = '';
    filtrarTabla();
  }

  if (aplicarBtn) aplicarBtn.addEventListener('click', filtrarTabla);
  if (limpiarBtn) limpiarBtn.addEventListener('click', limpiarTabla);

  // obtén datos del servidor vía AJAX
  fetch('<?= BASE_URL ?>/administrador/dashboard/data')
    .then(res => res.json())
    .then(datos => {
      // --- gráfico de reservas ---
      if (reservasCtx) {
        let labels = [];
        let data = [];
        const reservasData = datos.graficoReservas || [];
        if (Array.isArray(reservasData)) {
          reservasData.forEach(r => {
            labels.push(r.dia);
            data.push(r.total);
          });
        }
        if (labels.length === 0) {
          labels = ['Sin datos'];
          data = [0];
        }
        new Chart(reservasCtx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Reservas',
              data: data,
              borderColor: '#EA8217',
              backgroundColor: 'rgba(255, 132, 0, 0.15)',
              tension: 0.4,
              pointBackgroundColor: '#EA8217',
              pointRadius: 5,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { grid: { display: false }, ticks: { color: '#555' } },
              y: { grid: { color: '#eee' }, ticks: { color: '#555' } }
            },
            plugins: {
              legend: { display: false },
              tooltip: { backgroundColor: '#007bff', titleColor: '#fff', bodyColor: '#fff' }
            }
          }
        });
      }

      // --- gráfico de gastos ---
      if (gastosCtx) {
        let labelsG = [];
        let dataG = [];
        const gastosData = datos.gastosChartData || [];
        if (Array.isArray(gastosData)) {
          gastosData.forEach(g => {
            labelsG.push(g.categoria || g.dia || 'Sin datos');
            dataG.push(g.total || g.monto || 0);
          });
        }
        if (labelsG.length === 0) {
          labelsG = ['Sin datos'];
          dataG = [0];
        }
        new Chart(gastosCtx, {
          type: 'line',
          data: {
            labels: labelsG,
            datasets: [{
              label: 'Gastos',
              data: dataG,
              borderColor: '#EA8217',
              backgroundColor: 'rgba(211, 218, 225, 0.2)',
              tension: 0.4,
              pointBackgroundColor: '#EA8217',
              pointRadius: 4,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { grid: { display: false }, ticks: { color: '#000000ff' } },
              y: { grid: { color: '#DEE6F2' }, ticks: { color: '#000000ff' } }
            },
            plugins: {
              legend: { display: false },
              tooltip: { backgroundColor: '#000000ff', titleColor: '#000000ff', bodyColor: '#000000ff' }
            }
          }
        });
      }
    })
    .catch(err => console.error('Error cargando datos de dashboard:', err));
});

document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('gastosChart');

  if (ctx) {
    // preparar etiquetas y datos a partir de gastosData si existe
    let labelsG = [];
    let dataG = [];
    if (typeof gastosData !== 'undefined' && Array.isArray(gastosData)) {
      gastosData.forEach(g => {
        labelsG.push(g.categoria || g.dia || 'Sin datos');
        dataG.push(g.total || g.monto || 0);
      });
    }
    // si no llegó ningún dato, mostramos una etiqueta neutra
    if (labelsG.length === 0) {
      labelsG = ['Sin datos'];
      dataG = [0];
    }
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labelsG,
        datasets: [{
          label: 'Gastos',
          data: dataG,
          borderColor: '#EA8217',
          backgroundColor: 'rgba(211, 218, 225, 0.2)',
          tension: 0.4,
          pointBackgroundColor: '#EA8217',
          pointRadius: 4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#000000ff' }
          },
          y: {
            grid: { color: '#DEE6F2' },
            ticks: { color: '#000000ff' }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#000000ff',
            titleColor: '#000000ff',
            bodyColor: '#000000ff'
          }
        }
      }
    });
  }
});
