<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';

$datos = listarActividades();

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
    <title>Mis Actividades — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sistema proveedor -->
<link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <!-- CSS específico -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
</head>
<body class="pv-body">

<div class="pv-layout" id="proveedor-actividades">

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
                <input type="text" placeholder="Buscar actividades, destinos..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
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
                                <div class="pv-notif-item__icon pv-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                <div class="pv-notif-item__body">
                                    <p class="pv-notif-item__text">Nueva reserva confirmada en tu actividad.</p>
                                    <span class="pv-notif-item__time">Hace 1 hora</span>
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
                        <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-dropdown__item"><i class="bi bi-compass"></i> Mis actividades</a>
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
            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Gestión</div>
                    <h1 class="pv-page-title">Mis <span>Actividades</span></h1>
                    <p class="pv-greeting__sub">Consulta, edita y administra tus experiencias turísticas</p>
                </div>
                <div class="pv-page-header__actions">
                    <a href="<?= BASE_URL ?>proveedor/registrar-actividad" class="pv-btn-primary">
                        <i class="bi bi-plus-lg"></i> Nueva actividad
                    </a>
                    <a href="<?= BASE_URL ?>proveedor/pdf-actividades" class="pv-btn-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </div>
            </div>

            <!-- Tarjetas resumen -->
            <?php
            $total    = count($datos ?? []);
            $activos  = count(array_filter($datos ?? [], fn($a) => $a['estado'] === 'ACTIVO'));
            $inactivos = $total - $activos;
            ?>
            <div class="pv-act-stats">
                <div class="pv-act-stat pv-act-stat--featured">
                    <div class="pv-act-stat__icon pv-act-stat__icon--orange"><i class="bi bi-compass-fill"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Total</div>
                        <div class="pv-act-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon pv-act-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Activas</div>
                        <div class="pv-act-stat__value"><?= $activos ?></div>
                    </div>
                </div>
                <div class="pv-act-stat">
                    <div class="pv-act-stat__icon pv-act-stat__icon--red"><i class="bi bi-pause-circle-fill"></i></div>
                    <div>
                        <div class="pv-act-stat__label">Inactivas</div>
                        <div class="pv-act-stat__value"><?= $inactivos ?></div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="pv-act-filters">
                <button class="pv-act-filter pv-act-filter--active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="pv-act-filter" data-filter="activo">
                    <i class="bi bi-check-circle"></i> Activos
                </button>
                <button class="pv-act-filter" data-filter="inactivo">
                    <i class="bi bi-pause-circle"></i> Inactivos
                </button>
            </div>

            <!-- Tabla -->
            <div class="pv-section-header" style="margin-bottom:14px;">
                <h2 class="pv-section-title">Listado de <span>actividades</span></h2>
            </div>

            <div class="pv-table-wrap">
                <table class="pv-table" id="tablaActividades">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Actividad</th>
                            <th>Destino</th>
                            <th>Ubicación</th>
                            <th>Cupos</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos)): ?>
                            <?php foreach ($datos as $actividad): ?>
                                <tr data-estado="<?= strtolower($actividad['estado']) ?>">
                                    <td>
                                        <img src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= htmlspecialchars($actividad['imagen_principal'] ?? '') ?>"
                                             alt="<?= htmlspecialchars($actividad['nombre']) ?>"
                                             class="pv-act-img"
                                             onerror="this.src='<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/img/no-image.png'; this.onerror=null;">
                                    </td>
                                    <td>
                                        <div class="pv-table__name"><?= htmlspecialchars($actividad['nombre']) ?></div>
                                    </td>
                                    <td><?= htmlspecialchars($actividad['destino'] ?? 'N/A') ?></td>
                                    <td class="pv-act-ubicacion"><?= htmlspecialchars($actividad['ubicacion']) ?></td>
                                    <td>
                                        <span class="pv-cupos">
                                            <i class="bi bi-people"></i> <?= $actividad['cupos'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="pv-precio">$<?= number_format($actividad['precio'], 0, ',', '.') ?></span>
                                    </td>
                                    <td>
                                        <?php if ($actividad['estado'] === 'ACTIVO'): ?>
                                            <span class="pv-badge pv-badge--confirmed">
                                                <span class="pv-badge__dot"></span> Activa
                                            </span>
                                        <?php else: ?>
                                            <span class="pv-badge pv-badge--cancelled">
                                                <span class="pv-badge__dot"></span> Inactiva
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="pv-act-actions">
                                            <!-- IDs y data-* originales intactos para el JS -->
                                            <button class="pv-act-btn pv-act-btn--view btn-ver"
                                                data-id="<?= $actividad['id_actividad'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalActividad"
                                                title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="pv-act-btn pv-act-btn--reviews btn-ver-resenas"
                                                data-id="<?= $actividad['id_actividad'] ?>"
                                                data-nombre="<?= htmlspecialchars($actividad['nombre']) ?>"
                                                title="Ver reseñas">
                                                <i class="bi bi-star"></i>
                                            </button>
                                            <a href="<?= BASE_URL ?>proveedor/editar-actividad?id=<?= $actividad['id_actividad'] ?>"
                                               class="pv-act-btn pv-act-btn--edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>proveedor/eliminar-actividad?accion=eliminar&id=<?= $actividad['id_actividad'] ?>"
                                               class="pv-act-btn pv-act-btn--delete" title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de eliminar esta actividad?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="pv-empty-state">
                                        <i class="bi bi-compass pv-empty-state__icon"></i>
                                        <p>No hay actividades registradas aún.</p>
                                        <a href="<?= BASE_URL ?>proveedor/registrar-actividad" class="pv-btn-primary">
                                            <i class="bi bi-plus-lg"></i> Registrar actividad
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


<!-- MODAL DETALLE ACTIVIDAD — IDs originales intactos para modal_actividad.js -->
<div class="modal fade" id="modalActividad" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content pv-modal">

            <div class="pv-modal__header">
                <div class="pv-modal__header-info">
                    <div class="pv-modal__eyebrow">Actividad Turística</div>
                    <h5 class="pv-modal__title" id="modal-nombre">—</h5>
                    <span id="modal-estado-header" class="pv-badge mt-1"></span>
                </div>
                <div>
                    <small id="modal-fecha-registro" class="pv-modal__date"></small>
                </div>
                <button class="pv-modal__close btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body pv-modal__body">
                <div class="pv-modal__layout">

                    <!-- Galería -->
                    <div class="pv-modal__gallery">
                        <img id="modal-imagen-principal" class="pv-modal__img-main" alt="Imagen actividad">
                        <div id="modal-galeria" class="pv-modal__thumbs"></div>
                    </div>

                    <!-- Info -->
                    <div class="pv-modal__info">
                        <div class="pv-modal__info-grid">
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-map"></i> Departamento</div>
                                <div class="pv-modal__info-value" id="modal-departamento">—</div>
                            </div>
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-geo"></i> Ciudad</div>
                                <div class="pv-modal__info-value" id="modal-ciudad">—</div>
                            </div>
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-geo-alt"></i> Ubicación</div>
                                <div class="pv-modal__info-value" id="modal-ubicacion">—</div>
                            </div>
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-people"></i> Cupos</div>
                                <div class="pv-modal__info-value" id="modal-cupos">—</div>
                            </div>
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-cash-stack"></i> Precio</div>
                                <div class="pv-modal__info-value pv-precio">$<span id="modal-precio">—</span></div>
                            </div>
                            <div class="pv-modal__info-card">
                                <div class="pv-modal__info-label"><i class="bi bi-shield-check"></i> Estado</div>
                                <div class="pv-modal__info-value" id="modal-estado-texto">—</div>
                            </div>
                        </div>

                        <div class="pv-modal__desc-block">
                            <div class="pv-modal__desc-label"><i class="bi bi-card-text"></i> Descripción</div>
                            <p id="modal-descripcion" class="pv-modal__desc-text">—</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pv-modal__footer">
                <button data-bs-dismiss="modal" class="pv-btn-outline-sm">
                    <i class="bi bi-arrow-left"></i> Cerrar
                </button>
                <div class="pv-modal__footer-actions">
                    <button id="btn-desactivar" class="pv-modal__btn-danger">
                        <i class="bi bi-pause-circle"></i> Pausar
                    </button>
                    <button id="btn-activar" class="pv-modal__btn-success">
                        <i class="bi bi-play-circle"></i> Activar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- JS original del modal — IDs intactos -->
<script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/modal_actividad.js"></script>

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

    /* ─── FILTROS ─────────────────────────────── */
    const filtros = document.querySelectorAll('.pv-act-filter');
    const filas   = document.querySelectorAll('#tablaActividades tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('pv-act-filter--active'));
            btn.classList.add('pv-act-filter--active');
            const f = btn.dataset.filter;
            filas.forEach(row => {
                const est = row.dataset.estado;
                const show = f === 'all' || est === f
                    || (f === 'activo'   && est === 'activo')
                    || (f === 'inactivo' && est !== 'activo');
                row.style.display = show ? '' : 'none';
            });
        });
    });

    /* ─── BÚSQUEDA ───────────────────────────── */
    const searchInput = document.getElementById('pv-search-input');
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

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>

