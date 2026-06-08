<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales   = '';
$partes      = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}

$fotoAdmin = trim((string) ($_SESSION['user']['foto'] ?? ''));
$usarFotoAdmin = $fotoAdmin !== '' && stripos($fotoAdmin, 'default') !== 0;
$avatarAdminUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoAdmin);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets de Soporte — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/tickets/listar.css">

    <!-- CSS unificado para listados admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/consultas_admin_unificado.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- SIDEBAR -->
    <nav class="adm-sidebar">
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
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item">
            <i class="bi bi-person-badge adm-nav-item__icon"></i> Turistas
        </a>

        <div class="adm-sidebar__section-label">Soporte</div>
        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-nav-item adm-nav-item--active">
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
                <input type="text" placeholder="Buscar tickets, asuntos, proveedores..." class="adm-topbar__input" id="adm-search-input" autocomplete="off">
            </div>

            <div class="adm-topbar__actions">
                <button class="adm-icon-btn" id="adm-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="adm-dark-icon"></i>
                </button>

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
                                <div class="adm-notif-item__icon adm-notif-item__icon--amber"><i class="bi bi-ticket-perforated-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nuevo ticket de soporte pendiente.</p>
                                    <span class="adm-notif-item__time">Hace 1 hora</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-profile-btn" id="adm-profile-btn">
                        <div class="adm-profile-btn__avatar">
                            <?php if ($usarFotoAdmin): ?>
                                <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                            <?php else: ?>
                                <?= htmlspecialchars($iniciales) ?>
                            <?php endif; ?>
                        </div>
                        <div class="adm-profile-btn__info">
                            <span class="adm-profile-btn__name"><?= htmlspecialchars($nombreAdmin) ?></span>
                            <span class="adm-profile-btn__role">Administrador</span>
                        </div>
                        <i class="bi bi-chevron-down adm-profile-btn__chevron" id="adm-profile-chevron"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--profile" id="adm-profile-panel">
                        <div class="adm-dropdown__user-header">
                            <div class="adm-profile-btn__avatar adm-profile-btn__avatar--lg">
                                <?php if ($usarFotoAdmin): ?>
                                    <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                                <?php else: ?>
                                    <?= htmlspecialchars($iniciales) ?>
                                <?php endif; ?>
                            </div>
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
                    <div class="adm-greeting__eyebrow">Soporte</div>
                    <h1 class="adm-page-title">Tickets de <span>Soporte</span></h1>
                    <p class="adm-greeting__sub">Gestiona y responde las solicitudes de soporte de usuarios y proveedores</p>
                </div>
            </div>

            <!-- Tarjetas resumen -->
            <?php
            $total       = count($tickets ?? []);
            $abiertos    = count(array_filter($tickets ?? [], fn($t) => $t['estado'] === 'abierto'));
            $respondidos = count(array_filter($tickets ?? [], fn($t) => $t['estado'] === 'respondido'));
            $cerrados    = count(array_filter($tickets ?? [], fn($t) => $t['estado'] === 'cerrado'));
            ?>
            <div class="adm-tk-stats">
                <div class="adm-tk-stat adm-tk-stat--featured">
                    <div class="adm-tk-stat__icon adm-tk-stat__icon--orange"><i class="bi bi-ticket-perforated-fill"></i></div>
                    <div>
                        <div class="adm-tk-stat__label">Total tickets</div>
                        <div class="adm-tk-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="adm-tk-stat">
                    <div class="adm-tk-stat__icon adm-tk-stat__icon--amber"><i class="bi bi-folder2-open"></i></div>
                    <div>
                        <div class="adm-tk-stat__label">Abiertos</div>
                        <div class="adm-tk-stat__value"><?= $abiertos ?></div>
                    </div>
                </div>
                <div class="adm-tk-stat">
                    <div class="adm-tk-stat__icon adm-tk-stat__icon--green"><i class="bi bi-chat-check-fill"></i></div>
                    <div>
                        <div class="adm-tk-stat__label">Respondidos</div>
                        <div class="adm-tk-stat__value"><?= $respondidos ?></div>
                    </div>
                </div>
                <div class="adm-tk-stat">
                    <div class="adm-tk-stat__icon adm-tk-stat__icon--blue"><i class="bi bi-archive-fill"></i></div>
                    <div>
                        <div class="adm-tk-stat__label">Cerrados</div>
                        <div class="adm-tk-stat__value"><?= $cerrados ?></div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="adm-tk-filters">
                <button class="adm-tk-filter adm-tk-filter--active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="adm-tk-filter" data-filter="abierto">
                    <i class="bi bi-folder2-open"></i> Abiertos
                </button>
                <button class="adm-tk-filter" data-filter="respondido">
                    <i class="bi bi-chat-check"></i> Respondidos
                </button>
                <button class="adm-tk-filter" data-filter="cerrado">
                    <i class="bi bi-archive"></i> Cerrados
                </button>
            </div>

            <!-- Tabla -->
            <div class="adm-section-header" style="margin-bottom:14px;">
                <h2 class="adm-section-title">Historial de <span>solicitudes</span></h2>
            </div>

            <div class="adm-table-wrap adm-table-wrap--card">
                <table class="adm-table" id="tabla-tickets">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proveedor / Usuario</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th style="text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tickets)): ?>
                            <tr>
                                <td colspan="6">
                                    <div class="adm-empty-state">
                                        <i class="bi bi-ticket-perforated adm-empty-state__icon"></i>
                                        <p>No hay tickets registrados aún.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr data-estado="<?= htmlspecialchars($ticket['estado']) ?>">
                                    <td>
                                        <span class="adm-tk-id">#<?= $ticket['id_ticket'] ?></span>
                                    </td>
                                    <td>
                                        <div class="adm-table__act-name"><?= htmlspecialchars($ticket['nombre']) ?></div>
                                    </td>
                                    <td>
                                        <div class="adm-table__act-name"><?= htmlspecialchars($ticket['asunto']) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($ticket['estado'] === 'abierto'): ?>
                                            <span class="adm-badge adm-badge--pending">
                                                <span class="adm-badge__dot"></span> Abierto
                                            </span>
                                        <?php elseif ($ticket['estado'] === 'respondido'): ?>
                                            <span class="adm-badge adm-badge--confirmed">
                                                <span class="adm-badge__dot"></span> Respondido
                                            </span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--cancelled">
                                                <span class="adm-badge__dot"></span> Cerrado
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                    <td>
                                        <div class="adm-pv-actions" style="justify-content:center;">
                                            <a href="<?= BASE_URL ?>administrador/tickets/responder?id=<?= $ticket['id_ticket'] ?>"
                                               class="adm-pv-btn adm-pv-btn--view" title="Responder">
                                                <i class="bi bi-reply-fill"></i>
                                            </a>
                                            <?php if ($ticket['estado'] !== 'cerrado'): ?>
                                                <a href="<?= BASE_URL ?>administrador/tickets/cerrar?id=<?= $ticket['id_ticket'] ?>"
                                                   class="adm-pv-btn adm-pv-btn--delete" title="Cerrar ticket"
                                                   onclick="return confirm('¿Cerrar este ticket?')">
                                                    <i class="bi bi-lock-fill"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>
>>>>>>> cca6e22ee7efef818c0c1da004b478e91235cc4b

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
            document.querySelectorAll('.adm-notif-item--unread').forEach(el => el.classList.remove('adm-notif-item--unread'));
            document.querySelector('.adm-icon-btn--notif')?.classList.remove('adm-icon-btn--notif');
        });
    }

    /* ─── FILTROS ─────────────────────────────── */
    const filtros = document.querySelectorAll('.adm-tk-filter');
    const filas   = document.querySelectorAll('#tabla-tickets tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('adm-tk-filter--active'));
            btn.classList.add('adm-tk-filter--active');
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

</body>
</html>

