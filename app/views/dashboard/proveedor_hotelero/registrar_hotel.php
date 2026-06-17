<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

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
    <title>Nuevo Hospedaje — AventuraGO</title>

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
<div class="pv-layout">

    <?php $activeSection = 'nuevo'; include __DIR__ . '/_sidebar.php'; ?>

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
                                <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                <div class="pv-notif-item__body">
                                    <p class="pv-notif-item__text">Tienes reservas pendientes de confirmación.</p>
                                    <span class="pv-notif-item__time">Ahora</span>
                                </div>
                                <span class="pv-notif-item__dot"></span>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-reservas" class="pv-dropdown__footer">Ver reservas</a>
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
                <div class="pv-greeting__eyebrow">Gestión de hospedajes</div>
                <h1 class="pv-page-title">Nuevo <span>Hospedaje</span></h1>
                <p class="pv-greeting__sub">Completa los 3 pasos para publicar tu hospedaje</p>
            </div>

            <div class="pv-ci-layout">

                <!-- WIZARD -->
                <div class="pv-ci-wizard-wrap">
                    <form id="formHospedaje"
                          action="<?= BASE_URL ?>proveedor_hotelero/guardar-hospedaje"
                          method="POST"
                          enctype="multipart/form-data">

                        <input type="hidden" name="accion" value="registrar">

                        <div class="pv-wizard">

                            <div class="pv-wizard__header">
                                <p class="pv-wizard__header-text">
                                    <i class="bi bi-building-gear"></i>
                                    Registro de Hospedaje
                                </p>
                            </div>

                            <div class="wizard-steps pv-wizard__steps">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Información</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Servicios</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <div class="step-label">Confirmación</div>
                                </div>
                            </div>

                            <div class="wizard-content pv-wizard__content">

                                <!-- PASO 1 — Información -->
                                <div class="step-content active" id="step-1" data-step="1">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-hotel"></i></div>
                                        <h4>Información del hospedaje</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="pv-form-label">Nombre del hospedaje *</label>
                                            <input type="text" class="pv-form-input" name="nombre" placeholder="Ej: Hotel Las Palmas" required>
                                        </div>

                                        <div class="col-12">
                                            <label class="pv-form-label mb-3">Tipo de hospedaje *</label>
                                            <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(5,1fr);">
                                                <?php
                                                $tiposHosp = [
                                                    ['id'=>'tipo_hotel',  'valor'=>'hotel',  'emoji'=>'🏨', 'label'=>'Hotel'],
                                                    ['id'=>'tipo_hostal', 'valor'=>'Hostal', 'emoji'=>'🛏', 'label'=>'Hostal'],
                                                    ['id'=>'tipo_finca',  'valor'=>'finca',  'emoji'=>'🌿', 'label'=>'Finca'],
                                                    ['id'=>'tipo_cabana', 'valor'=>'cabaña', 'emoji'=>'🏡', 'label'=>'Cabaña'],
                                                    ['id'=>'tipo_otro',   'valor'=>'otro',   'emoji'=>'🏕', 'label'=>'Otro'],
                                                ];
                                                foreach ($tiposHosp as $t): ?>
                                                <label class="pv-ci-activity-card" for="<?= $t['id'] ?>">
                                                    <input class="pv-ci-activity-card__check" type="checkbox"
                                                        name="tipo[]" id="<?= $t['id'] ?>" value="<?= $t['valor'] ?>">
                                                    <span class="pv-ci-activity-card__emoji"><?= $t['emoji'] ?></span>
                                                    <span class="pv-ci-activity-card__label"><?= $t['label'] ?></span>
                                                </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label">Capacidad (huéspedes) *</label>
                                            <input type="number" class="pv-form-input" name="capacidad" min="1" placeholder="Ej: 4" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label">Precio por noche *</label>
                                            <input type="number" class="pv-form-input" name="precio" step="0.01" placeholder="Ej: 150000" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label" for="id_departamento">Departamento *</label>
                                            <select name="id_departamento" id="id_departamento" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione departamento</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label" for="id_ciudad">Ciudad / Destino *</label>
                                            <select name="id_ciudad" id="id_ciudad" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione ciudad</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="pv-form-label">Ubicación / Dirección *</label>
                                            <input type="text" class="pv-form-input" name="ubicacion" placeholder="Calle 123 #45-67" required>
                                        </div>
                                    </div>

                                    <div class="wizard-actions pv-wizard__actions" style="margin-top:24px;">
                                        <span></span>
                                        <button type="button" class="pv-wizard__btn-next btn-primary-wizard" onclick="nextStep(2)">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- PASO 2 — Servicios -->
                                <div class="step-content" id="step-2" data-step="2">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-concierge-bell"></i></div>
                                        <h4>Servicios y detalles</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="pv-form-label mb-3">Servicios incluidos *</label>
                                            <div class="pv-ci-activities-grid" style="grid-template-columns:repeat(4,1fr);">
                                                <?php
                                                $serviciosOpts = [
                                                    ['id'=>'sv_wifi',       'valor'=>'WiFi',             'emoji'=>'📶'],
                                                    ['id'=>'sv_piscina',    'valor'=>'Piscina',           'emoji'=>'🏊'],
                                                    ['id'=>'sv_rest',       'valor'=>'Restaurante',       'emoji'=>'🍽'],
                                                    ['id'=>'sv_spa',        'valor'=>'Spa',               'emoji'=>'💆'],
                                                    ['id'=>'sv_parq',       'valor'=>'Parqueadero',       'emoji'=>'🚗'],
                                                    ['id'=>'sv_pet',        'valor'=>'Pet Friendly',      'emoji'=>'🐶'],
                                                    ['id'=>'sv_desayuno',   'valor'=>'Desayuno incluido', 'emoji'=>'☕'],
                                                    ['id'=>'sv_transporte', 'valor'=>'Transporte',        'emoji'=>'🚐'],
                                                ];
                                                foreach ($serviciosOpts as $s): ?>
                                                <label class="pv-ci-activity-card" for="<?= $s['id'] ?>">
                                                    <input class="pv-ci-activity-card__check" type="checkbox"
                                                        name="servicios[]" id="<?= $s['id'] ?>" value="<?= $s['valor'] ?>">
                                                    <span class="pv-ci-activity-card__emoji"><?= $s['emoji'] ?></span>
                                                    <span class="pv-ci-activity-card__label"><?= $s['valor'] ?></span>
                                                </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="pv-form-label">Descripción del hospedaje *</label>
                                            <textarea name="descripcion" id="descripcion" class="pv-form-input"
                                                rows="4" placeholder="Describe tu hospedaje, experiencia, ubicación y servicios..." required
                                                style="resize:vertical;min-height:100px;"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label">Estado</label>
                                            <select name="estado" class="pv-form-input pv-form-select">
                                                <option value="ACTIVO">Activo</option>
                                                <option value="INACTIVO">Inactivo</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="pv-form-label">Disponibilidad</label>
                                            <select name="disponible" class="pv-form-input pv-form-select">
                                                <option value="1">Disponible</option>
                                                <option value="0">No disponible</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="pv-form-label">Imágenes del hospedaje (máx. 5) *</label>
                                            <input type="file" name="imagenes[]" multiple required class="pv-form-input pv-form-input--file" accept=".jpg,.jpeg,.png">
                                            <small class="pv-form-hint">Selecciona hasta 5 imágenes (JPG o PNG), máx. 1 MB cada una.</small>
                                        </div>
                                    </div>

                                    <div class="wizard-actions pv-wizard__actions" style="margin-top:24px;">
                                        <button type="button" class="pv-wizard__btn-prev btn-secondary-wizard" onclick="nextStep(1)">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>
                                        <button type="button" class="pv-wizard__btn-next btn-primary-wizard" onclick="nextStep(3)">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- PASO 3 — Confirmación -->
                                <div class="step-content" id="step-3" data-step="3">
                                    <div class="pv-wizard__confirm-header">
                                        <div class="pv-wizard__confirm-icon"><i class="fas fa-check-circle"></i></div>
                                        <h4>Confirma tu Hospedaje</h4>
                                        <p>Revisa la información antes de guardar</p>
                                    </div>

                                    <div class="pv-preview-grid">
                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-hotel"></i> Información</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Nombre</span><span class="preview-value" id="prev-nombre">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Tipo</span><span class="preview-value" id="prev-tipo">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Capacidad</span><span class="preview-value" id="prev-capacidad">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Precio/noche</span><span class="preview-value" id="prev-precio">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card">
                                            <div class="pv-preview-card__header"><i class="fas fa-map-marker-alt"></i> Ubicación</div>
                                            <div class="pv-preview-card__body">
                                                <div class="pv-preview-field"><span class="pv-preview-label">Ciudad</span><span class="preview-value" id="prev-ciudad">—</span></div>
                                                <div class="pv-preview-field"><span class="pv-preview-label">Dirección</span><span class="preview-value" id="prev-ubicacion">—</span></div>
                                            </div>
                                        </div>

                                        <div class="pv-preview-card pv-preview-card--full">
                                            <div class="pv-preview-card__header"><i class="fas fa-concierge-bell"></i> Servicios</div>
                                            <div class="pv-preview-card__body">
                                                <div id="prev-servicios" class="pv-preview-activities">—</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-actions pv-wizard__actions" style="margin-top:24px;">
                                        <button type="button" class="pv-wizard__btn-prev btn-secondary-wizard" onclick="nextStep(2)">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>
                                        <button type="submit" class="pv-wizard__btn-next btn-primary-wizard">
                                            <i class="fas fa-check"></i> Guardar hospedaje
                                        </button>
                                    </div>
                                </div>

                            </div><!-- /.pv-wizard__content -->
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
                            <p class="pv-ci-info-item__text">Completa los datos de tu hospedaje para mostrarlo de forma profesional a los turistas.</p>
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
                        <div class="pv-ci-info-item__icon"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Imágenes atractivas</div>
                            <p class="pv-ci-info-item__text">Sube hasta 5 fotos de tu hospedaje para que los viajeros se enamoren de él.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-rocket-takeoff"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Registro rápido</div>
                            <p class="pv-ci-info-item__text">¡Regístralo hoy y comienza a recibir reservas de aventureros!</p>
                        </div>
                    </div>
                </aside>

            </div><!-- /.pv-ci-layout -->
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const body = document.body, darkBtn = document.getElementById('pv-dark-toggle'), darkIcon = document.getElementById('pv-dark-icon'), DARK_KEY = 'pv_dark_mode';
    function applyDark(on) { body.classList.toggle('pv-dark', on); darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill'; darkBtn.title = on ? 'Modo claro' : 'Modo oscuro'; localStorage.setItem(DARK_KEY, on ? '1' : '0'); }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

    function makeDropdown(bId, pId, cId) {
        const btn = document.getElementById(bId), panel = document.getElementById(pId), chev = cId ? document.getElementById(cId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => { e.stopPropagation(); const open = panel.classList.toggle('pv-dropdown--open'); if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open); document.querySelectorAll('.pv-dropdown--open').forEach(d => { if (d !== panel) d.classList.remove('pv-dropdown--open'); }); });
    }
    makeDropdown('pv-notif-btn', 'pv-notif-panel');
    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');
    document.addEventListener('click', () => { document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open')); document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open')); });

    const markAll = document.querySelector('.pv-dropdown__mark-all');
    if (markAll) markAll.addEventListener('click', () => document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread')));

    // Cards toggle
    document.querySelectorAll('.pv-ci-activity-card__check').forEach(check => {
        check.addEventListener('change', () => {
            check.closest('.pv-ci-activity-card')?.classList.toggle('pv-ci-activity-card--selected', check.checked);
        });
    });
})();
</script>

