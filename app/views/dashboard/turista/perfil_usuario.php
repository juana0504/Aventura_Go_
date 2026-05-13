<?php

require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once __DIR__ . '/../../../helpers/alert_helper.php';
require_once __DIR__ . '/../../../controllers/perfil.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id      = $_SESSION['user']['id_usuario'];
$usuario = mostrarPerfilTurista($id);

// Iniciales para el topbar
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
    <title>Mi Perfil — AventuraGO</title>

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

    <!-- CSS del sistema (sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">

    <!-- CSS específico del perfil -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/perfil_usuario/perfil.css">
</head>

<body class="ag-body">

<div class="ag-layout">

    <!-- ==========================================
         SIDEBAR
    =========================================== -->
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
        <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-nav-item">
            <i class="bi bi-calendar3 ag-nav-item__icon"></i> Ver reservas
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item">
            <i class="bi bi-ticket-perforated ag-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-nav-item">
            <i class="bi bi-heart ag-nav-item__icon"></i> Favoritos
        </a>
        <a href="<?= BASE_URL ?>turista/resenas" class="ag-nav-item">
            <i class="bi bi-star ag-nav-item__icon"></i> Reseñas
        </a>
    </nav>

    <!-- ==========================================
         ÁREA PRINCIPAL
    =========================================== -->
    <div class="ag-main">

        <!-- TOPBAR -->
        <header class="ag-topbar">
            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar..." class="ag-topbar__input" autocomplete="off">
            </div>

            <div class="ag-topbar__actions">

                <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                </button>

                <!-- Notificaciones -->
                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-icon-btn ag-icon-btn--notif" id="ag-notif-btn">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--notif" id="ag-notif-panel">
                        <div class="ag-dropdown__header">
                            <span class="ag-dropdown__title">Notificaciones</span>
                            <button class="ag-dropdown__mark-all">Marcar todas</button>
                        </div>
                        <div class="ag-notif-list">
                            <div class="ag-notif-item ag-notif-item--unread">
                                <div class="ag-notif-item__icon ag-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">Tu reserva de <strong>Rafting</strong> fue confirmada.</p>
                                    <span class="ag-notif-item__time">Hace 2 horas</span>
                                </div>
                                <span class="ag-notif-item__dot"></span>
                            </div>
                            <div class="ag-notif-item ag-notif-item--unread">
                                <div class="ag-notif-item__icon ag-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">Tienes una reserva <strong>pendiente</strong> de pago.</p>
                                    <span class="ag-notif-item__time">Hace 5 horas</span>
                                </div>
                                <span class="ag-notif-item__dot"></span>
                            </div>
                            <div class="ag-notif-item">
                                <div class="ag-notif-item__icon ag-notif-item__icon--blue"><i class="bi bi-star-fill"></i></div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">¿Cómo fue tu experiencia en <strong>Parapente</strong>?</p>
                                    <span class="ag-notif-item__time">Ayer</span>
                                </div>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>turista/notificaciones" class="ag-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <!-- Perfil dropdown -->
                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-profile-btn" id="ag-profile-btn">
                        <div class="ag-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                        <div class="ag-profile-btn__info">
                            <span class="ag-profile-btn__name"><?= htmlspecialchars($nombreUsuario) ?></span>
                            <span class="ag-profile-btn__role">Turista</span>
                        </div>
                        <i class="bi bi-chevron-down ag-profile-btn__chevron" id="ag-profile-chevron"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--profile" id="ag-profile-panel">
                        <div class="ag-dropdown__user-header">
                            <div class="ag-profile-btn__avatar ag-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                            <div>
                                <div class="ag-dropdown__user-name"><?= htmlspecialchars($nombreUsuario) ?></div>
                                <div class="ag-dropdown__user-role">Turista · AventuraGO</div>
                            </div>
                        </div>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>turista/perfil" class="ag-dropdown__item ag-dropdown__item--active">
                            <i class="bi bi-person-circle"></i> Mi perfil
                        </a>
                        <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-dropdown__item">
                            <i class="bi bi-calendar3"></i> Mis reservas
                        </a>
                        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-dropdown__item">
                            <i class="bi bi-heart"></i> Favoritos
                        </a>
                        <a href="<?= BASE_URL ?>turista/configuracion" class="ag-dropdown__item">
                            <i class="bi bi-gear"></i> Configuración
                        </a>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="ag-dropdown__item ag-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ======================================
             CONTENIDO DEL PERFIL
        ======================================= -->
        <main class="ag-content">

            <!-- Encabezado -->
            <div class="ag-page-header" style="margin-bottom:28px;">
                <div>
                    <div class="ag-greeting__eyebrow">Cuenta</div>
                    <h1 class="ag-pf-title">Mi <span>Perfil</span></h1>
                    <p class="ag-greeting__sub">Gestiona tu información personal y seguridad</p>
                </div>
            </div>

            <!-- Layout de dos columnas -->
            <div class="ag-pf-layout">

                <!-- ── Columna izquierda: tarjeta de usuario ── -->
                <aside class="ag-pf-card">

                    <!-- Foto -->
                    <div class="ag-pf-avatar-wrap">
                        <img
                            src="<?= BASE_URL ?>public/uploads/usuario/<?= htmlspecialchars($usuario['foto'] ?? 'default.png') ?>"
                            alt="Foto de perfil"
                            class="ag-pf-avatar"
                            id="ag-pf-preview">
                        <div class="ag-pf-avatar-badge"><i class="bi bi-camera-fill"></i></div>
                    </div>

                    <div class="ag-pf-card__name"><?= htmlspecialchars($usuario['nombre'] ?? $nombreUsuario) ?></div>
                    <div class="ag-pf-card__role">
                        <i class="bi bi-shield-check"></i>
                        <?= htmlspecialchars($usuario['rol'] ?? 'Turista') ?>
                    </div>

                    <div class="ag-pf-card__divider"></div>

                    <!-- Navegación de secciones -->
                    <nav class="ag-pf-nav">
                        <button class="ag-pf-nav__btn ag-pf-nav__btn--active" data-section="datos">
                            <i class="bi bi-person-lines-fill"></i> Descripción General
                        </button>
                        <button class="ag-pf-nav__btn" data-section="editar">
                            <i class="bi bi-pencil-square"></i> Editar Perfil
                        </button>
                        <button class="ag-pf-nav__btn" data-section="cambiar">
                            <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                        </button>
                    </nav>

                </aside>

                <!-- ── Columna derecha: paneles ── -->
                <div class="ag-pf-panels">

                    <!-- ====== PANEL: Descripción General ====== -->
                    <div class="ag-pf-panel ag-pf-panel--active" id="panel-datos">

                        <div class="ag-pf-panel__header">
                            <div class="ag-pf-panel__title">
                                <i class="bi bi-person-lines-fill"></i> Detalles del Perfil
                            </div>
                        </div>

                        <div class="ag-pf-fields">

                            <div class="ag-pf-field">
                                <div class="ag-pf-field__label">Nombre Completo</div>
                                <div class="ag-pf-field__value"><?= htmlspecialchars($usuario['nombre'] ?? '—') ?></div>
                            </div>

                            <div class="ag-pf-field">
                                <div class="ag-pf-field__label">Correo Electrónico</div>
                                <div class="ag-pf-field__value"><?= htmlspecialchars($usuario['email'] ?? '—') ?></div>
                            </div>

                            <div class="ag-pf-field">
                                <div class="ag-pf-field__label">Teléfono</div>
                                <div class="ag-pf-field__value"><?= htmlspecialchars($usuario['telefono'] ?? '—') ?></div>
                            </div>

                            <div class="ag-pf-field">
                                <div class="ag-pf-field__label">Identificación</div>
                                <div class="ag-pf-field__value"><?= htmlspecialchars($usuario['identificacion'] ?? '—') ?></div>
                            </div>

                            <div class="ag-pf-field ag-pf-field--full">
                                <div class="ag-pf-field__label">Rol</div>
                                <div class="ag-pf-field__value">
                                    <span class="ag-badge ag-badge--confirmed">
                                        <span class="ag-badge__dot"></span>
                                        <?= htmlspecialchars($usuario['rol'] ?? 'Turista') ?>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ====== PANEL: Editar Perfil ====== -->
                    <div class="ag-pf-panel" id="panel-editar">

                        <div class="ag-pf-panel__header">
                            <div class="ag-pf-panel__title">
                                <i class="bi bi-pencil-square"></i> Editar Perfil
                            </div>
                        </div>

                        <!-- Lógica intacta: action y method originales -->
                        <form action="/aventura_go/turista/actualizar-perfil" method="POST" enctype="multipart/form-data" class="ag-pf-form">

                            <!-- Preview de foto -->
                            <div class="ag-pf-form__photo-row">
                                <img
                                    src="<?= BASE_URL ?>public/uploads/usuario/<?= htmlspecialchars($usuario['foto'] ?? 'default.png') ?>"
                                    alt="Vista previa"
                                    class="ag-pf-form__photo-preview"
                                    id="ag-pf-edit-preview">
                                <div class="ag-pf-form__photo-actions">
                                    <label for="foto" class="ag-btn-outline" style="cursor:pointer;">
                                        <i class="bi bi-upload"></i> Cambiar foto
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*" style="display:none;">
                                </div>
                            </div>

                            <div class="ag-pf-form__grid">

                                <div class="ag-pf-form__group">
                                    <label class="ag-pf-form__label">Nombre Completo</label>
                                    <input type="text" name="nombre" class="ag-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" required>
                                </div>

                                <div class="ag-pf-form__group">
                                    <label class="ag-pf-form__label">Correo Electrónico</label>
                                    <input type="email" name="email" class="ag-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                                </div>

                                <div class="ag-pf-form__group">
                                    <label class="ag-pf-form__label">Teléfono</label>
                                    <input type="number" name="telefono" class="ag-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
                                </div>

                                <div class="ag-pf-form__group">
                                    <label class="ag-pf-form__label">Identificación</label>
                                    <input type="text" name="identificacion" class="ag-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['identificacion'] ?? '') ?>">
                                </div>

                            </div>

                            <div class="ag-pf-form__footer">
                                <button type="submit" class="ag-btn-primary">
                                    <i class="bi bi-check-lg"></i> Guardar cambios
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- ====== PANEL: Cambiar Contraseña ====== -->
                    <div class="ag-pf-panel" id="panel-cambiar">

                        <div class="ag-pf-panel__header">
                            <div class="ag-pf-panel__title">
                                <i class="bi bi-shield-lock"></i> Cambiar Contraseña
                            </div>
                        </div>

                        <!-- Lógica intacta: action, method y nombres de campos originales -->
                        <form action="/aventura_go/turista/cambiar-password" method="POST" class="ag-pf-form">

                            <input type="hidden" name="accion" value="cambiar_password">

                            <div class="ag-pf-form__group ag-pf-form__group--full">
                                <label class="ag-pf-form__label">Contraseña Actual</label>
                                <div class="ag-pf-input-wrap">
                                    <input type="password" id="clave_actual" name="clave_actual"
                                        class="ag-pf-form__input"
                                        placeholder="Ingresa tu contraseña actual" required>
                                    <i class="bi bi-eye-fill ag-pf-toggle-pw" data-input="clave_actual"></i>
                                </div>
                            </div>

                            <div class="ag-pf-form__group ag-pf-form__group--full">
                                <label class="ag-pf-form__label">Nueva Contraseña</label>
                                <div class="ag-pf-input-wrap">
                                    <input type="password" id="clave_nueva" name="clave_nueva"
                                        class="ag-pf-form__input"
                                        placeholder="Mínimo 6 caracteres" required minlength="6">
                                    <i class="bi bi-eye-fill ag-pf-toggle-pw" data-input="clave_nueva"></i>
                                </div>
                            </div>

                            <div class="ag-pf-form__group ag-pf-form__group--full">
                                <label class="ag-pf-form__label">Confirmar Nueva Contraseña</label>
                                <div class="ag-pf-input-wrap">
                                    <input type="password" id="confirmar" name="confirmar"
                                        class="ag-pf-form__input"
                                        placeholder="Repite la nueva contraseña" required minlength="6">
                                    <i class="bi bi-eye-fill ag-pf-toggle-pw" data-input="confirmar"></i>
                                </div>
                            </div>

                            <div class="ag-pf-form__footer">
                                <button type="submit" class="ag-btn-primary">
                                    <i class="bi bi-shield-check"></i> Actualizar contraseña
                                </button>
                            </div>

                        </form>
                    </div>

                </div><!-- /.ag-pf-panels -->
            </div><!-- /.ag-pf-layout -->

        </main>
    </div><!-- /.ag-main -->

</div><!-- /.ag-layout -->


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS original del perfil (ojito, etc.) — SE MANTIENE INTACTO -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/perfil.js"></script>

<script>
(function () {

    /* ─── MODO OSCURO ────────────────────────── */
    const body     = document.body;
    const darkBtn  = document.getElementById('ag-dark-toggle');
    const darkIcon = document.getElementById('ag-dark-icon');
    const DARK_KEY = 'ag_dark_mode';

    function applyDark(on) {
        body.classList.toggle('ag-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

    /* ─── DROPDOWNS ──────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = panel.classList.toggle('ag-dropdown--open');
            if (chev) chev.classList.toggle('ag-profile-btn__chevron--open', open);
            document.querySelectorAll('.ag-dropdown--open').forEach(d => {
                if (d !== panel) {
                    d.classList.remove('ag-dropdown--open');
                    document.querySelectorAll('.ag-profile-btn__chevron--open')
                        .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
                }
            });
        });
    }

    makeDropdown('ag-notif-btn',   'ag-notif-panel');
    makeDropdown('ag-profile-btn', 'ag-profile-panel', 'ag-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.ag-dropdown--open').forEach(d => d.classList.remove('ag-dropdown--open'));
        document.querySelectorAll('.ag-profile-btn__chevron--open')
            .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
    });

    const markAll = document.querySelector('.ag-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.ag-notif-item--unread')
                .forEach(el => el.classList.remove('ag-notif-item--unread'));
            document.querySelector('.ag-icon-btn--notif')
                ?.classList.remove('ag-icon-btn--notif');
        });
    }

    /* ─── NAVEGACIÓN DE SECCIONES DEL PERFIL ─── */
    const navBtns  = document.querySelectorAll('.ag-pf-nav__btn');
    const panels   = document.querySelectorAll('.ag-pf-panel');

    navBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.section;

            navBtns.forEach(b => b.classList.remove('ag-pf-nav__btn--active'));
            btn.classList.add('ag-pf-nav__btn--active');

            panels.forEach(p => p.classList.remove('ag-pf-panel--active'));
            document.getElementById('panel-' + target)?.classList.add('ag-pf-panel--active');
        });
    });

    /* ─── PREVIEW DE FOTO ─────────────────────── */
    const fileInput   = document.getElementById('foto');
    const editPreview = document.getElementById('ag-pf-edit-preview');
    const cardPreview = document.getElementById('ag-pf-preview');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (!this.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                if (editPreview) editPreview.src = e.target.result;
                if (cardPreview) cardPreview.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    }

    /* ─── OJITO MOSTRAR/OCULTAR CONTRASEÑA ──── */
    document.querySelectorAll('.ag-pf-toggle-pw').forEach(icon => {
        icon.addEventListener('click', () => {
            const input = document.getElementById(icon.dataset.input);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword
                ? 'bi bi-eye-slash-fill ag-pf-toggle-pw'
                : 'bi bi-eye-fill ag-pf-toggle-pw';
        });
    });

})();
</script>

</body>
</html>