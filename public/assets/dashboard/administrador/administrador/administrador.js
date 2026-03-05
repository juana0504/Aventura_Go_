const byId = (id) => document.getElementById(id);
const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

const createBaseTooltip = () => ({
  backgroundColor: '#2c3e50',
  titleColor: '#fff',
  bodyColor: '#fff',
  padding: 10,
  cornerRadius: 6,
  titleFont: { size: 13, weight: 'bold' },
  bodyFont: { size: 12 },
  callbacks: {
    label: (context) => context.parsed.y.toLocaleString('es-CO'),
  },
});

const setupTopbarActions = () => {
  const modoOscuroBtn = byId('modoOscuroBtn');
  const notificacionesBtn = byId('notificacionesBtn');

  if (modoOscuroBtn) {
    modoOscuroBtn.addEventListener('click', (event) => {
      event.preventDefault();
      document.body.classList.toggle('modo-oscuro');
    });
  }

  if (notificacionesBtn) {
    notificacionesBtn.addEventListener('click', (event) => {
      event.preventDefault();
      alert('Tienes nuevas reservas, verifica');
    });
  }
};

const getDataUrl = () => document.querySelector('.dashboard-content')?.dataset.dashboardUrl || '';

const createChartManager = () => {
  const reservasCtx = byId('reservasChart');
  const gastosCtx = byId('gastosChart');
  let reservasChart = null;
  let gastosChart = null;

  const destroyChart = (chart) => {
    if (chart) chart.destroy();
  };

  const buildReservasDataset = (reservasData, tipo) => {
    const labels = [];
    const data = [];

    (Array.isArray(reservasData) ? reservasData : []).forEach((item) => {
      labels.push(item.periodo ?? item.dia ?? '');
      data.push(item.total ?? 0);
    });

    if (!labels.length) return { labels: ['Sin datos'], data: [0] };

    if (tipo !== 'mes') return { labels, data };

    const dataByMonth = {};
    reservasData.forEach((item) => {
      const month = Number.parseInt(item.periodo, 10);
      if (!Number.isNaN(month)) dataByMonth[month] = item.total ?? 0;
    });

    return {
      labels: MONTH_NAMES,
      data: Array.from({ length: 12 }, (_, index) => dataByMonth[index + 1] || 0),
    };
  };

  const createReservasConfig = (reservasData, tipo) => {
    const dataset = buildReservasDataset(reservasData, tipo);
    const isYearMode = tipo === 'anio';

    return {
      type: isYearMode ? 'bar' : 'line',
      data: {
        labels: dataset.labels,
        datasets: [{
          label: 'Reservas',
          data: dataset.data,
          borderColor: '#EA8217',
          backgroundColor: isYearMode ? '#EA8217' : 'rgba(234, 130, 23, 0.08)',
          borderWidth: isYearMode ? 0 : 2.5,
          tension: 0.4,
          fill: true,
          pointBackgroundColor: '#EA8217',
          pointBorderColor: '#D97016',
          pointBorderWidth: isYearMode ? 0 : 1.5,
          pointRadius: isYearMode ? 0 : 5,
          pointHoverRadius: isYearMode ? 0 : 7,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: createBaseTooltip(),
          title: { display: false },
        },
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Cantidad de Reservas' },
            ticks: {
              color: '#6c757d',
              callback: (value) => value.toLocaleString('es-CO'),
            },
            grid: { color: '#e9ecef', drawBorder: false },
          },
          x: {
            title: {
              display: true,
              text: tipo === 'anio' ? 'Año' : tipo === 'mes' ? 'Mes' : 'Fecha (Últimos 7 días)',
            },
            ticks: { color: '#6c757d' },
            grid: { display: false, drawBorder: false },
          },
        },
      },
    };
  };

  const createGastosConfig = (gastosData) => {
    const labels = [];
    const data = [];

    (Array.isArray(gastosData) ? gastosData : []).forEach((item) => {
      labels.push(item.categoria || item.dia || 'Sin datos');
      data.push(item.total || item.monto || 0);
    });

    if (!labels.length) {
      labels.push('Sin datos');
      data.push(0);
    }

    return {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Gastos',
          data,
          borderColor: '#EA8217',
          backgroundColor: 'rgba(234, 130, 23, 0.08)',
          tension: 0.4,
          pointBackgroundColor: '#EA8217',
          pointBorderColor: '#d97107',
          pointBorderWidth: 1.5,
          pointRadius: 4,
          pointHoverRadius: 6,
          borderWidth: 2,
          fill: true,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#6c757d' },
            title: { display: true, text: 'Categoría/Período' },
          },
          y: {
            beginAtZero: true,
            grid: { color: '#e9ecef' },
            ticks: {
              color: '#6c757d',
              callback: (value) => `$${value.toLocaleString('es-CO')}`,
            },
            title: { display: true, text: 'Monto ($)' },
          },
        },
        plugins: {
          legend: { display: true, labels: { color: '#6c757d' } },
          tooltip: {
            ...createBaseTooltip(),
            callbacks: {
              label: (context) => `$${context.parsed.y.toLocaleString('es-CO')}`,
            },
          },
        },
      },
    };
  };

  const renderCharts = (data, tipo) => {
    if (typeof Chart === 'undefined') return;

    if (reservasCtx) {
      destroyChart(reservasChart);
      reservasChart = new Chart(reservasCtx, createReservasConfig(data.graficoReservas || [], tipo));
    }

    if (gastosCtx) {
      destroyChart(gastosChart);
      gastosChart = new Chart(gastosCtx, createGastosConfig(data.gastosChartData || []));
    }
  };

  return { renderCharts };
};

