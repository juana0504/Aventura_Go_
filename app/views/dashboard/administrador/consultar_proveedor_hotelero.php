<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';

$datos = listarHoteles();

// Iniciales del administrador para el topbar
$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales   = '';
$partes      = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}

$fotoAdmin = trim((string) ($_SESSION['user']['foto'] ?? ''));
$usarFotoAdmin = $fotoAdmin !== '' && stripos($fotoAdmin, 'default') !== 0;
$avatarAdminUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoAdmin);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores Hoteleros — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sistema admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_hotelero.css">

    <!-- CSS unificado para listados admin -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/consultas_admin_unificado.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- SIDEBAR -->
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
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turísticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item adm-nav-item--active">
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

    <!-- ÁREA PRINCIPAL -->
    <div class="adm-main">

        <!-- TOPBAR -->
        <header class="adm-topbar">
            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar hoteles, establecimientos, ciudades..." class="adm-topbar__input" id="adm-search-input" autocomplete="off">
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
                                    <p class="adm-notif-item__text">Nuevo proveedor hotelero pendiente de <strong>aprobación</strong>.</p>
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
                        <div class="adm-profile-btn__avatar">
                            <?php if ($usarFotoAdmin): ?>
                                <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                            <?php else: ?>
                                <?= htmlspecialchars($iniciales) ?>
                            <?php endif; ?>
                        </div>
                        <div class="adm-profile-btn__info">
                            <span class="adm-profile-btn__name"><?= htmlspecialchars($nombreAdmin) ?></span>
                            <span class="adm-profile-btn__role">Administrador</span>
                        </div>
                        <i class="bi bi-chevron-down adm-profile-btn__chevron" id="adm-profile-chevron"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--profile" id="adm-profile-panel">
                        <div class="adm-dropdown__user-header">
                            <div class="adm-profile-btn__avatar adm-profile-btn__avatar--lg">
                                <?php if ($usarFotoAdmin): ?>
                                    <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                                <?php else: ?>
                                    <?= htmlspecialchars($iniciales) ?>
                                <?php endif; ?>
                            </div>
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

        <!-- CONTENIDO -->
        <main class="adm-content">

            <!-- Encabezado -->
            <div class="adm-page-header">
                <div>
                    <div class="adm-greeting__eyebrow">Gestión</div>
                    <h1 class="adm-page-title">Proveedores <span>Hoteleros</span></h1>
                    <p class="adm-greeting__sub">Consulta, activa, edita o elimina establecimientos hoteleros</p>
                </div>
                <div class="adm-page-header__actions">
                    <a href="<?= BASE_URL ?>administrador/registrar-proveedor-hotelero" class="adm-btn-primary">
                        <i class="bi bi-plus-lg"></i> Nuevo hotelero
                    </a>
                    <a href="<?= BASE_URL ?>administrador/reporte?tipo=hoteles" class="adm-btn-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                    </a>
                </div>
            </div>

            <!-- Tarjetas resumen -->
            <?php
            $total     = count($datos ?? []);
            $activos   = count(array_filter($datos ?? [], fn($h) => strtoupper($h['estado']) === 'ACTIVO'));
            $inactivos = count(array_filter($datos ?? [], fn($h) => strtoupper($h['estado']) === 'INACTIVO'));
            $pendientes = count(array_filter($datos ?? [], fn($h) => !in_array(strtoupper($h['estado']), ['ACTIVO','INACTIVO'])));
            ?>
            <div class="adm-pv-stats">
                <div class="adm-pv-stat adm-pv-stat--featured">
                    <div class="adm-pv-stat__icon adm-pv-stat__icon--orange"><i class="bi bi-building-fill"></i></div>
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

            <!-- Filtros -->
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
                <h2 class="adm-section-title">Listado de <span>establecimientos</span></h2>
            </div>

            <div class="adm-table-wrap adm-table-wrap--card">
                <table id="tablaAdmin" class="adm-table">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Establecimiento</th>
                            <th>Tipo</th>
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
                            <?php foreach ($datos as $hotelero):
                                $estadoUp = strtoupper(trim($hotelero['estado'] ?? ''));
                                $estadoKey = ($estadoUp === 'ACTIVO') ? 'activo' : (($estadoUp === 'INACTIVO') ? 'inactivo' : 'pendiente');
                            ?>
                                <tr id="fila-<?= $hotelero['id_proveedor_hotelero'] ?>"
                                    data-estado="<?= $estadoKey ?>">

                                    <td>
                                        <img src="<?= BASE_URL ?>public/uploads/hoteles/<?= htmlspecialchars($hotelero['logo'] ?? '') ?>"
                                             alt="Logo <?= htmlspecialchars($hotelero['nombre_establecimiento']) ?>"
                                             class="adm-pv-logo"
                                             onerror="this.src='<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/default-avatar.png';this.onerror=null;">
                                    </td>
                                    <td>
                                        <div class="adm-table__act-name"><?= htmlspecialchars($hotelero['nombre_establecimiento']) ?></div>
                                    </td>
                                    <td>
                                        <span class="adm-tipo-chip"><?= htmlspecialchars($hotelero['tipo_establecimiento']) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($hotelero['nombre_representante']) ?></td>
                                    <td class="adm-pv-email"><?= htmlspecialchars($hotelero['email']) ?></td>
                                    <td><?= htmlspecialchars($hotelero['telefono']) ?></td>
                                    <td><?= htmlspecialchars($hotelero['nombre_ciudad'] ?? '—') ?></td>

                                    <td class="col-estado">
                                        <?php if ($estadoKey === 'activo'): ?>
                                            <span class="adm-badge adm-badge--confirmed">
                                                <span class="adm-badge__dot"></span> Activo
                                            </span>
                                        <?php elseif ($estadoKey === 'inactivo'): ?>
                                            <span class="adm-badge adm-badge--cancelled">
                                                <span class="adm-badge__dot"></span> Inactivo
                                            </span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--pending">
                                                <span class="adm-badge__dot"></span> Pendiente
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="adm-pv-actions">
                                            <button class="adm-pv-btn adm-pv-btn--view btn-ver"
                                                data-id="<?= $hotelero['id_proveedor_hotelero'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#verProveedorModal"
                                                title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="<?= BASE_URL ?>administrador/editar-proveedor-hotelero?id=<?= $hotelero['id_proveedor_hotelero'] ?>"
                                               class="adm-pv-btn adm-pv-btn--edit" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>administrador/eliminar-proveedor-hotelero?accion=eliminar&id=<?= $hotelero['id_proveedor_hotelero'] ?>"
                                               class="adm-pv-btn adm-pv-btn--delete" title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de eliminar este establecimiento?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9">
                                    <div class="adm-empty-state">
                                        <i class="bi bi-building adm-empty-state__icon"></i>
                                        <p>No hay proveedores hoteleros registrados aún.</p>
                                        <a href="<?= BASE_URL ?>administrador/registrar-proveedor-hotelero" class="adm-btn-primary-sm">
                                            <i class="bi bi-plus-lg"></i> Registrar hotelero
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


