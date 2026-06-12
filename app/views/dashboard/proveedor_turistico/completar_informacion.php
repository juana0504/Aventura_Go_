<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';

// Lógica original intacta
$actividadesSeleccionadas = [];
if (!empty($proveedor['actividades'])) {
    $actividadesSeleccionadas = array_map('trim', explode(',', $proveedor['actividades']));
}

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
    <title>Completar Información — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sistema proveedor -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/completar_informacion.css">
</head>

<body class="pv-body">

<div class="pv-layout" id="informacion-proveedor">

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
                        <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

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
        <main class="pv-content">

            <!-- Encabezado -->
            <div style="margin-bottom:24px;">
                <div class="pv-greeting__eyebrow">Configuración de cuenta</div>
                <h1 class="pv-page-title">Completar <span>Información</span></h1>
                <p class="pv-greeting__sub">Completa los 5 pasos para activar tu perfil de proveedor</p>
            </div>

            <!-- Layout principal: wizard + panel info -->
            <div class="pv-ci-layout">

                <!-- ── WIZARD ── -->
                <div class="pv-ci-wizard-wrap">

                    <!-- Formulario — action, method, names originales intactos -->
                    <form id="formCompletarProveedor" action="<?= BASE_URL ?>proveedor/guardar-informacion" method="POST" enctype="multipart/form-data"
                          data-has-logo="<?= !empty($proveedor['logo']) ? '1' : '0' ?>"
                          data-has-foto="<?= !empty($proveedor['foto_representante']) ? '1' : '0' ?>">
                        <input type="hidden" name="accion" value="actualizar">

                        <div class="pv-wizard">

                            <!-- Header -->
                            <div class="pv-wizard__header">
                                <p class="pv-wizard__header-text">
                                    <i class="bi bi-person-gear"></i>
                                    Registro de Proveedor de Turismo
                                </p>
                            </div>

                            <!-- Pasos — clases originales para el JS -->
                            <div class="wizard-steps pv-wizard__steps">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Info Básica</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Servicios</div>
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

                            <!-- Contenido pasos -->
                            <div class="wizard-content pv-wizard__content">

                                <!-- PASO 1 — Info Básica -->
                                <div class="step-content active" data-step="1">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-building"></i></div>
                                        <h4>Información Básica del Proveedor</h4>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Nombre de la Empresa</label>
                                            <input type="text" name="nombre_empresa" class="pv-form-input" id="empresa"
                                                value="<?= htmlspecialchars($proveedor['nombre_empresa'] ?? '') ?>"
                                                placeholder="Ej: Aventuras Extremas SAS" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">NIT / RUT</label>
                                            <input type="text" name="nit_rut" class="pv-form-input" id="nit"
                                                value="<?= htmlspecialchars($proveedor['nit_rut'] ?? '') ?>"
                                                placeholder="123456789-0" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Email</label>
                                            <input type="email" name="email" class="pv-form-input" id="email"
                                                value="<?= htmlspecialchars($proveedor['email'] ?? '') ?>"
                                                placeholder="contacto@empresa.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Teléfono</label>
                                            <input type="tel" name="telefono" class="pv-form-input" id="telefono"
                                                value="<?= htmlspecialchars($proveedor['telefono'] ?? '') ?>"
                                                placeholder="+57 300 123 4567" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="pv-form-label">Logo de la Empresa</label>
                                            <input type="file" accept=".jpg,.png,.jpeg" name="logo" class="pv-form-input pv-form-input--file" id="logo" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- PASO 2 — Servicios -->
                                <div class="step-content" data-step="2">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-hiking"></i></div>
                                        <h4>Servicios Ofrecidos</h4>
                                    </div>

                                    <label class="pv-form-label mb-3">Tipo de actividades que ofreces</label>
                                    <div class="pv-ci-activities-grid">
                                        <?php
                                        $actividades = [
                                            ['id' => 'rafting',   'valor' => 'Rafting',            'emoji' => '🚣'],
                                            ['id' => 'parapente', 'valor' => 'Parapente',           'emoji' => '🪂'],
                                            ['id' => 'senderismo','valor' => 'Senderismo',          'emoji' => '🥾'],
                                            ['id' => 'escalada',  'valor' => 'Escalada',            'emoji' => '🧗'],
                                            ['id' => 'buceo',     'valor' => 'Buceo',               'emoji' => '🤿'],
                                            ['id' => 'camping',   'valor' => 'Camping',             'emoji' => '🏕'],
                                            ['id' => 'ciclismo',  'valor' => 'Ciclismo de Montaña', 'emoji' => '🚵'],
                                            ['id' => 'canopy',    'valor' => 'Canopy',              'emoji' => '🌲'],
                                        ];
                                        foreach ($actividades as $act):
                                            $checked = in_array($act['valor'], $actividadesSeleccionadas) ? 'checked' : '';
                                        ?>
                                            <label class="pv-ci-activity-card <?= $checked ? 'pv-ci-activity-card--selected' : '' ?>" for="<?= $act['id'] ?>">
                                                <input class="pv-ci-activity-card__check"
                                                       type="checkbox"
                                                       name="actividades[]"
                                                       id="<?= $act['id'] ?>"
                                                       value="<?= $act['valor'] ?>"
                                                       <?= $checked ?>>
                                                <span class="pv-ci-activity-card__emoji"><?= $act['emoji'] ?></span>
                                                <span class="pv-ci-activity-card__label"><?= $act['valor'] ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="mt-4">
                                        <label class="pv-form-label">Descripción de la empresa</label>
                                        <textarea name="descripcion" id="descripcion" class="pv-form-input pv-form-textarea"
                                            rows="4"
                                            placeholder="Describe brevemente tu empresa, experiencia y tipo de actividades que ofreces"
                                            required><?= htmlspecialchars($proveedor['descripcion'] ?? '') ?></textarea>
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
                                            <label class="pv-form-label" for="departamento">Departamento</label>
                                            <select name="departamento" id="departamento" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione un departamento</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label" for="id_ciudad">Ciudad</label>
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
                                            <label class="pv-form-label">Dirección</label>
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
                                        <h4>Datos del Representante</h4>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Nombre del Representante</label>
                                            <input type="text" name="nombre_representante" class="pv-form-input" id="nombre_repre"
                                                value="<?= htmlspecialchars($proveedor['nombre_representante'] ?? '') ?>"
                                                placeholder="Juan Pérez" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Tipo de Documento</label>
                                            <select name="tipo_documento" class="pv-form-input pv-form-select form-select1" id="tipo_documento">
                                                <option value="" disabled selected hidden>Tipo de documento</option>
                                                <option value="CC"        <?= ($proveedor['tipo_documento'] ?? '') === 'CC'        ? 'selected' : '' ?>>CC</option>
                                                <option value="CE"        <?= ($proveedor['tipo_documento'] ?? '') === 'CE'        ? 'selected' : '' ?>>CE</option>
                                                <option value="Pasaporte" <?= ($proveedor['tipo_documento'] ?? '') === 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Identificación</label>
                                            <input type="tel" name="identificacion_representante" class="pv-form-input" id="identificacion_repre"
                                                value="<?= htmlspecialchars($proveedor['identificacion_representante'] ?? '') ?>"
                                                placeholder="N.°" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Foto del Representante</label>
                                            <input type="file" accept=".jpg,.png,.jpeg" name="foto_representante" class="pv-form-input pv-form-input--file" id="foto_representante" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Email (correo de acceso)</label>
                                            <input type="email" name="email_representante" class="pv-form-input pv-form-input--readonly"
                                                id="email_repre"
                                                value="<?= htmlspecialchars($proveedor['email_login'] ?? '') ?>"
                                                readonly>
                                            <small class="pv-form-hint">Este es tu correo de acceso. Para modificarlo ve a tu perfil.</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Teléfono del Representante</label>
                                            <input type="tel" name="telefono_representante" class="pv-form-input" id="telefono_repre"
                                                value="<?= htmlspecialchars($proveedor['telefono_representante'] ?? '') ?>"
                                                placeholder="+57 300 123 4567" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- PASO 5 — Confirmación — IDs originales para el JS -->
                                <div class="step-content" data-step="5">
                                    <div class="pv-wizard__confirm-header">
                                        <div class="pv-wizard__confirm-icon"><i class="fas fa-check-circle"></i></div>
                                        <h4>Confirma tu Registro</h4>
                                        <p>Revisa la información antes de guardar</p>
                                    </div>

                                    <div class="pv-preview-grid">
                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-building"></i> Información Básica</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Empresa</span><span class="preview-value" id="prev-empresa">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">NIT/RUT</span><span class="preview-value" id="prev-nit">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Email</span><span class="preview-value" id="prev-email">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Teléfono</span><span class="preview-value" id="prev-telefono">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-hiking"></i> Servicios</div>
                                            <div class="pv-preview-card__body">
                                                <div id="prev-actividades" class="pv-preview-activities">—</div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-map-marker-alt"></i> Ubicación</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Ciudad</span><span class="preview-value" id="prev-ubicacion">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Dirección</span><span class="preview-value" id="prev-direccion">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-user-tie"></i> Representante</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Nombre</span><span class="preview-value" id="prev-representante">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Email</span><span class="preview-value" id="prev-email_repre">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Teléfono</span><span class="preview-value" id="prev-telefono_repre">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card pv-preview-card--full">
                                            <div class="pv-preview-card__header"><i class="fas fa-info-circle"></i> Descripción</div>
                                            <div class="pv-preview-card__body">
                                                <span class="preview-value" id="prev-descripcion">—</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.wizard-content -->

                            <!-- Acciones — IDs originales intactos -->
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

                <!-- ── PANEL INFORMATIVO ── -->
                <aside class="pv-ci-info-panel">

                    <div class="pv-ci-info-logo">
                        <img src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/img/image.png"
                             alt="AventuraGO"
                             onerror="this.style.display='none'">
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-building-check"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">¿Por qué registrar tu empresa?</div>
                            <p class="pv-ci-info-item__text">En Aventura Go conectamos viajeros con experiencias auténticas de turismo de aventura.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-file-text"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Información clara</div>
                            <p class="pv-ci-info-item__text">Completa los datos de tu empresa para mostrar tus actividades de forma profesional.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-globe-americas"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Mayor visibilidad</div>
                            <p class="pv-ci-info-item__text">Los viajeros podrán descubrir y reservar tus experiencias desde la plataforma.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-tree"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Turismo responsable</div>
                            <p class="pv-ci-info-item__text">Promovemos el turismo sostenible, apoyando a prestadores locales y experiencias seguras.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-rocket-takeoff"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Registro rápido</div>
                            <p class="pv-ci-info-item__text">¡Regístrate hoy y comienza a atraer más aventureros a tus experiencias únicas!</p>
                        </div>
                    </div>

                </aside>

            </div><!-- /.pv-ci-layout -->

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- JS originales — lógica intacta -->
<script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/completar_informacion.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/departamento.js"></script>

<script>
(function () {
    /* ─── MODO OSCURO ────────────────────────── */
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

    /* ─── DROPDOWNS ──────────────────────────── */
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
                if (d !== panel) {
                    d.classList.remove('pv-dropdown--open');
                    document.querySelectorAll('.pv-profile-btn__chevron--open')
                        .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
                }
            });
        });
    }

    makeDropdown('pv-notif-btn',   'pv-notif-panel');
    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open')
            .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });

    const markAll = document.querySelector('.pv-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread'));
            document.querySelector('.pv-icon-btn--notif')?.classList.remove('pv-icon-btn--notif');
        });
    }

    /* ─── RESALTAR ACTIVIDADES AL MARCAR ──────── */
    document.querySelectorAll('.pv-ci-activity-card__check').forEach(check => {
        check.addEventListener('change', () => {
            check.closest('.pv-ci-activity-card')
                 ?.classList.toggle('pv-ci-activity-card--selected', check.checked);
        });
    });
})();
</script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
</body>
</html>