<!-- MODAL RESEÑAS -->
<div class="modal fade" id="modalResenas" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content pv-modal">

            <div class="pv-modal__header">
                <div class="pv-modal__header-info">
                    <div class="pv-modal__eyebrow">Opiniones de turistas</div>
                    <h5 class="pv-modal__title" id="resenas-modal-titulo">Reseñas</h5>
                </div>
                <button class="pv-modal__close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body pv-modal__body" id="resenas-modal-body">
                <div class="pv-resenas-loading">
                    <div class="spinner-border text-warning" role="status"></div>
                    <span>Cargando reseñas…</span>
                </div>
            </div>

            <div class="pv-modal__footer">
                <button data-bs-dismiss="modal" class="pv-btn-outline-sm">
                    <i class="bi bi-arrow-left"></i> Cerrar
                </button>
                <span id="resenas-modal-promedio" class="pv-resenas-avg"></span>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    const modalEl      = document.getElementById('modalResenas');
    const modalBS      = new bootstrap.Modal(modalEl);
    const modalTitulo  = document.getElementById('resenas-modal-titulo');
    const modalBody    = document.getElementById('resenas-modal-body');
    const modalProm    = document.getElementById('resenas-modal-promedio');

    function estrellas(n) {
        n = parseInt(n, 10) || 0;
        return Array.from({ length: 5 }, (_, i) =>
            `<i class="bi bi-star${i < n ? '-fill' : ''} pv-star${i < n ? ' pv-star--on' : ''}"></i>`
        ).join('');
    }

    document.querySelectorAll('.btn-ver-resenas').forEach(btn => {
        btn.addEventListener('click', () => {
            const idActividad = btn.dataset.id;
            const nombre      = btn.dataset.nombre;

            modalTitulo.textContent = nombre;
            modalProm.textContent   = '';
            modalBody.innerHTML     = '<div class="pv-resenas-loading"><div class="spinner-border text-warning" role="status"></div><span>Cargando reseñas…</span></div>';
            modalBS.show();

            fetch(`${BASE_URL}proveedor/resenas-actividad?id=${idActividad}`)
                .then(r => { if (!r.ok) throw new Error('red'); return r.json(); })
                .then(data => {
                    if (!data.ok) {
                        modalBody.innerHTML = '<p class="pv-resenas-empty">No se pudieron cargar las reseñas.</p>';
                        return;
                    }
                    const resenas = data.resenas;
                    if (!resenas.length) {
                        modalBody.innerHTML = '<div class="pv-resenas-empty"><i class="bi bi-chat-square-text"></i><p>Esta actividad aún no tiene reseñas.</p></div>';
                        return;
                    }

                    const sum = resenas.reduce((a, r) => a + parseInt(r.calificacion, 10), 0);
                    const avg = (sum / resenas.length).toFixed(1);
                    modalProm.innerHTML = `${estrellas(Math.round(avg))} <strong>${avg}</strong> / 5 (${resenas.length} reseña${resenas.length !== 1 ? 's' : ''})`;

                    modalBody.innerHTML = resenas.map(r => `
                        <div class="pv-resena-card">
                            <div class="pv-resena-card__top">
                                <div class="pv-resena-card__avatar">${(r.nombre_turista || '?').charAt(0).toUpperCase()}</div>
                                <div class="pv-resena-card__info">
                                    <div class="pv-resena-card__nombre">${r.nombre_turista || 'Turista'}</div>
                                    <div class="pv-resena-card__fecha">${r.fecha ? r.fecha.slice(0, 10) : ''}</div>
                                </div>
                                <div class="pv-resena-card__estrellas">${estrellas(r.calificacion)}</div>
                            </div>
                            ${r.comentario ? `<p class="pv-resena-card__comentario">${r.comentario}</p>` : ''}
                        </div>
                    `).join('');
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="pv-resenas-empty">Error al cargar las reseñas.</p>';
                });
        });
    });
})();
</script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>