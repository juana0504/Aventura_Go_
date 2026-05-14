<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/proveedor.php';

$datos = listarProveedores();

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
    <title>Proveedores Turísticos — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Font Awesome (para íconos del modal — mantener) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin (sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_turistico.css">
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

        <!-- TOPBAR — idéntico al dashboard admin -->
        <header class="adm-topbar">

            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar proveedores, empresas, ciudades..." class="adm-topbar__input" id="adm-search-input" autocomplete="off">
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
                                <div class="adm-notif-item__icon adm-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nueva reserva confirmada por <strong>Juan Pérez</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 1 hora</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                            <div class="adm-notif-item adm-notif-item--unread">
                                <div class="adm-notif-item__icon adm-notif-item__icon--amber"><i class="bi bi-person-plus-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Nuevo proveedor pendiente de <strong>aprobación</strong>.</p>
                                    <span class="adm-notif-item__time">Hace 3 horas</span>
                                </div>
                                <span class="adm-notif-item__dot"></span>
                            </div>
                            <div class="adm-notif-item">
                                <div class="adm-notif-item__icon adm-notif-item__icon--blue"><i class="bi bi-ticket-perforated-fill"></i></div>
                                <div class="adm-notif-item__body">
                                    <p class="adm-notif-item__text">Ticket #42 requiere <strong>respuesta</strong>.</p>
                                    <span class="adm-notif-item__time">Ayer</span>
                                </div>
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
                    <div class="adm-greeting__eyebrow">Gestión</div>
                    <h1 class="adm-page-title">Proveedores <span>Turísticos</span></h1>
                    <p class="adm-greeting__sub">Consulta, activa, edita o elimina proveedores registrados</p>
                </div>
                <div class="adm-page-header__actions">
                    <a href="<?= BASE_URL ?>administrador/registrar-proveedor" class="adm-btn-primary">
                        <i class="bi bi-plus-lg"></i> Nuevo proveedor
                    </a>
                    <a href="<?= BASE_URL ?>administrador/reporte?tipo=turistico" class="adm-btn-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                    </a>
                </div>
            </div>

            <!-- Tarjetas resumen -->
            <?php
            $total    = count($datos ?? []);
            $activos  = count(array_filter($datos ?? [], fn($p) => strtoupper($p['estado']) === 'ACTIVO'));
            $inactivos = count(array_filter($datos ?? [], fn($p) => strtoupper($p['estado']) === 'INACTIVO'));
            $pendientes = count(array_filter($datos ?? [], fn($p) => !in_array(strtoupper($p['estado']), ['ACTIVO','INACTIVO'])));
            ?>
            <div class="adm-pv-stats">
                <div class="adm-pv-stat adm-pv-stat--featured">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--orange"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Total</div>
                        <div class="adm-pv-stat__value"><?= $total ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Activos</div>
                        <div class="adm-pv-stat__value"><?= $activos ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--red"><i class="bi bi-x-circle-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Inactivos</div>
                        <div class="adm-pv-stat__value"><?= $inactivos ?></div>
                    </div>
                </div>
                <div class="adm-pv-stat">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--amber"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <div class="adm-pv-stat__label">Pendientes</div>
                        <div class="adm-pv-stat__value"><?= $pendientes ?></div>
                    </div>
                </div>
            </div>

            <!-- Filtros rápidos -->
            <div class="adm-pv-filters">
                <button class="adm-pv-filter adm-pv-filter--active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="adm-pv-filter" data-filter="activo">
                    <i class="bi bi-check-circle"></i> Activos
                </button>
                <button class="adm-pv-filter" data-filter="inactivo">
                    <i class="bi bi-x-circle"></i> Inactivos
                </button>
                <button class="adm-pv-filter" data-filter="pendiente">
                    <i class="bi bi-clock"></i> Pendientes
                </button>
            </div>

            <!-- Tabla -->
            <div class="adm-section-header" style="margin-bottom:14px;">
                <h2 class="adm-section-title">Listado de <span>proveedores</span></h2>
            </div>

            <div class="adm-table-wrap adm-table-wrap--card">
                <table id="tablaAdmin" class="adm-table">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Empresa</th>
                            <th>Representante</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos)): ?>
                            <?php foreach ($datos as $proveedor): ?>
                                <tr id="fila-<?= $proveedor['id_proveedor'] ?>"
                                    data-estado="<?= strtolower($proveedor['estado']) ?>">

                                    <!-- Logo -->
                                    <td>
                                        <img
                                            src="<?= BASE_URL ?>public/uploads/turistico/<?= htmlspecialchars($proveedor['logo']) ?>"
                                            alt="Logo <?= htmlspecialchars($proveedor['nombre_empresa']) ?>"
                                            class="adm-pv-logo">
                                    </td>

                                    <!-- Empresa -->
                                    <td>
                                        <div class="adm-table__act-name"><?= htmlspecialchars($proveedor['nombre_empresa']) ?></div>
                                    </td>

                                    <!-- Representante -->
                                    <td><?= htmlspecialchars($proveedor['nombre_representante']) ?></td>

                                    <!-- Email -->
                                    <td class="adm-pv-email"><?= htmlspecialchars($proveedor['email']) ?></td>

                                    <!-- Teléfono -->
                                    <td><?= htmlspecialchars($proveedor['telefono']) ?></td>

                                    <!-- Ciudad -->
                                    <td><?= htmlspecialchars($proveedor['nombre_ciudad'] ?? '—') ?></td>

                                    <!-- Estado — clases originales conservadas para el JS -->
                                    <td class="col-estado">
                                        <?php if ($proveedor['estado'] == 'ACTIVO'): ?>
                                            <span class="adm-badge adm-badge--confirmed">
                                                <span class="adm-badge__dot"></span> Activo
                                            </span>
                                        <?php elseif ($proveedor['estado'] == 'INACTIVO'): ?>
                                            <span class="adm-badge adm-badge--cancelled">
                                                <span class="adm-badge__dot"></span> Inactivo
                                            </span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--pending">
                                                <span class="adm-badge__dot"></span> Pendiente
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Acciones — IDs y data-* originales intactos -->
                                    <td>
                                        <div class="adm-pv-actions">
                                            <button
                                                class="adm-pv-btn adm-pv-btn--view btn-ver"
                                                data-id="<?= $proveedor['id_proveedor'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#verProveedorModal"
                                                title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <a href="<?= BASE_URL ?>administrador/editar-proveedor?id=<?= $proveedor['id_proveedor'] ?>"
                                               class="adm-pv-btn adm-pv-btn--edit"
                                               title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="<?= BASE_URL ?>administrador/eliminar-proveedor?accion=eliminar&id=<?= $proveedor['id_proveedor'] ?>"
                                               class="adm-pv-btn adm-pv-btn--delete"
                                               title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="adm-empty-state">
                                        <i class="bi bi-people adm-empty-state__icon"></i>
                                        <p>No hay proveedores registrados aún.</p>
                                        <a href="<?= BASE_URL ?>administrador/registrar-proveedor" class="adm-btn-primary">
                                            <i class="bi bi-plus-lg"></i> Registrar proveedor
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div><!-- /.adm-main -->

