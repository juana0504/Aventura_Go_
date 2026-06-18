<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';
require_once BASE_PATH . '/app/models/proveedor_hotelero/Proveedor_hotelero.php';

try {
    $id_proveedor_hotelero = (new Proveedor())->obtenerIdProveedorPorUsuario($_SESSION['user']['id_usuario']);
    $hospedajeModel = new Hospedaje();
    $datos = $id_proveedor_hotelero ? $hospedajeModel->listarPorProveedor($id_proveedor_hotelero) : [];
} catch (Throwable $e) {
    error_log('consultar_hospedaje error: ' . $e->getMessage());
    $datos = [];
}

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$activeSection = 'hospedajes';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Hospedajes — AventuraGO</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
</head>
<body class="pv-body">
<div class="pv-layout">

    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="pv-main">
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar hospedajes..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro"><i class="bi bi-moon-fill" id="pv-dark-icon"></i></button>
                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn"><i class="bi bi-bell-fill"></i></button>
                    <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                        <div class="pv-dropdown__header"><span class="pv-dropdown__title">Notificaciones</span><button class="pv-dropdown__mark-all">Marcar todas</button></div>
                        <div class="pv-notif-list">
                            <div class="pv-notif-item pv-notif-item--unread">
                                <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                <div class="pv-notif-item__body"><p class="pv-notif-item__text">Tienes reservas pendientes de confirmación.</p><span class="pv-notif-item__time">Ahora</span></div>
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

        <main class="pv-content">
            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Gestión</div>
                    <h1 class="pv-page-title">Mis <span>Hospedajes</span></h1>
                    <p class="pv-greeting__sub">Consulta, edita y administra tus hospedajes</p>
                </div>
                <div class="pv-page-header__actions">
                    <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedajes" class="pv-btn-primary">
                        <i class="bi bi-plus-lg"></i> Nuevo hospedaje
                    </a>
                </div>
            </div>

            <?php
            $total    = count($datos ?? []);
            $activos  = count(array_filter($datos ?? [], fn($a) => strtoupper($a['estado']) === 'ACTIVO'));
            $inactivos = $total - $activos;
            ?>
            <div class="pv-act-stats">
                <div class="pv-act-stat pv-act-stat--featured">
                    <div class="pv-act-stat__icon pv-act-stat__icon--orange"><i class="bi bi-building-fill"></i></div>
                    <div><div class="pv-act-stat__label">Total</div><div class="pv-act-stat__value"><?= $total ?></div></div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon pv-act-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div><div class="pv-act-stat__label">Activos</div><div class="pv-act-stat__value"><?= $activos ?></div></div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon pv-act-stat__icon--red"><i class="bi bi-pause-circle-fill"></i></div>
                    <div><div class="pv-act-stat__label">Inactivos</div><div class="pv-act-stat__value"><?= $inactivos ?></div></div>
                </div>
            </div>

            <div class="pv-act-filters">
                <button class="pv-act-filter pv-act-filter--active" data-filter="all"><i class="bi bi-grid"></i> Todos</button>
                <button class="pv-act-filter" data-filter="activo"><i class="bi bi-check-circle"></i> Activos</button>
                <button class="pv-act-filter" data-filter="inactivo"><i class="bi bi-pause-circle"></i> Inactivos</button>
            </div>

            <div class="pv-section-header" style="margin-bottom:14px;">
                <h2 class="pv-section-title">Listado de <span>hospedajes</span></h2>
            </div>

            <div class="pv-table-wrap">
                <table class="pv-table" id="tablaHospedajes">
                    <thead>
                        <tr>
                            <th>Hospedaje</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Capacidad</th>
                            <th>Precio/noche</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos)): ?>
                            <?php foreach ($datos as $h): ?>
                                <tr data-estado="<?= strtolower($h['estado']) ?>">
                                    <td>
                                        <div class="pv-table__name"><?= htmlspecialchars($h['nombre']) ?></div>
                                        <?php if (!empty($h['descripcion'])): ?>
                                            <div class="pv-table__meta" style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($h['descripcion']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($h['tipo'] ?? '—') ?></td>
                                    <td><?= htmlspecialchars($h['ubicacion'] ?? '—') ?></td>
                                    <td><span class="pv-cupos"><i class="bi bi-people"></i> <?= $h['capacidad'] ?></span></td>
                                    <td><span class="pv-precio">$<?= number_format($h['precio'], 0, ',', '.') ?></span></td>
                                    <td>
                                        <?php if (strtoupper($h['estado']) === 'ACTIVO'): ?>
                                            <span class="pv-badge pv-badge--confirmed"><span class="pv-badge__dot"></span> Activo</span>
                                        <?php else: ?>
                                            <span class="pv-badge pv-badge--cancelled"><span class="pv-badge__dot"></span> Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="pv-act-actions">
                                            <a href="<?= BASE_URL ?>proveedor_hotelero/editar-hospedaje?id=<?= $h['id_hospedaje'] ?>"
                                               class="pv-act-btn pv-act-btn--edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if (strtoupper($h['estado']) === 'ACTIVO'): ?>
                                                <button class="pv-act-btn pv-act-btn--delete" title="Pausar"
                                                        data-bs-toggle="modal" data-bs-target="#modalPausar"
                                                        data-href="<?= BASE_URL ?>proveedor_hotelero/guardar-hospedaje?accion=desactivar&id_usuario=<?= $h['id_hospedaje'] ?>"
                                                        data-nombre="<?= htmlspecialchars($h['nombre']) ?>">
                                                    <i class="bi bi-pause-circle"></i>
                                                </button>
                                            <?php else: ?>
                                                <a href="<?= BASE_URL ?>proveedor_hotelero/guardar-hospedaje?accion=activar&id_usuario=<?= $h['id_hospedaje'] ?>"
                                                   class="pv-act-btn pv-act-btn--confirm" title="Activar">
                                                    <i class="bi bi-play-circle"></i>
                                                </a>
                                            <?php endif; ?>
                                            <button class="pv-act-btn pv-act-btn--delete" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                                    data-href="<?= BASE_URL ?>proveedor_hotelero/guardar-hospedaje?accion=eliminar&id_usuario=<?= $h['id_hospedaje'] ?>"
                                                    data-nombre="<?= htmlspecialchars($h['nombre']) ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="pv-empty-state">
                                        <i class="bi bi-building pv-empty-state__icon"></i>
                                        <p>No hay hospedajes registrados aún.</p>
                                        <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedajes" class="pv-btn-primary">
                                            <i class="bi bi-plus-lg"></i> Registrar hospedaje
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
    const markAll = document.querySelector('.pv-dropdown__mark-all');
    if (markAll) markAll.addEventListener('click', () => document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread')));

    const filtros = document.querySelectorAll('.pv-act-filter');
    const filas   = document.querySelectorAll('#tablaHospedajes tbody tr[data-estado]');
    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('pv-act-filter--active'));
            btn.classList.add('pv-act-filter--active');
            const f = btn.dataset.filter;
            filas.forEach(row => {
                const est = row.dataset.estado;
                const show = f === 'all' || (f === 'activo' && est === 'activo') || (f === 'inactivo' && est !== 'activo');
                row.style.display = show ? '' : 'none';
            });
        });
    });

    const searchInput = document.getElementById('pv-search-input');
    if (searchInput) searchInput.addEventListener('input', () => { const q = searchInput.value.toLowerCase().trim(); filas.forEach(row => { row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none'; }); });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>

<!-- MODAL PAUSAR -->
<div class="modal fade" id="modalPausar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.18);">
            <div style="background:linear-gradient(135deg,#f59e0b,#d97706);padding:28px 24px 22px;text-align:center;">
                <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;backdrop-filter:blur(4px);">
                    <i class="bi bi-pause-circle-fill" style="font-size:28px;color:#fff;"></i>
                </div>
                <h5 style="color:#fff;font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin:0 0 4px;">¿Pausar hospedaje?</h5>
                <p id="pausar-nombre" style="color:rgba(255,255,255,.8);font-size:13px;margin:0;font-style:italic;"></p>
            </div>
            <div style="padding:24px;background:#fff;">
                <p style="color:#374151;font-size:14px;line-height:1.65;margin:0 0 22px;text-align:center;">
                    Este hospedaje <strong>dejará de ser visible</strong> para los turistas mientras esté pausado.<br>
                    Puedes reactivarlo en cualquier momento desde esta misma sección.
                </p>
                <div style="display:flex;gap:10px;">
                    <button data-bs-dismiss="modal"
                            style="flex:1;padding:12px;background:#f1f5f9;color:#374151;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;transition:background .15s;"
                            onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Cancelar
                    </button>
                    <a id="pausar-confirm-btn" href="#"
                       style="flex:1;padding:12px;background:#f59e0b;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s;"
                       onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                        <i class="bi bi-pause-circle"></i> Sí, pausar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.18);">
            <div style="background:linear-gradient(135deg,#ef4444,#dc2626);padding:28px 24px 22px;text-align:center;">
                <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;backdrop-filter:blur(4px);">
                    <i class="bi bi-trash3-fill" style="font-size:28px;color:#fff;"></i>
                </div>
                <h5 style="color:#fff;font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:1px;margin:0 0 4px;">¿Eliminar hospedaje?</h5>
                <p id="eliminar-nombre" style="color:rgba(255,255,255,.8);font-size:13px;margin:0;font-style:italic;"></p>
            </div>
            <div style="padding:24px;background:#fff;">
                <p style="color:#374151;font-size:14px;line-height:1.65;margin:0 0 22px;text-align:center;">
                    Esta acción <strong>no podrá deshacerse</strong>. El hospedaje y todos sus datos serán eliminados permanentemente.
                </p>
                <div style="display:flex;gap:10px;">
                    <button data-bs-dismiss="modal"
                            style="flex:1;padding:12px;background:#f1f5f9;color:#374151;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;transition:background .15s;"
                            onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Cancelar
                    </button>
                    <a id="eliminar-confirm-btn" href="#"
                       style="flex:1;padding:12px;background:#ef4444;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;transition:background .15s;"
                       onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                        <i class="bi bi-trash"></i> Sí, eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('modalPausar').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('pausar-confirm-btn').href = btn.dataset.href;
    document.getElementById('pausar-nombre').textContent = btn.dataset.nombre || '';
});
document.getElementById('modalEliminar').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('eliminar-confirm-btn').href = btn.dataset.href;
    document.getElementById('eliminar-nombre').textContent = btn.dataset.nombre || '';
});
</script>
</body>
</html>
