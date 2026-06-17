<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$activeSection = 'reservas';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas — AventuraGO Hotelero</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_reservas/consultar_reservas.css">
</head>
<body class="pv-body">
<div class="pv-layout">

    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="pv-main">
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar reservas, huéspedes..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="pv-dark-icon"></i>
                </button>
                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn"><i class="bi bi-bell-fill"></i></button>
                    <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                        <div class="pv-dropdown__header">
                            <span class="pv-dropdown__title">Notificaciones</span>
                            <button class="pv-dropdown__mark-all">Marcar todas</button>
                        </div>
                        <div class="pv-notif-list">
                            <div class="pv-notif-item pv-notif-item--unread">
                                <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                <div class="pv-notif-item__body">
                                    <p class="pv-notif-item__text">Tienes una reserva <strong>pendiente</strong> de confirmación.</p>
                                    <span class="pv-notif-item__time">Hace 30 min</span>
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

        <main class="pv-content">
            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Gestión</div>
                    <h1 class="pv-page-title">Reservas de <span>Hospedajes</span></h1>
                    <p class="pv-greeting__sub">Confirma o cancela las reservas de tus hospedajes</p>
                </div>
                <a href="<?= BASE_URL ?>proveedor_hotelero/pdf-reservas?filtro=<?= urlencode($filtro ?? 'all') ?>" class="pv-btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                </a>
            </div>

            <?php
            $total       = count($reservas ?? []);
            $pendientes  = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'pendiente'));
            $confirmadas = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'confirmada'));
            $canceladas  = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'cancelada'));
            ?>
            <div class="pv-rv-stats">
                <div class="pv-rv-stat pv-rv-stat--featured">
                    <div class="pv-rv-stat__icon pv-rv-stat__icon--orange"><i class="bi bi-calendar3"></i></div>
                    <div><div class="pv-rv-stat__label">Total</div><div class="pv-rv-stat__value"><?= $total ?></div></div>
                </div>
                <div class="pv-rv-stat">
                    <div class="pv-rv-stat__icon pv-rv-stat__icon--amber"><i class="bi bi-clock-fill"></i></div>
                    <div><div class="pv-rv-stat__label">Pendientes</div><div class="pv-rv-stat__value"><?= $pendientes ?></div></div>
                </div>
                <div class="pv-rv-stat">
                    <div class="pv-rv-stat__icon pv-rv-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div><div class="pv-rv-stat__label">Confirmadas</div><div class="pv-rv-stat__value"><?= $confirmadas ?></div></div>
                </div>
                <div class="pv-rv-stat">
                    <div class="pv-rv-stat__icon pv-rv-stat__icon--red"><i class="bi bi-x-circle-fill"></i></div>
                    <div><div class="pv-rv-stat__label">Canceladas</div><div class="pv-rv-stat__value"><?= $canceladas ?></div></div>
                </div>
            </div>

            <div class="pv-rv-filters">
                <?php $filtroActual = $filtro ?? 'all'; ?>
                <button class="pv-rv-filter <?= $filtroActual==='all'       ? 'pv-rv-filter--active':'' ?>" data-filter="all"><i class="bi bi-grid"></i> Todos</button>
                <button class="pv-rv-filter <?= $filtroActual==='pendiente' ? 'pv-rv-filter--active':'' ?>" data-filter="pendiente"><i class="bi bi-clock"></i> Pendientes</button>
                <button class="pv-rv-filter <?= $filtroActual==='confirmada'? 'pv-rv-filter--active':'' ?>" data-filter="confirmada"><i class="bi bi-check-circle"></i> Confirmadas</button>
                <button class="pv-rv-filter <?= $filtroActual==='cancelada' ? 'pv-rv-filter--active':'' ?>" data-filter="cancelada"><i class="bi bi-x-circle"></i> Canceladas</button>
            </div>

            <div class="pv-section-header" style="margin-bottom:14px;">
                <h2 class="pv-section-title">Historial de <span>reservas</span></h2>
            </div>

            <div class="pv-table-wrap">
                <table class="pv-table" id="tablaReservas">
                    <thead>
                        <tr>
                            <th>Huésped</th>
                            <th>Hospedaje</th>
                            <th>Fecha entrada</th>
                            <th>Personas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reservas)): ?>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <div class="pv-table__name"><?= htmlspecialchars($reserva['nombre_turista'] ?? '—') ?></div>
                                        <?php if (!empty($reserva['email_turista'])): ?>
                                            <div class="pv-table__meta"><?= htmlspecialchars($reserva['email_turista']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="pv-table__name"><?= htmlspecialchars($reserva['nombre_hospedaje']) ?></div>
                                        <div class="pv-table__meta"><?= htmlspecialchars($reserva['ubicacion'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <div><?= date('d/m/Y', strtotime($reserva['fecha'])) ?></div>
                                        <div class="pv-table__meta">Reservado: <?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?></div>
                                    </td>
                                    <td>
                                        <span class="pv-personas"><i class="bi bi-people"></i> <?= $reserva['cantidad_personas'] ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $est = $reserva['estado'];
                                        $bc  = match($est) {
                                            'confirmada' => 'pv-badge pv-badge--confirmed',
                                            'pendiente'  => 'pv-badge pv-badge--pending',
                                            default      => 'pv-badge pv-badge--cancelled',
                                        };
                                        ?>
                                        <span class="<?= $bc ?>"><span class="pv-badge__dot"></span> <?= ucfirst($est) ?></span>
                                    </td>
                                    <td>
                                        <div class="pv-act-actions">
                                            <button class="pv-act-btn pv-act-btn--view btn-ver"
                                                data-id="<?= $reserva['id_reserva'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalReserva"
                                                title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <?php if ($reserva['estado'] === 'pendiente'): ?>
                                                <button class="pv-act-btn pv-act-btn--confirm"
                                                    onclick="confirmarReserva(<?= $reserva['id_reserva'] ?>)"
                                                    title="Confirmar">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                                <button class="pv-act-btn pv-act-btn--delete"
                                                    onclick="cancelarReserva(<?= $reserva['id_reserva'] ?>)"
                                                    title="Cancelar">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <div class="pv-empty-state">
                                        <i class="bi bi-calendar-x pv-empty-state__icon"></i>
                                        <p>No hay reservas registradas.</p>
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

<!-- MODAL DETALLE -->
<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content pv-modal">
            <div class="pv-modal__header">
                <div class="pv-modal__header-info">
                    <div class="pv-modal__eyebrow">Detalle de Reserva</div>
                    <h5 class="pv-modal__title">Información de la Reserva</h5>
                </div>
                <button class="pv-modal__close" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body pv-modal__body">
                <div class="pv-modal__info-grid pv-modal__info-grid--2col">
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">ID Reserva</div><div class="pv-modal__info-value" id="modal-id">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Huésped</div><div class="pv-modal__info-value" id="modal-turista">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Email</div><div class="pv-modal__info-value" id="modal-email">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Teléfono</div><div class="pv-modal__info-value" id="modal-telefono">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Fecha entrada</div><div class="pv-modal__info-value" id="modal-fecha">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Hospedaje</div><div class="pv-modal__info-value" id="modal-actividad">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Ubicación</div><div class="pv-modal__info-value" id="modal-ubicacion">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Fecha reserva</div><div class="pv-modal__info-value" id="modal-fecha-reserva">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Personas</div><div class="pv-modal__info-value" id="modal-personas">—</div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Precio/noche</div><div class="pv-modal__info-value pv-precio">$<span id="modal-precio">—</span></div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Total</div><div class="pv-modal__info-value pv-precio">$<span id="modal-total">—</span></div></div>
                    <div class="pv-modal__info-card"><div class="pv-modal__info-label">Estado</div><div class="pv-modal__info-value" id="modal-estado">—</div></div>
                </div>
                <div class="pv-modal__desc-block" style="margin-top:16px;">
                    <div class="pv-modal__desc-label"><i class="bi bi-card-text"></i> Descripción del hospedaje</div>
                    <p id="modal-descripcion" class="pv-modal__desc-text">—</p>
                </div>
            </div>
            <div class="pv-modal__footer">
                <button data-bs-dismiss="modal" class="pv-btn-outline-sm"><i class="bi bi-x-circle"></i> Cerrar</button>
                <div class="pv-modal__footer-actions">
                    <button id="btn-confirmar-modal" class="pv-modal__btn-success" style="display:none;"><i class="bi bi-check-lg"></i> Confirmar</button>
                    <button id="btn-cancelar-modal"  class="pv-modal__btn-danger"  style="display:none;"><i class="bi bi-x-lg"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const body    = document.body;
    const darkBtn = document.getElementById('pv-dark-toggle');
    const darkIcon= document.getElementById('pv-dark-icon');
    const DARK_KEY= 'pv_dark_mode';

    function applyDark(on) {
        body.classList.toggle('pv-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

    function makeDropdown(bId, pId, cId) {
        const btn = document.getElementById(bId), panel = document.getElementById(pId), chev = cId ? document.getElementById(cId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.classList.toggle('pv-dropdown--open');
            if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open);
            document.querySelectorAll('.pv-dropdown--open').forEach(d => {
                if (d !== panel) { d.classList.remove('pv-dropdown--open'); }
            });
        });
    }
    makeDropdown('pv-notif-btn',   'pv-notif-panel');
    makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');
    document.addEventListener('click', () => {
        document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
        document.querySelectorAll('.pv-profile-btn__chevron--open').forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
    });

    const markAll = document.querySelector('.pv-dropdown__mark-all');
    if (markAll) markAll.addEventListener('click', () => {
        document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread'));
        document.querySelector('.pv-icon-btn--notif')?.classList.remove('pv-icon-btn--notif');
    });

    document.querySelectorAll('.pv-rv-filter').forEach(btn => {
        btn.addEventListener('click', () => {
            window.location.href = `<?= BASE_URL ?>proveedor_hotelero/consultar-reservas?filtro=${btn.dataset.filter}`;
        });
    });

    const searchInput = document.getElementById('pv-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            document.querySelectorAll('#tablaReservas tbody tr').forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }

    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            fetch(`<?= BASE_URL ?>proveedor_hotelero/reserva-detalle?id=${id}`)
                .then(res => res.json())
                .then(resp => {
                    if (!resp.success) return;
                    const r = resp.data;
                    document.getElementById('modal-id').textContent          = r.id_reserva;
                    document.getElementById('modal-turista').textContent      = r.nombre_turista;
                    document.getElementById('modal-email').textContent        = r.email_turista;
                    document.getElementById('modal-telefono').textContent     = r.telefono_turista || 'No disponible';
                    document.getElementById('modal-actividad').textContent    = r.nombre_hospedaje;
                    document.getElementById('modal-ubicacion').textContent    = r.ubicacion;
                    document.getElementById('modal-fecha').textContent        = r.fecha;
                    document.getElementById('modal-fecha-reserva').textContent= new Date(r.created_at).toLocaleDateString('es-CO');
                    document.getElementById('modal-personas').textContent     = r.cantidad_personas;
                    document.getElementById('modal-precio').textContent       = fmt(r.precio);
                    document.getElementById('modal-total').textContent        = fmt(r.total);
                    document.getElementById('modal-estado').textContent       = r.estado;
                    document.getElementById('modal-descripcion').textContent  = r.descripcion_hospedaje || 'Sin descripción';

                    const btnC = document.getElementById('btn-confirmar-modal');
                    const btnX = document.getElementById('btn-cancelar-modal');
                    if (r.estado === 'pendiente') {
                        btnC.style.display = 'inline-flex'; btnX.style.display = 'inline-flex';
                        btnC.onclick = () => confirmarReserva(r.id_reserva);
                        btnX.onclick = () => cancelarReserva(r.id_reserva);
                    } else {
                        btnC.style.display = 'none'; btnX.style.display = 'none';
                    }
                });
        });
    });

    function fmt(n) {
        return new Intl.NumberFormat('es-CO', { minimumFractionDigits: 0 }).format(n);
    }
})();

function confirmarReserva(id) {
    if (confirm('¿Confirmar esta reserva? El huésped será notificado.')) {
        window.location.href = `<?= BASE_URL ?>proveedor_hotelero/consultar-reservas?accion=confirmar&id=${id}`;
    }
}
function cancelarReserva(id) {
    if (confirm('¿Cancelar esta reserva? Esta acción no se puede deshacer.')) {
        window.location.href = `<?= BASE_URL ?>proveedor_hotelero/consultar-reservas?accion=cancelar&id=${id}`;
    }
}
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
