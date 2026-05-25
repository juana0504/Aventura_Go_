<?php

require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

// Lógica intacta
$estadoBadgeClass = static function (string $estado): string {
    if ($estado === 'confirmada') return 'pv-badge pv-badge--confirmed';
    if ($estado === 'pendiente')  return 'pv-badge pv-badge--pending';
    return 'pv-badge pv-badge--cancelled';
};

// Iniciales para el topbar
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
    <title>Registro Proveedor Hotelero</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Layout -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/layout_admin.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/completar_informacion/completar_informacion.css">

</head>

<body class="pv-body">

    <div class="pv-layout" id="listado">

        <!-- ==========================================
            SIDEBAR PROVEEDOR TURÍSTICO
        =========================================== -->
        <nav class="pv-sidebar">

            <div class="pv-sidebar__logo">
                <div class="pv-sidebar__logo-icon">A</div>
                <div>
                    <div class="pv-sidebar__logo-text">AVENTURA GO</div>
                    <div class="pv-sidebar__logo-sub">Proveedor Turístico</div>
                </div>
            </div>

            <div class="pv-sidebar__section-label">Panel</div>

            <a href="<?= BASE_URL ?>proveedor_hotelero/dashboard" class="pv-nav-item">
                <i class="bi bi-grid-1x2-fill pv-nav-item__icon"></i> Dashboard
            </a>

            <div class="pv-sidebar__section-label">Actividades</div>

            <a href="<?= BASE_URL ?>proveedor_hotelero/completar-informacion" class="pv-nav-item pv-nav-item--active">
                <i class="bi bi-pen"></i> Registrar/Actualizar Información
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedaje" class="pv-nav-item">
                <i class="bi bi-plus-circle pv-nav-item__icon"></i> Nuevo Hospedaje
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hospedajes" class="pv-nav-item">
                <i class="bi bi-compass pv-nav-item__icon"></i> Mis Hospedajes
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-reservas" class="pv-nav-item">
                <i class="bi bi-calendar3 pv-nav-item__icon"></i> Reservas
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/ingresos" class="pv-nav-item">
                <i class="bi bi-bar-chart-line pv-nav-item__icon"></i> Ingresos
            </a>

            <div class="pv-sidebar__section-label">Soporte</div>

            <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-nav-item">
                <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/perfil" class="pv-nav-item">
                <i class="bi bi-person-circle pv-nav-item__icon"></i> Mi Perfil
            </a>

        </nav>

        <!-- CONTENIDO -->
        <div class="pv-main">

            <!-- TOPBAR -->
            <header class="pv-topbar">

                    <div class="pv-topbar__search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Buscar actividades, reservas..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
                    </div>

                    <div class="pv-topbar__actions">

                        <!-- Modo oscuro -->
                        <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro">
                            <i class="bi bi-moon-fill" id="pv-dark-icon"></i>
                        </button>

                        <!-- Notificaciones -->
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
                                    <div class="pv-notif-item pv-notif-item--unread">
                                        <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                        <div class="pv-notif-item__body">
                                            <p class="pv-notif-item__text">Tienes una reserva <strong>pendiente</strong> de confirmación.</p>
                                            <span class="pv-notif-item__time">Hace 3 horas</span>
                                        </div>
                                        <span class="pv-notif-item__dot"></span>
                                    </div>
                                </div>
                                <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__footer">Ver todas las notificaciones</a>
                            </div>
                        </div>

                        <!-- Perfil -->
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
                                <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-dropdown__item">
                                    <i class="bi bi-person-circle"></i> Mi perfil
                                </a>
                                <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-dropdown__item">
                                    <i class="bi bi-compass"></i> Mis actividades
                                </a>
                                <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__item">
                                    <i class="bi bi-headset"></i> Soporte
                                </a>
                                <div class="pv-dropdown__divider"></div>
                                <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                </a>
                            </div>
                        </div>

                    </div>
            </header>

            <!-- FORMULARIO -->
            <section class="formulario">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-9 col-md-8 col-lg-9">

                            <form
                                id="formCompletarHotelero"
                                action="<?= BASE_URL ?>proveedor_hotelero/completar-informacion"
                                method="POST"
                                enctype="multipart/form-data">

                                <div class="wizard-container">

                                    <div class="wizard-header">
                                        <p class="mb-0">
                                            Registro de Proveedor Hotelero
                                        </p>
                                    </div>

                                    <!-- STEPS -->
                                    <div class="wizard-steps">

                                        <div class="step active" data-step="1">
                                            <div class="step-circle">1</div>
                                            <div class="step-label">Información Básica</div>
                                        </div>

                                        <div class="step" data-step="2">
                                            <div class="step-circle">2</div>
                                            <div class="step-label">Hospedaje</div>
                                        </div>

                                        <div class="step" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-label">Ubicación</div>
                                        </div>

                                        <div class="step" data-step="4">
                                            <div class="step-circle">4</div>
                                            <div class="step-label">Representante</div>
                                        </div>

                                        <div class="step" data-step="5">
                                            <div class="step-circle">5</div>
                                            <div class="step-label">Confirmación</div>
                                        </div>

                                    </div>

                                    <!-- CONTENIDO -->
                                    <div class="wizard-content">

                                        <!-- PASO 1 -->
                                        <div class="step-content active" data-step="1">

                                            <h4 class="mb-4">
                                                <i class="fas fa-hotel text-primary"></i>
                                                Información del Establecimiento
                                            </h4>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Nombre del establecimiento *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="nombre_establecimiento"
                                                        class="form-control"
                                                        value="<?= $proveedor['nombre_establecimiento'] ?? '' ?>"
                                                    required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        NIT / RUT *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="nit_rut"
                                                        class="form-control"
                                                        value="<?= $proveedor['nit_rut'] ?? '' ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Tipo de establecimiento *
                                                    </label>

                                                    <select
                                                        name="tipo_establecimiento"
                                                        class="form-control"
                                                        required>

                                                        <option value="">Seleccione</option>

                                                        <option value="Hotel">Hotel</option>
                                                        <option value="Hostal">Hostal</option>
                                                        <option value="Cabaña">Cabaña</option>
                                                        <option value="Glamping">Glamping</option>

                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Email *
                                                    </label>

                                                    <input
                                                        type="email"
                                                        name="email"
                                                        class="form-control"
                                                        value="<?= $proveedor['email'] ?? '' ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Teléfono *
                                                    </label>

                                                    <input
                                                        type="tel"
                                                        name="telefono"
                                                        class="form-control"
                                                        value="<?= $proveedor['telefono'] ?? '' ?>"
                                                        required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        Logo *
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="logo"
                                                        class="form-control"
                                                        accept=".jpg,.jpeg,.png"
                                                        required>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- PASO 2 -->
                                        <div class="step-content" data-step="2">

                                            <h4 class="mb-4">
                                                <i class="fas fa-bed text-primary"></i>
                                                Información del Hospedaje
                                            </h4>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Tipo de habitación *
                                                    </label>

                                                    <select
                                                        name="tipo_habitacion"
                                                        class="form-control"
                                                        required>

                                                        <option value="">Seleccione</option>

                                                        <option value="Individual">Individual</option>
                                                        <option value="Doble">Doble</option>
                                                        <option value="Suite">Suite</option>
                                                        <option value="Familiar">Familiar</option>

                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Máximo huéspedes *
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="max_huesped"
                                                        class="form-control"
                                                        value="<?= $proveedor['max_huesped'] ?? '' ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Método de pago *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="metodo_pago"
                                                        class="form-control"
                                                        value="<?= $proveedor['metodo_pago'] ?? '' ?>"
                                                        placeholder="Efectivo, tarjeta, Nequi..."
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Servicios incluidos *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="servicio_incluido"
                                                        class="form-control"
                                                        value="<?= $proveedor['servicio_incluido'] ?? '' ?>"
                                                        placeholder="Wifi, piscina, desayuno..."
                                                        required>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- PASO 3 -->
                                        <div class="step-content" data-step="3">
                                            <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Ubicación</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="departamento">Departamento *</label>
                                                    <select name="departamento" id="departamento" class="form-control" required>
                                                        <option value="">Seleccione un departamento</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="departamento">Ciudad *</label>
                                                    <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                                                        <option value="">Seleccione una ciudad</option>
                                                        <?php if (!empty($ciudades)): ?>
                                                            <?php foreach ($ciudades as $ciudad): ?>
                                                                <option value="<?= $ciudad['id_ciudad']; ?>">
                                                                    <?= $ciudad['nombre']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>


                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Dirección *</label>
                                                    <input type="text" name="direccion" class="form-control" id="direccion" value="<?= $proveedor['direccion'] ?? '' ?>" placeholder="Calle 123 #45-67" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PASO 4 -->
                                        <div class="step-content" data-step="4">

                                            <h4 class="mb-4">
                                                <i class="fas fa-user text-primary"></i>
                                                Representante Legal
                                            </h4>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Nombre representante *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="nombre_representante"
                                                        class="form-control"
                                                        value="<?= $proveedor['nombre_representante'] ?? '' ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Tipo documento *
                                                    </label>

                                                    <select
                                                        name="tipo_documento"
                                                        class="form-control"
                                                        required>

                                                        <option value="">Seleccione</option>

                                                        <option value="CC">CC</option>
                                                        <option value="CE">CE</option>
                                                        <option value="Pasaporte">Pasaporte</option>

                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Identificación *
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="identificacion_representante"
                                                        class="form-control"
                                                        value="<?= $proveedor['identificacion_representante'] ?? '' ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Teléfono representante *
                                                    </label>

                                                    <input
                                                        type="tel"
                                                        name="telefono_representante"
                                                        class="form-control"
                                                        value="<?= $proveedor['telefono_representante'] ?? '' ?>"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Foto representante *
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="foto_representante"
                                                        class="form-control"
                                                        accept=".jpg,.jpeg,.png"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Cámara de comercio *
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="camara_comercio"
                                                        class="form-control"
                                                        required>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">
                                                        Licencia *
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="licencia"
                                                        class="form-control"
                                                        required>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- PASO 5 -->
                                        <div class="step-content" data-step="5">

                                            <div class="text-center">

                                                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>

                                                <h4>
                                                    Confirmar Registro
                                                </h4>

                                                <p>
                                                    Verifica la información antes de enviar.
                                                </p>

                                                <button
                                                    type="submit"
                                                    class="btn btn-success">

                                                    Finalizar Registro

                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- BOTONES -->
                                    <div class="wizard-actions">
                                        <button type="button" class="btn btn-secondary-wizard" id="prevBtn" style="display:none;">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>

                                        <button type="button" class="btn btn-primary-wizard" id="nextBtn">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>
                        <div class="col-lg-3 col-md-4 parrafos-informativos">

                            <img src="../public/assets/dashboard/proveedor_turistico/completar_informacion/img/image.png" alt="logo aventura go" class="mb-3">

                            <p>
                                <strong>¿Por qué registrar una actividad?</strong> <br>
                                Registra tus actividades de turismo de aventura y permite que más personas descubran y reserven lo que ofreces
                            </p>

                            <hr>

                            <p>
                                <strong>📋 Información detallada</strong><br>
                                Completa los datos básicos de tu actividad para que los viajeros entiendan fácilmente qué experiencia van a vivir.
                            </p>

                            <hr>

                            <p>
                                <strong>Más viajeros te descubrirán</strong> <br>
                                Tu actividad aparecerá en la plataforma para que turistas interesados en aventura puedan encontrarla y reservarla.
                            </p>

                            <hr>

                            <p>
                                <strong>Conecta con aventureros</strong> <br>
                                Comparte actividades únicas en la naturaleza y conecta con viajeros que buscan experiencias reales y memorables.
                            </p>

                            <hr>

                            <p>
                                <strong>Administra tus actividades</strong> <br>
                                Podrás actualizar información, precios y disponibilidad fácilmente desde tu panel de proveedor turistico.
                            </p>
                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/completar_informacion/completar_informacion.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/completar_informacion/departamento.js"></script>

</body>

</html>