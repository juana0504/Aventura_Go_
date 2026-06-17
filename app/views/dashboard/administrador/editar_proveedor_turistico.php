<?php
require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';
require_once BASE_PATH . '/app/helpers/session_administrador.php';

$id = $_GET['id'];
$proveedor = listarProveedorId($id);

// Resolver rutas de imagen con fallback para datos viejos de producción
$logoFile = $proveedor['logo'] ?? '';
if ($logoFile && $logoFile !== 'default_proveedor.png' && !file_exists(BASE_PATH . '/public/uploads/proveedores/' . $logoFile) && file_exists(BASE_PATH . '/public/uploads/turistico/' . $logoFile)) {
    $logoUrl = BASE_URL . 'public/uploads/turistico/' . rawurlencode($logoFile);
} else {
    $logoUrl = BASE_URL . 'public/uploads/proveedores/' . rawurlencode($logoFile);
}

$fotoFile = $proveedor['foto_representante'] ?? '';
if ($fotoFile && $fotoFile !== 'default_proveedor.png' && !file_exists(BASE_PATH . '/public/uploads/proveedores/' . $fotoFile) && file_exists(BASE_PATH . '/public/uploads/usuario/' . $fotoFile)) {
    $fotoUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoFile);
} else {
    $fotoUrl = BASE_URL . 'public/uploads/proveedores/' . rawurlencode($fotoFile);
}

$actividadesSeleccionadas = [];
if (!empty($proveedor['actividades'])) {
    $actividadesSeleccionadas = array_map('trim', explode(",", $proveedor['actividades']));
}

