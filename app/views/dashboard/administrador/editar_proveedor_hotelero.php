<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';

$id       = $_GET['id'];
$hotelero = listarHotelId($id);

$establecimientoSeleccionado = [];
$habitacionSeleccionada      = [];
$servicioSeleccionado        = [];
$pagoSeleccionado            = [];

if (!empty($hotelero['tipo_establecimiento']))
    $establecimientoSeleccionado = array_map('trim', explode(',', $hotelero['tipo_establecimiento']));
if (!empty($hotelero['tipo_habitacion']))
    $habitacionSeleccionada = array_map('trim', explode(',', $hotelero['tipo_habitacion']));
if (!empty($hotelero['servicio_incluido']))
    $servicioSeleccionado = array_map('trim', explode(',', $hotelero['servicio_incluido']));
if (!empty($hotelero['metodo_pago']))
    $pagoSeleccionado = array_map('trim', explode(',', $hotelero['metodo_pago']));

// Topbar — datos del admin
$nombreAdmin    = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales      = '';
$partes         = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p)
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
$fotoAdmin      = trim((string) ($_SESSION['user']['foto'] ?? ''));
$usarFotoAdmin  = $fotoAdmin !== '' && stripos($fotoAdmin, 'default') !== 0;
$avatarAdminUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoAdmin);

// Imagen del logo con fallback
$logoFile = $hotelero['logo'] ?? '';
$logoUrl  = BASE_URL . 'public/uploads/hoteles/' . rawurlencode($logoFile ?: 'default_proveedor_hotelero.png');

// Foto representante con fallback
$fotoFile = $hotelero['foto_representante'] ?? '';
$fotoUrl  = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoFile ?: 'default_proveedor.png');

