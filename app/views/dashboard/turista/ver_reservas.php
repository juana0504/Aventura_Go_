<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Iniciales del usuario para el topbar
$nombreUsuario = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
$partes = explode(' ', trim($nombreUsuario));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS del sistema (variables, sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/ver_reservas/ver_reservas.css">
</head>

<body class="ag-body">

<div class="ag-layout">

    <!-- ==========================================
         SIDEBAR — idéntico al dashboard
    =========================================== -->
    <nav class="ag-sidebar">

        <div class="ag-sidebar__logo">
            <div class="ag-sidebar__logo-icon">A</div>
            <div>
                <div class="ag-sidebar__logo-text">AVENTURA GO</div>
                <div class="ag-sidebar__logo-sub">Panel Turista</div>
            </div>
        </div>

        <div class="ag-sidebar__section-label">Menú</div>

        <a href="<?= BASE_URL ?>turista/dashboard" class="ag-nav-item">
            <i class="bi bi-grid-1x2-fill ag-nav-item__icon"></i>
            Dashboard
        </a>
        <a href="<?= BASE_URL ?>turista/reservas" class="ag-nav-item ag-nav-item--active">
            <i class="bi bi-calendar3 ag-nav-item__icon"></i>
            Ver reservas
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item">
            <i class="bi bi-ticket-perforated ag-nav-item__icon"></i>
            Tickets
        </a>
        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-nav-item">
            <i class="bi bi-heart ag-nav-item__icon"></i>
            Favoritos
        </a>
        <a href="<?= BASE_URL ?>turista/resenas" class="ag-nav-item">
            <i class="bi bi-star ag-nav-item__icon"></i>
            Reseñas
        </a>

    </nav>

    <!-- ==========================================
         ÁREA PRINCIPAL
    =========================================== -->
    <div class="ag-main">

        <!-- TOPBAR — idéntico al dashboard -->
        <header class="ag-topbar">

            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar reservas, actividades..." class="ag-topbar__input" id="ag-search-input" autocomplete="off">
            </div>

            <div class="ag-topbar__actions">

                <!-- Modo oscuro -->
                <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                </button>

                <!-- Notificaciones -->
                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-icon-btn ag-icon-btn--notif" id="ag-notif-btn" title="Notificaciones">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--notif" id="ag-notif-panel">
                        <div class="ag-dropdown__header">
                            <span class="ag-dropdown__title">Notificaciones</span>
                            <button class="ag-dropdown__mark-all">Marcar todas</button>
                        </div>
                        <div class="ag-notif-list">
                            <div class="ag-notif-item ag-notif-item--unread">
                                <div class="ag-notif-item__icon ag-notif-item__icon--green">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">Tu reserva de <strong>Rafting</strong> fue confirmada.</p>
                                    <span class="ag-notif-item__time">Hace 2 horas</span>
                                </div>
                                <span class="ag-notif-item__dot"></span>
                            </div>
                            <div class="ag-notif-item ag-notif-item--unread">
                                <div class="ag-notif-item__icon ag-notif-item__icon--amber">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">Tienes una reserva <strong>pendiente</strong> de pago.</p>
                                    <span class="ag-notif-item__time">Hace 5 horas</span>
                                </div>
                                <span class="ag-notif-item__dot"></span>
                            </div>
                            <div class="ag-notif-item">
                                <div class="ag-notif-item__icon ag-notif-item__icon--blue">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="ag-notif-item__body">
                                    <p class="ag-notif-item__text">¿Cómo fue tu experiencia en <strong>Parapente</strong>?</p>
                                    <span class="ag-notif-item__time">Ayer</span>
                                </div>
                            </div>
                        </div>
                        <a href="<?= BASE_URL ?>turista/notificaciones" class="ag-dropdown__footer">
                            Ver todas las notificaciones
                        </a>
                    </div>
                </div>

                <!-- Perfil -->
                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-profile-btn" id="ag-profile-btn">
                        <div class="ag-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                        <div class="ag-profile-btn__info">
                            <span class="ag-profile-btn__name"><?= htmlspecialchars($nombreUsuario) ?></span>
                            <span class="ag-profile-btn__role">Turista</span>
                        </div>
                        <i class="bi bi-chevron-down ag-profile-btn__chevron" id="ag-profile-chevron"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--profile" id="ag-profile-panel">
                        <div class="ag-dropdown__user-header">
                            <div class="ag-profile-btn__avatar ag-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                            <div>
                                <div class="ag-dropdown__user-name"><?= htmlspecialchars($nombreUsuario) ?></div>
                                <div class="ag-dropdown__user-role">Turista · AventuraGO</div>
                            </div>
                        </div>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>turista/perfil" class="ag-dropdown__item">
                            <i class="bi bi-person-circle"></i> Mi perfil
                        </a>
                        <a href="<?= BASE_URL ?>turista/reservas" class="ag-dropdown__item">
                            <i class="bi bi-calendar3"></i> Mis reservas
                        </a>
                        
                        </a>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="ag-dropdown__item ag-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ======================================
             CONTENIDO PRINCIPAL
        ======================================= -->
        <main class="ag-content">

            <!-- Encabezado de página -->
            <div class="ag-page-header">
                <div>
                    <div class="ag-greeting__eyebrow">Panel Turista</div>
                    <h1 class="ag-page-header__title">Mis <span>Reservas</span></h1>
                    <p class="ag-greeting__sub">Consulta, confirma o cancela tus reservas de aventura</p>
                </div>
                <a href="<?= BASE_URL ?>turista/pdf-actividades" class="ag-btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Generar Reporte
                </a>
            </div>

            <!-- ── Tarjetas de estadísticas ── -->
            <?php
            $total      = count($reservas ?? []);
            $confirmadas = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'confirmada'));
            $pendientes  = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'pendiente'));
            $canceladas  = count(array_filter($reservas ?? [], fn($r) => $r['estado'] === 'cancelada'));
            ?>
            <div class="ag-rv-stats">
                <div class="ag-rv-stat ag-rv-stat--featured">
                    <div class="ag-rv-stat__icon ag-rv-stat__icon--orange"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="ag-rv-stat__label">Total reservas</div>
                        <div class="ag-rv-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="ag-rv-stat">
                    <div class="ag-rv-stat__icon ag-rv-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="ag-rv-stat__label">Confirmadas</div>
                        <div class="ag-rv-stat__value"><?= $confirmadas ?></div>
                    </div>
                </div>
                <div class="ag-rv-stat">
                    <div class="ag-rv-stat__icon ag-rv-stat__icon--amber"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <div class="ag-rv-stat__label">Pendientes</div>
                        <div class="ag-rv-stat__value"><?= $pendientes ?></div>
                    </div>
                </div>
                <div class="ag-rv-stat">
                    <div class="ag-rv-stat__icon ag-rv-stat__icon--red"><i class="bi bi-x-circle-fill"></i></div>
                    <div>
                        <div class="ag-rv-stat__label">Canceladas</div>
                        <div class="ag-rv-stat__value"><?= $canceladas ?></div>
                    </div>
                </div>
            </div>

            <!-- ── Filtros rápidos ── -->
            <div class="ag-rv-filters">
                <button class="ag-rv-filter ag-rv-filter--active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="ag-rv-filter" data-filter="confirmada">
                    <i class="bi bi-check-circle"></i> Confirmadas
                </button>
                <button class="ag-rv-filter" data-filter="pendiente">
                    <i class="bi bi-clock"></i> Pendientes
                </button>
                <button class="ag-rv-filter" data-filter="cancelada">
                    <i class="bi bi-x-circle"></i> Canceladas
                </button>
            </div>

            <!-- ── Tabla ── -->
            <div class="ag-section-header">
                <h2 class="ag-section-title">Historial de <span>reservas</span></h2>
            </div>

            <div class="ag-table-wrap">
                <table class="ag-table" id="tablaReservas">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Personas</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reservas)): ?>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr data-estado="<?= htmlspecialchars($reserva['estado']) ?>">

                                    <!-- Actividad + imagen -->
                                    <td>
                                        <div class="ag-rv-actividad">
                                            <?php if (!empty($reserva['imagen'])): ?>
                                                <img
                                                    src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= htmlspecialchars($reserva['imagen']) ?>"
                                                    class="ag-rv-img"
                                                    alt="<?= htmlspecialchars($reserva['nombre_actividad']) ?>">
                                            <?php else: ?>
                                                <div class="ag-rv-img ag-rv-img--placeholder">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="ag-table__act-name">
                                                    <?= htmlspecialchars($reserva['nombre_actividad']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Proveedor -->
                                    <td>
                                        <div class="ag-table__act-meta"><?= htmlspecialchars($reserva['proveedor']) ?></div>
                                    </td>

                                    <!-- Fecha -->
                                    <td><?= date('d/m/Y', strtotime($reserva['fecha'])) ?></td>

                                    <!-- Personas -->
                                    <td>
                                        <span class="ag-rv-personas">
                                            <i class="bi bi-people"></i>
                                            <?= (int)$reserva['cantidad_personas'] ?>
                                        </span>
                                    </td>

                                    <!-- Total -->
                                    <td>
                                        <span class="ag-rv-precio">
                                            $<?= number_format($reserva['precio'], 0, ',', '.') ?>
                                        </span>
                                    </td>

                                    <!-- Estado -->
                                    <td>
                                        <?php
                                        $estado = $reserva['estado'];
                                        $badgeClass = match($estado) {
                                            'confirmada' => 'ag-badge ag-badge--confirmed',
                                            'pendiente'  => 'ag-badge ag-badge--pending',
                                            'cancelada'  => 'ag-badge ag-badge--cancelled',
                                            default      => 'ag-badge ag-badge--cancelled',
                                        };
                                        ?>
                                        <span class="<?= $badgeClass ?>">
                                            <span class="ag-badge__dot"></span>
                                            <?= ucfirst($estado) ?>
                                        </span>
                                    </td>

                                    <!-- Acción -->
                                    <td>
                                        <button
                                            class="ag-btn-ver btn-ver-reserva"
                                            data-id="<?= $reserva['id_reserva'] ?>">
                                            <i class="bi bi-eye"></i> Ver
                                        </button>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="ag-empty-state">
                                        <i class="bi bi-calendar-x ag-empty-state__icon"></i>
                                        <p>No tienes reservas registradas aún.</p>
                                        <a href="<?= BASE_URL ?>turista/actividades" class="ag-btn-primary">
                                            <i class="bi bi-compass"></i> Explorar actividades
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div><!-- /.ag-main -->

</div><!-- /.ag-layout -->


<!-- ==========================================
     MODAL DETALLE RESERVA — lógica intacta,
     solo se rediseña la presentación
=========================================== -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ag-rv-modal">

            <!-- Header del modal -->
            <div class="ag-rv-modal__header">
                <div class="ag-rv-modal__header-info">
                    <div class="ag-modal__eyebrow" id="modal-fecha-reserva"></div>
                    <h5 class="ag-rv-modal__title" id="modal-nombre-actividad"></h5>
                    <span id="modal-estado" class="ag-badge mt-1"></span>
                </div>
                <button class="ag-modal__close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Body del modal -->
            <div class="ag-rv-modal__body">

                <!-- Columna imágenes -->
                <div class="ag-rv-modal__gallery">
                    <img id="modal-imagen-principal" class="ag-rv-modal__img-main" alt="Imagen actividad">
                    <div id="modal-galeria" class="ag-rv-modal__thumbs"></div>
                </div>

                <!-- Columna info -->
                <div class="ag-rv-modal__info">

                    <div class="ag-rv-modal__info-grid">
                        <div class="ag-rv-info-item">
                            <div class="ag-rv-info-item__label"><i class="bi bi-person-workspace"></i> Proveedor</div>
                            <div class="ag-rv-info-item__value" id="modal-proveedor">—</div>
                        </div>
                        <div class="ag-rv-info-item">
                            <div class="ag-rv-info-item__label"><i class="bi bi-calendar-event"></i> Fecha</div>
                            <div class="ag-rv-info-item__value" id="modal-fecha">—</div>
                        </div>
                        <div class="ag-rv-info-item">
                            <div class="ag-rv-info-item__label"><i class="bi bi-people"></i> Personas</div>
                            <div class="ag-rv-info-item__value" id="modal-personas">—</div>
                        </div>
                        <div class="ag-rv-info-item">
                            <div class="ag-rv-info-item__label"><i class="bi bi-cash-stack"></i> Total</div>
                            <div class="ag-rv-info-item__value ag-rv-info-item__value--price">
                                $<span id="modal-total">—</span>
                            </div>
                        </div>
                        <div class="ag-rv-info-item ag-rv-info-item--full">
                            <div class="ag-rv-info-item__label"><i class="bi bi-info-circle"></i> Estado</div>
                            <div class="ag-rv-info-item__value" id="modal-estado-texto">—</div>
                        </div>
                    </div>

                    <div class="ag-rv-modal__desc-block">
                        <div class="ag-rv-modal__desc-label"><i class="bi bi-card-text"></i> Descripción</div>
                        <p id="modal-descripcion" class="ag-rv-modal__desc-text">—</p>
                    </div>

                </div>
            </div>

            <!-- Footer del modal -->
            <div class="ag-rv-modal__footer">
                <button data-bs-dismiss="modal" class="ag-btn-outline">
                    <i class="bi bi-arrow-left"></i> Volver
                </button>
                <div class="ag-rv-modal__footer-actions">
                    <button id="btn-confirmar" class="ag-btn-primary" style="display:none;">
                        <i class="bi bi-check-lg"></i> Confirmar reserva
                    </button>
                    <button id="btn-cancelar" class="ag-btn-danger" style="display:none;">
                        <i class="bi bi-x-lg"></i> Cancelar reserva
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS externo del modal (lógica original, no se toca) -->
<script src="<?= BASE_URL ?>public/assets/dashboard/turista/ver_reservas/modal_reserva.js"></script>

<script>
(function () {
    /* ─── MODO OSCURO ────────────────────────── */
    const body     = document.body;
    const darkBtn  = document.getElementById('ag-dark-toggle');
    const darkIcon = document.getElementById('ag-dark-icon');
    const DARK_KEY = 'ag_dark_mode';

    function applyDark(on) {
        body.classList.toggle('ag-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

    /* ─── DROPDOWNS ──────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = panel.classList.toggle('ag-dropdown--open');
            if (chev) chev.classList.toggle('ag-profile-btn__chevron--open', open);
            document.querySelectorAll('.ag-dropdown--open').forEach(d => {
                if (d !== panel) {
                    d.classList.remove('ag-dropdown--open');
                    document.querySelectorAll('.ag-profile-btn__chevron--open')
                        .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
                }
            });
        });
    }

    makeDropdown('ag-notif-btn',   'ag-notif-panel');
    makeDropdown('ag-profile-btn', 'ag-profile-panel', 'ag-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.ag-dropdown--open').forEach(d => d.classList.remove('ag-dropdown--open'));
        document.querySelectorAll('.ag-profile-btn__chevron--open')
            .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
    });

    /* ─── NOTIFICACIONES ─────────────────────── */
    const markAll = document.querySelector('.ag-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.ag-notif-item--unread')
                .forEach(el => el.classList.remove('ag-notif-item--unread'));
            document.querySelector('.ag-icon-btn--notif')
                ?.classList.remove('ag-icon-btn--notif');
        });
    }

    /* ─── FILTROS DE ESTADO ──────────────────── */
    const filtros = document.querySelectorAll('.ag-rv-filter');
    const filas   = document.querySelectorAll('#tablaReservas tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('ag-rv-filter--active'));
            btn.classList.add('ag-rv-filter--active');

            const f = btn.dataset.filter;
            filas.forEach(row => {
                row.style.display = (f === 'all' || row.dataset.estado === f) ? '' : 'none';
            });
        });
    });

    /* ─── BÚSQUEDA EN TABLA ──────────────────── */
    const searchInput = document.getElementById('ag-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            filas.forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }
})();
</script>

</body>
</html>