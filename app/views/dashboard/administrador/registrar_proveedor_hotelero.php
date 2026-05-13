<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

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
    <title>Registrar Proveedor Hotelero — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sistema admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_hotelero.css">
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
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-building adm-nav-item__icon"></i> Proveedores Hoteleros
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item">
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
                                <div class="adm-notif-item__icon adm-notif-item__icon--amber"><i class="bi bi-person-plus-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nuevo proveedor hotelero pendiente de <strong>aprobación</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 2 horas</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

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
                    <div class="adm-greeting__eyebrow">Gestión · Proveedores Hoteleros</div>
                    <h1 class="adm-page-title">Registrar Proveedor <span>Hotelero</span></h1>
                    <p class="adm-greeting__sub">Completa los 5 pasos para registrar un nuevo proveedor hotelero</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>

            <!-- WIZARD -->
            <form id="formProveedor" action="<?= BASE_URL ?>administrador/guardar-proveedor-hotelero" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="registrar">

                <div class="adm-wizard">

                    <!-- Header wizard -->
                    <div class="adm-wizard__header">
                        <p class="adm-wizard__header-text">
                            <i class="bi bi-building-fill"></i>
                            Registro de Proveedor Hotelero
                        </p>
                    </div>

                    <!-- Pasos — clases originales para el JS -->
                    <div class="wizard-steps adm-wizard__steps">
                        <div class="step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Info Básica</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Representante</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Ubicación</div>
                        </div>
                        <div class="step" data-step="4">
                            <div class="step-circle">4</div>
                            <div class="step-label">Habitaciones</div>
                        </div>
                        <div class="step" data-step="5">
                            <div class="step-circle">5</div>
                            <div class="step-label">Documentación</div>
                        </div>
                    </div>

                    <!-- Contenido pasos -->
                    <div class="wizard-content adm-wizard__content">

                        <!-- PASO 1 — Info Básica + Tipo establecimiento -->
                        <div class="step-content active" data-step="1">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-building"></i></div>
                                <h4>Información Básica del Establecimiento</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label" for="nombre_establecimiento">Nombre del Establecimiento</label>
                                    <input type="text" name="nombre_establecimiento" id="nombre_establecimiento" class="adm-form-input" maxlength="100" placeholder="Ej: Hotel Aventura" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email</label>
                                    <input type="email" name="email" id="email" class="adm-form-input" placeholder="contacto@hotel.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono</label>
                                    <input type="tel" name="telefono" id="telefono" class="adm-form-input" placeholder="+57 300 123 4567" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Logo del Establecimiento</label>
                                    <input type="file" accept=".jpg,.png,.jpeg" name="logo" id="logo" class="adm-form-input adm-form-input--file" required>
                                </div>
                            </div>

                            <!-- Tipo de establecimiento -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-file-earmark-medical-fill"></i> Tipo de Establecimiento
                                </div>
                                <div class="adm-check-grid">
                                    <?php
                                    $establecimientos = [
                                        ['id' => 'hotel',    'valor' => 'Hotel',    'icon' => 'bi-building'],
                                        ['id' => 'cabana',   'valor' => 'Cabaña',   'icon' => 'bi-house-fill'],
                                        ['id' => 'hostal',   'valor' => 'Hostal',   'icon' => 'bi-door-open-fill'],
                                        ['id' => 'glamping', 'valor' => 'Glamping', 'icon' => 'bi-stars'],
                                    ];
                                    foreach ($establecimientos as $est): ?>
                                        <label class="adm-check-card" for="<?= $est['id'] ?>">
                                            <input class="adm-check-card__input" type="checkbox"
                                                   name="tipo_establecimiento[]"
                                                   id="<?= $est['id'] ?>"
                                                   value="<?= $est['valor'] ?>">
                                            <i class="bi <?= $est['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $est['valor'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 2 — Representante -->
                        <div class="step-content" data-step="2">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-person-fill"></i></div>
                                <h4>Datos del Representante</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre del Representante</label>
                                    <input type="text" name="nombre_representante" id="nombre_repre" class="adm-form-input" placeholder="Juan Pérez" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Tipo de Documento</label>
                                    <select name="tipo_documento" id="tipo_documento" class="adm-form-input adm-form-select form-select">
                                        <option value="" disabled selected hidden>Selecciona tipo</option>
                                        <option value="CC">CC</option>
                                        <option value="CE">CE</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Identificación</label>
                                    <input type="tel" name="identificacion_representante" id="identiificacion_repre" class="adm-form-input" placeholder="N.°" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Foto del Representante</label>
                                    <input type="file" accept=".jpg,.png,.jpeg" name="foto_representante" id="foto_representante" class="adm-form-input adm-form-input--file" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email del Representante</label>
                                    <input type="email" name="email_representante" id="email_repre" class="adm-form-input" placeholder="contacto@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono del Representante</label>
                                    <input type="tel" name="telefono_representante" id="telefono_repre" class="adm-form-input" placeholder="+57 300 123 4567" required>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 3 — Ubicación -->
                        <div class="step-content" data-step="3">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <h4>Ubicación del Establecimiento</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label" for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="adm-form-input adm-form-select" required>
                                        <option value="">Seleccione un departamento</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label" for="id_ciudad">Ciudad</label>
                                    <select name="id_ciudad" id="id_ciudad" class="adm-form-input adm-form-select" required>
                                        <option value="">Seleccione una ciudad</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="adm-form-label">Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="adm-form-input" placeholder="Calle 123 #45-67" required>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 4 — Tipo habitación + Servicios -->
                        <div class="step-content" data-step="4">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-door-open-fill"></i></div>
                                <h4>Habitaciones y Servicios</h4>
                            </div>

                            <!-- Tipo de habitación -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-file-earmark-medical-fill"></i> Tipo de Habitación
                                </div>
                                <div class="adm-check-grid adm-check-grid--5">
                                    <?php
                                    $habitaciones = ['Estandar' => 'Estándar', 'Doble' => 'Doble', 'Suite' => 'Suite', 'Familiar' => 'Familiar', 'Premium' => 'Premium'];
                                    foreach ($habitaciones as $id => $label): ?>
                                        <label class="adm-check-card" for="<?= $id ?>">
                                            <input class="adm-check-card__input" type="checkbox"
                                                   name="tipo_habitacion[]"
                                                   id="<?= $id ?>"
                                                   value="<?= $id ?>">
                                            <i class="bi bi-door-closed adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $label ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>

                                <div class="row g-3" style="margin-top:16px;">
                                    <div class="col-md-6">
                                        <label class="adm-form-label">Número Máximo de Huéspedes</label>
                                        <input type="tel" name="max_huesped" id="max_huesped" class="adm-form-input" placeholder="Ej: 40" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Servicios incluidos -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-stars"></i> Servicios Incluidos
                                </div>
                                <?php
                                $servicios = [
                                    ['id' => 'WiFi',                'label' => 'WiFi',               'icon' => 'bi-wifi'],
                                    ['id' => 'Parqueadero',         'label' => 'Parqueadero',         'icon' => 'bi-p-square-fill'],
                                    ['id' => 'Piscina',             'label' => 'Piscina',             'icon' => 'bi-water'],
                                    ['id' => 'Restaurante',         'label' => 'Restaurante',         'icon' => 'bi-cup-hot-fill'],
                                    ['id' => 'Bar',                 'label' => 'Bar',                 'icon' => 'bi-cup-straw'],
                                    ['id' => 'Spa',                 'label' => 'Spa',                 'icon' => 'bi-flower1'],
                                    ['id' => 'Pet Friendly',        'label' => 'Pet Friendly',        'icon' => 'bi-heart-fill'],
                                    ['id' => 'Servicio al cuarto',  'label' => 'Serv. al Cuarto',     'icon' => 'bi-bell-fill'],
                                    ['id' => 'Transporte',          'label' => 'Transporte',          'icon' => 'bi-bus-front-fill'],
                                    ['id' => 'Desayuno incluido',   'label' => 'Desayuno',            'icon' => 'bi-egg-fried'],
                                    ['id' => 'Accesibilidad',       'label' => 'Accesibilidad',       'icon' => 'bi-person-wheelchair'],
                                ];
                                ?>
                                <div class="adm-check-grid adm-check-grid--srv">
                                    <?php foreach ($servicios as $s): ?>
                                        <label class="adm-check-card adm-check-card--sm" for="<?= $s['id'] ?>">
                                            <input class="adm-check-card__input" type="checkbox"
                                                   name="servicio_incluido[]"
                                                   id="<?= $s['id'] ?>"
                                                   value="<?= $s['id'] ?>">
                                            <i class="bi <?= $s['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $s['label'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 5 — Documentación + Métodos de pago -->
                        <div class="step-content" data-step="5">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-file-alt"></i></div>
                                <h4>Documentación y Métodos de Pago</h4>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="adm-form-label">NIT / RUT</label>
                                    <input type="text" name="nit_rut" id="nit" class="adm-form-input" placeholder="123456789-0" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="adm-form-label">Cámara de Comercio</label>
                                    <input type="text" name="camara_comercio" id="camara_comercio" class="adm-form-input" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="adm-form-label">Licencia</label>
                                    <input type="text" name="licencia" id="licencia" class="adm-form-input" required>
                                </div>
                            </div>

                            <!-- Métodos de pago -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-credit-card-2-front-fill"></i> Métodos de Pago Aceptados
                                </div>
                                <?php
                                $pagos = [
                                    ['id' => 'Tarjeta de Crédito', 'label' => 'Tarjeta Crédito', 'icon' => 'bi-credit-card-fill'],
                                    ['id' => 'Tarjeta Débito',     'label' => 'Tarjeta Débito',   'icon' => 'bi-credit-card-2-back-fill'],
                                    ['id' => 'PSE',                'label' => 'PSE',               'icon' => 'bi-bank2'],
                                    ['id' => 'Nequi',              'label' => 'Nequi',             'icon' => 'bi-phone-fill'],
                                ];
                                ?>
                                <div class="adm-check-grid adm-check-grid--4">
                                    <?php foreach ($pagos as $p): ?>
                                        <label class="adm-check-card" for="<?= $p['id'] ?>">
                                            <input class="adm-check-card__input" type="checkbox"
                                                   name="metodo_pago[]"
                                                   id="<?= $p['id'] ?>"
                                                   value="<?= $p['id'] ?>">
                                            <i class="bi <?= $p['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $p['label'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.wizard-content -->

                    <!-- Acciones — IDs originales intactos -->
                    <div class="wizard-actions adm-wizard__actions">
                        <button type="button" class="adm-wizard__btn-prev btn-secondary-wizard1" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                            <i class="fas fa-arrow-left"></i> Anterior
                        </button>
                        <button type="button" class="adm-wizard__btn-next btn-primary-wizard" id="nextBtn">
                            Siguiente <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                </div><!-- /.adm-wizard -->
            </form>

        </main>
    </div><!-- /.adm-main -->

</div><!-- /.adm-layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- JS originales — lógica intacta -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/departamento.js"></script>

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

    const markAll = document.querySelector('.adm-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.adm-notif-item--unread')
                .forEach(el => el.classList.remove('adm-notif-item--unread'));
            document.querySelector('.adm-icon-btn--notif')
                ?.classList.remove('adm-icon-btn--notif');
        });
    }
})();
</script>

</body>
</html>