// Helper: ¿checkbox seleccionado?
function sel(array $arr, string $val): string {
    return in_array($val, $arr) ? 'checked' : '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor Hotelero — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sistema admin (sidebar, topbar, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- Wizard + formulario hotelero -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_hotelero.css">

    <style>
        .adm-img-preview {
            display: flex; align-items: center; justify-content: center;
            width: 100%; height: 120px;
            background: var(--adm-bg);
            border: 1px dashed var(--adm-border);
            border-radius: var(--adm-radius);
            overflow: hidden;
        }
        .adm-img-preview__thumb {
            max-height: 110px; max-width: 100%; object-fit: contain;
            border-radius: 4px;
        }
    </style>
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
                                    <p class="adm-notif-item__text">Nuevo proveedor pendiente de <strong>aprobación</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 3 horas</span>
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
                                <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar" class="adm-profile-btn__avatar-img">
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
                                    <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar" class="adm-profile-btn__avatar-img">
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

        <!-- CONTENIDO PRINCIPAL -->
        <main class="adm-content">

            <div class="adm-page-header">
                <div>
                    <div class="adm-greeting__eyebrow">Gestión · Proveedores Hoteleros</div>
                    <h1 class="adm-page-title">Editar <span>Proveedor Hotelero</span></h1>
                    <p class="adm-greeting__sub">Actualiza la información del proveedor hotelero</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>

            <!-- WIZARD -->
            <form id="formProveedor" action="<?= BASE_URL ?>administrador/actualizar-proveedor-hotelero" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_proveedor_hotelero" value="<?= htmlspecialchars($hotelero['id_proveedor_hotelero']) ?>">
                <input type="hidden" name="id_usuario"            value="<?= htmlspecialchars($hotelero['id_usuario']) ?>">
                <input type="hidden" name="accion"                value="actualizar">

                <div class="adm-wizard">

                    <div class="adm-wizard__header">
                        <p class="adm-wizard__header-text">
                            <i class="bi bi-pencil-square"></i>
                            Editar Proveedor Hotelero
                        </p>
                    </div>

                    <div class="wizard-steps adm-wizard__steps">
                        <div class="step active" data-step="1"><div class="step-circle">1</div><div class="step-label">Información</div></div>
                        <div class="step" data-step="2"><div class="step-circle">2</div><div class="step-label">Representante</div></div>
                        <div class="step" data-step="3"><div class="step-circle">3</div><div class="step-label">Ubicación</div></div>
                        <div class="step" data-step="4"><div class="step-circle">4</div><div class="step-label">Servicios</div></div>
                        <div class="step" data-step="5"><div class="step-circle">5</div><div class="step-label">Documentación</div></div>
                    </div>

                    <div class="wizard-content adm-wizard__content">

                        <!-- ─── PASO 1: Información básica ─── -->
                        <div class="step-content active" data-step="1">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-building"></i></div>
                                <h4>Información Básica del Establecimiento</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Logo actual</label>
                                    <div class="adm-img-preview">
                                        <img src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo" class="adm-img-preview__thumb">
                                    </div>
                                    <input type="file" name="logo" class="adm-form-input adm-form-input--file mt-2" accept=".png,.jpg,.jpeg">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre del establecimiento</label>
                                    <input type="text" name="nombre_establecimiento" id="nombre_establecimiento" class="adm-form-input"
                                        placeholder="Ej: Hostal Villeta" required
                                        value="<?= htmlspecialchars($hotelero['nombre_establecimiento']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email del establecimiento</label>
                                    <input type="email" name="email" class="adm-form-input" id="email"
                                        placeholder="contacto@hotel.com" required
                                        value="<?= htmlspecialchars($hotelero['email']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="adm-form-input" id="telefono"
                                        placeholder="+57 300 123 4567" required
                                        value="<?= htmlspecialchars($hotelero['telefono']) ?>">
                                </div>
                            </div>

                            <!-- Tipo de establecimiento -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-buildings"></i> Tipo de establecimiento
                                </div>
                                <div class="adm-check-grid adm-check-grid--4">
                                    <?php
                                    $tiposEst = [
                                        ['val' => 'Hotel',    'icon' => 'bi-building'],
                                        ['val' => 'Cabaña',   'icon' => 'bi-house-heart'],
                                        ['val' => 'Hostal',   'icon' => 'bi-houses'],
                                        ['val' => 'Glamping', 'icon' => 'bi-stars'],
                                    ];
                                    foreach ($tiposEst as $t): ?>
                                        <label class="adm-check-card">
                                            <input class="adm-check-card__input" type="checkbox"
                                                name="tipo_establecimiento[]" value="<?= $t['val'] ?>"
                                                <?= sel($establecimientoSeleccionado, $t['val']) ?>>
                                            <i class="bi <?= $t['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $t['val'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- ─── PASO 2: Representante ─── -->
                        <div class="step-content" data-step="2">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-person-badge"></i></div>
                                <h4>Datos del Representante</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre del representante</label>
                                    <input type="text" name="nombre_representante" class="adm-form-input" id="nombre_repre"
                                        placeholder="Juan Pérez" required
                                        value="<?= htmlspecialchars(trim($hotelero['nombre_representante'])) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Tipo de documento</label>
                                    <select name="tipo_documento" class="adm-form-input adm-form-select">
                                        <option value="" disabled hidden>Selecciona...</option>
                                        <option value="CC"        <?= $hotelero['tipo_documento'] == 'CC'        ? 'selected' : '' ?>>CC</option>
                                        <option value="CE"        <?= $hotelero['tipo_documento'] == 'CE'        ? 'selected' : '' ?>>CE</option>
                                        <option value="Pasaporte" <?= $hotelero['tipo_documento'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Identificación</label>
                                    <input type="text" name="identificacion_representante" class="adm-form-input" id="identificacion_repre"
                                        placeholder="N.° de documento" required
                                        value="<?= htmlspecialchars($hotelero['identificacion_representante']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Foto del representante (opcional)</label>
                                    <div class="adm-img-preview">
                                        <img src="<?= htmlspecialchars($fotoUrl) ?>" alt="Foto" class="adm-img-preview__thumb">
                                    </div>
                                    <input type="file" name="foto_representante" class="adm-form-input adm-form-input--file mt-2" accept=".png,.jpg,.jpeg">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email del representante</label>
                                    <input type="email" name="email_representante" class="adm-form-input" id="email_repre"
                                        placeholder="representante@email.com" required
                                        value="<?= htmlspecialchars($hotelero['email_representante']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono del representante</label>
                                    <input type="tel" name="telefono_representante" class="adm-form-input" id="telefono_repre"
                                        placeholder="+57 300 123 4567" required
                                        value="<?= htmlspecialchars($hotelero['telefono_representante']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- ─── PASO 3: Ubicación ─── -->
                        <div class="step-content" data-step="3">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <h4>Ubicación</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label" for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="adm-form-input adm-form-select" required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label" for="id_ciudad">Ciudad</label>
                                    <select name="id_ciudad" id="id_ciudad" class="adm-form-input adm-form-select" required></select>
                                </div>
                                <div class="col-12">
                                    <label class="adm-form-label">Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="adm-form-input"
                                        placeholder="Calle 123 #45-67" required
                                        value="<?= htmlspecialchars($hotelero['direccion']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- ─── PASO 4: Servicios ─── -->
                        <div class="step-content" data-step="4">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-door-closed"></i></div>
                                <h4>Tipos de Habitación y Servicios</h4>
                            </div>

                            <!-- Tipo de habitación -->
                            <div class="adm-wizard__subsection-title">
                                <i class="bi bi-door-closed-fill"></i> Tipo de habitación
                            </div>
                            <div class="adm-check-grid adm-check-grid--5">
                                <?php
                                $tiposHab = [
                                    ['val' => 'Estandar', 'label' => 'Estándar', 'icon' => 'bi-door-closed'],
                                    ['val' => 'Doble',    'label' => 'Doble',    'icon' => 'bi-people'],
                                    ['val' => 'Suite',    'label' => 'Suite',    'icon' => 'bi-gem'],
                                    ['val' => 'Familiar', 'label' => 'Familiar', 'icon' => 'bi-house-heart'],
                                    ['val' => 'Premium',  'label' => 'Premium',  'icon' => 'bi-star'],
                                ];
                                foreach ($tiposHab as $h): ?>
                                    <label class="adm-check-card adm-check-card--sm">
                                        <input class="adm-check-card__input" type="checkbox"
                                            name="tipo_habitacion[]" value="<?= $h['val'] ?>"
                                            <?= sel($habitacionSeleccionada, $h['val']) ?>>
                                        <i class="bi <?= $h['icon'] ?> adm-check-card__icon"></i>
                                        <span class="adm-check-card__label"><?= $h['label'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Máximo huéspedes -->
                            <div class="adm-wizard__subsection mt-3">
                                <label class="adm-form-label">Número máximo de huéspedes</label>
                                <input type="number" name="max_huesped" class="adm-form-input" style="max-width:200px"
                                    placeholder="Ej: 25" min="1" required
                                    value="<?= htmlspecialchars($hotelero['max_huesped']) ?>">
                            </div>

                            <!-- Servicios incluidos -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-list-check"></i> Servicios incluidos
                                </div>
                                <div class="adm-check-grid adm-check-grid--srv">
                                    <?php
                                    $servicios = [
                                        ['val' => 'WiFi',               'icon' => 'bi-wifi'],
                                        ['val' => 'Parqueadero',        'icon' => 'bi-p-circle'],
                                        ['val' => 'Piscina',            'icon' => 'bi-water'],
                                        ['val' => 'Restaurante',        'icon' => 'bi-cup-hot'],
                                        ['val' => 'Bar',                'icon' => 'bi-cup-straw'],
                                        ['val' => 'Spa',                'icon' => 'bi-flower1'],
                                        ['val' => 'Pet Friendly',       'icon' => 'bi-heart'],
                                        ['val' => 'Servicio al cuarto', 'icon' => 'bi-bell'],
                                        ['val' => 'Transporte',         'icon' => 'bi-car-front'],
                                        ['val' => 'Desayuno incluido',  'icon' => 'bi-egg-fried'],
                                        ['val' => 'Accesibilidad',      'icon' => 'bi-universal-access'],
                                    ];
                                    foreach ($servicios as $s): ?>
                                        <label class="adm-check-card adm-check-card--sm">
                                            <input class="adm-check-card__input" type="checkbox"
                                                name="servicio_incluido[]" value="<?= $s['val'] ?>"
                                                <?= sel($servicioSeleccionado, $s['val']) ?>>
                                            <i class="bi <?= $s['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $s['val'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- ─── PASO 5: Documentación ─── -->
                        <div class="step-content" data-step="5">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="bi bi-file-earmark-text"></i></div>
                                <h4>Documentación y Métodos de Pago</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="adm-form-label">NIT / RUT</label>
                                    <input type="text" name="nit_rut" class="adm-form-input" id="nit"
                                        placeholder="123456789-0" required
                                        value="<?= htmlspecialchars($hotelero['nit_rut']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="adm-form-label">Cámara de comercio</label>
                                    <input type="text" name="camara_comercio" class="adm-form-input" id="camara_comercio"
                                        required value="<?= htmlspecialchars($hotelero['camara_comercio']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="adm-form-label">Licencia</label>
                                    <input type="text" name="licencia" class="adm-form-input" id="licencia"
                                        placeholder="N.° de licencia" required
                                        value="<?= htmlspecialchars($hotelero['licencia']) ?>">
                                </div>
                            </div>

                            <!-- Métodos de pago -->
                            <div class="adm-wizard__subsection">
                                <div class="adm-wizard__subsection-title">
                                    <i class="bi bi-credit-card"></i> Métodos de pago aceptados
                                </div>
                                <div class="adm-check-grid adm-check-grid--4">
                                    <?php
                                    $pagos = [
                                        ['val' => 'Tarjeta de Crédito', 'icon' => 'bi-credit-card'],
                                        ['val' => 'Tarjeta Débito',     'icon' => 'bi-credit-card-2-back'],
                                        ['val' => 'PSE',                'icon' => 'bi-bank'],
                                        ['val' => 'Nequi',              'icon' => 'bi-phone'],
                                    ];
                                    foreach ($pagos as $pg): ?>
                                        <label class="adm-check-card adm-check-card--sm">
                                            <input class="adm-check-card__input" type="checkbox"
                                                name="metodo_pago[]" value="<?= $pg['val'] ?>"
                                                <?= sel($pagoSeleccionado, $pg['val']) ?>>
                                            <i class="bi <?= $pg['icon'] ?> adm-check-card__icon"></i>
                                            <span class="adm-check-card__label"><?= $pg['val'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.wizard-content -->

                    <div class="wizard-actions adm-wizard__actions">
                        <button type="button" class="adm-wizard__btn-prev" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                            <i class="fas fa-arrow-left"></i> Anterior
                        </button>
                        <button type="button" class="adm-wizard__btn-next" id="nextBtn">
                            Siguiente <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                </div><!-- /.adm-wizard -->
            </form>

        </main>
    </div><!-- /.adm-main -->
</div><!-- /.adm-layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>

<script>
window.BASE_URL          = '<?= BASE_URL ?>';
const departamentoActual = "<?= htmlspecialchars($hotelero['departamento']) ?>";
const ciudadActual       = "<?= htmlspecialchars($hotelero['id_ciudad']) ?>";
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/editar_proveedor.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/departamento.js"></script>

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
                if (d !== panel) d.classList.remove('adm-dropdown--open');
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
})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>
</body>
</html>
