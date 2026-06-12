<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';

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
    <title>Cuenta Pendiente — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
</head>

<body class="pv-body">

<div class="pv-layout">

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

        <div class="pv-sidebar__section-label">Mi Cuenta</div>
        <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-nav-item">
            <i class="bi bi-person-gear pv-nav-item__icon"></i> Completar Información
        </a>
        <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-nav-item">
            <i class="bi bi-person-circle pv-nav-item__icon"></i> Mi Perfil
        </a>

        <div class="pv-sidebar__section-label">Soporte</div>
        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-nav-item">
            <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>logout" class="pv-nav-item" style="margin-top:auto;">
            <i class="bi bi-box-arrow-right pv-nav-item__icon"></i> Cerrar sesión
        </a>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="pv-main">

        <!-- TOPBAR -->
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar..." class="pv-topbar__input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="pv-dark-icon"></i>
                </button>
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
                        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__item"><i class="bi bi-headset"></i> Soporte</a>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="pv-content" style="display:flex; align-items:center; justify-content:center;">

            <div style="max-width:560px; width:100%; text-align:center; padding: 40px 24px;">

                <!-- Ícono de estado -->
                <div style="width:96px;height:96px;border-radius:50%;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 28px;">
                    <i class="bi bi-hourglass-split" style="font-size:42px;color:#f59e0b;"></i>
                </div>

                <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:var(--pv-primary);font-weight:600;margin-bottom:8px;">
                    Estado de cuenta
                </div>

                <h1 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:2px;color:var(--pv-text);margin-bottom:16px;">
                    Cuenta pendiente de <span style="color:var(--pv-primary);">aprobación</span>
                </h1>

                <p style="color:var(--pv-muted);font-size:15px;line-height:1.6;margin-bottom:32px;">
                    Nuestro equipo está revisando tu información. En un plazo máximo de
                    <strong>7 días hábiles</strong> recibirás una notificación cuando tu cuenta sea activada.
                    Una vez aprobado, podrás registrar actividades turísticas y comenzar a recibir reservas.
                </p>

                <!-- Pasos -->
                <div style="background:var(--pv-surface);border:1px solid var(--pv-border);border-radius:var(--pv-radius-lg);padding:24px;margin-bottom:28px;text-align:left;">
                    <div style="font-weight:600;color:var(--pv-text);margin-bottom:16px;font-size:14px;">
                        <i class="bi bi-list-check" style="color:var(--pv-primary);margin-right:8px;"></i>
                        Pasos del proceso
                    </div>

                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#10b981;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-check-lg" style="color:#fff;font-size:13px;"></i>
                            </div>
                            <span style="font-size:14px;color:var(--pv-text);">Registro de cuenta completado</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:<?= (!empty($proveedor) && !empty($proveedor['nombre_empresa'])) ? '#10b981' : '#f59e0b' ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-<?= (!empty($proveedor) && !empty($proveedor['nombre_empresa'])) ? 'check-lg' : 'pencil' ?>" style="color:#fff;font-size:13px;"></i>
                            </div>
                            <span style="font-size:14px;color:var(--pv-text);">
                                Información de empresa completada
                                <?php if (empty($proveedor['nombre_empresa'])): ?>
                                    — <a href="<?= BASE_URL ?>proveedor/completar-informacion" style="color:var(--pv-primary);font-weight:600;">Completar ahora</a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--pv-border);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-clock" style="color:var(--pv-muted);font-size:13px;"></i>
                            </div>
                            <span style="font-size:14px;color:var(--pv-muted);">Revisión y aprobación por el administrador</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--pv-border);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-rocket-takeoff" style="color:var(--pv-muted);font-size:13px;"></i>
                            </div>
                            <span style="font-size:14px;color:var(--pv-muted);">Cuenta activa — publica actividades</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <a href="<?= BASE_URL ?>proveedor/completar-informacion"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--pv-primary);color:#fff;border-radius:8px;padding:12px 24px;font-size:14px;font-weight:600;text-decoration:none;transition:background .2s;">
                        <i class="bi bi-person-gear"></i> Completar información
                    </a>
                    <a href="<?= BASE_URL ?>proveedor/tickets"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--pv-surface);color:var(--pv-text);border:1px solid var(--pv-border);border-radius:8px;padding:12px 24px;font-size:14px;font-weight:600;text-decoration:none;">
                        <i class="bi bi-headset"></i> Contactar soporte
                    </a>
                </div>

                <p style="margin-top:24px;font-size:13px;color:var(--pv-muted);">
                    ¿Tienes dudas? Escríbenos a
                    <a href="mailto:soporte@aventurago.com" style="color:var(--pv-primary);">soporte@aventurago.com</a>
                </p>

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
        darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.classList.toggle('pv-dropdown--open');
            if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open);
        });
    }

    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });
})();
</script>

</body>
</html>
