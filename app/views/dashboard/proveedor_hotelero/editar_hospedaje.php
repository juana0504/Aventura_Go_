<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/Proveedor_hotelero.php';
require_once BASE_PATH . '/app/models/Ciudad.php';

$id_hospedaje = (int)($_GET['id'] ?? 0);
if (!$id_hospedaje) {
    header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-hospedajes');
    exit;
}

$hospedajeModel        = new Hospedaje();
$h                     = $hospedajeModel->listarPorId($id_hospedaje);
$id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);

if (!$h || (int)$h['id_proveedor_hotelero'] !== (int)$id_proveedor_hotelero) {
    header('Location: ' . BASE_URL . 'proveedor_hotelero/consultar-hospedajes');
    exit;
}

$ciudadModel = new Ciudad();
$ciudades    = $ciudadModel->obtenerCiudadesActivas();

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$activeSection = 'hospedajes';

$tiposExistentes = array_map('trim', explode(',', $h['tipo'] ?? ''));
$serviciosExistentes = array_map('trim', explode(',', $h['servicios'] ?? ''));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Hospedaje — AventuraGO</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
    <style>
        .pv-edit-card { max-width:860px; }
        .pv-form-card { background:var(--pv-surface,#fff); border:1px solid var(--pv-border,#e2e8f0); border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.05); }
        .pv-form-card__header { background:#1a2b3c; color:#fff; padding:16px 24px; display:flex; align-items:center; gap:10px; font-family:'Bebas Neue',sans-serif; font-size:1.1rem; letter-spacing:1px; border-bottom:3px solid #ea8217; }
        .pv-form-card__header i { color:#ea8217; }
        .pv-form-card__body { padding:28px; }
        .pv-form-label { display:block; font-size:.75rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.6px; margin-bottom:7px; }
        .pv-form-input, .pv-form-select, .pv-form-textarea { width:100%; background:var(--pv-bg,#f8fafc); border:1px solid var(--pv-border,#e2e8f0); border-radius:8px; padding:11px 14px; color:var(--pv-text,#1e293b); font-size:.92rem; font-family:'DM Sans',sans-serif; transition:border-color .2s,box-shadow .2s; }
        .pv-form-input:focus, .pv-form-select:focus, .pv-form-textarea:focus { outline:none; border-color:#ea8217; box-shadow:0 0 0 3px rgba(234,130,23,.12); background:#fff; }
        .pv-form-textarea { resize:vertical; min-height:110px; }
        .pv-form-section { font-size:.72rem; font-weight:700; color:#ea8217; text-transform:uppercase; letter-spacing:.8px; margin:24px 0 12px; }
        .pv-check-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:8px; }
        .pv-check-item { display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; border:1px solid var(--pv-border,#e2e8f0); cursor:pointer; font-size:.88rem; transition:all .15s; }
        .pv-check-item:hover { border-color:#ea8217; background:#fff7ed; }
        .pv-check-item input[type=checkbox]:checked + span { color:#ea8217; font-weight:600; }
        .pv-form-actions { display:flex; align-items:center; gap:14px; margin-top:28px; }
        .pv-btn-back-link { display:inline-flex; align-items:center; gap:6px; color:#64748b; font-size:.88rem; font-weight:500; text-decoration:none; padding:10px 14px; border-radius:8px; transition:all .2s; }
        .pv-btn-back-link:hover { color:#1a2b3c; background:var(--pv-bg,#f1f5f9); }
    </style>
</head>
<body class="pv-body">
<div class="pv-layout">

    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="pv-main">
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar..." class="pv-topbar__input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro"><i class="bi bi-moon-fill" id="pv-dark-icon"></i></button>
                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn"><i class="bi bi-bell-fill"></i></button>
                    <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                        <div class="pv-dropdown__header"><span class="pv-dropdown__title">Notificaciones</span><button class="pv-dropdown__mark-all">Marcar todas</button></div>
                        <div class="pv-notif-list"></div>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__footer">Ver todas</a>
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

        <main class="pv-content">
            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Hospedajes</div>
                    <h1 class="pv-page-title">Editar <span>Hospedaje</span></h1>
                    <p class="pv-greeting__sub">Modifica la información de tu hospedaje</p>
                </div>
            </div>

            <div class="pv-edit-card">
                <div class="pv-form-card">
                    <div class="pv-form-card__header">
                        <i class="bi bi-pencil-square"></i>
                        Editar: <?= htmlspecialchars($h['nombre']) ?>
                    </div>
                    <div class="pv-form-card__body">
                        <form method="POST" action="<?= BASE_URL ?>proveedor_hotelero/actualizar-hospedaje">
                            <input type="hidden" name="accion" value="actualizar">
                            <input type="hidden" name="id_hospedaje" value="<?= $h['id_hospedaje'] ?>">
                            <input type="hidden" name="id_proveedor_hotelero" value="<?= $id_proveedor_hotelero ?>">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="pv-form-label">Nombre del hospedaje</label>
                                    <input type="text" name="nombre" class="pv-form-input" value="<?= htmlspecialchars($h['nombre']) ?>" required maxlength="150">
                                </div>
                                <div class="col-12">
                                    <label class="pv-form-label">Descripción</label>
                                    <textarea name="descripcion" class="pv-form-textarea" required><?= htmlspecialchars($h['descripcion'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <div class="pv-form-section"><i class="bi bi-building"></i> Tipo de hospedaje</div>
                            <div class="pv-check-grid">
                                <?php
                                $tipos = ['Hotel' => '🏨', 'Hostal' => '🛏', 'Finca' => '🌿', 'Cabaña' => '🏡', 'Otro' => '🏕'];
                                foreach ($tipos as $valor => $emoji):
                                    $checked = in_array(strtolower($valor), array_map('strtolower', $tiposExistentes)) ? 'checked' : '';
                                ?>
                                    <label class="pv-check-item">
                                        <input type="checkbox" name="tipo[]" value="<?= $valor ?>" <?= $checked ?>>
                                        <span><?= $emoji ?> <?= $valor ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="pv-form-label">Ciudad / Destino</label>
                                    <select name="id_ciudad" class="pv-form-select" required>
                                        <option value="">Seleccione ciudad</option>
                                        <?php foreach ($ciudades as $c): ?>
                                            <option value="<?= $c['id_ciudad'] ?>" <?= (int)$c['id_ciudad'] === (int)$h['id_ciudad'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-form-label">Ubicación (dirección)</label>
                                    <input type="text" name="ubicacion" class="pv-form-input" value="<?= htmlspecialchars($h['ubicacion']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-form-label">Capacidad (personas)</label>
                                    <input type="number" name="capacidad" class="pv-form-input" value="<?= $h['capacidad'] ?>" min="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-form-label">Precio por noche (COP)</label>
                                    <input type="number" name="precio" class="pv-form-input" step="0.01" value="<?= $h['precio'] ?>" min="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="pv-form-label">Estado</label>
                                    <select name="estado" class="pv-form-select">
                                        <option value="ACTIVO"  <?= strtoupper($h['estado']) === 'ACTIVO'   ? 'selected' : '' ?>>Activo</option>
                                        <option value="INACTIVO" <?= strtoupper($h['estado']) !== 'ACTIVO'  ? 'selected' : '' ?>>Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pv-form-section"><i class="bi bi-star"></i> Servicios</div>
                            <div class="pv-check-grid">
                                <?php
                                $serviciosList = ['WiFi', 'Parqueadero', 'Piscina', 'Restaurante', 'Bar', 'Spa', 'Gym', 'Aire acondicionado', 'TV por cable', 'Lavandería'];
                                foreach ($serviciosList as $s):
                                    $checked = in_array(strtolower($s), array_map('strtolower', $serviciosExistentes)) ? 'checked' : '';
                                ?>
                                    <label class="pv-check-item">
                                        <input type="checkbox" name="servicios[]" value="<?= $s ?>" <?= $checked ?>>
                                        <span><?= $s ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="pv-form-actions">
                                <button type="submit" class="pv-btn-primary"><i class="bi bi-save"></i> Guardar cambios</button>
                                <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hospedajes" class="pv-btn-back-link"><i class="bi bi-arrow-left"></i> Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const body = document.body, darkBtn = document.getElementById('pv-dark-toggle'), darkIcon = document.getElementById('pv-dark-icon'), DARK_KEY = 'pv_dark_mode';
    function applyDark(on) { body.classList.toggle('pv-dark', on); darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill'; localStorage.setItem(DARK_KEY, on ? '1' : '0'); }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));
    function makeDropdown(bId, pId, cId) {
        const btn = document.getElementById(bId), panel = document.getElementById(pId), chev = cId ? document.getElementById(cId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => { e.stopPropagation(); const open = panel.classList.toggle('pv-dropdown--open'); if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open); });
    }
    makeDropdown('pv-notif-btn','pv-notif-panel'); makeDropdown('pv-profile-btn','pv-profile-panel','pv-profile-chevron');
    document.addEventListener('click', () => { document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open')); });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
