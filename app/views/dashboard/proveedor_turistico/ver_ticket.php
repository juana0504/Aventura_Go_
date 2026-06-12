<?php require_once BASE_PATH . '/app/helpers/session_proveedor.php'; ?>
<?php
/** @var array $ticket — set by TicketProveedorController::ver() before this view is required */
$ticket          = $ticket ?? [];
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
    <title>Ticket #<?= (int)($ticket['id_ticket'] ?? 0) ?> — AventuraGO</title>

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
        .pv-tk-detail-card {
            max-width: 820px;
            background: var(--pv-surface, #fff);
            border: 1px solid var(--pv-border, #e2e8f0);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            animation: pvFadeIn .4s ease-out;
        }
        @keyframes pvFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .pv-tk-detail-header {
            background: #1a2b3c;
            color: #fff;
            padding: 22px 28px;
            border-bottom: 3px solid #ea8217;
        }
        .pv-tk-detail-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 1px;
            margin: 0 0 8px;
        }
        .pv-tk-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            font-size: .8rem;
            color: #94a3b8;
        }
        .pv-tk-meta span { display: flex; align-items: center; gap: 5px; }

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

        .pv-tk-body { padding: 28px; }

        .pv-tk-section-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #94a3b8;
            margin-bottom: 10px;
        }
        .pv-tk-asunto-text {
            font-size: 1rem;
            font-weight: 700;
            color: var(--pv-text, #1a2b3c);
            margin-bottom: 22px;
        }
        .pv-tk-message-box {
            background: var(--pv-bg, #f8fafc);
            border: 1px solid var(--pv-border, #e2e8f0);
            border-radius: 10px;
            padding: 18px 22px;
            color: var(--pv-text, #334155);
            font-size: .92rem;
            line-height: 1.75;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .pv-tk-divider {
            border: none;
            border-top: 2px dashed var(--pv-border, #e2e8f0);
            margin: 28px 0;
        }
        .pv-tk-response-box {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-left: 5px solid #ea8217;
            border-radius: 10px;
            padding: 18px 22px;
            color: #1e293b;
            font-size: .92rem;
            line-height: 1.75;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .pv-tk-response-meta {
            font-size: .78rem;
            color: #94a3b8;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .pv-tk-waiting {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 36px;
            color: #94a3b8;
            text-align: center;
            gap: 10px;
        }
        .pv-tk-waiting i { font-size: 2rem; color: #cbd5e1; }
        .pv-tk-waiting p { margin: 0; font-size: .9rem; }

        .pv-tk-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: .88rem;
            font-weight: 500;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all .2s;
        }
        .pv-tk-back:hover { background: var(--pv-bg, #f1f5f9); color: #1a2b3c; }
    </style>
</head>
<body class="pv-body">

<div class="pv-layout" id="proveedor-ver-ticket">

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
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="pv-main">

        <!-- TOPBAR -->
        <header class="pv-topbar">

            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
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
                    <h1 class="pv-page-title">Detalle del <span>Ticket</span></h1>
                    <p class="pv-greeting__sub">Revisa tu solicitud y la respuesta del administrador</p>
                </div>
            </div>

            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-tk-back">
                <i class="bi bi-arrow-left"></i> Volver a mis tickets
            </a>

            <div class="pv-tk-detail-card">

                <!-- HEADER -->
                <div class="pv-tk-detail-header">
                    <h2><i class="bi bi-ticket-perforated me-2"></i>Ticket #<?= (int)$ticket['id_ticket'] ?></h2>
                    <div class="pv-tk-meta">
                        <span>
                            <?php
                            $estado = $ticket['estado'];
                            $cls = match($estado) {
                                'abierto'    => 'pv-tk-badge--open',
                                'respondido' => 'pv-tk-badge--answered',
                                default      => 'pv-tk-badge--closed',
                            };
                            $label = match($estado) {
                                'abierto'    => 'Abierto',
                                'respondido' => 'Respondido',
                                default      => 'Cerrado',
                            };
                            ?>
                            <span class="pv-tk-badge <?= $cls ?>"><?= $label ?></span>
                        </span>
                        <span><i class="bi bi-calendar3"></i><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></span>
                    </div>
                </div>

                <!-- BODY -->
                <div class="pv-tk-body">

                    <p class="pv-tk-section-label"><i class="bi bi-tag me-1"></i>Asunto</p>
                    <p class="pv-tk-asunto-text"><?= htmlspecialchars($ticket['asunto']) ?></p>

                    <p class="pv-tk-section-label"><i class="bi bi-chat-left-dots me-1"></i>Tu mensaje</p>
                    <div class="pv-tk-message-box"><?= htmlspecialchars($ticket['descripcion']) ?></div>

                    <hr class="pv-tk-divider">

                    <p class="pv-tk-section-label"><i class="bi bi-reply me-1"></i>Respuesta del administrador</p>

                    <?php if (!empty($ticket['respuesta'])): ?>
                        <div class="pv-tk-response-box"><?= htmlspecialchars($ticket['respuesta']) ?></div>
                        <?php if (!empty($ticket['fecha_respuesta'])): ?>
                            <p class="pv-tk-response-meta">
                                <i class="bi bi-clock"></i>
                                Respondido el <?= date('d/m/Y H:i', strtotime($ticket['fecha_respuesta'])) ?>
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="pv-tk-waiting">
                            <i class="bi bi-hourglass-split"></i>
                            <p>Aún no hay respuesta del administrador.</p>
                            <p style="font-size:.8rem;">Te notificaremos cuando tu ticket sea atendido.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
</body>
</html>
