const byId = (id) => document.getElementById(id);

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

const getDashboardConfig = () => {
	const dashboard = document.querySelector('.dashboard-proveedor');
	return {
		dataUrl: dashboard?.dataset.dashboardUrl || '',
	};
};

const formatCurrency = (value) => {
	const amount = Number.parseFloat(value) || 0;
	return amount.toLocaleString('es-CO', {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});
};

const getEstadoBadgeClass = (estado) => {
	if (estado === 'confirmada') return 'bg-success';
	if (estado === 'pendiente') return 'bg-warning text-dark';
	return 'bg-secondary';
};

const createTableRow = (reserva) => {
	const row = document.createElement('tr');
	row.innerHTML = `
		<td>${reserva.nombre_turista}</td>
		<td>${reserva.fecha}</td>
		<td>${reserva.nombre_actividad}</td>
		<td>${reserva.cantidad_personas}</td>
		<td>$${formatCurrency(reserva.precio)}</td>
		<td><span class="badge ${getEstadoBadgeClass(reserva.estado)}">${reserva.estado}</span></td>
	`;
	return row;
};

const setupDashboardFilters = () => {
	const { dataUrl } = getDashboardConfig();
	const tablaReservas = byId('tabla-reservas-proveedor');
	if (!tablaReservas || !dataUrl) return;

	const aplicarBtn = byId('aplicar-filtros-proveedor');
	const limpiarBtn = byId('limpiar-filtros-proveedor');
	const tipoSelect = byId('filtro-tipo-proveedor');
	const anioSelect = byId('filtro-anio-proveedor');
	const mesSelect = byId('filtro-mes-proveedor');
	const mesContainer = byId('filtro-mes-container-proveedor');
	const anioContainer = byId('filtro-anio-container-proveedor');
	const btnFiltrar = byId('btn-filtrar');
	const filtrosContainer = byId('filtros-reservas');
	const tbody = tablaReservas.querySelector('tbody');
	if (!tbody || !tipoSelect || !anioSelect || !mesSelect) return;

	const togglePeriodFilters = () => {
		const isMes = tipoSelect.value === 'mes';
		if (mesContainer) mesContainer.style.display = isMes ? 'flex' : 'none';
		if (anioContainer) anioContainer.style.display = 'flex';
	};

	const renderRows = (reservas) => {
		tbody.innerHTML = '';

		if (!reservas?.length) {
			tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay reservas con estos filtros.</td></tr>';
			return;
		}

		reservas.forEach((reserva) => tbody.appendChild(createTableRow(reserva)));
	};

	const buildFilterUrl = () => {
		const url = new URL(dataUrl.replace('/data', '/filtrarReservas'), window.location.origin);
		url.searchParams.set('tipo', tipoSelect.value || 'anio');

		if (anioSelect.value) url.searchParams.set('anio', anioSelect.value);
		if (tipoSelect.value === 'mes' && mesSelect.value) url.searchParams.set('mes', mesSelect.value);

		return url.toString();
	};

	const filtrarReservas = async () => {
		try {
			const response = await fetch(buildFilterUrl());
			if (!response.ok) {
				throw new Error(`Error en la respuesta: ${response.status}`);
			}

			const data = await response.json();
			renderRows(data.reservas || []);
		} catch (error) {
			console.error('Error filtrando reservas:', error);
		}
	};

	const limpiarFiltros = () => {
		tipoSelect.value = 'anio';
		anioSelect.value = '';
		mesSelect.value = '';
		togglePeriodFilters();
		filtrarReservas();
	};

	tipoSelect.addEventListener('change', togglePeriodFilters);
	if (aplicarBtn) aplicarBtn.addEventListener('click', filtrarReservas);
	if (limpiarBtn) limpiarBtn.addEventListener('click', limpiarFiltros);

	if (btnFiltrar && filtrosContainer) {
		btnFiltrar.addEventListener('click', (event) => {
			event.preventDefault();
			const isHidden = filtrosContainer.style.display === 'none';
			filtrosContainer.style.display = isHidden ? 'block' : 'none';
			if (isHidden) filtrarReservas();
		});
	}

	togglePeriodFilters();
};

document.addEventListener('DOMContentLoaded', () => {
	setupTopbarActions();
	setupDashboardFilters();
});
