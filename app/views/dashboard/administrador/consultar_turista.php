<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/turista.php';

$datos = listarTuristas();

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
    <title>Gestión de Turistas — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_turista/consultar_turista.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- SIDEBAR -->
    <nav class="adm-sidebar responsive-sidebar">
        <div class="adm-sidebar__logo">
            <div class="adm-sidebar__logo-icon">A</div>
            <div>
                <div class="adm-sidebar__logo-text">AVENTURA GO</div>
                <div class="adm-sidebar__logo-sub">Panel Admin</div>
            </div>
        </div>

        <div class="adm-sidebar__section-label">Principal</div>
        <a href="<?= BASE_URL ?>administrador/dashboard" class="adm-nav-item">
            <i class="bi bi-grid-1x2-fill adm-nav-item__icon"></i> Dashboard
        </a>

        <div class="adm-sidebar__section-label">Gestión</div>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turísticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
            <i class="bi bi-building adm-nav-item__icon"></i> Proveedores Hoteleros
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item adm-nav-item--active">
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

    <!-- ÁREA PRINCIPAL -->
    <div class="adm-main">

        <!-- TOPBAR -->
        <header class="adm-topbar">
            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar turistas, nombres, emails..." class="adm-topbar__input" id="adm-search-input" autocomplete="off">
            </div>

            <div class="adm-topbar__actions">
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
                                <div class="adm-notif-item__icon adm-notif-item__icon--blue"><i class="bi bi-person-plus-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nuevo turista registrado hoy.</p>
                                    <span class="adm-notif-item__time">Hace 30 min</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                            <div class="adm-notif-item">
                                <div class="adm-notif-item__icon adm-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Reserva confirmada por <strong>María López</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 2 horas</span>
                                </div>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <!-- Perfil -->
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

        <!-- CONTENIDO -->
        <main class="adm-content">

            <!-- Encabezado -->
            <div class="adm-page-header">
                <div>
                    <div class="adm-greeting__eyebrow">Gestión</div>
                    <h1 class="adm-page-title">Gestión de <span>Turistas</span></h1>
                    <p class="adm-greeting__sub">Consulta, edita o elimina los turistas registrados en la plataforma</p>
                </div>
                <div class="adm-page-header__actions">
                    <a href="<?= BASE_URL ?>administrador/reporte-turista?tipo=turista" class="adm-btn-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                    </a>
                </div>
            </div>

            <!-- Tarjetas resumen -->
            <?php
            $total    = count($datos ?? []);
            $activos  = count(array_filter($datos ?? [], fn($t) => strtolower($t['estado'] ?? '') === 'activo'));
            $inactivos = count(array_filter($datos ?? [], fn($t) => strtolower($t['estado'] ?? '') === 'inactivo'));
            ?>
            <div class="adm-pv-stats">
                <div class="adm-pv-stat adm-pv-stat--featured">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--orange"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Total Turistas</div>
                        <div class="adm-pv-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--green"><i class="bi bi-person-check-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Activos</div>
                        <div class="adm-pv-stat__value"><?= $activos ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--red"><i class="bi bi-person-x-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Inactivos</div>
                        <div class="adm-pv-stat__value"><?= $inactivos ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--blue"><i class="bi bi-person-badge-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Registrados hoy</div>
                        <div class="adm-pv-stat__value">—</div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="adm-pv-filters">
                <button class="adm-pv-filter adm-pv-filter--active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="adm-pv-filter" data-filter="activo">
                    <i class="bi bi-check-circle"></i> Activos
                </button>
                <button class="adm-pv-filter" data-filter="inactivo">
                    <i class="bi bi-x-circle"></i> Inactivos
                </button>
            </div>

            <!-- Tabla -->
            <div class="adm-section-header" style="margin-bottom:14px;">
                <h2 class="adm-section-title">Listado de <span>turistas</span></h2>
            </div>

            <div class="adm-table-wrap adm-table-wrap--card">
                <table id="tablaAdmin" class="adm-table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Género</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos)): ?>
                            <?php foreach ($datos as $turista): ?>
                                <tr data-estado="<?= strtolower($turista['estado'] ?? 'activo') ?>">

                                    <!-- Foto -->
                                    <td>
                                        <div class="adm-turista-avatar">
                                            <?php if (!empty($turista['foto'])): ?>
                                                <img src="<?= BASE_URL ?>public/uploads/usuario/<?= htmlspecialchars($turista['foto']) ?>"
                                                     alt="<?= htmlspecialchars($turista['nombre']) ?>"
                                                     class="adm-turista-avatar__img">
                                            <?php else: ?>
                                                <div class="adm-turista-avatar__initials">
                                                    <?php
                                                    $np = explode(' ', trim($turista['nombre']));
                                                    echo mb_strtoupper(mb_substr($np[0] ?? '', 0, 1) . mb_substr($np[1] ?? '', 0, 1));
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Nombre -->
                                    <td>
                                        <div class="adm-table__act-name"><?= htmlspecialchars($turista['nombre']) ?></div>
                                    </td>

                                    <!-- Género -->
                                    <td>
                                        <span class="adm-genero-chip adm-genero-chip--<?= strtolower($turista['genero'] ?? 'otro') ?>">
                                            <?= htmlspecialchars($turista['genero'] ?? '—') ?>
                                        </span>
                                    </td>

                                    <!-- Teléfono -->
                                    <td><?= htmlspecialchars($turista['telefono'] ?? '—') ?></td>

                                    <!-- Email -->
                                    <td class="adm-pv-email"><?= htmlspecialchars($turista['email']) ?></td>

                                    <!-- Estado -->
                                    <td>
                                        <?php $est = strtolower($turista['estado'] ?? 'activo'); ?>
                                        <?php if ($est === 'activo'): ?>
                                            <span class="adm-badge adm-badge--confirmed">
                                                <span class="adm-badge__dot"></span> Activo
                                            </span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--cancelled">
                                                <span class="adm-badge__dot"></span> Inactivo
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Acciones — hrefs originales intactos -->
                                    <td>
                                        <div class="adm-pv-actions">
                                            <a href="<?= BASE_URL ?>administrador/editar-turista?id=<?= $turista['id_usuario'] ?>"
                                               class="adm-pv-btn adm-pv-btn--edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>administrador/eliminar-turista?accion=eliminar&id=<?= $turista['id_usuario'] ?>"
                                               class="adm-pv-btn adm-pv-btn--delete" title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de eliminar este turista?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="adm-empty-state">
                                        <i class="bi bi-people adm-empty-state__icon"></i>
                                        <p>No hay turistas registrados aún.</p>
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

<!-- JS original del módulo -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_turista/consultar_turista.js"></script>

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

    /* ─── FILTROS ─────────────────────────────── */
    const filtros = document.querySelectorAll('.adm-pv-filter');
    const filas   = document.querySelectorAll('#tablaAdmin tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('adm-pv-filter--active'));
            btn.classList.add('adm-pv-filter--active');
            const f = btn.dataset.filter;
            filas.forEach(row => {
                row.style.display = (f === 'all' || row.dataset.estado === f) ? '' : 'none';
            });
        });
    });

    /* ─── BÚSQUEDA ───────────────────────────── */
    const searchInput = document.getElementById('adm-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            filas.forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }

})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>

</body>
</html>