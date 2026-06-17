<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: ' . BASE_URL . 'proveedor/consultar-actividad');
    exit;
}

$actividadController = listarActividadId($id);

if (!$actividadController) {
    header('Location: ' . BASE_URL . 'proveedor/consultar-actividad');
    exit;
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
    <title>Editar Actividad — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/registrar_actividad_turistica/registrar_actividad_turistica.css">
</head>

<body class="pv-body">

<div class="pv-layout">

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
        <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-nav-item pv-nav-item--active">
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
        <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-nav-item">
            <i class="bi bi-building pv-nav-item__icon"></i> Mi Empresa
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
                        <a href="<?= BASE_URL ?>proveedor/completar-informacion" class="pv-dropdown__item"><i class="bi bi-building"></i> Mi empresa</a>
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
                <div class="pv-greeting__eyebrow">Gestión</div>
                <h1 class="pv-page-title">Editar <span>Actividad</span></h1>
                <p class="pv-greeting__sub">Modifica los datos de tu experiencia turística</p>
            </div>

            <div class="pv-ra-layout">

                <!-- FORMULARIO WIZARD -->
                <div class="pv-ra-wizard-wrap">

                    <form id="formActividad" action="<?= BASE_URL ?>proveedor/actualizar-actividad" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id_actividad" value="<?= (int)$actividadController['id_actividad'] ?>">
                        <input type="hidden" name="id_proveedor" value="<?= (int)$actividadController['id_proveedor'] ?>">

                        <div class="pv-wizard">

                            <!-- Header -->
                            <div class="pv-wizard__header">
                                <p class="pv-wizard__header-text">
                                    <i class="bi bi-pencil-square"></i>
                                    Editar Actividad Turística
                                </p>
                            </div>

                            <!-- Pasos -->
                            <div class="wizard-steps pv-wizard__steps">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <div class="step-label">Información</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <div class="step-label">Descripción</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <div class="step-label">Precio</div>
                                </div>
                            </div>

                            <!-- Contenido pasos -->
                            <div class="pv-wizard__content">

                                <!-- PASO 1 — Información básica -->
                                <div class="wizard-step active" id="step-1">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-map-marked-alt"></i></div>
                                        <h4>Información básica</h4>
                                    </div>

                                    <label class="pv-form-label">Nombre de la actividad</label>
                                    <input type="text" name="nombre" class="pv-form-input"
                                        value="<?= htmlspecialchars($actividadController['nombre']) ?>" required>

                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Departamento</label>
                                            <select name="id_departamento" id="id_departamento" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione departamento</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Ciudad / Destino</label>
                                            <select name="id_ciudad" id="id_ciudad" class="pv-form-input pv-form-select" required>
                                                <option value="">Seleccione ciudad</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="pv-form-label mt-3">Ubicación exacta</label>
                                    <input type="text" name="ubicacion" class="pv-form-input"
                                        value="<?= htmlspecialchars($actividadController['ubicacion']) ?>" required>

                                    <div class="pv-wizard__actions">
                                        <span></span>
                                        <button type="button" class="pv-wizard__btn-next" onclick="nextStep(2)">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- PASO 2 — Descripción y cupos -->
                                <div class="wizard-step" id="step-2">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-align-left"></i></div>
                                        <h4>Descripción y cupos</h4>
                                    </div>

                                    <label class="pv-form-label">Descripción</label>
                                    <textarea name="descripcion" class="pv-form-input pv-form-textarea" rows="4" required><?= htmlspecialchars($actividadController['descripcion']) ?></textarea>

                                    <label class="pv-form-label mt-3">Cupos disponibles</label>
                                    <input type="number" name="cupos" class="pv-form-input" min="1"
                                        value="<?= (int)$actividadController['cupos'] ?>" required>

                                    <div class="pv-wizard__actions">
                                        <button type="button" class="pv-wizard__btn-prev" onclick="prevStep(1)">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>
                                        <button type="button" class="pv-wizard__btn-next" onclick="nextStep(3)">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- PASO 3 — Precio, estado e imágenes -->
                                <div class="wizard-step" id="step-3">
                                    <div class="pv-wizard__step-title">
                                        <div class="pv-wizard__step-icon"><i class="fas fa-dollar-sign"></i></div>
                                        <h4>Precio, estado e imágenes</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Precio (COP)</label>
                                            <input type="number" name="precio" class="pv-form-input" min="0"
                                                value="<?= (int)$actividadController['precio'] ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pv-form-label">Estado</label>
                                            <select name="estado" class="pv-form-input pv-form-select">
                                                <option value="ACTIVO" <?= ($actividadController['estado'] === 'ACTIVO') ? 'selected' : '' ?>>Activa</option>
                                                <option value="INACTIVO" <?= ($actividadController['estado'] === 'INACTIVO') ? 'selected' : '' ?>>Inactiva</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="pv-form-label mt-3">
                                        Reemplazar imágenes
                                        <small class="pv-form-hint">(opcional — máx. 5, JPG/PNG, 2 MB c/u)</small>
                                    </label>
                                    <input type="file" name="imagenes[]" class="pv-form-input pv-form-input--file"
                                        multiple accept=".jpg,.jpeg,.png">

                                    <div class="pv-wizard__actions">
                                        <button type="button" class="pv-wizard__btn-prev" onclick="prevStep(2)">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>
                                        <button type="submit" class="pv-wizard__btn-next">
                                            <i class="bi bi-check-lg"></i> Actualizar actividad
                                        </button>
                                    </div>
                                </div>

                            </div><!-- /.pv-wizard__content -->
                        </div><!-- /.pv-wizard -->
                    </form>

                </div><!-- /.pv-ra-wizard-wrap -->

                <!-- PANEL INFORMATIVO -->
                <aside class="pv-ci-info-panel">

                    <div class="pv-ci-info-logo">
                        <img src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/completar_informacion/img/image.png"
                             alt="AventuraGO" onerror="this.style.display='none'">
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-pencil-square"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Editando actividad</div>
                            <p class="pv-ci-info-item__text">
                                Estás modificando: <strong><?= htmlspecialchars($actividadController['nombre']) ?></strong>
                            </p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Imágenes opcionales</div>
                            <p class="pv-ci-info-item__text">Si no subes nuevas imágenes, se conservan las actuales. Si subes nuevas, reemplazan las anteriores.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Ciudad actual</div>
                            <p class="pv-ci-info-item__text">Selecciona departamento y luego ciudad para cambiar la ubicación de tu actividad.</p>
                        </div>
                    </div>

                    <div class="pv-ci-info-item">
                        <div class="pv-ci-info-item__icon"><i class="bi bi-arrow-left-circle"></i></div>
                        <div>
                            <div class="pv-ci-info-item__title">Volver sin guardar</div>
                            <p class="pv-ci-info-item__text">
                                <a href="<?= BASE_URL ?>proveedor/consultar-actividad" style="color:var(--pv-primary);font-weight:600;">
                                    ← Mis actividades
                                </a>
                            </p>
                        </div>
                    </div>

                </aside>

            </div><!-- /.pv-ra-layout -->

        </main>
    </div>
</div>


<!-- JS DEPARTAMENTO → CIUDAD con preselección -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const departamentoSelect = document.getElementById('id_departamento');
    const ciudadSelect       = document.getElementById('id_ciudad');
    const currentCityId      = <?= (int)($actividadController['id_ciudad'] ?? 0) ?>;

    fetch('<?= BASE_URL ?>departamentos')
        .then(res => res.json())
        .then(data => {
            data.forEach(dep => {
                const opt = document.createElement('option');
                opt.value = dep.id_departamento;
                opt.textContent = dep.nombre;
                departamentoSelect.appendChild(opt);
            });

            // Si hay una ciudad actual, buscamos qué departamento le corresponde
            if (currentCityId) {
                fetch('<?= BASE_URL ?>ciudades?find_departamento=' + currentCityId)
                    .then(r => r.json())
                    .then(info => {
                        if (info && info.id_departamento) {
                            departamentoSelect.value = info.id_departamento;
                            departamentoSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(() => {});
            }
        });

    departamentoSelect.addEventListener('change', () => {
        ciudadSelect.innerHTML = '<option value="">Seleccione ciudad</option>';
        if (!departamentoSelect.value) return;

        fetch(`<?= BASE_URL ?>ciudades?id_departamento=${departamentoSelect.value}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(ciudad => {
                    const opt = document.createElement('option');
                    opt.value = ciudad.id_ciudad;
                    opt.textContent = ciudad.nombre;
                    if (ciudad.id_ciudad == currentCityId) opt.selected = true;
                    ciudadSelect.appendChild(opt);
                });
            });
    });
});
</script>

<!-- JS WIZARD -->
<script>
function nextStep(step) {
    document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');

    document.querySelectorAll('.step').forEach(el => {
        const s = parseInt(el.dataset.step);
        el.classList.toggle('active', s <= step);
    });
}

function prevStep(step) {
    nextStep(step);
}
</script>

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
        });
    }

    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });
})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