<!-- Departamento → Ciudad -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const depSel = document.getElementById('id_departamento');
    const ciudadSel = document.getElementById('id_ciudad');

    fetch('<?= BASE_URL ?>app/controllers/departamentoController.php')
        .then(r => r.json())
        .then(data => data.forEach(d => {
            const o = document.createElement('option');
            o.value = d.id_departamento; o.textContent = d.nombre;
            depSel.appendChild(o);
        }));

    depSel.addEventListener('change', () => {
        ciudadSel.innerHTML = '<option value="">Seleccione ciudad</option>';
        if (!depSel.value) return;
        fetch(`<?= BASE_URL ?>app/controllers/ciudadController.php?id_departamento=${depSel.value}`)
            .then(r => r.json())
            .then(data => data.forEach(c => {
                const o = document.createElement('option');
                o.value = c.id_ciudad; o.textContent = c.nombre;
                ciudadSel.appendChild(o);
            }));
    });
});
</script>

<!-- Wizard -->
<script>
function nextStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');

    document.querySelectorAll('.step').forEach(s => { s.classList.remove('active', 'completed'); });
    document.querySelector('.step[data-step="' + step + '"]').classList.add('active');
    for (let i = 1; i < step; i++) {
        document.querySelector('.step[data-step="' + i + '"]').classList.add('completed');
    }

    if (step === 3) cargarResumen();
}

