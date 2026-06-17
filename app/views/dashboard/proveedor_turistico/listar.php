<?php require_once BASE_PATH . '/app/helpers/session_proveedor.php'; ?>
<?php
$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">

    <style>
        /* ── TABLA TICKETS ── */
        .pv-tk-table-wrap {
            background: var(--pv-surface, #fff);
            border-radius: 14px;
            border: 1px solid var(--pv-border, #e2e8f0);
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .pv-tk-table { width: 100%; border-collapse: collapse; font-size: .9rem; }

        .pv-tk-table thead tr { background: #1a2b3c; color: #fff; }

        .pv-tk-table th {
            padding: 13px 16px;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 600;
            border-bottom: 3px solid #ea8217;
        }

        .pv-tk-table tbody tr { border-bottom: 1px solid var(--pv-border, #f1f5f9); transition: background .15s; }
        .pv-tk-table tbody tr:hover { background: var(--pv-bg, #f8fafc); }
        .pv-tk-table td { padding: 13px 16px; vertical-align: middle; }

        .pv-tk-empty {
            text-align: center;
            color: #94a3b8;
            padding: 48px !important;
        }

        /* badges */
        .pv-tk-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .pv-tk-badge--open     { background: #fef9c3; color: #854d0e; }
        .pv-tk-badge--answered { background: #dcfce7; color: #166534; }
        .pv-tk-badge--closed   { background: #f1f5f9; color: #64748b; }

        /* action buttons */
        .pv-tk-actions { display: flex; gap: 6px; }

        .pv-tk-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 14px; border-radius: 7px; font-size: .8rem;
            font-weight: 600; text-decoration: none; border: none; cursor: pointer;
            transition: all .2s;
        }
        .pv-tk-btn--view    { background: #1a2b3c; color: #fff; }
        .pv-tk-btn--view:hover { background: #ea8217; color: #fff; }
        .pv-tk-btn--outline { background: transparent; border: 1px solid #cbd5e1; color: #64748b; }
        .pv-tk-btn--outline:hover { background: #f1f5f9; color: #1a2b3c; }

        /* modal response */
        .pv-tk-modal .modal-header { background: #1a2b3c; color: #fff; }
        .pv-tk-modal .modal-header .btn-close { filter: invert(1); }
        .pv-tk-modal .modal-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.15rem; letter-spacing: 1px; }

        .pv-tk-response-box {
            background: #fff7ed;
            border-left: 5px solid #ea8217;
            border-radius: 10px;
            padding: 18px 20px;
            font-size: .9rem;
            line-height: 1.75;
            color: #1e293b;
        }

        .pv-tk-asunto-tag {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: .83rem;
            color: #475569;
            margin-bottom: 14px;
        }
    </style>
</head>
<body class="pv-body">

<div class="pv-layout" id="proveedor-tickets">

    <!-- SIDEBAR -->
    <nav class="pv-sidebar">
        <div class="pv-sidebar__logo">
            <div class="pv-sidebar__logo-icon">A</div>
            <div>
                <div class="pv-sidebar__logo-text">AVENTURA GO</div>
                <div class="pv-sidebar__logo-sub">Proveedor Turístico</div>
            </div>
        </div>

        <div class="pv-sidebar__section-label">Panel</div>
        <a href="<?= BASE_URL ?>proveedor/dashboard" class="pv-nav-item">
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
        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-nav-item pv-nav-item--active">
            <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-nav-item">
            <i class="bi bi-person-circle pv-nav-item__icon"></i> Mi Perfil
        </a>
        <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-nav-item">
            <i class="bi bi-building pv-nav-item__icon"></i> Mi Empresa
        </a>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="pv-main">

        <!-- TOPBAR -->
        <header class="pv-topbar">

            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar tickets..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
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
                        <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-dropdown__item"><i class="bi bi-person-circle"></i> Mi perfil</a>
                        <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-dropdown__item"><i class="bi bi-compass"></i> Mis actividades</a>
                        <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-dropdown__item"><i class="bi bi-building"></i> Mi empresa</a>
                        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__item"><i class="bi bi-headset"></i> Soporte</a>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="pv-content">

            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Soporte</div>
                    <h1 class="pv-page-title">Mis <span>Tickets</span></h1>
                    <p class="pv-greeting__sub">Gestiona tus solicitudes de soporte al administrador</p>
                </div>
                <div class="pv-page-header__actions">
                    <a href="<?= BASE_URL ?>proveedor/tickets/crear" class="pv-btn-primary">
                        <i class="bi bi-plus-lg"></i> Nuevo Ticket
                    </a>
                </div>
            </div>

            <!-- Stats rápidas -->
            <?php
            $total      = count($tickets ?? []);
            $abiertos   = count(array_filter($tickets ?? [], fn($t) => $t['estado'] === 'abierto'));
            $respondidos = count(array_filter($tickets ?? [], fn($t) => $t['estado'] === 'respondido'));
            ?>
            <div class="pv-act-stats">
                <div class="pv-act-stat pv-act-stat--featured">
                    <div class="pv-act-stat__icon pv-act-stat__icon--orange"><i class="bi bi-ticket-perforated-fill"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Total</div>
                        <div class="pv-act-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon" style="background:#fef9c3;color:#854d0e;"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Abiertos</div>
                        <div class="pv-act-stat__value"><?= $abiertos ?></div>
                    </div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon pv-act-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Respondidos</div>
                        <div class="pv-act-stat__value"><?= $respondidos ?></div>
                    </div>
                </div>
            </div>

            <div class="pv-section-header" style="margin-bottom:14px;">
                <h2 class="pv-section-title">Listado de <span>tickets</span></h2>
            </div>

            <div class="pv-tk-table-wrap">
                <table class="pv-tk-table" id="tk-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tickets)): ?>
                            <tr>
                                <td colspan="5" class="pv-tk-empty">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                    No has creado ningún ticket aún
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tickets as $t): ?>
                                <tr>
                                    <td><strong>#<?= (int)$t['id_ticket'] ?></strong></td>
                                    <td><?= htmlspecialchars($t['asunto']) ?></td>
                                    <td>
                                        <?php if ($t['estado'] === 'abierto'): ?>
                                            <span class="pv-tk-badge pv-tk-badge--open">Abierto</span>
                                        <?php elseif ($t['estado'] === 'respondido'): ?>
                                            <span class="pv-tk-badge pv-tk-badge--answered">Respondido</span>
                                        <?php else: ?>
                                            <span class="pv-tk-badge pv-tk-badge--closed">Cerrado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($t['fecha_creacion'])) ?></td>
                                    <td>
                                        <div class="pv-tk-actions">
                                            <a href="<?= BASE_URL ?>proveedor/tickets/ver?id=<?= (int)$t['id_ticket'] ?>"
                                               class="pv-tk-btn pv-tk-btn--view">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                            <?php if (!empty($t['respuesta'])): ?>
                                                <button class="pv-tk-btn pv-tk-btn--outline"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-resp-<?= (int)$t['id_ticket'] ?>">
                                                    <i class="bi bi-chat-left-text"></i> Respuesta
                                                </button>
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

<!-- MODALES (fuera del layout) -->
<?php if (!empty($tickets)): ?>
    <?php foreach ($tickets as $t): ?>
        <?php if (!empty($t['respuesta'])): ?>
            <div class="modal fade pv-tk-modal" id="modal-resp-<?= (int)$t['id_ticket'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-chat-left-text me-2"></i>Respuesta del Administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="pv-tk-asunto-tag">
                                <strong>Ticket #<?= (int)$t['id_ticket'] ?> —</strong>
                                <?= htmlspecialchars($t['asunto']) ?>
                            </div>
                            <div class="pv-tk-response-box">
                                <?= nl2br(htmlspecialchars($t['respuesta'])) ?>
                            </div>
                            <?php if (!empty($t['fecha_respuesta'])): ?>
                                <p class="text-muted mt-3 mb-0" style="font-size:.78rem;">
                                    <i class="bi bi-clock me-1"></i>
                                    Respondido el <?= date('d/m/Y H:i', strtotime($t['fecha_respuesta'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const BASE_URL = "<?= BASE_URL ?>";
(function () {
    const body     = document.body;
    const darkBtn  = document.getElementById('pv-dark-toggle');
    const darkIcon = document.getElementById('pv-dark-icon');
    const DARK_KEY = 'pv_dark_mode';
    function applyDark(on) {
        body.classList.toggle('pv-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

    function makeDropdown(btnId, panelId, chevronId) {
        const btn = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.classList.toggle('pv-dropdown--open');
            if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open);
        });
    }
    makeDropdown('pv-notif-btn',   'pv-notif-panel');
    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');
    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });
    const markAll = document.querySelector('.pv-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread'));
        });
    }

    /* Búsqueda en tabla */
    const searchInput = document.getElementById('pv-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase();
            document.querySelectorAll('#tk-table tbody tr').forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
