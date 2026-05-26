<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

require_once __DIR__ . '/../../../helpers/alert_helper.php';
require_once __DIR__ . '/../../../controllers/perfil.php';

/* ─────────────────────────────────────────────
   DATOS DEL ADMINISTRADOR
───────────────────────────────────────────── */
$id      = $_SESSION['user']['id_usuario'];
$usuario = mostrarPerfilAdmin($id);

/* Iniciales para topbar */
$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';

$iniciales = '';
$partes = explode(' ', trim($nombreAdmin));

foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}

$fotoPerfil = !empty($usuario['foto']) ? $usuario['foto'] : 'default.png';
$fotoPerfilUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoPerfil);
$tieneFotoPerfil = !empty($usuario['foto']) && $usuario['foto'] !== 'default.png';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi Perfil — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CSS Sistema -->
    <link rel="stylesheet"
        href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS Perfil -->
    <link rel="stylesheet"
        href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/perfil.css">

</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- ==========================================
         SIDEBAR
    =========================================== -->
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
            <i class="bi bi-grid-1x2-fill adm-nav-item__icon"></i>
            Dashboard
        </a>

        <div class="adm-sidebar__section-label">Gestión</div>

        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i>
            Proveedores Turísticos
        </a>

        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
            <i class="bi bi-building adm-nav-item__icon"></i>
            Proveedores Hoteleros
        </a>

        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item">
            <i class="bi bi-person-badge adm-nav-item__icon"></i>
            Turistas
        </a>

        <div class="adm-sidebar__section-label">Soporte</div>

        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-nav-item">
            <i class="bi bi-headset adm-nav-item__icon"></i>
            Tickets
        </a>

        <a href="<?= BASE_URL ?>administrador/reporte" class="adm-nav-item">
            <i class="bi bi-file-earmark-bar-graph adm-nav-item__icon"></i>
            Reportes
        </a>

        <a href="<?= BASE_URL ?>administrador/perfil"
            class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-person-circle adm-nav-item__icon"></i>
            Mi Perfil
        </a>

    </nav>

    <!-- ==========================================
         MAIN
    =========================================== -->
    <div class="adm-main">

        <!-- TOPBAR -->
        <header class="adm-topbar">

            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>

                <input type="text"
                    placeholder="Buscar..."
                    class="adm-topbar__input"
                    autocomplete="off">
            </div>

            <div class="adm-topbar__actions">

                <!-- Dark Mode -->
                <button class="adm-icon-btn"
                    id="adm-dark-toggle"
                    title="Modo oscuro">

                    <i class="bi bi-moon-fill"
                        id="adm-dark-icon"></i>
                </button>

                <!-- Notificaciones -->
                <div class="adm-topbar__dropdown-wrap">

                    <button class="adm-icon-btn adm-icon-btn--notif"
                        id="adm-notif-btn">

                        <i class="bi bi-bell-fill"></i>
                    </button>

                    <div class="adm-dropdown adm-dropdown--notif"
                        id="adm-notif-panel">

                        <div class="adm-dropdown__header">
                            <span class="adm-dropdown__title">
                                Notificaciones
                            </span>

                            <button class="adm-dropdown__mark-all">
                                Marcar todas
                            </button>
                        </div>

                        <div class="adm-notif-list">

                            <div class="adm-notif-item adm-notif-item--unread">

                                <div class="adm-notif-item__icon adm-notif-item__icon--green">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>

                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">
                                        Nuevo registro aprobado correctamente.
                                    </p>

                                    <span class="adm-notif-item__time">
                                        Hace 1 hora
                                    </span>
                                </div>

                                <span class="adm-notif-item__dot"></span>

                            </div>

                        </div>

                        <a href="<?= BASE_URL ?>administrador/tickets"
                            class="adm-dropdown__footer">

                            Ver todas las notificaciones
                        </a>

                    </div>
                </div>

                <!-- Perfil -->
                <div class="adm-topbar__dropdown-wrap">

                    <button class="adm-profile-btn"
                        id="adm-profile-btn">

                        <div class="adm-profile-btn__avatar">
                            <?php if ($tieneFotoPerfil): ?>
                                <img src="<?= htmlspecialchars($fotoPerfilUrl) ?>"
                                    alt="Avatar"
                                    class="adm-profile-btn__avatar-img">
                            <?php else: ?>
                                <?= htmlspecialchars($iniciales) ?>
                            <?php endif; ?>
                        </div>

                        <div class="adm-profile-btn__info">

                            <span class="adm-profile-btn__name">
                                <?= htmlspecialchars($nombreAdmin) ?>
                            </span>

                            <span class="adm-profile-btn__role">
                                Administrador
                            </span>

                        </div>

                        <i class="bi bi-chevron-down adm-profile-btn__chevron"
                            id="adm-profile-chevron"></i>

                    </button>

                    <div class="adm-dropdown adm-dropdown--profile"
                        id="adm-profile-panel">

                        <div class="adm-dropdown__user-header">

                            <div class="adm-profile-btn__avatar adm-profile-btn__avatar--lg">
                                <?php if ($tieneFotoPerfil): ?>
                                    <img src="<?= htmlspecialchars($fotoPerfilUrl) ?>"
                                        alt="Avatar"
                                        class="adm-profile-btn__avatar-img">
                                <?php else: ?>
                                    <?= htmlspecialchars($iniciales) ?>
                                <?php endif; ?>
                            </div>

                            <div>

                                <div class="adm-dropdown__user-name">
                                    <?= htmlspecialchars($nombreAdmin) ?>
                                </div>

                                <div class="adm-dropdown__user-role">
                                    Administrador · AventuraGO
                                </div>

                            </div>
                        </div>

                        <div class="adm-dropdown__divider"></div>

                        <a href="<?= BASE_URL ?>administrador/perfil"
                            class="adm-dropdown__item adm-dropdown__item--active">

                            <i class="bi bi-person-circle"></i>
                            Mi perfil
                        </a>

                        <a href="<?= BASE_URL ?>administrador/cambiar-password"
                            class="adm-dropdown__item">

                            <i class="bi bi-shield-lock"></i>
                            Cambiar contraseña
                        </a>

                        <div class="adm-dropdown__divider"></div>

                        <a href="<?= BASE_URL ?>logout"
                            class="adm-dropdown__item adm-dropdown__item--danger">

                            <i class="bi bi-box-arrow-right"></i>
                            Cerrar sesión
                        </a>

                    </div>

                </div>

            </div>

        </header>

        <!-- ======================================
             CONTENIDO PERFIL
        ======================================= -->
        <main class="adm-content">

            <!-- Header -->
            <div class="adm-page-header">

                <div>
                    <div class="adm-greeting__eyebrow">
                        Cuenta
                    </div>

                    <h1 class="adm-pf-title">
                        Mi <span>Perfil</span>
                    </h1>

                    <p class="adm-greeting__sub">
                        Gestiona tu información personal y seguridad
                    </p>
                </div>

            </div>

            <!-- Layout -->
            <div class="adm-pf-layout">

                <!-- ======================================
                     SIDEBAR PERFIL
                ======================================= -->
                <aside class="adm-pf-card">

                    <!-- Avatar -->
                    <div class="adm-pf-avatar-wrap adm-pf-avatar-wrap--clickable"
                        id="adm-pf-avatar-trigger"
                        role="button"
                        tabindex="0"
                        aria-label="Cambiar foto de perfil"
                        title="Cambiar foto de perfil">

                        <img src="<?= BASE_URL ?>public/uploads/usuario/<?= htmlspecialchars($usuario['foto'] ?? 'default.png') ?>"
                            alt="Foto perfil"
                            class="adm-pf-avatar"
                            id="adm-pf-preview">

                        <div class="adm-pf-avatar-badge">
                            <i class="bi bi-camera-fill"></i>
                        </div>

                    </div>

                    <div class="adm-pf-card__name">
                        <?= htmlspecialchars($usuario['nombre'] ?? $nombreAdmin) ?>
                    </div>

                    <div class="adm-pf-card__role">

                        <i class="bi bi-shield-check"></i>

                        <?= htmlspecialchars($usuario['rol'] ?? 'Administrador') ?>

                    </div>

                    <div class="adm-pf-card__divider"></div>

                    <!-- Navegación -->
                    <nav class="adm-pf-nav">

                        <button class="adm-pf-nav__btn adm-pf-nav__btn--active"
                            data-section="datos">

                            <i class="bi bi-person-lines-fill"></i>
                            Descripción General
                        </button>

                        <button class="adm-pf-nav__btn"
                            data-section="editar">

                            <i class="bi bi-pencil-square"></i>
                            Editar Perfil
                        </button>

                        <button class="adm-pf-nav__btn"
                            data-section="cambiar">

                            <i class="bi bi-shield-lock"></i>
                            Cambiar Contraseña
                        </button>

                    </nav>

                </aside>

                <!-- ======================================
                     PANELES
                ======================================= -->
                <div class="adm-pf-panels">

                    <!-- ======================================
                         PANEL DATOS
                    ======================================= -->
                    <div class="adm-pf-panel adm-pf-panel--active"
                        id="panel-datos">

                        <div class="adm-pf-panel__header">

                            <div class="adm-pf-panel__title">
                                <i class="bi bi-person-lines-fill"></i>
                                Detalles del Perfil
                            </div>

                        </div>

                        <div class="adm-pf-fields">

                            <div class="adm-pf-field">
                                <div class="adm-pf-field__label">
                                    Nombre Completo
                                </div>

                                <div class="adm-pf-field__value">
                                    <?= htmlspecialchars($usuario['nombre'] ?? '—') ?>
                                </div>
                            </div>

                            <div class="adm-pf-field">
                                <div class="adm-pf-field__label">
                                    Correo Electrónico
                                </div>

                                <div class="adm-pf-field__value">
                                    <?= htmlspecialchars($usuario['email'] ?? '—') ?>
                                </div>
                            </div>

                            <div class="adm-pf-field">
                                <div class="adm-pf-field__label">
                                    Teléfono
                                </div>

                                <div class="adm-pf-field__value">
                                    <?= htmlspecialchars($usuario['telefono'] ?? '—') ?>
                                </div>
                            </div>

                            <div class="adm-pf-field">
                                <div class="adm-pf-field__label">
                                    Identificación
                                </div>

                                <div class="adm-pf-field__value">
                                    <?= htmlspecialchars($usuario['identificacion'] ?? '—') ?>
                                </div>
                            </div>

                            <div class="adm-pf-field adm-pf-field--full">

                                <div class="adm-pf-field__label">
                                    Rol
                                </div>

                                <div class="adm-pf-field__value">

                                    <span class="adm-badge adm-badge--confirmed">

                                        <span class="adm-badge__dot"></span>

                                        <?= htmlspecialchars($usuario['rol'] ?? 'Administrador') ?>

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- ======================================
                         PANEL EDITAR
                    ======================================= -->
                    <div class="adm-pf-panel"
                        id="panel-editar">

                        <div class="adm-pf-panel__header">

                            <div class="adm-pf-panel__title">
                                <i class="bi bi-pencil-square"></i>
                                Editar Perfil
                            </div>

                        </div>

                        <!-- FORM ORIGINAL -->
                        <form action="<?= BASE_URL ?>administrador/actualizar-perfil"
                            method="POST"
                            enctype="multipart/form-data"
                            class="adm-pf-form">

                            <!-- Foto -->
                            <div class="adm-pf-form__photo-row">

                                <img src="<?= BASE_URL ?>public/uploads/usuario/<?= htmlspecialchars($usuario['foto'] ?? 'default.png') ?>"
                                    alt="Vista previa"
                                    class="adm-pf-form__photo-preview"
                                    id="adm-pf-edit-preview">

                                <div class="adm-pf-form__photo-actions">

                                    <label for="foto"
                                        class="adm-btn-outline"
                                        style="cursor:pointer;">

                                        <i class="bi bi-upload"></i>
                                        Cambiar foto
                                    </label>

                                    <input type="file"
                                        name="foto"
                                        id="foto"
                                        accept="image/*"
                                        style="display:none;">

                                </div>

                            </div>

                            <div class="adm-pf-form__grid">

                                <div class="adm-pf-form__group">

                                    <label class="adm-pf-form__label">
                                        Nombre Completo
                                    </label>

                                    <input type="text"
                                        name="nombre"
                                        class="adm-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>"
                                        required>

                                </div>

                                <div class="adm-pf-form__group">

                                    <label class="adm-pf-form__label">
                                        Correo Electrónico
                                    </label>

                                    <input type="email"
                                        name="email"
                                        class="adm-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['email'] ?? '') ?>"
                                        required>

                                </div>

                                <div class="adm-pf-form__group">

                                    <label class="adm-pf-form__label">
                                        Teléfono
                                    </label>

                                    <input type="number"
                                        name="telefono"
                                        class="adm-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">

                                </div>

                                <div class="adm-pf-form__group">

                                    <label class="adm-pf-form__label">
                                        Identificación
                                    </label>

                                    <input type="text"
                                        name="identificacion"
                                        class="adm-pf-form__input"
                                        value="<?= htmlspecialchars($usuario['identificacion'] ?? '') ?>">

                                </div>

                            </div>

                            <div class="adm-pf-form__footer">

                                <button type="submit"
                                    class="adm-btn-primary">

                                    <i class="bi bi-check-lg"></i>
                                    Guardar cambios
                                </button>

                            </div>

                        </form>

                    </div>

                    <!-- ======================================
                         PANEL CONTRASEÑA
                    ======================================= -->
                    <div class="adm-pf-panel"
                        id="panel-cambiar">

                        <div class="adm-pf-panel__header">

                            <div class="adm-pf-panel__title">
                                <i class="bi bi-shield-lock"></i>
                                Cambiar Contraseña
                            </div>

                        </div>

                        <!-- FORM ORIGINAL -->
                        <form action="<?= BASE_URL ?>administrador/cambiar-password"
                            method="POST"
                            class="adm-pf-form">

                            <input type="hidden"
                                name="accion"
                                value="cambiar_password">

                            <div class="adm-pf-form__group adm-pf-form__group--full">

                                <label class="adm-pf-form__label">
                                    Contraseña Actual
                                </label>

                                <div class="adm-pf-input-wrap">

                                    <input type="password"
                                        id="clave_actual"
                                        name="clave_actual"
                                        class="adm-pf-form__input"
                                        placeholder="Ingresa tu contraseña actual"
                                        required>

                                    <i class="bi bi-eye-fill adm-pf-toggle-pw"
                                        data-input="clave_actual"></i>

                                </div>

                            </div>

                            <div class="adm-pf-form__group adm-pf-form__group--full">

                                <label class="adm-pf-form__label">
                                    Nueva Contraseña
                                </label>

                                <div class="adm-pf-input-wrap">

                                    <input type="password"
                                        id="clave_nueva"
                                        name="clave_nueva"
                                        class="adm-pf-form__input"
                                        placeholder="Mínimo 6 caracteres"
                                        required
                                        minlength="6">

                                    <i class="bi bi-eye-fill adm-pf-toggle-pw"
                                        data-input="clave_nueva"></i>

                                </div>

                            </div>

                            <div class="adm-pf-form__group adm-pf-form__group--full">

                                <label class="adm-pf-form__label">
                                    Confirmar Nueva Contraseña
                                </label>

                                <div class="adm-pf-input-wrap">

                                    <input type="password"
                                        id="confirmar"
                                        name="confirmar"
                                        class="adm-pf-form__input"
                                        placeholder="Repite la nueva contraseña"
                                        required
                                        minlength="6">

                                    <i class="bi bi-eye-fill adm-pf-toggle-pw"
                                        data-input="confirmar"></i>

                                </div>

                            </div>

                            <div class="adm-pf-form__footer">

                                <button type="submit"
                                    class="adm-btn-primary">

                                    <i class="bi bi-shield-check"></i>
                                    Actualizar contraseña
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS ORIGINAL -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/perfil.js"></script>

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

    darkBtn.addEventListener('click', () => {
        applyDark(!body.classList.contains('adm-dark'));
    });

    /* ─── DROPDOWNS ─────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {

        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId
            ? document.getElementById(chevronId)
            : null;

        if (!btn || !panel) return;

        btn.addEventListener('click', (e) => {

            e.stopPropagation();

            const open = panel.classList.toggle('adm-dropdown--open');

            if (chev) {
                chev.classList.toggle(
                    'adm-profile-btn__chevron--open',
                    open
                );
            }

            document.querySelectorAll('.adm-dropdown--open')
                .forEach(d => {

                    if (d !== panel) {

                        d.classList.remove('adm-dropdown--open');

                        document.querySelectorAll('.adm-profile-btn__chevron--open')
                            .forEach(c => {
                                c.classList.remove('adm-profile-btn__chevron--open');
                            });
                    }
                });
        });
    }

    makeDropdown(
        'adm-notif-btn',
        'adm-notif-panel'
    );

    makeDropdown(
        'adm-profile-btn',
        'adm-profile-panel',
        'adm-profile-chevron'
    );

    document.addEventListener('click', () => {

        document.querySelectorAll('.adm-dropdown--open')
            .forEach(d => {
                d.classList.remove('adm-dropdown--open');
            });

        document.querySelectorAll('.adm-profile-btn__chevron--open')
            .forEach(c => {
                c.classList.remove('adm-profile-btn__chevron--open');
            });

    });

    /* ─── NOTIFICACIONES ────────────────────── */
    const markAll = document.querySelector('.adm-dropdown__mark-all');

    if (markAll) {

        markAll.addEventListener('click', () => {

            document.querySelectorAll('.adm-notif-item--unread')
                .forEach(el => {
                    el.classList.remove('adm-notif-item--unread');
                });

            document.querySelector('.adm-icon-btn--notif')
                ?.classList.remove('adm-icon-btn--notif');

        });
    }

    /* ─── NAVEGACIÓN DE PANELES ─────────────── */
    const navBtns = document.querySelectorAll('.adm-pf-nav__btn');
    const panels  = document.querySelectorAll('.adm-pf-panel');

    const activarSeccion = (target) => {

        navBtns.forEach(b => {
            b.classList.remove('adm-pf-nav__btn--active');
        });

        const btnObjetivo = document.querySelector('.adm-pf-nav__btn[data-section="' + target + '"]');
        if (btnObjetivo) {
            btnObjetivo.classList.add('adm-pf-nav__btn--active');
        }

        panels.forEach(p => {
            p.classList.remove('adm-pf-panel--active');
        });

        document.getElementById('panel-' + target)
            ?.classList.add('adm-pf-panel--active');
    };

    navBtns.forEach(btn => {

        btn.addEventListener('click', () => {
            activarSeccion(btn.dataset.section);

        });
    });

    // Permite abrir panel especifico desde URL, p.e. ?section=cambiar
    const params = new URLSearchParams(window.location.search);
    const sectionFromUrl = params.get('section');

    if (sectionFromUrl) {
        const targetBtn = document.querySelector('.adm-pf-nav__btn[data-section="' + sectionFromUrl + '"]');

        if (targetBtn) {
            activarSeccion(sectionFromUrl);
        }
    }

    // Click en avatar lateral: abre editar perfil y dispara selector de foto
    const avatarTrigger = document.getElementById('adm-pf-avatar-trigger');
    const triggerFoto = () => {
        activarSeccion('editar');
        setTimeout(() => {
            const input = document.getElementById('foto');
            if (input) {
                input.click();
            }
        }, 50);
    };

    if (avatarTrigger) {
        avatarTrigger.addEventListener('click', triggerFoto);
        avatarTrigger.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                triggerFoto();
            }
        });
    }

    /* ─── PREVIEW FOTO ──────────────────────── */
    const fileInput   = document.getElementById('foto');
    const editPreview = document.getElementById('adm-pf-edit-preview');
    const cardPreview = document.getElementById('adm-pf-preview');

    if (fileInput) {

        fileInput.addEventListener('change', function () {

            if (!this.files[0]) return;

            const reader = new FileReader();

            reader.onload = e => {

                if (editPreview) {
                    editPreview.src = e.target.result;
                }

                if (cardPreview) {
                    cardPreview.src = e.target.result;
                }

            };

            reader.readAsDataURL(this.files[0]);

        });
    }

    /* ─── OJITO PASSWORD ────────────────────── */
    document.querySelectorAll('.adm-pf-toggle-pw')
        .forEach(icon => {

            icon.addEventListener('click', () => {

                const input = document.getElementById(icon.dataset.input);

                if (!input) return;

                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';

                icon.className = isPassword
                    ? 'bi bi-eye-slash-fill adm-pf-toggle-pw'
                    : 'bi bi-eye-fill adm-pf-toggle-pw';

            });

        });

})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>

</body>
</html>