function cargarResumen() {
    document.getElementById('prev-nombre').textContent =
        document.querySelector('input[name="nombre"]').value || '—';

    const tipos = [...document.querySelectorAll('input[name="tipo[]"]:checked')].map(el => el.value);
    document.getElementById('prev-tipo').textContent = tipos.length ? tipos.join(', ') : '—';

    document.getElementById('prev-capacidad').textContent =
        document.querySelector('input[name="capacidad"]').value || '—';

    const precio = document.querySelector('input[name="precio"]').value;
    document.getElementById('prev-precio').textContent = precio ? '$' + Number(precio).toLocaleString('es-CO') : '—';

    const ciudad = document.getElementById('id_ciudad');
    document.getElementById('prev-ciudad').textContent = ciudad?.options[ciudad.selectedIndex]?.text || '—';

    document.getElementById('prev-ubicacion').textContent =
        document.querySelector('input[name="ubicacion"]').value || '—';

    const servicios = [...document.querySelectorAll('input[name="servicios[]"]:checked')].map(el => el.value);
    const prevServ = document.getElementById('prev-servicios');
    prevServ.innerHTML = servicios.length
        ? servicios.map(s => `<span>${s}</span>`).join('')
        : '<span style="color:var(--pv-muted)">—</span>';
}
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