</div><!-- /.adm-layout -->


<!-- ==========================================
     MODAL VER PROVEEDOR
     IDs originales intactos para el JS externo
=========================================== -->
<div class="modal fade" id="verProveedorModal" tabindex="-1" aria-labelledby="verProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content adm-modal">

            <!-- Header -->
            <div class="adm-modal__header">
                <div class="adm-modal__logo-wrap">
                    <img src="" alt="Logo proveedor" id="modal-logo" class="adm-modal__logo">
                </div>
                <div class="adm-modal__header-info">
                    <div class="adm-modal__eyebrow">Proveedor Turístico</div>
                    <h5 class="adm-modal__title" id="verProveedorModalLabel">Detalles del Proveedor</h5>
                    <small class="adm-modal__subtitle">Información completa del proveedor turístico</small>
                </div>
                <button type="button" class="adm-modal__close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body adm-modal__body">

                <!-- Barra de estado — IDs originales -->
                <div class="adm-modal__status-bar">
                    <span class="adm-modal__status-badge" id="modal-status"></span>
                    <span class="adm-modal__date" id="modal-fecha-registro"></span>
                </div>

                <!-- Información Principal -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-building"></i>
                        <h6>Información Principal</h6>
                    </div>
                    <div class="adm-modal__grid">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-signature"></i> Nombre de la Empresa</div>
                            <div class="adm-modal__info-value" id="modal-empresa">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-id-card"></i> NIT / RUT</div>
                            <div class="adm-modal__info-value" id="modal-nit">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-envelope"></i> Email</div>
                            <div class="adm-modal__info-value" id="modal-email">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-phone"></i> Teléfono</div>
                            <div class="adm-modal__info-value" id="modal-telefono">—</div>
                        </div>
                        <div class="adm-modal__info-card adm-modal__info-card--full">
                            <div class="adm-modal__info-label"><i class="fas fa-align-left"></i> Descripción</div>
                            <div class="adm-modal__info-value" id="modal-descripcion">—</div>
                        </div>
                    </div>
                </div>

                <!-- Representante -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-user-tie"></i>
                        <h6>Información del Representante</h6>
                    </div>
                    <div class="adm-modal__grid">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-user"></i> Nombre Completo</div>
                            <div class="adm-modal__info-value" id="modal-representante">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-id-badge"></i> Identificación</div>
                            <div class="adm-modal__info-value" id="modal-identificacion">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-envelope"></i> Email Representante</div>
                            <div class="adm-modal__info-value" id="modal-email-repre">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-phone"></i> Teléfono Representante</div>
                            <div class="adm-modal__info-value" id="modal-telefono-repre">—</div>
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h6>Ubicación</h6>
                    </div>
                    <div class="adm-modal__grid">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-map"></i> Departamento</div>
                            <div class="adm-modal__info-value" id="modal-departamento">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-city"></i> Ciudad</div>
                            <div class="adm-modal__info-value" id="modal-ciudad">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label"><i class="fas fa-road"></i> Dirección</div>
                            <div class="adm-modal__info-value" id="modal-direccion">—</div>
                        </div>
                    </div>
                </div>

                <!-- Actividades -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-hiking"></i>
                        <h6>Actividades Turísticas</h6>
                    </div>
                    <div class="activities-container" id="modal-actividades">
                        <!-- Dinámico — JS externo intacto -->
                    </div>
                </div>

            </div>

            <!-- Footer — IDs originales para el JS externo -->
            <div class="adm-modal__footer">
                <button type="button" class="adm-btn-outline" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left"></i> Cerrar
                </button>
                <div class="adm-modal__footer-actions">
                    <a class="adm-modal__btn-success" id="btn-activar-proveedor">
                        <i class="fas fa-check-circle"></i> Activar
                    </a>
                    <a class="adm-modal__btn-danger" id="btn-desactivar-proveedor">
                        <i class="fas fa-ban"></i> Desactivar
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS original del módulo — IDs intactos -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_turistico.js"></script>

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

    /* ─── FILTROS DE ESTADO ──────────────────── */
    const filtros = document.querySelectorAll('.adm-pv-filter');
    const filas   = document.querySelectorAll('#tablaAdmin tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('adm-pv-filter--active'));
            btn.classList.add('adm-pv-filter--active');

            const f = btn.dataset.filter;
            filas.forEach(row => {
                const estado = row.dataset.estado;
                const visible = f === 'all'
                    || estado === f
                    || (f === 'pendiente' && estado !== 'activo' && estado !== 'inactivo');
                row.style.display = visible ? '' : 'none';
            });
        });
    });

    /* ─── BÚSQUEDA EN TABLA ──────────────────── */
    const searchInput = document.getElementById('adm-search-input');
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