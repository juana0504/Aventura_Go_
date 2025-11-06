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
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
          label: 'Reservas',
          data: [10, 20, 15, 25, 30, 28, 40, 35, 45, 50, 48, 70],
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
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
          label: 'Gastos',
          data: [5, 10, 8, 12, 15, 13, 17, 19, 22, 20, 18, 25],
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