// Iniciales del administrador para el topbar
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
    <title>Editar Proveedor Turístico — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin (sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS wizard (mismo que registrar) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_turistico.css">
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
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turísticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
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
                    <div class="adm-greeting__eyebrow">Gestión · Proveedores Turísticos</div>
                    <h1 class="adm-page-title">Editar <span>Proveedor</span></h1>
                    <p class="adm-greeting__sub">Actualiza la información del proveedor turístico</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>

            <!-- WIZARD FORM -->
            <form id="formProveedor" action="<?= BASE_URL ?>administrador/actualizar-proveedor" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_proveedor" value="<?= $proveedor['id_proveedor'] ?>">
                <input type="hidden" name="id_usuario"   value="<?= $proveedor['id_usuario'] ?>">
                <input type="hidden" name="accion"        value="actualizar">
                <input type="hidden" name="logo_actual"   value="<?= htmlspecialchars($proveedor['logo'] ?? '') ?>">
                <input type="hidden" name="foto_actual"   value="<?= htmlspecialchars($proveedor['foto_representante'] ?? '') ?>">

                <div class="adm-wizard">

                    <div class="adm-wizard__header">
                        <p class="adm-wizard__header-text">
                            <i class="bi bi-pencil-square"></i>
                            Editar Proveedor de Turismo
                        </p>
                    </div>

                    <div class="wizard-steps adm-wizard__steps">
                        <div class="step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Información Básica</div>
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

                    <div class="wizard-content adm-wizard__content">

                        <!-- Paso 1 -->
                        <div class="step-content active" data-step="1">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-building"></i></div>
                                <h4>Información Básica de la Empresa</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Logo actual</label>
                                    <div class="adm-img-preview">
                                        <img src="<?= htmlspecialchars($logoUrl) ?>"
                                            alt="Logo proveedor" class="adm-img-preview__thumb">
                                    </div>
                                    <input type="file" name="logo" class="adm-form-input adm-form-input--file mt-2" accept=".png,.jpg,.jpeg">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre de la Empresa</label>
                                    <input type="text" name="nombre_empresa" id="empresa" class="adm-form-input" placeholder="Ej: Aventuras Extremas SAS" required value="<?= htmlspecialchars($proveedor['nombre_empresa']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">NIT / RUT</label>
                                    <input type="text" name="nit_rut" id="nit" class="adm-form-input" placeholder="123456789-0" required value="<?= htmlspecialchars($proveedor['nit_rut']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email de la Empresa</label>
                                    <input type="email" name="email" id="email" class="adm-form-input" placeholder="contacto@empresa.com" required value="<?= htmlspecialchars($proveedor['email']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono</label>
                                    <input type="tel" name="telefono" id="telefono" class="adm-form-input" placeholder="+57 300 123 4567" required value="<?= htmlspecialchars($proveedor['telefono']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2 -->
                        <div class="step-content" data-step="2">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-hiking"></i></div>
                                <h4>Servicios Ofrecidos</h4>
                            </div>
                            <label class="adm-form-label mb-3">Selecciona las actividades que ofrece</label>
                            <div class="adm-activities-grid">
                                <?php
                                $actividadesEdit = [
                                    ['id' => 'edit-rafting',   'valor' => 'Rafting',             'emoji' => '🚣'],
                                    ['id' => 'edit-parapente', 'valor' => 'Parapente',            'emoji' => '🪂'],
                                    ['id' => 'edit-senderismo','valor' => 'Senderismo',           'emoji' => '🥾'],
                                    ['id' => 'edit-escalada',  'valor' => 'escalada',             'emoji' => '🧗'],
                                    ['id' => 'edit-buceo',     'valor' => 'Buceo',                'emoji' => '🤿'],
                                    ['id' => 'edit-camping',   'valor' => 'Camping',              'emoji' => '🏕'],
                                    ['id' => 'edit-ciclismo',  'valor' => 'Ciclismo de Montaña',  'emoji' => '🚵'],
                                    ['id' => 'edit-canopy',    'valor' => 'Canopy',               'emoji' => '🌲'],
                                ];
                                $actividadesNorm = array_map('strtolower', $actividadesSeleccionadas);
                                foreach ($actividadesEdit as $act): ?>
                                    <label class="adm-activity-card" for="<?= $act['id'] ?>">
                                        <input class="adm-activity-card__check"
                                               type="checkbox"
                                               name="actividades[]"
                                               id="<?= $act['id'] ?>"
                                               value="<?= $act['valor'] ?>"
                                               <?= in_array(strtolower($act['valor']), $actividadesNorm) ? 'checked' : '' ?>>
                                        <span class="adm-activity-card__emoji"><?= $act['emoji'] ?></span>
                                        <span class="adm-activity-card__label"><?= $act['valor'] === 'escalada' ? 'Escalada' : $act['valor'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Paso 3 -->
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
                                    <input type="text" name="direccion" id="direccion" class="adm-form-input" placeholder="Calle 123 #45-67" required value="<?= htmlspecialchars($proveedor['direccion']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Paso 4 -->
                        <div class="step-content" data-step="4">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-user-tie"></i></div>
                                <h4>Datos del Representante</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre del Representante</label>
                                    <input type="text" name="nombre_representante" class="adm-form-input" id="representante" placeholder="Juan Pérez" required value="<?= htmlspecialchars($proveedor['nombre_representante']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Tipo de documento</label>
                                    <select name="tipo_documento" id="tipo_documento" class="adm-form-input adm-form-select">
                                        <option value="" disabled selected hidden>Tipo de documento</option>
                                        <option value="CC"        <?= $proveedor['tipo_documento'] == 'CC'        ? 'selected' : '' ?>>CC</option>
                                        <option value="CE"        <?= $proveedor['tipo_documento'] == 'CE'        ? 'selected' : '' ?>>CE</option>
                                        <option value="Pasaporte" <?= $proveedor['tipo_documento'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Identificación</label>
                                    <input type="text" name="identificacion_representante" id="identificacion" class="adm-form-input" placeholder="Número de documento" required value="<?= htmlspecialchars($proveedor['identificacion_representante']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Foto del representante (opcional)</label>
                                    <div class="adm-img-preview">
                                        <img src="<?= htmlspecialchars($fotoUrl) ?>"
                                            alt="Foto representante" class="adm-img-preview__thumb adm-img-preview__thumb--sm">
                                    </div>
                                    <input type="file" name="foto_representante" class="adm-form-input adm-form-input--file mt-2" accept=".png,.jpg,.jpeg">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email del representante</label>
                                    <input type="email" name="email_representante" id="email_repre" class="adm-form-input" placeholder="contacto@empresa.com" required value="<?= htmlspecialchars($proveedor['email_representante']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono del representante</label>
                                    <input type="tel" name="telefono_representante" id="telefono_repre" class="adm-form-input" placeholder="+57 300 123 4567" required value="<?= htmlspecialchars($proveedor['telefono_representante']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Paso 5 — Confirmación -->
                        <div class="step-content" data-step="5">

                            <div class="adm-wizard__confirm-header">
                                <div class="adm-wizard__confirm-icon"><i class="bi bi-check-circle-fill"></i></div>
                                <h4>Confirma los cambios</h4>
                                <p>Revisa la información antes de actualizar</p>
                            </div>

                            <div class="adm-preview-grid">

                                <!-- Información de la empresa -->
                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-building"></i> Información Principal
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Empresa</span>
                                            <span class="preview-value" id="prev-empresa">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">NIT / RUT</span>
                                            <span class="preview-value" id="prev-nit">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Email empresa</span>
                                            <span class="preview-value" id="prev-email">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Teléfono empresa</span>
                                            <span class="preview-value" id="prev-telefono">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Representante -->
                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-user-tie"></i> Representante
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Nombre</span>
                                            <span class="preview-value" id="prev-representante">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Tipo doc · Identificación</span>
                                            <span class="preview-value" id="prev-identificacion">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Email representante</span>
                                            <span class="preview-value" id="prev-email-repre">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Teléfono representante</span>
                                            <span class="preview-value" id="prev-telefono-repre">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Servicios -->
                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-hiking"></i> Actividades Turísticas
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-activities" id="prev-actividades">-</div>
                                    </div>
                                </div>

                                <!-- Ubicación -->
                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-map-marker-alt"></i> Ubicación
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Departamento · Ciudad</span>
                                            <span class="preview-value" id="prev-ubicacion">-</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Dirección</span>
                                            <span class="preview-value" id="prev-direccion">-</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="wizard-actions adm-wizard__actions">
                        <button type="button" class="adm-wizard__btn-prev" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                            <i class="fas fa-arrow-left"></i> Anterior
                        </button>
                        <button type="button" class="adm-wizard__btn-next" id="nextBtn">
                            Siguiente <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>

        </main>
    </div><!-- /.adm-main -->
</div><!-- /.adm-layout -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>

<!-- Variables globales PRIMERO para que los scripts siguientes las encuentren -->
<script>
window.BASE_URL          = '<?= BASE_URL ?>';
const departamentoActual = "<?= htmlspecialchars($proveedor['departamento']) ?>";
const ciudadActual       = "<?= htmlspecialchars($proveedor['id_ciudad']) ?>";
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/editar_proveedor.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/departamento.js"></script>

<script>
window.BASE_URL = '<?= BASE_URL ?>';

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
