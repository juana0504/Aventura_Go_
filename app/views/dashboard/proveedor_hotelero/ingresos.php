<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$activeSection = 'ingresos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos — AventuraGO</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/proveedorTuristico/ingresos.css">
</head>
<body class="pv-body">
<div class="pv-layout">

    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="pv-main">
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar hospedaje o turista..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro"><i class="bi bi-moon-fill" id="pv-dark-icon"></i></button>
                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn"><i class="bi bi-bell-fill"></i></button>
                    <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                        <div class="pv-dropdown__header"><span class="pv-dropdown__title">Notificaciones</span><button class="pv-dropdown__mark-all">Marcar todas</button></div>
                        <div class="pv-notif-list">
                            <div class="pv-notif-item pv-notif-item--unread">
                                <div class="pv-notif-item__icon pv-notif-item__icon--green"><i class="bi bi-cash-stack"></i></div>
                                <div class="pv-notif-item__body"><p class="pv-notif-item__text">Nueva reserva <strong>confirmada</strong> registrada.</p><span class="pv-notif-item__time">Hace 1 hora</span></div>
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
                        <a href="<?= BASE_URL ?>proveedor_hotelero/completar-informacion" class="pv-dropdown__item"><i class="bi bi-building-gear"></i> Mi empresa</a>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__item"><i class="bi bi-headset"></i> Soporte</a>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="pv-content">

            <div class="pv-ing-header">
                <div>
                    <div class="pv-greeting__eyebrow">Finanzas</div>
                    <h1 class="pv-page-title">Mis <span>Ingresos</span></h1>
                    <p class="pv-greeting__sub">Listado detallado de ingresos por reservas de hospedaje</p>
                </div>
                <a href="<?= BASE_URL ?>proveedor_hotelero/dashboard" class="pv-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al dashboard
                </a>
            </div>

            <?php
            $sumaTotal   = array_sum(array_column($ingresos ?? [], 'total'));
            $totalFilas  = count($ingresos ?? []);
            $confirmadas = count(array_filter($ingresos ?? [], fn($r) => $r['estado'] === 'confirmada'));
            $pendientes  = count(array_filter($ingresos ?? [], fn($r) => $r['estado'] === 'pendiente'));
            ?>
            <div class="pv-ing-stats">
                <div class="pv-ing-stat pv-ing-stat--featured">
                    <div class="pv-ing-stat__icon pv-ing-stat__icon--orange"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <div class="pv-ing-stat__label">Total Ingresos</div>
                        <div class="pv-ing-stat__value">$<?= number_format($sumaTotal, 2) ?></div>
                    </div>
                </div>
                <div class="pv-ing-stat">
                    <div class="pv-ing-stat__icon pv-ing-stat__icon--blue"><i class="bi bi-receipt"></i></div>
                    <div>
                        <div class="pv-ing-stat__label">Registros</div>
                        <div class="pv-ing-stat__value"><?= $totalFilas ?></div>
                    </div>
                </div>
                <div class="pv-ing-stat">
                    <div class="pv-ing-stat__icon pv-ing-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="pv-ing-stat__label">Confirmadas</div>
                        <div class="pv-ing-stat__value"><?= $confirmadas ?></div>
                    </div>
                </div>
                <div class="pv-ing-stat">
                    <div class="pv-ing-stat__icon pv-ing-stat__icon--amber"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <div class="pv-ing-stat__label">Pendientes</div>
                        <div class="pv-ing-stat__value"><?= $pendientes ?></div>
                    </div>
                </div>
            </div>

            <div class="pv-section-header" style="margin-bottom:14px;">
                <h2 class="pv-section-title">Detalle de <span>ingresos</span></h2>
            </div>

            <div class="pv-table-wrap">
                <table class="pv-table pv-ing-table" id="tablaIngresos">
                    <thead>
                        <tr>
                            <th><i class="bi bi-calendar"></i> Fecha reserva</th>
                            <th><i class="bi bi-calendar-event"></i> Fecha entrada</th>
                            <th><i class="bi bi-building"></i> Hospedaje</th>
                            <th class="text-end"><i class="bi bi-people"></i> Personas</th>
                            <th class="text-end"><i class="bi bi-tag"></i> Precio/noche</th>
                            <th class="text-end"><i class="bi bi-cash"></i> Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ingresos)): ?>
                            <?php $sumaFila = 0; ?>
                            <?php foreach ($ingresos as $row): ?>
                                <?php $sumaFila += (float)$row['total']; ?>
                                <tr>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['fecha_reserva']))) ?></td>
                                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['fecha_actividad']))) ?></td>
                                    <td>
                                        <div class="pv-table__name"><?= htmlspecialchars($row['nombre_actividad']) ?></div>
                                    </td>
                                    <td class="text-end">
                                        <span class="pv-personas"><i class="bi bi-people"></i> <?= number_format($row['cantidad_personas']) ?></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="pv-ing-currency">$<?= number_format($row['precio'], 2) ?></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="pv-ing-currency pv-ing-currency--total">$<?= number_format($row['total'], 2) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $est = $row['estado'];
                                        $badgeClass = match($est) {
                                            'confirmada' => 'pv-badge pv-badge--confirmed',
                                            'pendiente'  => 'pv-badge pv-badge--pending',
                                            default      => 'pv-badge pv-badge--cancelled',
                                        };
                                        ?>
                                        <span class="<?= $badgeClass ?>"><span class="pv-badge__dot"></span> <?= htmlspecialchars($est) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="pv-ing-total-row">
                                <td colspan="5" class="text-end pv-ing-total-label"><i class="bi bi-calculator"></i> Total acumulado:</td>
                                <td class="text-end"><span class="pv-ing-total-value">$<?= number_format($sumaFila, 2) ?></span></td>
                                <td></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="pv-empty-state">
                                        <i class="bi bi-inbox pv-empty-state__icon"></i>
                                        <p><strong>No se encontraron ingresos</strong></p>
                                        <small>Cuando tengas reservas confirmadas, aparecerán aquí</small>
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
    const searchInput = document.getElementById('pv-search-input');
    if (searchInput) searchInput.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();
        document.querySelectorAll('#tablaIngresos tbody tr:not(.pv-ing-total-row)').forEach(row => {
            row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
        });
    });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
