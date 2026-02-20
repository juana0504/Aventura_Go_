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

document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('reservasChart');

  if (ctx) { // Verifica que exista el canvas antes de crear el gráfico
    // preparar etiquetas y datos a partir de reservasData
    let labels = [];
    let data = [];
    if (typeof reservasData !== 'undefined' && Array.isArray(reservasData)) {
      reservasData.forEach(r => {
        labels.push(r.dia);
        data.push(r.total);
      });
    }
    new Chart(ctx, {
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
          x: {
            grid: { display: false },
            ticks: { color: '#555' }
          },
          y: {
            grid: { color: '#eee' },
            ticks: { color: '#555' }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#007bff',
            titleColor: '#fff',
            bodyColor: '#fff'
          }
        }
      }
    });
  }
});


document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('gastosChart');

  if (ctx) {
    // preparar etiquetas y datos a partir de gastosData si existe
    let labelsG = [];
    let dataG = [];
    if (typeof gastosData !== 'undefined' && Array.isArray(gastosData)) {
      gastosData.forEach(g => {
        labelsG.push(g.categoria || g.dia || '');
        dataG.push(g.total || g.monto || 0);
      });
    }
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labelsG.length ? labelsG : ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
          label: 'Gastos',
          data: dataG.length ? dataG : [5, 10, 8, 12, 15, 13, 17, 19, 22, 20, 18, 25],
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
