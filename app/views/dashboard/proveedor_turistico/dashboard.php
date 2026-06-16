<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';

// Lógica intacta
$estadoBadgeClass = static function (string $estado): string {
    if ($estado === 'confirmada') return 'pv-badge pv-badge--confirmed';
    if ($estado === 'pendiente')  return 'pv-badge pv-badge--pending';
    return 'pv-badge pv-badge--cancelled';
};

// Iniciales para el topbar
$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
$partes = explode(' ', trim($nombreProveedor));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Proveedor Turístico — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema proveedor -->

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
</head>

<body class="pv-body">

    <div class="pv-layout" id="listado">

        <!-- ==========================================
            SIDEBAR PROVEEDOR TURÍSTICO
        =========================================== -->
        <nav class="pv-sidebar">

            <div class="pv-sidebar__logo">
                <div class="pv-sidebar__logo-icon">A</div>
                <div>
                    <div class="pv-sidebar__logo-text">AVENTURA GO</div>
                    <div class="pv-sidebar__logo-sub">Proveedor Turístico</div>
                </div>
            </div>

            <div class="pv-sidebar__section-label">Panel</div>

            <a href="<?= BASE_URL ?>proveedor/dashboard" class="pv-nav-item pv-nav-item--active">
                <i class="bi bi-grid-1x2-fill pv-nav-item__icon"></i> Dashboard
            </a>

            <div class="pv-sidebar__section-label">Actividades</div>

            <a href="<?= BASE_URL ?>proveedor/registrar-actividad" class="pv-nav-item">
                <i class="bi bi-plus-circle pv-nav-item__icon"></i> Nueva Actividad
            </a>
            <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-nav-item">
                <i class="bi bi-compass pv-nav-item__icon"></i> Mis Actividades
            </a>
            <a href="<?= BASE_URL ?>proveedor/consultar-reservas" class="pv-nav-item">
                <i class="bi bi-calendar3 pv-nav-item__icon"></i> Reservas
            </a>
            <a href="<?= BASE_URL ?>proveedor/ingresos" class="pv-nav-item">
                <i class="bi bi-bar-chart-line pv-nav-item__icon"></i> Ingresos
            </a>

            <div class="pv-sidebar__section-label">Soporte</div>

            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-nav-item">
                <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
            </a>
            <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-nav-item">
                <i class="bi bi-person-circle pv-nav-item__icon"></i> Mi Perfil
            </a>
            <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-nav-item">
                <i class="bi bi-building pv-nav-item__icon"></i> Mi Empresa
            </a>

        </nav>

        <!-- ==========================================
            ÁREA PRINCIPAL
        =========================================== -->
        <div class="pv-main">

            <!-- TOPBAR -->
            <header class="pv-topbar">

                <div class="pv-topbar__search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Buscar actividades, reservas..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
                </div>

                <div class="pv-topbar__actions">

                    <!-- Modo oscuro -->
                    <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro">
                        <i class="bi bi-moon-fill" id="pv-dark-icon"></i>
                    </button>

                    <!-- Notificaciones -->
                    <div class="pv-topbar__dropdown-wrap">
                        <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn">
                            <i class="bi bi-bell-fill"></i>
                        </button>
                        <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                            <div class="pv-dropdown__header">
                                <span class="pv-dropdown__title">Notificaciones</span>
                                <button class="pv-dropdown__mark-all">Marcar todas</button>
                            </div>
                            <div class="pv-notif-list">
                                <div class="pv-notif-item pv-notif-item--unread">
                                    <div class="pv-notif-item__icon pv-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                    <div class="pv-notif-item__body">
                                        <p class="pv-notif-item__text">Nueva reserva confirmada en tu actividad.</p>
                                        <span class="pv-notif-item__time">Hace 1 hora</span>
                                    </div>
                                    <span class="pv-notif-item__dot"></span>
                                </div>
                                <div class="pv-notif-item pv-notif-item--unread">
                                    <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                    <div class="pv-notif-item__body">
                                        <p class="pv-notif-item__text">Tienes una reserva <strong>pendiente</strong> de confirmación.</p>
                                        <span class="pv-notif-item__time">Hace 3 horas</span>
                                    </div>
                                    <span class="pv-notif-item__dot"></span>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__footer">Ver todas las notificaciones</a>
                        </div>
                    </div>

                    <!-- Perfil -->
                    <div class="pv-topbar__dropdown-wrap">
                        <button class="pv-profile-btn" id="pv-profile-btn">
                            <div class="pv-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                            <div class="pv-profile-btn__info">
                                <span class="pv-profile-btn__name"><?= htmlspecialchars($nombreProveedor) ?></span>
                                <span class="pv-profile-btn__role">Proveedor Turístico</span>
                            </div>
                            <i class="bi bi-chevron-down pv-profile-btn__chevron" id="pv-profile-chevron"></i>
                        </button>
                        <div class="pv-dropdown pv-dropdown--profile" id="pv-profile-panel">
                            <div class="pv-dropdown__user-header">
                                <div class="pv-profile-btn__avatar pv-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                                <div>
                                    <div class="pv-dropdown__user-name"><?= htmlspecialchars($nombreProveedor) ?></div>
                                    <div class="pv-dropdown__user-role">Proveedor Turístico · AventuraGO</div>
                                </div>
                            </div>
                            <div class="pv-dropdown__divider"></div>
                            <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-dropdown__item">
                                <i class="bi bi-person-circle"></i> Mi perfil
                            </a>
                            <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-dropdown__item">
                                <i class="bi bi-compass"></i> Mis actividades
                            </a>
                            <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-dropdown__item">
                                <i class="bi bi-building"></i> Mi empresa
                            </a>
                            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__item">
                                <i class="bi bi-headset"></i> Soporte
                            </a>
                            <div class="pv-dropdown__divider"></div>
                            <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- CONTENIDO -->
            <main class="pv-content"
                data-dashboard-url="<?= BASE_URL ?>proveedor/dashboard/data">

                <!-- Saludo -->
                <div class="pv-greeting">
                    <div class="pv-greeting__eyebrow">Panel del Proveedor</div>
                    <h1 class="pv-greeting__name">
                        ¡Hola, <span><?= htmlspecialchars($nombreProveedor) ?>!</span>
                    </h1>
                    <p class="pv-greeting__sub">Gestiona tus experiencias, reservas e ingresos</p>
                </div>

                <!-- ── Tarjetas de estadísticas ── -->
                <div class="pv-stats-grid">

                    <div class="pv-stat-card">
                        <div class="pv-stat-card__icon pv-stat-card__icon--orange">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div class="pv-stat-card__label">Mis Servicios</div>
                        <div class="pv-stat-card__value"><?= number_format($totalServicios ?? 0) ?></div>
                    </div>

                    <div class="pv-stat-card">
                        <div class="pv-stat-card__icon pv-stat-card__icon--blue">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="pv-stat-card__label">Reservas</div>
                        <div class="pv-stat-card__value"><?= number_format($totalReservas ?? 0) ?></div>
                    </div>

                    <div class="pv-stat-card pv-stat-card--featured">
                        <div class="pv-stat-card__icon pv-stat-card__icon--orange">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="pv-stat-card__label">Ingresos Potenciales</div>
                        <div class="pv-stat-card__value">$<?= number_format($ingresosPotenciales ?? 0, 2) ?></div>
                    </div>

                    <div class="pv-stat-card">
                        <div class="pv-stat-card__icon pv-stat-card__icon--green">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="pv-stat-card__label">Estado</div>
                        <div class="pv-stat-card__value" style="font-size:18px; margin-top:4px;">
                            <span class="<?= $estadoBadgeClass($estado ?? '') ?>">
                                <span class="pv-badge__dot"></span>
                                <?= htmlspecialchars($estado ?? 'Sin estado') ?>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- ── Acciones rápidas ── -->
                <div class="pv-section-header">
                    <h2 class="pv-section-title">Acciones <span>rápidas</span></h2>
                </div>

                <div class="pv-quick-grid">
                    <a href="<?= BASE_URL ?>proveedor/registrar-actividad" class="pv-quick-card">
                        <div class="pv-quick-card__icon"><i class="bi bi-plus-circle-fill"></i></div>
                        <div>
                            <div class="pv-quick-card__label">Nueva actividad</div>
                            <div class="pv-quick-card__sub">Registra una nueva experiencia</div>
                        </div>
                        <i class="bi bi-chevron-right pv-quick-card__arrow"></i>
                    </a>
                    <a href="<?= BASE_URL ?>proveedor/consultar-reservas" class="pv-quick-card">
                        <div class="pv-quick-card__icon"><i class="bi bi-calendar-event"></i></div>
                        <div>
                            <div class="pv-quick-card__label">Ver reservas</div>
                            <div class="pv-quick-card__sub">Gestiona tus reservas activas</div>
                        </div>
                        <i class="bi bi-chevron-right pv-quick-card__arrow"></i>
                    </a>
                    <a href="<?= BASE_URL ?>proveedor/ingresos" class="pv-quick-card">
                        <div class="pv-quick-card__icon"><i class="bi bi-bar-chart-line"></i></div>
                        <div>
                            <div class="pv-quick-card__label">Ver ingresos</div>
                            <div class="pv-quick-card__sub">Consulta tus estadísticas</div>
                        </div>
                        <i class="bi bi-chevron-right pv-quick-card__arrow"></i>
                    </a>
                </div>

                <!-- ── Filtros y tabla de reservas ── -->
                <div class="pv-section-header">
                    <h2 class="pv-section-title">Listado de <span>Reservas</span></h2>
                    <button id="btn-filtrar" class="pv-btn-filtrar">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>

                <!-- Filtros — IDs originales intactos para el JS -->
                <div id="filtros-reservas" style="display:none;" class="pv-filtros">
                    <form id="form-filtros-proveedor">
                        <div class="pv-filtros__row">
                            <div class="pv-filtros__group">
                                <label class="pv-filtros__label">Período</label>
                                <select id="filtro-tipo-proveedor" class="pv-filtros__select">
                                    <option value="anio" selected>Año</option>
                                    <option value="mes">Mes</option>
                                </select>
                            </div>
                            <div class="pv-filtros__group" id="filtro-anio-container-proveedor">
                                <label class="pv-filtros__label">Año</label>
                                <select id="filtro-anio-proveedor" class="pv-filtros__select">
                                    <option value="">Todos</option>
                                    <?php
                                    $anioActual = date('Y');
                                    for ($a = $anioActual; $a >= 2020; $a--) {
                                        echo "<option value=\"$a\">$a</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="pv-filtros__group" id="filtro-mes-container-proveedor" style="display:none;">
                                <label class="pv-filtros__label">Mes</label>
                                <select id="filtro-mes-proveedor" class="pv-filtros__select">
                                    <option value="">Todos</option>
                                    <?php
                                    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                                    foreach ($meses as $i => $m) {
                                        echo "<option value=\"" . ($i+1) . "\">$m</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="pv-filtros__actions">
                                <button type="button" id="aplicar-filtros-proveedor" class="pv-btn-apply">
                                    <i class="bi bi-check-circle"></i> Aplicar
                                </button>
                                <button type="button" id="limpiar-filtros-proveedor" class="pv-btn-clear">
                                    <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla — IDs originales intactos para el JS -->
                <div class="pv-table-wrap">
                    <table class="pv-table" id="tabla-reservas-proveedor">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Experiencia</th>
                                <th>Personas</th>
                                <th>Precio Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reservasRecientes)): ?>
                                <?php foreach ($reservasRecientes as $r): ?>
                                    <tr>
                                        <td>
                                            <div class="pv-table__name"><?= htmlspecialchars($r['nombre_turista']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($r['fecha']) ?></td>
                                        <td><?= htmlspecialchars($r['nombre_actividad']) ?></td>
                                        <td>
                                            <span class="pv-personas">
                                                <i class="bi bi-people"></i>
                                                <?= htmlspecialchars($r['cantidad_personas']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="pv-precio">$<?= number_format((float)($r['precio'] ?? 0) * (int)($r['cantidad_personas'] ?? 1), 2) ?></span>
                                        </td>
                                        <td>
                                            <span class="<?= $estadoBadgeClass($r['estado'] ?? '') ?>">
                                                <span class="pv-badge__dot"></span>
                                                <?= htmlspecialchars($r['estado']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="pv-empty-state">
                                            <i class="bi bi-calendar-x pv-empty-state__icon"></i>
                                            <p>No hay reservas recientes.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS original del dashboard — IDs y data-* intactos -->
    <script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.js"></script>

    <script>
    (function () {

        /* ─── MODO OSCURO ────────────────────────── */
        const body     = document.body;
        const darkBtn  = document.getElementById('pv-dark-toggle');
        const darkIcon = document.getElementById('pv-dark-icon');
        const DARK_KEY = 'pv_dark_mode';

        function applyDark(on) {
            body.classList.toggle('pv-dark', on);
            darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
            localStorage.setItem(DARK_KEY, on ? '1' : '0');
        }

        applyDark(localStorage.getItem(DARK_KEY) === '1');
        darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

        /* ─── DROPDOWNS ──────────────────────────── */
        function makeDropdown(btnId, panelId, chevronId) {
            const btn   = document.getElementById(btnId);
            const panel = document.getElementById(panelId);
            const chev  = chevronId ? document.getElementById(chevronId) : null;
            if (!btn || !panel) return;
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const open = panel.classList.toggle('pv-dropdown--open');
                if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open);
                document.querySelectorAll('.pv-dropdown--open').forEach(d => {
                    if (d !== panel) {
                        d.classList.remove('pv-dropdown--open');
                        document.querySelectorAll('.pv-profile-btn__chevron--open')
                            .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
                    }
                });
            });
        }

        makeDropdown('pv-notif-btn',   'pv-notif-panel');
        makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

        document.addEventListener('click', () => {
            document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
            document.querySelectorAll('.pv-profile-btn__chevron--open')
                .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
        });

        /* ─── NOTIFICACIONES ─────────────────────── */
        const markAll = document.querySelector('.pv-dropdown__mark-all');
        if (markAll) {
            markAll.addEventListener('click', () => {
                document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread'));
                document.querySelector('.pv-icon-btn--notif')?.classList.remove('pv-icon-btn--notif');
            });
        }

        /* ─── BOTÓN FILTRAR ──────────────────────── */
        const btnFiltrar = document.getElementById('btn-filtrar');
        if (btnFiltrar) {
            btnFiltrar.addEventListener('click', () => {
                const panel = document.getElementById('filtros-reservas');
                if (panel) panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
            });
        }

        /* ─── BÚSQUEDA ───────────────────────────── */
        const searchInput = document.getElementById('pv-search-input');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                const q = searchInput.value.toLowerCase().trim();
                document.querySelectorAll('#tabla-reservas-proveedor tbody tr').forEach(row => {
                    row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
                });
            });
        }

    })();
    </script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
</body>
</html>