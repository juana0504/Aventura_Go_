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
    <title>Registrar Hotel</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CSS propio -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/registrar_hotel/registrar_hotel.css">
</head>

<body class="pv-body">



    <section id="registrar-actividades">

        <!-- ==========================================
            SIDEBAR PROVEEDOR HOTELERO
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

            <a href="<?= BASE_URL ?>proveedor_hotelero/completar-informacion" class="pv-nav-item">
                <i class="bi bi-pen"></i> Registrar/Actualizar Información
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedaje" class="pv-nav-item pv-nav-item--active">
                <i class="bi bi-plus-circle pv-nav-item__icon"></i> Nuevo Hospedaje
            </a>
            <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hoteles" class="pv-nav-item">
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

            <!-- CONTENIDO DE LA PAGINA -->
            <section class="formulario">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-9 col-md-8 col-lg-9">

                            <form id="formHospedaje"
                                action="<?= BASE_URL ?>proveedor_hotelero/guardar-hospedaje"
                                method="POST">

                                <input type="hidden" name="accion" value="registrar">

                                <div class="wizard-container">

                                    <!-- HEADER -->
                                    <div class="wizard-header">
                                        <p class="mb-0">Registro de Hospedajes</p>
                                    </div>

                                    <!-- PASOS -->
                                    <div class="wizard-steps">

                                        <div class="step active" data-step="1">
                                            <div class="step-circle">1</div>
                                            <div class="step-label">Información</div>
                                        </div>

                                        <div class="step" data-step="2">
                                            <div class="step-circle">2</div>
                                            <div class="step-label">Servicios</div>
                                        </div>

                                        <div class="step" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-label">Confirmación</div>
                                        </div>

                                    </div>

                                    <div class="wizard-content">

                                        <!-- PASO 1 -->
                                        <div class="step-content active" id="step-1">

                                            <h4 class="mb-4">
                                                <i class="fas fa-hotel text-primary"></i>
                                                Información del hospedaje
                                            </h4>

                                            <label class="form-label">Nombre del hospedaje</label>
                                            <input type="text" class="form-control" name="nombre" required>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">Tipo de hospedaje</label>

                                                    <select name="tipo" class="form-control" required>

                                                        <option value="">Seleccione</option>

                                                        <option value="HOTEL">🏨 Hotel</option>

                                                        <option value="HOSTAL">🛏 Hostal</option>

                                                        <option value="FINCA">🌿 Finca</option>

                                                        <option value="CABAÑA">🪵 Cabaña</option>

                                                        <option value="OTRO">🏕 Otro</option>

                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">Capacidad</label>
                                                    <input type="number" class="form-control" name="capacidad" required>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">Departamento</label>

                                                    <select name="id_departamento" class="form-control" id="id_departamento" required>
                                                        <option value="">Seleccione departamento</option>
                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label">Ciudad / Destino</label>

                                                    <select name="id_destino" class="form-control" id="id_ciudad" required>
                                                        <option value="">Seleccione ciudad</option>
                                                    </select>

                                                </div>

                                            </div>

                                            <label class="form-label">Ubicación</label>
                                            <input type="text" class="form-control" name="ubicacion" required>

                                            <label class="form-label">Precio por noche</label>
                                            <input type="number" class="form-control" step="0.01" name="precio" required>

                                            <div class="wizard-actions">
                                                <span></span>
                                                <button type="button" onclick="nextStep(2)">
                                                    Siguiente <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>

                                        </div>

                                        <!-- PASO 2 -->
                                        <div class="step-content" id="step-2">

                                            <h4 class="mb-4">
                                                <i class="fas fa-concierge-bell text-primary"></i>
                                                Servicios y estado
                                            </h4>

                                            <div class="row">

                                                <div class="col-md-12 mb-4">

                                                    <label class="form-label">
                                                        Servicios incluidos
                                                    </label>

                                                    <div class="row">

                                                        <div class="col-md-6">

                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="wifi"
                                                                    value="WiFi">

                                                                <label class="form-check-label">
                                                                    📶 WiFi
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="piscina"
                                                                    value="Piscina">

                                                                <label class="form-check-label">
                                                                    🏊 Piscina
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="restaurante"
                                                                    value="Restaurante">

                                                                <label class="form-check-label">
                                                                    🍽 Restaurante
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="spa"
                                                                    value="Spa">

                                                                <label class="form-check-label">
                                                                    💆 Spa
                                                                </label>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="parqueadero"
                                                                    value="Parqueadero">

                                                                <label class="form-check-label">
                                                                    🚗 Parqueadero
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="petfriendly"
                                                                    value="Pet Friendly">

                                                                <label class="form-check-label">
                                                                    🐶 Pet Friendly
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="desayuno"
                                                                    value="Desayuno incluido">

                                                                <label class="form-check-label">
                                                                    ☕ Desayuno incluido
                                                                </label>
                                                            </div>

                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="servicios[]"
                                                                    id="transporte"
                                                                    value="Transporte">

                                                                <label class="form-check-label">
                                                                    🚐 Transporte
                                                                </label>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 mb-3">

                                                    <label class="form-label">
                                                        Descripción del hospedaje
                                                    </label>

                                                    <textarea
                                                        name="descripcion"
                                                        id="descripcion"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Describe tu hospedaje, experiencia, ubicación y servicios..."
                                                        required></textarea>

                                                </div>

                                            </div>

                                            <label>Estado</label>

                                            <select name="estado">

                                                <option value="ACTIVO">Activo</option>
                                                <option value="INACTIVO">Inactivo</option>

                                            </select>

                                            <label>Disponibilidad</label>

                                            <select name="disponible">

                                                <option value="1">Disponible</option>
                                                <option value="0">No disponible</option>

                                            </select>

                                            <div class="wizard-actions">

                                                <button type="button" onclick="prevStep(1)">
                                                    Atrás <i class="fas fa-arrow-left"></i>
                                                </button>

                                                <button type="button" onclick="nextStep(3)">
                                                    Siguiente <i class="fas fa-arrow-right"></i>
                                                </button>

                                            </div>

                                        </div>

                                        <!-- PASO 3 -->
                                        <div class="step-content" id="step-3">

                                            <h4 class="mb-4">

                                                <i class="fas fa-check-circle text-success"></i>
                                                Confirmar hospedaje

                                            </h4>

                                            <div class="preview-card">

                                                <div class="row">

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Nombre</div>
                                                        <div class="preview-value" id="prev-nombre"></div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Tipo</div>
                                                        <div class="preview-value" id="prev-tipo"></div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Capacidad</div>
                                                        <div class="preview-value" id="prev-capacidad"></div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Precio</div>
                                                        <div class="preview-value" id="prev-precio"></div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="preview-label">Ubicación</div>
                                                        <div class="preview-value" id="prev-ubicacion"></div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="preview-label">Servicios</div>
                                                        <div class="preview-value" id="prev-servicios"></div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="wizard-actions">

                                                <button type="button" onclick="prevStep(2)">
                                                    Atrás <i class="fas fa-arrow-left"></i>
                                                </button>

                                                <button type="submit">
                                                    Guardar hospedaje
                                                </button>

                                            </div>

                                        </div>

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
    </section>



    <!-- JS DEPARTAMENTO → CIUDAD (NO TOCAR) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const departamentoSelect = document.getElementById('id_departamento');
            const ciudadSelect = document.getElementById('id_ciudad');

            // Cargar departamentos
            fetch('<?= BASE_URL ?>app/controllers/departamentoController.php')
                .then(res => res.json())
                .then(data => {
                    data.forEach(dep => {
                        const opt = document.createElement('option');
                        opt.value = dep.id_departamento;
                        opt.textContent = dep.nombre;
                        departamentoSelect.appendChild(opt);
                    });
                });

            // Cargar ciudades por departamento
            departamentoSelect.addEventListener('change', () => {
                ciudadSelect.innerHTML = '<option value="">Seleccione ciudad</option>';

                if (!departamentoSelect.value) return;

                fetch(`<?= BASE_URL ?>app/controllers/ciudadController.php?id_departamento=${departamentoSelect.value}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(ciudad => {
                            const opt = document.createElement('option');
                            opt.value = ciudad.id_ciudad;
                            opt.textContent = ciudad.nombre;
                            ciudadSelect.appendChild(opt);
                        });
                    });
            });
        });
    </script>

    <script>
        function nextStep(step) {

            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));

            document.getElementById('step-' + step).classList.add('active');

            if (step === 4) {
                cargarResumen();
            }
        }

        function prevStep(step) {
            nextStep(step);
        }


        function cargarResumen() {

            document.getElementById("prev-nombre").textContent =
                document.querySelector('input[name="nombre"]').value;

            document.getElementById("prev-ubicacion").textContent =
                document.querySelector('input[name="ubicacion"]').value;

            document.getElementById("prev-cupos").textContent =
                document.querySelector('input[name="cupos"]').value;

            document.getElementById("prev-precio").textContent =
                document.querySelector('input[name="precio"]').value;

            document.getElementById("prev-descripcion").textContent =
                document.querySelector('textarea[name="descripcion"]').value;


            let departamento =
                document.querySelector('#id_departamento option:checked')?.textContent || "-";

            let ciudad =
                document.querySelector('#id_ciudad option:checked')?.textContent || "-";


            document.getElementById("prev-departamento").textContent = departamento;
            document.getElementById("prev-ciudad").textContent = ciudad;

        }
    </script>

    <script>
        function nextStep(step) {

            // Ocultar todos los pasos
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.remove('active');
            });

            // Mostrar el paso actual
            document.getElementById('step-' + step).classList.add('active');

            // Actualizar los círculos del wizard
            document.querySelectorAll('.step').forEach(item => {
                item.classList.remove('active');
            });

            document.querySelector('.step[data-step="' + step + '"]')
                .classList.add('active');

            // Cargar resumen en el último paso
            if (step === 3) {
                cargarResumen();
            }
        }

        function prevStep(step) {
            nextStep(step);
        }

        function cargarResumen() {

            document.getElementById("prev-nombre").textContent =
                document.querySelector('input[name="nombre"]').value;

            document.getElementById("prev-tipo").textContent =
                document.querySelector('select[name="tipo"] option:checked').textContent;

            document.getElementById("prev-capacidad").textContent =
                document.querySelector('input[name="capacidad"]').value;

            document.getElementById("prev-precio").textContent =
                document.querySelector('input[name="precio"]').value;

            document.getElementById("prev-ubicacion").textContent =
                document.querySelector('input[name="ubicacion"]').value;

            let servicios = [];

            document.querySelectorAll('input[name="servicios[]"]:checked')
                .forEach(servicio => {
                    servicios.push(servicio.value);
                });

            document.getElementById("prev-servicios").textContent =
                servicios.length > 0 ?
                servicios.join(', ') :
                'Sin servicios';
        }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>