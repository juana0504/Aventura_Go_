<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

$tiposHabitacionSel = !empty($proveedor['tipo_habitacion'])
    ? array_map('trim', explode(',', $proveedor['tipo_habitacion']))
    : [];

$metodosPagoSel = !empty($proveedor['metodo_pago'])
    ? array_map('trim', explode(',', $proveedor['metodo_pago']))
    : [];

$serviciosSel = !empty($proveedor['servicio_incluido'])
    ? array_map('trim', explode(',', $proveedor['servicio_incluido']))
    : [];

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
    <title>Actualizar Información — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/completar_informacion.css">
</head>

<body class="pv-body">
<div class="pv-layout" id="completar-info-hotelero">

    <?php $activeSection = 'info'; include __DIR__ . '/_sidebar.php'; ?>

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
                                <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-exclamation-circle-fill"></i></div>
                                <div class="pv-notif-item__body">
                                    <p class="pv-notif-item__text">Completa tu información para activar tu cuenta.</p>
                                    <span class="pv-notif-item__time">Ahora</span>
                                </div>
                                <span class="pv-notif-item__dot"></span>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-profile-btn" id="pv-profile-btn">
                        <div class="pv-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                        <div class="pv-profile-btn__info">
                            <span class="pv-profile-btn__name"><?= htmlspecialchars($nombreProveedor) ?></span>
                            <span class="pv-profile-btn__role">Proveedor Hotelero</span>
                        </div>
                        <i class="bi bi-chevron-down pv-profile-btn__chevron" id="pv-profile-chevron"></i>
                    </button>
                    <div class="pv-dropdown pv-dropdown--profile" id="pv-profile-panel">
                        <div class="pv-dropdown__user-header">
                            <div class="pv-profile-btn__avatar pv-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                            <div>
                                <div class="pv-dropdown__user-name"><?= htmlspecialchars($nombreProveedor) ?></div>
                                <div class="pv-dropdown__user-role">Proveedor Hotelero · AventuraGO</div>
                            </div>
                        </div>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/perfil" class="pv-dropdown__item"><i class="bi bi-person-circle"></i> Mi perfil</a>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hospedajes" class="pv-dropdown__item"><i class="bi bi-building"></i> Mis hospedajes</a>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__item"><i class="bi bi-headset"></i> Soporte</a>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="pv-content">

            <div style="margin-bottom:24px;">
                <div class="pv-greeting__eyebrow">Configuración de cuenta</div>
                <h1 class="pv-page-title">Actualizar <span>Información</span></h1>
                <p class="pv-greeting__sub">Completa los 5 pasos para activar tu perfil de proveedor hotelero</p>
            </div>

            <div class="pv-ci-layout">

                <!-- WIZARD -->
                <div class="pv-ci-wizard-wrap">
                    <form id="formCompletarHotelero"
                          action="<?= BASE_URL ?>proveedor_hotelero/completar-informacion"
                          method="POST"
                          enctype="multipart/form-data"
                          data-has-logo="<?= !empty($proveedor['logo']) ? '1' : '0' ?>"
                          data-has-foto="<?= !empty($proveedor['foto_representante']) ? '1' : '0' ?>">

                        <div class="pv-wizard">

                            <div class="pv-wizard__header">
                                <p class="pv-wizard__header-text">
                                    <i class="bi bi-building-gear"></i>
                                    Registro de Proveedor Hotelero
                                </p>
                            </div>

                            <div class="wizard-steps pv-wizard__steps">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Info Básica</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Hospedaje</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <div class="step-label">Ubicación</div>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-circle">4</div>
                                    <div class="step-label">Representante</div>
                                </div>
                                <div class="step" data-step="5">
                                    <div class="step-circle">5</div>
                                    <div class="step-label">Confirmación</div>
                                </div>
                            </div>

                            <div class="wizard-content pv-wizard__content">

                                <!-- PASO 1 — Información Básica -->
                                <div class="step-content active" data-step="1">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-hotel"></i></div>
                                        <h4>Información del Establecimiento</h4>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Nombre del establecimiento *</label>
                                            <input type="text" name="nombre_establecimiento" class="pv-form-input" id="nombre_estab"
                                                value="<?= htmlspecialchars($proveedor['nombre_establecimiento'] ?? '') ?>"
                                                placeholder="Ej: Hotel Las Palmas" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">NIT / RUT *</label>
                                            <input type="text" name="nit_rut" class="pv-form-input" id="nit"
                                                value="<?= htmlspecialchars($proveedor['nit_rut'] ?? '') ?>"
                                                placeholder="123456789-0" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="pv-form-label mb-3">Tipo de establecimiento *</label>
                                            <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(4,1fr);">
                                                <?php
                                                $tiposEstab = [
                                                    ['valor'=>'Hotel',    'emoji'=>'🏨'],
                                                    ['valor'=>'Hostal',   'emoji'=>'🏠'],
                                                    ['valor'=>'Cabaña',   'emoji'=>'🌲'],
                                                    ['valor'=>'Glamping', 'emoji'=>'⛺'],
                                                ];
                                                foreach ($tiposEstab as $te):
                                                    $checked = ($proveedor['tipo_establecimiento'] ?? '') === $te['valor'];
                                                ?>
                                                <label class="pv-ci-activity-card <?= $checked ? 'pv-ci-activity-card--selected' : '' ?>" for="te_<?= strtolower($te['valor']) ?>">
                                                    <input class="pv-ci-activity-card__check" type="radio"
                                                        name="tipo_establecimiento" id="te_<?= strtolower($te['valor']) ?>"
                                                        value="<?= $te['valor'] ?>" <?= $checked ? 'checked' : '' ?> required>
                                                    <span class="pv-ci-activity-card__emoji"><?= $te['emoji'] ?></span>
                                                    <span class="pv-ci-activity-card__label"><?= $te['valor'] ?></span>
                                                </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Email *</label>
                                            <input type="email" name="email" class="pv-form-input" id="email"
                                                value="<?= htmlspecialchars($proveedor['email'] ?? '') ?>"
                                                placeholder="contacto@hotel.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Teléfono *</label>
                                            <input type="tel" name="telefono" class="pv-form-input" id="telefono"
                                                value="<?= htmlspecialchars($proveedor['telefono'] ?? '') ?>"
                                                placeholder="+57 300 123 4567" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Logo del establecimiento *</label>
                                            <input type="file" name="logo" class="pv-form-input pv-form-input--file" accept=".jpg,.jpeg,.png">
                                            <?php if (!empty($proveedor['logo'])): ?>
                                                <small class="pv-form-hint"><i class="bi bi-check-circle-fill text-success"></i> Logo actual guardado</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- PASO 2 — Hospedaje -->
                                <div class="step-content" data-step="2">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-bed"></i></div>
                                        <h4>Información del Hospedaje</h4>
                                    </div>

                                    <label class="pv-form-label mb-3">Tipo de habitación (selecciona las que ofreces) *</label>
                                    <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(4,1fr); margin-bottom:24px;">
                                        <?php
                                        $tiposHabit = [
                                            ['id'=>'th_individual', 'valor'=>'Individual', 'emoji'=>'🛏'],
                                            ['id'=>'th_doble',      'valor'=>'Doble',      'emoji'=>'🛏🛏'],
                                            ['id'=>'th_suite',      'valor'=>'Suite',      'emoji'=>'👑'],
                                            ['id'=>'th_familiar',   'valor'=>'Familiar',   'emoji'=>'👨‍👩‍👧‍👦'],
                                        ];
                                        foreach ($tiposHabit as $t):
                                            $checked = in_array($t['valor'], $tiposHabitacionSel);
                                        ?>
                                        <label class="pv-ci-activity-card <?= $checked ? 'pv-ci-activity-card--selected' : '' ?>" for="<?= $t['id'] ?>">
                                            <input class="pv-ci-activity-card__check" type="checkbox"
                                                name="tipo_habitacion[]" id="<?= $t['id'] ?>"
                                                value="<?= $t['valor'] ?>" <?= $checked ? 'checked' : '' ?>>
                                            <span class="pv-ci-activity-card__emoji"><?= $t['emoji'] ?></span>
                                            <span class="pv-ci-activity-card__label"><?= $t['valor'] ?></span>
                                        </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <label class="pv-form-label mb-3">Métodos de pago aceptados *</label>
                                    <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(4,1fr); margin-bottom:24px;">
                                        <?php
                                        $metodosPago = [
                                            ['id'=>'mp_efectivo',     'valor'=>'Efectivo',     'emoji'=>'💵'],
                                            ['id'=>'mp_tarjeta',      'valor'=>'Tarjeta',      'emoji'=>'💳'],
                                            ['id'=>'mp_nequi',        'valor'=>'Nequi',        'emoji'=>'📱'],
                                            ['id'=>'mp_transferencia','valor'=>'Transferencia','emoji'=>'🏦'],
                                        ];
                                        foreach ($metodosPago as $m):
                                            $checked = in_array($m['valor'], $metodosPagoSel);
                                        ?>
                                        <label class="pv-ci-activity-card <?= $checked ? 'pv-ci-activity-card--selected' : '' ?>" for="<?= $m['id'] ?>">
                                            <input class="pv-ci-activity-card__check" type="checkbox"
                                                name="metodo_pago[]" id="<?= $m['id'] ?>"
                                                value="<?= $m['valor'] ?>" <?= $checked ? 'checked' : '' ?>>
                                            <span class="pv-ci-activity-card__emoji"><?= $m['emoji'] ?></span>
                                            <span class="pv-ci-activity-card__label"><?= $m['valor'] ?></span>
                                        </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="row g-3" style="margin-bottom:8px;">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Máximo de huéspedes *</label>
                                            <input type="number" name="max_huesped" class="pv-form-input" id="max_huesped"
                                                min="1" value="<?= htmlspecialchars($proveedor['max_huesped'] ?? '') ?>"
                                                placeholder="Ej: 4" required>
                                        </div>
                                    </div>

                                    <label class="pv-form-label mb-3">Servicios incluidos (selecciona los que ofreces) *</label>
                                    <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(4,1fr);">
                                        <?php
                                        $serviciosOpts = [
                                            ['id'=>'sv_wifi',        'valor'=>'WiFi',          'emoji'=>'📶'],
                                            ['id'=>'sv_piscina',     'valor'=>'Piscina',        'emoji'=>'🏊'],
                                            ['id'=>'sv_desayuno',    'valor'=>'Desayuno',       'emoji'=>'🍳'],
                                            ['id'=>'sv_parking',     'valor'=>'Parking',        'emoji'=>'🅿️'],
                                            ['id'=>'sv_gym',         'valor'=>'Gimnasio',       'emoji'=>'🏋️'],
                                            ['id'=>'sv_spa',         'valor'=>'Spa',            'emoji'=>'💆'],
                                            ['id'=>'sv_restaurant',  'valor'=>'Restaurante',    'emoji'=>'🍽️'],
                                            ['id'=>'sv_ac',          'valor'=>'Aire acond.',    'emoji'=>'❄️'],
                                            ['id'=>'sv_tv',          'valor'=>'TV Cable',       'emoji'=>'📺'],
                                            ['id'=>'sv_lavanderia',  'valor'=>'Lavandería',     'emoji'=>'👕'],
                                            ['id'=>'sv_bar',         'valor'=>'Bar',            'emoji'=>'🍹'],
                                            ['id'=>'sv_jacuzzi',     'valor'=>'Jacuzzi',        'emoji'=>'🛁'],
                                            ['id'=>'sv_terraza',     'valor'=>'Terraza',        'emoji'=>'🌿'],
                                            ['id'=>'sv_mascotas',    'valor'=>'Mascotas',       'emoji'=>'🐾'],
                                            ['id'=>'sv_transporte',  'valor'=>'Transporte',     'emoji'=>'🚐'],
                                            ['id'=>'sv_roomservice', 'valor'=>'Room Service',   'emoji'=>'🛎️'],
                                        ];
                                        foreach ($serviciosOpts as $s):
                                            $checked = in_array($s['valor'], $serviciosSel);
                                        ?>
                                        <label class="pv-ci-activity-card <?= $checked ? 'pv-ci-activity-card--selected' : '' ?>" for="<?= $s['id'] ?>">
                                            <input class="pv-ci-activity-card__check" type="checkbox"
                                                name="servicio_incluido[]" id="<?= $s['id'] ?>"
                                                value="<?= $s['valor'] ?>" <?= $checked ? 'checked' : '' ?>>
                                            <span class="pv-ci-activity-card__emoji"><?= $s['emoji'] ?></span>
                                            <span class="pv-ci-activity-card__label"><?= $s['valor'] ?></span>
                                        </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- PASO 3 — Ubicación -->
                                <div class="step-content" data-step="3">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <h4>Ubicación</h4>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label" for="departamento">Departamento *</label>
                                            <select name="departamento" id="departamento" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione un departamento</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label" for="id_ciudad">Ciudad *</label>
                                            <select name="id_ciudad" id="id_ciudad" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione una ciudad</option>
                                                <?php if (!empty($ciudades)): ?>
                                                    <?php foreach ($ciudades as $ciudad): ?>
                                                        <option value="<?= $ciudad['id_ciudad'] ?>"><?= htmlspecialchars($ciudad['nombre']) ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="pv-form-label">Dirección *</label>
                                            <input type="text" name="direccion" class="pv-form-input" id="direccion"
                                                value="<?= htmlspecialchars($proveedor['direccion'] ?? '') ?>"
                                                placeholder="Calle 123 #45-67" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- PASO 4 — Representante -->
                                <div class="step-content" data-step="4">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-user-tie"></i></div>
                                        <h4>Representante Legal</h4>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Nombre del representante *</label>
                                            <input type="text" name="nombre_representante" class="pv-form-input" id="nombre_repre"
                                                value="<?= htmlspecialchars($proveedor['nombre_representante'] ?? '') ?>"
                                                placeholder="Juan Pérez" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Tipo de documento *</label>
                                            <select name="tipo_documento" class="pv-form-input pv-form-select" id="tipo_documento" required>
                                                <option value="" disabled selected hidden>Tipo de documento</option>
                                                <?php foreach (['CC','CE','Pasaporte'] as $td): ?>
                                                    <option value="<?= $td ?>" <?= ($proveedor['tipo_documento'] ?? '') === $td ? 'selected' : '' ?>><?= $td ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Identificación *</label>
                                            <input type="tel" name="identificacion_representante" class="pv-form-input" id="identificacion_repre"
                                                value="<?= htmlspecialchars($proveedor['identificacion_representante'] ?? '') ?>"
                                                placeholder="N.°" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Teléfono del representante *</label>
                                            <input type="tel" name="telefono_representante" class="pv-form-input" id="telefono_repre"
                                                value="<?= htmlspecialchars($proveedor['telefono_representante'] ?? '') ?>"
                                                placeholder="+57 300 123 4567" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Foto del representante *</label>
                                            <input type="file" name="foto_representante" class="pv-form-input pv-form-input--file" accept=".jpg,.jpeg,.png">
                                            <?php if (!empty($proveedor['foto_representante'])): ?>
                                                <small class="pv-form-hint"><i class="bi bi-check-circle-fill text-success"></i> Foto actual guardada</small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">N.° Cámara de comercio *</label>
                                            <input type="text" name="camara_comercio" class="pv-form-input" id="camara_comercio"
                                                value="<?= htmlspecialchars($proveedor['camara_comercio'] ?? '') ?>"
                                                placeholder="Ej: 12345678" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">N.° Licencia *</label>
                                            <input type="text" name="licencia" class="pv-form-input" id="licencia"
                                                value="<?= htmlspecialchars($proveedor['licencia'] ?? '') ?>"
                                                placeholder="Ej: LIC-2024-001" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- PASO 5 — Confirmación -->
                                <div class="step-content" data-step="5">
                                    <div class="pv-wizard__confirm-header">
                                        <div class="pv-wizard__confirm-icon"><i class="fas fa-check-circle"></i></div>
                                        <h4>Confirma tu Registro</h4>
                                        <p>Revisa la información antes de guardar</p>
                                    </div>

                                    <div class="pv-preview-grid">
                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-hotel"></i> Establecimiento</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Nombre</span><span class="preview-value" id="prev-nombre_estab">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">NIT/RUT</span><span class="preview-value" id="prev-nit">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Tipo</span><span class="preview-value" id="prev-tipo_estab">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Teléfono</span><span class="preview-value" id="prev-telefono">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-bed"></i> Hospedaje</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Habitaciones</span><div id="prev-habitaciones" class="pv-preview-activities">—</div></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Métodos de pago</span><div id="prev-metodos" class="pv-preview-activities">—</div></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Máx. huéspedes</span><span class="preview-value" id="prev-max_huesped">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-map-marker-alt"></i> Ubicación</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Ciudad</span><span class="preview-value" id="prev-ciudad">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Dirección</span><span class="preview-value" id="prev-direccion">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-user-tie"></i> Representante</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Nombre</span><span class="preview-value" id="prev-representante">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Documento</span><span class="preview-value" id="prev-tipo_doc">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Teléfono</span><span class="preview-value" id="prev-telefono_repre">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Cámara comercio</span><span class="preview-value" id="prev-camara">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Licencia</span><span class="preview-value" id="prev-licencia">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card pv-preview-card--full">
                                            <div class="pv-preview-card__header"><i class="fas fa-concierge-bell"></i> Servicios incluidos</div>
                                            <div class="pv-preview-card__body">
                                                <div id="prev-servicios" class="pv-preview-activities">—</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.wizard-content -->

                            <div class="wizard-actions pv-wizard__actions">
                                <button type="button" class="pv-wizard__btn-prev btn-secondary-wizard" id="prevBtn" style="display:none;">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </button>
                                <button type="button" class="pv-wizard__btn-next btn-primary-wizard" id="nextBtn">
                                    Siguiente <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>

                        </div><!-- /.pv-wizard -->
                    </form>
                </div><!-- /.pv-ci-wizard-wrap -->

                <!-- PANEL INFORMATIVO -->
                <aside class="pv-ci-info-panel">
                    <div class="pv-ci-info-logo">
                        <img src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/img/image.png"
                             alt="AventuraGO" onerror="this.style.display='none'">
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-building-check"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">¿Por qué registrar tu hospedaje?</div>
                            <p class="pv-ci-info-item__text">Conéctate con viajeros que buscan alojamiento único y de calidad en sus aventuras.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-file-text"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Información clara</div>
                            <p class="pv-ci-info-item__text">Completa los datos de tu establecimiento para mostrarlo de forma profesional.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-globe-americas"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Mayor visibilidad</div>
                            <p class="pv-ci-info-item__text">Los turistas podrán encontrar y reservar tu hospedaje desde la plataforma.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Proceso de verificación</div>
                            <p class="pv-ci-info-item__text">Una vez enviada la información, nuestro equipo verificará tu establecimiento.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-rocket-takeoff"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Registro rápido</div>
                            <p class="pv-ci-info-item__text">¡Regístrate hoy y comienza a recibir reservas de aventureros!</p>
                        </div>
                    </div>
                </aside>

            </div><!-- /.pv-ci-layout -->

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>const BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/completar_informacion/completar_informacion.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/completar_informacion/departamento.js"></script>

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
            document.querySelectorAll('.pv-dropdown--open').forEach(d => {
                if (d !== panel) d.classList.remove('pv-dropdown--open');
            });
        });
    }

    makeDropdown('pv-notif-btn',   'pv-notif-panel');
    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });

    document.querySelectorAll('.pv-ci-activity-card__check').forEach(check => {
        check.addEventListener('change', () => {
            if (check.type === 'radio') {
                document.querySelectorAll(`input[name="${check.name}"]`).forEach(r => {
                    r.closest('.pv-ci-activity-card')?.classList.remove('pv-ci-activity-card--selected');
                });
            }
            check.closest('.pv-ci-activity-card')?.classList.toggle('pv-ci-activity-card--selected', check.checked);
        });
    });
})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
