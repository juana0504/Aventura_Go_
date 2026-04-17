<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Iniciales y nombre para el topbar
$nombreUsuario = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
$partes = explode(' ', trim($nombreUsuario));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/tickets/tickets.css">
</head>

<body class="ag-body">

<div class="ag-layout">

    <nav class="ag-sidebar">
        <div class="ag-sidebar__logo">
            <div class="ag-sidebar__logo-icon">A</div>
            <div>
                <div class="ag-sidebar__logo-text">AVENTURA GO</div>
                <div class="ag-sidebar__logo-sub">Panel Turista</div>
            </div>
        </div>
        <div class="ag-sidebar__section-label">Menú</div>
        <a href="<?= BASE_URL ?>turista/dashboard" class="ag-nav-item">
            <i class="bi bi-grid-1x2-fill ag-nav-item__icon"></i> Dashboard
        </a>
        <a href="<?= BASE_URL ?>turista/reservas" class="ag-nav-item">
            <i class="bi bi-calendar3 ag-nav-item__icon"></i> Ver reservas
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item ag-nav-item--active">
            <i class="bi bi-ticket-perforated ag-nav-item__icon"></i> Tickets
        </a>
    </nav>

    <div class="ag-main">

        <header class="ag-topbar">
            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar ayuda..." class="ag-topbar__input" autocomplete="off">
            </div>

            <div class="ag-topbar__actions">
                <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                </button>

                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-icon-btn ag-icon-btn--notif" id="ag-notif-btn">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--notif" id="ag-notif-panel">
                        <div class="ag-dropdown__header">
                            <span class="ag-dropdown__title">Notificaciones</span>
                        </div>
                        <div class="ag-notif-list">
                            <div class="ag-notif-item">
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">Bienvenido al centro de soporte.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-profile-btn" id="ag-profile-btn">
                        <div class="ag-profile-btn__avatar"><?= $iniciales ?></div>
                        <div class="ag-profile-btn__info">
                            <span class="ag-profile-btn__name"><?= htmlspecialchars($nombreUsuario) ?></span>
                            <span class="ag-profile-btn__role">Turista</span>
                        </div>
                        <i class="bi bi-chevron-down ag-profile-btn__chevron" id="ag-profile-chevron"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--profile" id="ag-profile-panel">
                        <div class="ag-dropdown__user-header">
                            <div class="ag-profile-btn__avatar ag-profile-btn__avatar--lg"><?= $iniciales ?></div>
                            <div>
                                <div class="ag-dropdown__user-name"><?= htmlspecialchars($nombreUsuario) ?></div>
                                <div class="ag-dropdown__user-role">Turista · AventuraGO</div>
                            </div>
                        </div>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>turista/perfil" class="ag-dropdown__item"><i class="bi bi-person-circle"></i> Mi perfil</a>
                        <a href="<?= BASE_URL ?>auth/logout" class="ag-dropdown__item ag-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="ag-content">
            <div class="ag-page-header">
                <div>
                    <div class="ag-greeting__eyebrow">Soporte</div>
                    <h1 class="ag-page-header__title">Crear <span>Ticket</span></h1>
                </div>
            </div>

            <div class="ag-ticket-form-card">
                <div class="ag-card-form">
                    <div class="ag-card-form__header">
                        <i class="bi bi-pencil-square"></i> Nueva Solicitud de Soporte
                    </div>
                    
                    <form method="POST" action="<?= BASE_URL ?>turista/guardar_ticket" class="ag-form">
                        <div class="ag-form-group">
                            <label class="ag-form-label">Asunto</label>
                            <input type="text" name="asunto" class="ag-form-control" placeholder="¿En qué podemos ayudarte?" required>
                        </div>

                        <div class="ag-form-group">
                            <label class="ag-form-label">Descripción</label>
                            <textarea name="descripcion" class="ag-form-control ag-form-textarea" rows="5" placeholder="Detalla tu problema aquí..." required></textarea>
                        </div>

                        <div class="ag-form-actions">
                            <button type="submit" class="ag-btn-primary">Enviar Ticket</button>
                            <a href="<?= BASE_URL ?>turista/tickets" class="ag-btn-back">Volver</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    // MODO OSCURO
    const body = document.body;
    const darkBtn = document.getElementById('ag-dark-toggle');
    const darkIcon = document.getElementById('ag-dark-icon');
    const DARK_KEY = 'ag_dark_mode';

    function applyDark(on) {
        body.classList.toggle('ag-dark', on);
        if(darkIcon) darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn?.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

    // DROPDOWNS (Perfil y Notificaciones)
    function makeDropdown(btnId, panelId, chevronId) {
        const btn = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = panel.classList.toggle('ag-dropdown--open');
            if (chev) chev.classList.toggle('ag-profile-btn__chevron--open', open);
            
            // Cerrar los otros
            document.querySelectorAll('.ag-dropdown--open').forEach(d => {
                if (d !== panel) d.classList.remove('ag-dropdown--open');
            });
        });
    }

    makeDropdown('ag-notif-btn', 'ag-notif-panel');
    makeDropdown('ag-profile-btn', 'ag-profile-panel', 'ag-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.ag-dropdown--open').forEach(d => d.classList.remove('ag-dropdown--open'));
        document.querySelectorAll('.ag-profile-btn__chevron--open').forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
    });
})();
</script>
</body>
</html>