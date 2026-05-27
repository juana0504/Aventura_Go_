<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

/** @var array $ticket Información del ticket desde el controlador */

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
    <title>Responder Ticket #<?= $ticket['id_ticket'] ?> — AventuraGO</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/tickets/responder.css">

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
                <input type="text" placeholder="Buscar..." class="adm-topbar__input" autocomplete="off">
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
                    <div class="adm-greeting__eyebrow">Soporte · Tickets</div>
                    <h1 class="adm-page-title">Ticket <span>#<?= $ticket['id_ticket'] ?></span></h1>
                    <p class="adm-greeting__sub">Revisa la solicitud y envía tu respuesta al usuario</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/tickets" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver a tickets
                </a>
            </div>

            <!-- Grid: info + formulario -->
            <div class="adm-reply-layout">

                <!-- ── Info del ticket ── -->
                <div class="adm-reply-info">

                    <div class="adm-reply-card">
                        <div class="adm-reply-card__header">
                            <i class="bi bi-ticket-perforated-fill"></i>
                            Información del Ticket
                        </div>
                        <div class="adm-reply-card__body">

                            <!-- Estado badge -->
                            <div class="adm-reply-status-row">
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
                            </div>

                            <div class="adm-reply-field">
                                <div class="adm-reply-field__label"><i class="bi bi-person-fill"></i> Proveedor / Usuario</div>
                                <div class="adm-reply-field__value"><?= htmlspecialchars($ticket['nombre'] ?? 'N/A') ?></div>
                            </div>

                            <div class="adm-reply-field">
                                <div class="adm-reply-field__label"><i class="bi bi-chat-square-text"></i> Asunto</div>
                                <div class="adm-reply-field__value"><?= htmlspecialchars($ticket['asunto']) ?></div>
                            </div>

                        </div>
                    </div>

                    <!-- Bloque: descripción del usuario -->
                    <div class="adm-reply-block adm-reply-block--query">
                        <div class="adm-reply-block__label">
                            <i class="bi bi-person-circle"></i> Consulta del usuario
                        </div>
                        <p class="adm-reply-block__text">
                            <?= nl2br(htmlspecialchars($ticket['descripcion'])) ?>
                        </p>
                    </div>

                </div>

                <!-- ── Formulario de respuesta ── -->
                <div class="adm-reply-form-wrap">

                    <div class="adm-reply-card">
                        <div class="adm-reply-card__header">
                            <i class="bi bi-reply-fill"></i>
                            Respuesta del Administrador
                        </div>
                        <div class="adm-reply-card__body">

                            <!-- Lógica intacta: action, method y names originales -->
                            <form method="POST" action="<?= BASE_URL ?>administrador/tickets/guardar-respuesta">
                                <input type="hidden" name="id_ticket" value="<?= $ticket['id_ticket'] ?>">

                                <div class="adm-form-group">
                                    <label class="adm-form-label">Tu respuesta</label>
                                    <textarea
                                        name="respuesta"
                                        class="adm-form-textarea"
                                        rows="8"
                                        placeholder="Escribe aquí tu respuesta detallada..."
                                        required><?= htmlspecialchars($ticket['respuesta'] ?? '') ?></textarea>
                                </div>

                                <div class="adm-reply-form-footer">
                                    <a href="<?= BASE_URL ?>administrador/tickets" class="adm-btn-back-sm">
                                        <i class="bi bi-arrow-left"></i> Cancelar
                                    </a>
                                    <button type="submit" class="adm-btn-send">
                                        <i class="bi bi-send-fill"></i> Enviar respuesta
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div><!-- /.adm-reply-layout -->

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>

<script>
(function () {
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

    const markAll = document.querySelector('.adm-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.adm-notif-item--unread').forEach(el => el.classList.remove('adm-notif-item--unread'));
            document.querySelector('.adm-icon-btn--notif')?.classList.remove('adm-icon-btn--notif');
        });
    }
})();
</script>

</body>
</html>