<!-- ==========================================
     MODAL VER PROVEEDOR HOTELERO
     Todos los IDs originales intactos para el JS
=========================================== -->
<div class="modal fade" id="verProveedorModal" tabindex="-1" aria-labelledby="verProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content adm-modal">

            <!-- Header -->
            <div class="adm-modal__header">
                <div class="adm-modal__logo-wrap">
                    <img src="" alt="Logo" id="modal-logo" class="adm-modal__logo">
                </div>
                <div class="adm-modal__header-info">
                    <div class="adm-modal__eyebrow">Proveedor Hotelero</div>
                    <h5 class="adm-modal__title" id="verProveedorModalLabel">
                        <span id="modal-nombre-establecimiento">Detalles del Establecimiento</span>
                    </h5>
                    <small class="adm-modal__subtitle">Información completa del proveedor hotelero</small>
                </div>
                <button type="button" class="adm-modal__close" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body adm-modal__body">

                <!-- Barra de estado -->
                <div class="adm-modal__status-bar">
                    <span class="adm-modal__status-badge" id="modal-status"></span>
                    <span class="adm-modal__date" id="modal-fecha-registro"></span>
                </div>

                <!-- Sección 1: Establecimiento -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-building"></i>
                        <h6>Información del Establecimiento</h6>
                    </div>
                    <div class="adm-modal__grid adm-modal__grid--3">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Nombre</div>
                            <div class="adm-modal__info-value" id="modal-nombre-establecimiento-card">—</div>
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
                            <div class="adm-modal__info-label">Tipo de Establecimiento</div>
                            <div class="adm-modal__info-value chips" id="modal-tipo-establecimiento">—</div>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Representante -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-user-tie"></i>
                        <h6>Información del Representante</h6>
                    </div>
                    <div class="adm-modal__grid adm-modal__grid--2">
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

                <!-- Sección 3: Ubicación -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h6>Ubicación</h6>
                    </div>
                    <div class="adm-modal__grid adm-modal__grid--3">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Departamento</div>
                            <div class="adm-modal__info-value" id="modal-departamento">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Ciudad</div>
                            <div class="adm-modal__info-value" id="modal-ciudad">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Dirección</div>
                            <div class="adm-modal__info-value" id="modal-direccion">—</div>
                        </div>
                    </div>
                </div>

                <!-- Sección 4: Habitaciones y Servicios -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-bed"></i>
                        <h6>Habitaciones y Servicios</h6>
                    </div>
                    <div class="adm-modal__grid adm-modal__grid--2">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Tipo de Habitación</div>
                            <div class="adm-modal__info-value chips" id="modal-tipo-habitacion">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Máx. Huéspedes</div>
                            <div class="adm-modal__info-value" id="modal-max-huesped">—</div>
                        </div>
                        <div class="adm-modal__info-card adm-modal__info-card--full">
                            <div class="adm-modal__info-label">Servicios Incluidos</div>
                            <div class="adm-modal__info-value chips" id="modal-servicios">—</div>
                        </div>
                    </div>
                </div>

                <!-- Sección 5: Documentación y Pagos -->
                <div class="adm-modal__section">
                    <div class="adm-modal__section-header">
                        <i class="fas fa-file-alt"></i>
                        <h6>Documentación y Pagos</h6>
                    </div>
                    <div class="adm-modal__grid adm-modal__grid--3">
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">NIT / RUT</div>
                            <div class="adm-modal__info-value" id="modal-nit">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Cámara de Comercio</div>
                            <div class="adm-modal__info-value" id="modal-camara">—</div>
                        </div>
                        <div class="adm-modal__info-card">
                            <div class="adm-modal__info-label">Licencia</div>
                            <div class="adm-modal__info-value" id="modal-licencia">—</div>
                        </div>
                        <div class="adm-modal__info-card adm-modal__info-card--full">
                            <div class="adm-modal__info-label">Métodos de Pago</div>
                            <div class="adm-modal__info-value chips" id="modal-metodos-pago">—</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.adm-modal__body -->

            <!-- Footer — IDs originales para el JS -->
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
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- JS original del módulo — IDs intactos -->
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_hotelero.js"></script>

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

    /* ─── FILTROS ─────────────────────────────── */
    const filtros = document.querySelectorAll('.adm-pv-filter');
    const filas   = document.querySelectorAll('#tablaAdmin tbody tr[data-estado]');

    filtros.forEach(btn => {
        btn.addEventListener('click', () => {
            filtros.forEach(b => b.classList.remove('adm-pv-filter--active'));
            btn.classList.add('adm-pv-filter--active');

            const f = btn.dataset.filter;
            filas.forEach(row => {
                row.style.display = (f === 'all' || row.dataset.estado === f) ? '' : 'none';
            });
        });
    });

    /* ─── BÚSQUEDA ───────────────────────────── */
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

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>

</body>
</html>

