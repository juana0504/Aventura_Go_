<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

// Lógica intacta del backend
$getPagoColorClass = static function (string $texto = ''): string {
    $textoNormalizado = strtolower($texto);
    if (strpos($textoNormalizado, 'experiencia') !== false) return 'green_r';
    if (strpos($textoNormalizado, 'operador') !== false)   return 'blue_r';
    if (strpos($textoNormalizado, 'reserva') !== false)    return 'red_r';
    return 'blue_r';
};

// Iniciales del administrador para el topbar
$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales   = '';
$partes      = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS sistema admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/administrador.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="listado">

    <!-- ==========================================
         SIDEBAR ADMINISTRADOR
    =========================================== -->
    <nav class="adm-sidebar">

        <div class="adm-sidebar__logo">
            <div class="adm-sidebar__logo-icon">A</div>
            <div>
                <div class="adm-sidebar__logo-text">AVENTURA GO</div>
                <div class="adm-sidebar__logo-sub">Panel Admin</div>
            </div>
        </div>

        <div class="adm-sidebar__section-label">Principal</div>

        <a href="<?= BASE_URL ?>administrador/dashboard" class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-grid-1x2-fill adm-nav-item__icon"></i> Dashboard
        </a>

        <div class="adm-sidebar__section-label">Gestión</div>

        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turísticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
            <i class="bi bi-building adm-nav-item__icon"></i> Proveedores Hoteleros
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item">
            <i class="bi bi-person-badge adm-nav-item__icon"></i> Turistas
        </a>

        <div class="adm-sidebar__section-label">Soporte</div>

        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-nav-item">
            <i class="bi bi-headset adm-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>administrador/reporte" class="adm-nav-item">
            <i class="bi bi-file-earmark-bar-graph adm-nav-item__icon"></i> Reportes
        </a>
        <a href="<?= BASE_URL ?>administrador/perfil" class="adm-nav-item">
            <i class="bi bi-person-circle adm-nav-item__icon"></i> Mi Perfil
        </a>

    </nav>

    <!-- ==========================================
         ÁREA PRINCIPAL
    =========================================== -->
    <div class="adm-main">

        <!-- TOPBAR -->
        <header class="adm-topbar">

            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar reservas, usuarios, actividades..." class="adm-topbar__input" autocomplete="off">
            </div>

            <div class="adm-topbar__actions">

                <!-- Modo oscuro -->
                <button class="adm-icon-btn" id="adm-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="adm-dark-icon"></i>
                </button>

                <!-- Notificaciones -->
                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-icon-btn adm-icon-btn--notif" id="adm-notif-btn">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--notif" id="adm-notif-panel">
                        <div class="adm-dropdown__header">
                            <span class="adm-dropdown__title">Notificaciones</span>
                            <button class="adm-dropdown__mark-all">Marcar todas</button>
                        </div>
                        <div class="adm-notif-list">
                            <div class="adm-notif-item adm-notif-item--unread">
                                <div class="adm-notif-item__icon adm-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nueva reserva confirmada por <strong>Juan Pérez</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 1 hora</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                            <div class="adm-notif-item adm-notif-item--unread">
                                <div class="adm-notif-item__icon adm-notif-item__icon--amber"><i class="bi bi-person-plus-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nuevo proveedor pendiente de <strong>aprobación</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 3 horas</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                            <div class="adm-notif-item">
                                <div class="adm-notif-item__icon adm-notif-item__icon--blue"><i class="bi bi-ticket-perforated-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Ticket #42 requiere <strong>respuesta</strong>.</p>
                                    <span class="adm-notif-item__time">Ayer</span>
                                </div>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <!-- Perfil admin -->
                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-profile-btn" id="adm-profile-btn">
                        <div class="adm-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                        <div class="adm-profile-btn__info">
                            <span class="adm-profile-btn__name"><?= htmlspecialchars($nombreAdmin) ?></span>
                            <span class="adm-profile-btn__role">Administrador</span>
                        </div>
                        <i class="bi bi-chevron-down adm-profile-btn__chevron" id="adm-profile-chevron"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--profile" id="adm-profile-panel">
                        <div class="adm-dropdown__user-header">
                            <div class="adm-profile-btn__avatar adm-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                            <div>
                                <div class="adm-dropdown__user-name"><?= htmlspecialchars($nombreAdmin) ?></div>
                                <div class="adm-dropdown__user-role">Administrador · AventuraGO</div>
                            </div>
                        </div>
                        <div class="adm-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>administrador/perfil" class="adm-dropdown__item">
                            <i class="bi bi-person-circle"></i> Mi perfil
                        </a>
                        <a href="<?= BASE_URL ?>administrador/cambiar-password" class="adm-dropdown__item">
                            <i class="bi bi-shield-lock"></i> Cambiar contraseña
                        </a>
                        <div class="adm-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="adm-dropdown__item adm-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ======================================
             CONTENIDO PRINCIPAL
        ======================================= -->
        <main class="adm-content"
              data-dashboard-url="<?= BASE_URL ?>administrador/dashboard/data">

            <!-- Saludo -->
            <div class="adm-greeting">
                <div class="adm-greeting__eyebrow">Panel de control</div>
                <h1 class="adm-greeting__name">¡Hola, <span><?= htmlspecialchars($nombreAdmin) ?>!</span></h1>
                <p class="adm-greeting__sub">Resumen general de AventuraGO</p>
            </div>

            <!-- ==============================
                 TARJETAS DE ESTADÍSTICAS
            =============================== -->
            <div class="adm-stats-grid">

                <div class="adm-stat-card">
                    <div class="adm-stat-card__icon adm-stat-card__icon--orange">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="adm-stat-card__label">Total de Reservas</div>
                    <div class="adm-stat-card__value"><?= number_format($totalReservas ?? 0) ?></div>
                </div>

                <div class="adm-stat-card">
                    <div class="adm-stat-card__icon adm-stat-card__icon--green">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="adm-stat-card__label">Reservas Diarias</div>
                    <div class="adm-stat-card__value"><?= number_format($reservasDiarias ?? 0) ?></div>
                </div>

                <div class="adm-stat-card">
                    <div class="adm-stat-card__icon adm-stat-card__icon--blue">
                        <i class="bi bi-globe-central-south-asia-fill"></i>
                    </div>
                    <div class="adm-stat-card__label">Experiencias Activas</div>
                    <div class="adm-stat-card__value"><?= number_format($experienciasActivas ?? 0) ?></div>
                </div>

                <div class="adm-stat-card adm-stat-card--featured">
                    <div class="adm-stat-card__icon adm-stat-card__icon--orange">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="adm-stat-card__label">Ingresos Disponibles</div>
                    <div class="adm-stat-card__value">$<?= number_format($ingresosDisponibles ?? 0, 2) ?></div>
                </div>

            </div>

            <!-- ==============================
                 LAYOUT PRINCIPAL: gráfico + panel
            =============================== -->
            <div class="adm-dashboard-grid">

                <!-- Columna izquierda -->
                <div class="adm-dashboard-main">

                    <!-- Resumen de reservas + gráfico -->
                    <div class="adm-card">

                        <div class="adm-card__header">
                            <h2 class="adm-card__title">Resumen de <span>Reservas</span></h2>
                            <button class="adm-btn-filtrar" id="adm-btn-filtrar">
                                <i class="bi bi-funnel"></i> Filtrar
                            </button>
                        </div>

                        <!-- Filtros — lógica y IDs originales intactos -->
                        <div id="filtros-reservas" style="display:none;" class="adm-filtros">
                            <form id="form-filtros">
                                <div class="adm-filtros__row">

                                    <div class="adm-filtros__group">
                                        <label for="filtro-tipo" class="adm-filtros__label">Período</label>
                                        <select id="filtro-tipo" class="adm-filtros__select">
                                            <option value="anio" selected>Año</option>
                                            <option value="mes">Mes</option>
                                        </select>
                                    </div>

                                    <div class="adm-filtros__group" id="filtro-anio-container">
                                        <label for="filtro-anio" class="adm-filtros__label">Año</label>
                                        <select id="filtro-anio" class="adm-filtros__select">
                                            <option value="">Todos</option>
                                            <?php
                                            $anioActual = date('Y');
                                            for ($a = $anioActual; $a >= 2020; $a--) {
                                                echo "<option value=\"$a\">$a</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="adm-filtros__group" id="filtro-mes-container" style="display:none;">
                                        <label for="filtro-mes" class="adm-filtros__label">Mes</label>
                                        <select id="filtro-mes" class="adm-filtros__select">
                                            <option value="">Todos</option>
                                            <?php
                                            $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                                            foreach ($meses as $i => $m) {
                                                echo "<option value=\"" . ($i+1) . "\">$m</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="adm-filtros__actions">
                                        <button type="button" id="aplicar-filtros" class="adm-btn-apply">
                                            <i class="bi bi-check-circle"></i> Aplicar
                                        </button>
                                        <button type="button" id="limpiar-filtros" class="adm-btn-clear">
                                            <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!-- Gráfico — canvas con ID original -->
                        <div class="adm-chart-wrap">
                            <canvas id="reservasChart"></canvas>
                        </div>

                        <!-- Tabla reservas recientes -->
                        <div class="adm-section-header" style="margin-top:24px;">
                            <h3 class="adm-section-title">Reservas <span>recientes</span></h3>
                        </div>

                        <div class="adm-table-wrap">
                            <table class="adm-table">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Precio</th>
                                        <th>Experiencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($reservasRecientes)): ?>
                                        <?php foreach ($reservasRecientes as $r): ?>
                                            <tr>
                                                <td>
                                                    <div class="adm-table__name"><?= htmlspecialchars($r['cliente']) ?></div>
                                                </td>
                                                <td><?= htmlspecialchars($r['fecha']) ?></td>
                                                <td><span class="adm-table__price">$<?= htmlspecialchars($r['precio']) ?></span></td>
                                                <td><?= htmlspecialchars($r['experiencia']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="adm-empty-state">
                                                    <i class="bi bi-calendar-x adm-empty-state__icon"></i>
                                                    <p>No se encontraron reservas recientes.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div><!-- /.adm-card -->

                    <!-- Última reserva -->
                    <div class="adm-card adm-card--last-booking">
                        <div class="adm-card__header">
                            <h2 class="adm-card__title">Última <span>Reserva</span></h2>
                        </div>
                        <div class="adm-table-wrap">
                            <table class="adm-table">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Precio</th>
                                        <th>Experiencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ultimaReserva)): ?>
                                        <tr>
                                            <td><div class="adm-table__name"><?= htmlspecialchars($ultimaReserva['cliente']) ?></div></td>
                                            <td><?= htmlspecialchars($ultimaReserva['fecha']) ?></td>
                                            <td><span class="adm-table__price">$<?= htmlspecialchars($ultimaReserva['precio']) ?></span></td>
                                            <td><?= htmlspecialchars($ultimaReserva['experiencia']) ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center" style="padding:20px; color:var(--adm-muted);">Sin reservas recientes</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!-- /.adm-dashboard-main -->

                <!-- Columna derecha: panel resumen -->
                <aside class="adm-dashboard-aside">

                    <!-- Ingresos destacados -->
                    <div class="adm-income-card">
                        <div class="adm-income-card__eyebrow">Ingresos totales</div>
                        <div class="adm-income-card__amount">$<?= number_format($ingresosDisponibles ?? 0, 2) ?></div>
                        <div class="adm-income-card__label">Disponibles ahora</div>
                    </div>

                    <!-- Próximos pagos -->
                    <div class="adm-card adm-card--compact">
                        <div class="adm-card__header">
                            <h3 class="adm-card__title">Próximos <span>Pagos</span></h3>
                        </div>
                        <?php if (empty($proximosPagos)): ?>
                            <p class="adm-empty-text">No hay pagos próximos.</p>
                        <?php else: ?>
                            <ul class="adm-pagos-list">
                                <?php foreach ($proximosPagos as $pago): ?>
                                    <li class="adm-pagos-item">
                                        <span class="adm-pagos-dot adm-pagos-dot--<?= $getPagoColorClass($pago['texto'] ?? '') ?>"></span>
                                        <span class="adm-pagos-text"><?= htmlspecialchars($pago['texto']) ?></span>
                                        <span class="adm-pagos-amount">$<?= number_format($pago['cantidad'] ?? 0, 2) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Gráfico de gastos — canvas con ID original -->
                    <div class="adm-card adm-card--compact adm-card--chart">
                        <div class="adm-card__header">
                            <h3 class="adm-card__title">Estado de <span>Gastos</span></h3>
                        </div>
                        <div class="adm-chart-wrap adm-chart-wrap--sm">
                            <canvas id="gastosChart"></canvas>
                        </div>
                    </div>

                    <!-- Accesos rápidos -->
                    <div class="adm-card adm-card--compact">
                        <div class="adm-card__header">
                            <h3 class="adm-card__title">Accesos <span>rápidos</span></h3>
                        </div>
                        <div class="adm-quick-links">
                            <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-quick-link">
                                <i class="bi bi-person-badge"></i>
                                <span>Turistas</span>
                                <i class="bi bi-chevron-right adm-quick-link__arrow"></i>
                            </a>
                            <a href="<?= BASE_URL ?>administrador/tickets" class="adm-quick-link">
                                <i class="bi bi-headset"></i>
                                <span>Tickets soporte</span>
                                <i class="bi bi-chevron-right adm-quick-link__arrow"></i>
                            </a>
                            <a href="<?= BASE_URL ?>administrador/reporte" class="adm-quick-link">
                                <i class="bi bi-file-earmark-pdf"></i>
                                <span>Generar reporte</span>
                                <i class="bi bi-chevron-right adm-quick-link__arrow"></i>
                            </a>
                        </div>
                    </div>

                </aside><!-- /.adm-dashboard-aside -->

            </div><!-- /.adm-dashboard-grid -->

        </main>
    </div><!-- /.adm-main -->

