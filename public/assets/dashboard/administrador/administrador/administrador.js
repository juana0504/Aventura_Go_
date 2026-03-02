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
  const tipoSelect = document.getElementById('filtro-tipo');
  const mesContainer = document.getElementById('filtro-mes-container');
  const anioContainer = document.getElementById('filtro-anio-container');
  const tablaReservas = document.querySelector('.resumen-reservas table');

  // mostrar/ocultar mes y año según tipo
  if (tipoSelect) {
    tipoSelect.addEventListener('change', () => {
      const tipo = tipoSelect.value;
      if (tipo === 'mes') {
        mesContainer.style.display = 'flex';
        anioContainer.style.display = 'flex';
      } else {
        mesContainer.style.display = 'none';
        anioContainer.style.display = 'flex';
      }
    });
  }

  function filtrarTabla() {
    if (!tablaReservas) return;
    const tipo = tipoSelect ? tipoSelect.value : 'anio';
    const año = document.getElementById('filtro-anio').value;
    const mes = document.getElementById('filtro-mes').value;
    const filas = Array.from(tablaReservas.tBodies[0].rows);
    filas.forEach(tr => {
      const fecha = tr.cells[1].textContent.trim(); // formato YYYY-MM-DD
      let mostrar = true;
      if (año && fecha.indexOf(año) !== 0) {
        mostrar = false;
      }
      if (mostrar && tipo === 'mes' && mes) {
        const partes = fecha.split('-');
        if (partes[1] !== mes.padStart(2, '0')) {
          mostrar = false;
        }
      }
      tr.style.display = mostrar ? '' : 'none';
    });
    // recargar datos del gráfico
    if (tipo === 'anio') {
      fetchChartData('anio', año || undefined);
    } else if (tipo === 'mes') {
      fetchChartData('mes', año || undefined);
    } else {
      fetchChartData();
    }
  }

  function limpiarTabla() {
    if (!tablaReservas) return;
    document.getElementById('filtro-anio').value = '';
    document.getElementById('filtro-mes').value = '';
    filtrarTabla();
  }

  if (aplicarBtn) aplicarBtn.addEventListener('click', filtrarTabla);
  if (limpiarBtn) limpiarBtn.addEventListener('click', limpiarTabla);

  // función auxiliar que solicita datos de dashboard y construye los gráficos
  // tipo puede ser 'anio' o 'mes'; año y mes son valores numéricos
  function fetchChartData(tipo, anio, mes) {
    if (typeof DASHBOARD_DATA_URL === 'undefined') {
      console.error('La URL de datos del dashboard no está definida');
      return;
    }
    let url = DASHBOARD_DATA_URL;
    const params = [];
    if (tipo) params.push('tipo=' + encodeURIComponent(tipo));
    if (anio) params.push('anio=' + encodeURIComponent(anio));
    if (mes) params.push('mes=' + encodeURIComponent(mes));
    if (params.length) url += '?' + params.join('&');
    fetch(url)
      .then(res => res.json())
      .then(datos => {
        buildCharts(datos, tipo);
      })
      .catch(err => console.error('Error cargando datos de dashboard:', err));
  }

  // constructor de gráficos reutilizable
  function buildCharts(datos, tipo) {
    // --- gráfico de reservas ---
    if (reservasCtx) {
        let labels = [];
        let data = [];
        const reservasData = datos.graficoReservas || [];
        if (Array.isArray(reservasData)) {
          reservasData.forEach(r => {
            // el servidor puede enviar 'periodo' (año/mes) o 'dia' cuando son últimos días
            const label = r.periodo !== undefined ? r.periodo : (r.dia !== undefined ? r.dia : '');
            labels.push(label);
            data.push(r.total);
          });
        }
        if (labels.length === 0) {
          labels = ['Sin datos'];
          data = [0];
        }
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: { 
                backgroundColor: '#007bff', 
                titleColor: '#fff', 
                bodyColor: '#fff',
                padding: 12,
                cornerRadius: 4,
                titleFont: { size: 14, weight: 'bold' },
                bodyFont: { size: 13 }
              },
              title: { display: false }
            }
        };
        const chartConfig = {
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
            options: chartOptions
        };
        // ajustar tipo y orientación según agrupación
        if (tipo === 'anio') {
            chartConfig.type = 'bar';
            // Mantener eje X normal (años abajo, reservas arriba)
            chartConfig.data.datasets[0].backgroundColor = '#EA8217';
            chartConfig.data.datasets[0].borderColor = '#D97016';
            chartConfig.data.datasets[0].borderWidth = 2;
            
            // Configuración mejorada con más detalles
            chartOptions.scales = {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Cantidad de Reservas' },
                    ticks: { 
                        color: '#000000ff',
                        callback: function(value) { return value.toLocaleString('es-CO'); }
                    },
                    grid: { color: '#DEE6F2', drawBorder: true }
                },
                x: {
                    title: { display: true, text: 'Año' },
                    ticks: { color: '#000000ff' },
                    grid: { display: false, drawBorder: true }
                }
            };
            chartOptions.plugins.tooltip.callbacks = {
                label: function(context) {
                    return 'Reservas: ' + context.parsed.y.toLocaleString('es-CO');
                }
            };
        } else if (tipo === 'mes') {
            chartConfig.type = 'line';
            // interpretar etiquetas como nombres de mes si son números
            labels.forEach((lab, idx) => {
                const num = parseInt(lab, 10);
                if (!isNaN(num)) {
                    const mesesNombres = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                    labels[idx] = mesesNombres[num-1] || lab;
                }
            });
            
            // Configuración mejorada con más detalles
            chartConfig.data.datasets[0].pointRadius = 6;
            chartConfig.data.datasets[0].pointHoverRadius = 8;
            chartConfig.data.datasets[0].pointBorderWidth = 2;
            chartConfig.data.datasets[0].pointBorderColor = '#D97016';
            
            chartOptions.scales = {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Cantidad de Reservas' },
                    ticks: { 
                        color: '#000000ff',
                        callback: function(value) { return value.toLocaleString('es-CO'); }
                    },
                    grid: { color: '#DEE6F2', drawBorder: true }
                },
                x: {
                    title: { display: true, text: 'Mes' },
                    ticks: { color: '#000000ff' },
                    grid: { display: false, drawBorder: true }
                }
            };
            chartOptions.plugins.tooltip.callbacks = {
                label: function(context) {
                    return 'Reservas: ' + context.parsed.y.toLocaleString('es-CO');
                }
            };
        } else {
            // modo días por defecto
            chartConfig.type = 'line';
            
            // Mejoras para modo por defecto
            chartConfig.data.datasets[0].pointRadius = 6;
            chartConfig.data.datasets[0].pointHoverRadius = 8;
            chartConfig.data.datasets[0].pointBorderWidth = 2;
            chartConfig.data.datasets[0].pointBorderColor = '#D97016';
            chartConfig.data.datasets[0].borderWidth = 3;
            
            chartOptions.scales = {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Cantidad de Reservas' },
                    ticks: { 
                        color: '#000000ff',
                        callback: function(value) { return value.toLocaleString('es-CO'); }
                    },
                    grid: { color: '#DEE6F2', drawBorder: true }
                },
                x: {
                    title: { display: true, text: 'Fecha (Últimos 7 días)' },
                    ticks: { color: '#000000ff' },
                    grid: { display: false, drawBorder: true }
                }
            };
            chartOptions.plugins.tooltip.callbacks = {
                label: function(context) {
                    return 'Reservas: ' + context.parsed.y.toLocaleString('es-CO');
                }
            };
        }
        new Chart(reservasCtx, chartConfig);
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
              pointBorderColor: '#D97016',
              pointBorderWidth: 2,
              pointRadius: 5,
              pointHoverRadius: 7,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { 
                grid: { display: false }, 
                ticks: { color: '#000000ff' },
                title: { display: true, text: 'Categoría/Período' }
              },
              y: { 
                beginAtZero: true,
                grid: { color: '#DEE6F2' }, 
                ticks: { 
                  color: '#000000ff',
                  callback: function(value) { return '$' + value.toLocaleString('es-CO'); }
                },
                title: { display: true, text: 'Monto ($)' }
              }
            },
            plugins: {
              legend: { display: true, labels: { color: '#000000ff' } },
              tooltip: { 
                backgroundColor: '#000000ff', 
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                callbacks: {
                  label: function(context) {
                    return 'Gasto: $' + context.parsed.y.toLocaleString('es-CO');
                  }
                }
              }
            }
          }
        });
      }
  }
  // inicializa gráficos la primera vez en modo anual (show years)
  fetchChartData('anio');
});