const setupDashboardFilters = () => {
  const dataUrl = getDataUrl();
  if (!dataUrl) {
    console.error('No se encontró la URL de datos del dashboard.');
    return;
  }

  const chartManager = createChartManager();
  const aplicarBtn = byId('aplicar-filtros');
  const limpiarBtn = byId('limpiar-filtros');
  const tipoSelect = byId('filtro-tipo');
  const anioSelect = byId('filtro-anio');
  const mesSelect = byId('filtro-mes');
  const mesContainer = byId('filtro-mes-container');
  const anioContainer = byId('filtro-anio-container');
  const filtrosContainer = byId('filtros-reservas');
  const btnFiltrar = document.querySelector('.btn-filtrar');
  const tablaReservas = document.querySelector('.resumen-reservas table');
  const tableRows = tablaReservas?.tBodies?.[0] ? Array.from(tablaReservas.tBodies[0].rows) : [];

  const togglePeriodControls = () => {
    const isMonthMode = tipoSelect?.value === 'mes';
    if (mesContainer) mesContainer.style.display = isMonthMode ? 'flex' : 'none';
    if (anioContainer) anioContainer.style.display = 'flex';
  };

  const buildRequestUrl = (tipo, anio, mes) => {
    const url = new URL(dataUrl, window.location.origin);
    if (tipo) url.searchParams.set('tipo', tipo);
    if (anio) url.searchParams.set('anio', anio);
    if (tipo === 'mes' && mes) url.searchParams.set('mes', mes);
    return url.toString();
  };

  const requestDashboardData = async (tipo, anio, mes) => {
    try {
      const response = await fetch(buildRequestUrl(tipo, anio, mes));
      if (!response.ok) throw new Error(`Error en la respuesta: ${response.status}`);
      const data = await response.json();
      chartManager.renderCharts(data, tipo);
    } catch (error) {
      console.error('Error cargando datos de dashboard:', error);
    }
  };

  const filterTableRows = () => {
    const tipo = tipoSelect?.value || 'anio';
    const anio = anioSelect?.value || '';
    const mes = mesSelect?.value || '';

    tableRows.forEach((row) => {
      const fecha = row.cells?.[1]?.textContent?.trim() || '';
      let visible = true;

      if (anio && !fecha.startsWith(anio)) visible = false;
      if (visible && tipo === 'mes' && mes) {
        const [, month] = fecha.split('-');
        visible = month === mes.padStart(2, '0');
      }

      row.style.display = visible ? '' : 'none';
    });

    requestDashboardData(tipo, anio || undefined, mes || undefined);
  };

  const clearFilters = () => {
    if (tipoSelect) tipoSelect.value = 'anio';
    if (anioSelect) anioSelect.value = '';
    if (mesSelect) mesSelect.value = '';
    togglePeriodControls();
    filterTableRows();
  };

  if (tipoSelect) tipoSelect.addEventListener('change', togglePeriodControls);
  if (aplicarBtn) aplicarBtn.addEventListener('click', filterTableRows);
  if (limpiarBtn) limpiarBtn.addEventListener('click', clearFilters);

  if (btnFiltrar && filtrosContainer) {
    btnFiltrar.addEventListener('click', (event) => {
      event.preventDefault();
      const isHidden = filtrosContainer.style.display === 'none';
      filtrosContainer.style.display = isHidden ? 'block' : 'none';
      if (isHidden) filterTableRows();
    });
  }

  togglePeriodControls();
  requestDashboardData('anio');
};

document.addEventListener('DOMContentLoaded', () => {
  setupTopbarActions();
  setupDashboardFilters();
});