</div><!-- /.adm-layout -->


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS original del dashboard admin — IDs intactos, lógica intacta -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/administrador.js"></script>

<script>
(function () {

    /* ─── MODO OSCURO ────────────────────────── */
    const body     = document.body;
    const darkBtn  = document.getElementById('adm-dark-toggle');
    const darkIcon = document.getElementById('adm-dark-icon');
    const DARK_KEY = 'adm_dark_mode';

    function applyDark(on) {
        body.classList.toggle('adm-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('adm-dark')));

    /* ─── DROPDOWNS ──────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.classList.toggle('adm-dropdown--open');
            if (chev) chev.classList.toggle('adm-profile-btn__chevron--open', open);
            document.querySelectorAll('.adm-dropdown--open').forEach(d => {
                if (d !== panel) {
                    d.classList.remove('adm-dropdown--open');
                    document.querySelectorAll('.adm-profile-btn__chevron--open')
                        .forEach(c => c.classList.remove('adm-profile-btn__chevron--open'));
                }
            });
        });
    }

    makeDropdown('adm-notif-btn',   'adm-notif-panel');
    makeDropdown('adm-profile-btn', 'adm-profile-panel', 'adm-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.adm-dropdown--open').forEach(d => d.classList.remove('adm-dropdown--open'));
        document.querySelectorAll('.adm-profile-btn__chevron--open')
            .forEach(c => c.classList.remove('adm-profile-btn__chevron--open'));
    });

    /* ─── NOTIFICACIONES ─────────────────────── */
    const markAll = document.querySelector('.adm-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.adm-notif-item--unread')
                .forEach(el => el.classList.remove('adm-notif-item--unread'));
            document.querySelector('.adm-icon-btn--notif')
                ?.classList.remove('adm-icon-btn--notif');
        });
    }

    /* ─── FILTROS — dispara el JS original ───── */
    const btnFiltrar = document.getElementById('adm-btn-filtrar');
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', () => {
            const panel = document.getElementById('filtros-reservas');
            if (panel) panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });
    }

    /* ─── BÚSQUEDA LOCAL EN TABLA ─────────────── */
    const searchInput = document.querySelector('.adm-topbar__input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            document.querySelectorAll('.adm-table tbody tr').forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }

})();
</script>

</body>
</html>