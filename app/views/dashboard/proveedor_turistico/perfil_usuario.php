<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/helpers/alert_helper.php';
require_once BASE_PATH . '/app/controllers/perfil.php';

$id      = $_SESSION['user']['id_usuario'];
$usuario = mostrarPerfilProveedor($id);

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$fotoUrl = !empty($usuario['foto'])
    ? BASE_URL . 'public/uploads/usuario/' . $usuario['foto']
    : BASE_URL . 'public/assets/dashboard/administrador/perfil_usuario/img/default-avatar.png';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil — AventuraGO</title>

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
        /* ── PERFIL LAYOUT ── */
        .pv-pf-wrap {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ── TARJETA LATERAL ── */
        .pv-pf-card {
            background: var(--pv-surface, #fff);
            border: 1px solid var(--pv-border, #e2e8f0);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            text-align: center;
            padding-bottom: 20px;
        }
        .pv-pf-card__banner {
            height: 80px;
            background: linear-gradient(135deg, #1a2b3c 60%, #ea8217);
        }
        .pv-pf-avatar-wrap {
            margin-top: -44px;
            margin-bottom: 12px;
        }
        .pv-pf-avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }
        .pv-pf-card__name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            letter-spacing: .5px;
            color: var(--pv-text, #1a2b3c);
            margin: 0 0 4px;
            padding: 0 16px;
        }
        .pv-pf-card__role {
            font-size: .78rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 20px;
        }
        .pv-pf-nav { border-top: 1px solid var(--pv-border, #e2e8f0); }
        .pv-pf-nav-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 13px 20px;
            background: transparent;
            border: none;
            border-left: 3px solid transparent;
            text-align: left;
            font-size: .88rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
        }
        .pv-pf-nav-btn:hover { background: var(--pv-bg, #f8fafc); color: #1a2b3c; }
        .pv-pf-nav-btn.active { border-left-color: #ea8217; color: #ea8217; background: #fff7ed; }
        .pv-pf-nav-btn i { width: 18px; text-align: center; }

        /* ── PANELS ── */
        .pv-pf-panel {
            background: var(--pv-surface, #fff);
            border: 1px solid var(--pv-border, #e2e8f0);
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            overflow: hidden;
            display: none;
            animation: pvFadeIn .35s ease-out;
        }
        .pv-pf-panel.active { display: block; }

        @keyframes pvFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .pv-pf-panel__header {
            background: #1a2b3c;
            color: #fff;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border-bottom: 3px solid #ea8217;
        }
        .pv-pf-panel__header i { color: #ea8217; }
        .pv-pf-panel__body { padding: 28px; }

        /* ── INFO ROW ── */
        .pv-pf-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .pv-pf-info-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .pv-pf-info-value {
            font-size: .95rem;
            color: var(--pv-text, #1e293b);
            font-weight: 500;
        }

        /* ── FORM FIELDS ── */
        .pv-pf-label {
            display: block;
            font-size: .75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 7px;
        }
        .pv-pf-input {
            width: 100%;
            background: var(--pv-bg, #f8fafc);
            border: 1px solid var(--pv-border, #e2e8f0);
            border-radius: 8px;
            padding: 11px 15px;
            color: var(--pv-text, #1e293b);
            font-size: .91rem;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }
        .pv-pf-input:focus {
            outline: none;
            border-color: #ea8217;
            box-shadow: 0 0 0 3px rgba(234,130,23,.12);
            background: #fff;
        }

        /* password toggle wrap */
        .pv-pf-pw-wrap { position: relative; }
        .pv-pf-pw-wrap .pv-pf-input { padding-right: 44px; }
        .pv-pf-pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1rem;
            padding: 4px;
        }
        .pv-pf-pw-toggle:hover { color: #1a2b3c; }

        @media (max-width: 900px) {
            .pv-pf-wrap { grid-template-columns: 1fr; }
            .pv-pf-info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="pv-body">

<div class="pv-layout" id="proveedor-perfil">

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
        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-nav-item">
            <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-nav-item pv-nav-item--active">
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
                    <div class="pv-greeting__eyebrow">Cuenta</div>
                    <h1 class="pv-page-title">Mi <span>Perfil</span></h1>
                    <p class="pv-greeting__sub">Administra tu información personal y seguridad</p>
                </div>
            </div>

            <div class="pv-pf-wrap">

                <!-- TARJETA LATERAL -->
                <div class="pv-pf-card">
                    <div class="pv-pf-card__banner"></div>
                    <div class="pv-pf-avatar-wrap">
                        <img src="<?= htmlspecialchars($fotoUrl) ?>"
                             alt="Foto de perfil"
                             class="pv-pf-avatar"
                             onerror="this.src='<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/default-avatar.png'; this.onerror=null;">
                    </div>
                    <p class="pv-pf-card__name"><?= htmlspecialchars($usuario['nombre'] ?? $nombreProveedor) ?></p>
                    <p class="pv-pf-card__role">Proveedor Turístico</p>

                    <div class="pv-pf-nav">
                        <button class="pv-pf-nav-btn active" data-panel="info">
                            <i class="bi bi-person-lines-fill"></i> Información
                        </button>
                        <button class="pv-pf-nav-btn" data-panel="edit">
                            <i class="bi bi-pencil-square"></i> Editar Perfil
                        </button>
                        <button class="pv-pf-nav-btn" data-panel="password">
                            <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                        </button>
                    </div>
                </div>

                <!-- PANEL INFORMACIÓN -->
                <div class="pv-pf-panel active" id="panel-info">
                    <div class="pv-pf-panel__header">
                        <i class="bi bi-person-lines-fill"></i> Detalles del Perfil
                    </div>
                    <div class="pv-pf-panel__body">
                        <div class="pv-pf-info-grid">
                            <div class="pv-pf-info-item">
                                <div class="pv-pf-info-label"><i class="bi bi-person me-1"></i>Nombre completo</div>
                                <div class="pv-pf-info-value"><?= htmlspecialchars($usuario['nombre'] ?? '—') ?></div>
                            </div>
                            <div class="pv-pf-info-item">
                                <div class="pv-pf-info-label"><i class="bi bi-envelope me-1"></i>Correo electrónico</div>
                                <div class="pv-pf-info-value"><?= htmlspecialchars($usuario['email'] ?? '—') ?></div>
                            </div>
                            <div class="pv-pf-info-item">
                                <div class="pv-pf-info-label"><i class="bi bi-telephone me-1"></i>Teléfono</div>
                                <div class="pv-pf-info-value"><?= htmlspecialchars($usuario['telefono'] ?? '—') ?></div>
                            </div>
                            <div class="pv-pf-info-item">
                                <div class="pv-pf-info-label"><i class="bi bi-card-text me-1"></i>Identificación</div>
                                <div class="pv-pf-info-value"><?= htmlspecialchars($usuario['identificacion'] ?? '—') ?></div>
                            </div>
                            <div class="pv-pf-info-item">
                                <div class="pv-pf-info-label"><i class="bi bi-shield-check me-1"></i>Rol</div>
                                <div class="pv-pf-info-value">Proveedor Turístico</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PANEL EDITAR -->
                <div class="pv-pf-panel" id="panel-edit">
                    <div class="pv-pf-panel__header">
                        <i class="bi bi-pencil-square"></i> Editar Perfil
                    </div>
                    <div class="pv-pf-panel__body">
                        <form action="<?= BASE_URL ?>proveedor/actualizar-perfil" method="POST" enctype="multipart/form-data">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="pv-pf-label">Foto de perfil</label>
                                    <input type="file" name="foto" class="pv-pf-input" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-pf-label">Nombre completo</label>
                                    <input type="text" name="nombre" class="pv-pf-input"
                                           value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-pf-label">Correo electrónico</label>
                                    <input type="email" name="email" class="pv-pf-input"
                                           value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-pf-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="pv-pf-input"
                                           value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-pf-label">Identificación</label>
                                    <input type="text" name="identificacion" class="pv-pf-input"
                                           value="<?= htmlspecialchars($usuario['identificacion'] ?? '') ?>">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="pv-btn-primary">
                                        <i class="bi bi-floppy"></i> Guardar cambios
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- PANEL CONTRASEÑA -->
                <div class="pv-pf-panel" id="panel-password">
                    <div class="pv-pf-panel__header">
                        <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                    </div>
                    <div class="pv-pf-panel__body">
                        <form action="<?= BASE_URL ?>proveedor/cambiar-password" method="POST">
                            <input type="hidden" name="accion" value="cambiar_password">

                            <div class="row g-3" style="max-width:480px;">
                                <div class="col-12">
                                    <label class="pv-pf-label">Contraseña actual</label>
                                    <div class="pv-pf-pw-wrap">
                                        <input type="password" id="clave_actual" name="clave_actual"
                                               class="pv-pf-input" placeholder="Contraseña actual" required>
                                        <button type="button" class="pv-pf-pw-toggle" data-target="clave_actual">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="pv-pf-label">Nueva contraseña</label>
                                    <div class="pv-pf-pw-wrap">
                                        <input type="password" id="clave_nueva" name="clave_nueva"
                                               class="pv-pf-input" placeholder="Nueva contraseña" required minlength="6">
                                        <button type="button" class="pv-pf-pw-toggle" data-target="clave_nueva">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="pv-pf-label">Confirmar contraseña</label>
                                    <div class="pv-pf-pw-wrap">
                                        <input type="password" id="confirmar" name="confirmar"
                                               class="pv-pf-input" placeholder="Repite la nueva contraseña" required minlength="6">
                                        <button type="button" class="pv-pf-pw-toggle" data-target="confirmar">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="pv-btn-primary">
                                        <i class="bi bi-lock"></i> Cambiar contraseña
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div><!-- /pv-pf-wrap -->

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

    /* ── Tabs de perfil ── */
    const navBtns = document.querySelectorAll('.pv-pf-nav-btn');
    const panels  = document.querySelectorAll('.pv-pf-panel');
    navBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            navBtns.forEach(b => b.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('panel-' + btn.dataset.panel).classList.add('active');
        });
    });

    /* ── Toggle contraseñas ── */
    document.querySelectorAll('.pv-pf-pw-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const icon  = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash-fill';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye-fill';
            }
        });
    });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
</body>
</html>
