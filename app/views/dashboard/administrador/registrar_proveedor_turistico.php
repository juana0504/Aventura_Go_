<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

// Iniciales del administrador para el topbar
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
    <title>Registrar Proveedor Turístico — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin (sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_turistico.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- ==========================================
         SIDEBAR — idéntico al dashboard admin
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

    <!-- ==========================================
         ÁREA PRINCIPAL
    =========================================== -->
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

                <!-- Notificaciones -->
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

                <!-- Perfil -->
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

        <!-- ======================================
             CONTENIDO PRINCIPAL
        ======================================= -->
        <main class="adm-content">

            <!-- Encabezado -->
            <div class="adm-page-header">
                <div>
                    <div class="adm-greeting__eyebrow">Gestión · Proveedores Turísticos</div>
                    <h1 class="adm-page-title">Registrar <span>Proveedor</span></h1>
                    <p class="adm-greeting__sub">Completa los 5 pasos para registrar un nuevo proveedor turístico</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>

            <!-- ==============================
                 WIZARD — lógica JS intacta
                 IDs y clases originales conservados
            =============================== -->
            <form id="formProveedor" action="<?= BASE_URL ?>administrador/guardar-proveedor" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="registrar">

                <div class="adm-wizard">

                    <!-- Cabecera del wizard -->
                    <div class="adm-wizard__header">
                        <p class="adm-wizard__header-text">
                            <i class="bi bi-person-plus-fill"></i>
                            Registro de Proveedor de Turismo
                        </p>
                    </div>

                    <!-- Pasos — clases originales para el JS -->
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

                    <!-- Contenido de pasos -->
                    <div class="wizard-content adm-wizard__content">

                        <!-- PASO 1 — Información Básica -->
                        <div class="step-content active" data-step="1">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-building"></i></div>
                                <h4>Información Básica del Proveedor</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre de la Empresa</label>
                                    <input type="text" name="nombre_empresa" class="adm-form-input" id="empresa" placeholder="Ej: Aventuras Extremas SAS" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">NIT / RUT</label>
                                    <input type="text" name="nit_rut" class="adm-form-input" id="nit" placeholder="123456789-0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email de la Empresa</label>
                                    <input type="email" name="email" class="adm-form-input" id="email" placeholder="contacto@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="adm-form-input" id="telefono" placeholder="+57 300 123 4567" required>
                                </div>
                                <div class="col-12">
                                    <label class="adm-form-label">Logo de la Empresa</label>
                                    <input type="file" accept=".jpg,.png,.jpeg" name="logo" class="adm-form-input adm-form-input--file" id="logo" required>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 2 — Servicios -->
                        <div class="step-content" data-step="2">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-hiking"></i></div>
                                <h4>Servicios Ofrecidos</h4>
                            </div>
                            <label class="adm-form-label mb-3">Selecciona las actividades que ofrece</label>
                            <div class="adm-activities-grid">
                                <?php
                                $actividades = [
                                    ['id' => 'rafting',   'valor' => 'Rafting',             'emoji' => '🚣'],
                                    ['id' => 'parapente', 'valor' => 'Parapente',            'emoji' => '🪂'],
                                    ['id' => 'senderismo','valor' => 'Senderismo',           'emoji' => '🥾'],
                                    ['id' => 'escalada',  'valor' => 'Escalada',             'emoji' => '🧗'],
                                    ['id' => 'buceo',     'valor' => 'Buceo',                'emoji' => '🤿'],
                                    ['id' => 'camping',   'valor' => 'Camping',              'emoji' => '🏕'],
                                    ['id' => 'ciclismo',  'valor' => 'Ciclismo de Montaña',  'emoji' => '🚵'],
                                    ['id' => 'canopy',    'valor' => 'Canopy',               'emoji' => '🌲'],
                                ];
                                foreach ($actividades as $act): ?>
                                    <label class="adm-activity-card" for="<?= $act['id'] ?>">
                                        <input class="form-check-input adm-activity-card__check"
                                               type="checkbox"
                                               name="actividades[]"
                                               id="<?= $act['id'] ?>"
                                               value="<?= $act['valor'] ?>">
                                        <span class="adm-activity-card__emoji"><?= $act['emoji'] ?></span>
                                        <span class="adm-activity-card__label"><?= $act['valor'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- PASO 3 — Ubicación -->
                        <div class="step-content" data-step="3">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <h4>Ubicación</h4>
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
                                        <?php if (!empty($ciudades)): ?>
                                            <?php foreach ($ciudades as $ciudad): ?>
                                                <option value="<?= $ciudad['id_ciudad'] ?>"><?= $ciudad['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="adm-form-label">Dirección</label>
                                    <input type="text" name="direccion" class="adm-form-input" id="direccion" placeholder="Calle 123 #45-67" required>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 4 — Representante -->
                        <div class="step-content" data-step="4">
                            <div class="adm-wizard__step-title">
                                <div class="adm-wizard__step-icon"><i class="fas fa-user-tie"></i></div>
                                <h4>Datos del Representante</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="adm-form-label">Nombre del Representante</label>
                                    <input type="text" name="nombre_representante" class="adm-form-input" id="nombre_repre" placeholder="Juan Pérez" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Tipo de Documento</label>
                                    <select name="tipo_documento" class="adm-form-input adm-form-select form-select1" id="tipo_documento">
                                        <option value="" disabled selected hidden>Tipo de documento</option>
                                        <option value="CC">CC</option>
                                        <option value="CE">CE</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Identificación</label>
                                    <input type="tel" name="identificacion_representante" class="adm-form-input" id="identiificacion_repre" placeholder="N.°" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Foto del Representante</label>
                                    <input type="file" accept=".jpg,.png,.jpeg" name="foto_representante" class="adm-form-input adm-form-input--file" id="foto_representante" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Email (mismo que para iniciar sesión)</label>
                                    <input type="email" name="email_representante" class="adm-form-input" id="email_repre" placeholder="contacto@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="adm-form-label">Teléfono del Representante</label>
                                    <input type="tel" name="telefono_representante" class="adm-form-input" id="telefono_repre" placeholder="+57 300 123 4567" required>
                                </div>
                            </div>
                        </div>

                        <!-- PASO 5 — Confirmación — IDs originales intactos -->
                        <div class="step-content" data-step="5">
                            <div class="adm-wizard__confirm-header">
                                <div class="adm-wizard__confirm-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h4>Confirma tu Registro</h4>
                                <p>Revisa la información antes de guardar</p>
                            </div>

                            <div class="adm-preview-grid">

                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-building"></i> Información Básica
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Empresa</span>
                                            <span class="preview-value" id="prev-empresa">—</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">NIT/RUT</span>
                                            <span class="preview-value" id="prev-nit">—</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Email</span>
                                            <span class="preview-value" id="prev-email">—</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Teléfono</span>
                                            <span class="preview-value" id="prev-telefono">—</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-hiking"></i> Servicios
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div id="prev-actividades" class="adm-preview-activities">—</div>
                                    </div>
                                </div>

                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-map-marker-alt"></i> Ubicación
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Dirección</span>
                                            <span class="preview-value" id="prev-ubicacion">—</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="adm-preview-card">
                                    <div class="adm-preview-card__header">
                                        <i class="fas fa-user-tie"></i> Representante
                                    </div>
                                    <div class="adm-preview-card__body">
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Nombre</span>
                                            <span class="preview-value" id="prev-nombre_repre">—</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Email</span>
                                            <span class="preview-value" id="prev-email_repre">—</span>
                                        </div>
                                        <div class="adm-preview-field">
                                            <span class="adm-preview-label">Teléfono</span>
                                            <span class="preview-value" id="prev-telefono_repre">—</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- /.wizard-content -->

                    <!-- Acciones del wizard — IDs originales intactos -->
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


<!-- Bootstrap JS -->
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

    /* ─── NOTIFICACIONES ─────────────────────── */
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