<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';

$datos = listarHoteles();

require_once __DIR__ . '/../../layouts/header_administrador.php';

?>

<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hotelero</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">

    <!-- CSS SOLO DE ESTA VISTA (SIEMPRE AL FINAL) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_hotelero.css">



</head>

<body>

    <!-- Layout Principal -->
    <section id="admin-dashboard">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/panel_izq_administrador.php';
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../layouts/buscador_administrador.php';
            ?>

            <!-- Título y Acciones -->
            <div class="header-section">
                <h1>Gestión de Proveedores hoteleros</h1>
            </div>

            <!-- Filtros Rápidos -->
            <div class="filtros-rapidos">
                <button class="filtro-btn active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="filtro-btn" data-filter="activo">
                    <i class="bi bi-check-circle"></i> Activos
                </button>
                <button class="filtro-btn" data-filter="inactivo">
                    <i class="bi bi-x-circle"></i> Inactivos
                </button>
                <button class="filtro-btn" data-filter="pendiente">
                    <i class="bi bi-clock"></i> Pendientes
                </button>
                <a href="<?= BASE_URL ?>/administrador/reporte?tipo=hoteles" class="btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>Generar Reportes
                </a>
            </div>

            <!-- Tabla de Datos -->
            <div class="tabla-container">
                <table id="tablaAdmin" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Empresa</th>
                            <th>Establecimiento</th>
                            <th>Representante</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if (!empty($datos)) : ?>
                                <?php foreach ($datos as $hotelero): ?>
                                    <td><img src="<?= BASE_URL ?>/public/uploads/hoteles/<?= $hotelero['logo'] ?>" alt="" style="10px"></td>
                                    <td><?= $hotelero['nombre_establecimiento'] ?></td>
                                    <td><?= $hotelero['tipo_establecimiento'] ?></td>
                                    <td><?= $hotelero['nombre_representante'] ?></td>
                                    <td><?= $hotelero['email'] ?></td>
                                    <td><?= $hotelero['telefono'] ?></td>
                                    <td><?= $hotelero['nombre_ciudad'] ?? '—' ?></td>

                                    <!-- ESTADO -->
                                    <td class="col-estado">
                                        <?php if ($hotelero['estado'] == 'ACTIVO'): ?>
                                            <span class="badge-activo">Activo</span>
                                        <?php elseif ($hotelero['estado'] == 'INACTIVO'): ?>
                                            <span class="badge-inactivo">Inactivo</span>
                                        <?php else: ?>
                                            <span class="badge-pendiente">Pendiente</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button class="btn-accion btn-ver"
                                            data-id="<?= $hotelero['id_proveedor_hotelero'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#verProveedorModal">
                                            <i class="i bi-eye"></i>
                                        </button>

                                        <a href="<?= BASE_URL ?>/administrador/editar-proveedor-hotelero?id=<?= $hotelero['id_proveedor_hotelero'] ?>" class="btn-accion btn-editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="<?= BASE_URL ?>/administrador/eliminar-proveedor-hotelero?accion=eliminar&id=<?= $hotelero['id_proveedor_hotelero'] ?>" class="btn-accion btn-eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No hay proveedores registrados.</td>
                    </tr>
                <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal para ver detalles del proveedor hotelero -->
    <div class="modal fade" id="verProveedorModal" tabindex="-1" aria-labelledby="verProveedorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content aventura-modal">

                <!-- Header del Modal -->
                <div class="modal-header aventura-modal-header">
                    <div class="modal-header-content">
                        <div class="modal-logo">
                            <img src="" alt="Logo del Proveedor" id="modal-logo">
                        </div>
                        <div class="modal-title">
                            <h5 class="modal-title-text" id="verProveedorModalLabel">
                                <span class="aventura-text" id="modal-nombre-establecimiento">Proveedor Hotelero</span>
                            </h5>
                            <small class="modal-subtitle">Información completa del proveedor hotelero</small>
                        </div>
                    </div>
                </div>

                <!-- Body del Modal -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Barra de estado -->
                        <div class="row">
                            <div class="col-12">
                                <div class="status-bar mb-4">
                                    <span class="status-badge" id="modal-status"></span>
                                    <span class="register-date" id="modal-fecha-registro"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 1: Información Principal -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-building section-icon"></i>
                                <h6>Información Principal</h6>
                            </div>
                            <div class="info-section mb-4">
                                <div class="section-header">
                                    <i class="fas fa-building section-icon"></i>
                                    <h6>Información del Establecimiento</h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <div class="info-label">Nombre del establecimiento</div>
                                            <div class="info-value" id="modal-nombre-establecimiento"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <div class="info-label">Email</div>
                                            <div class="info-value" id="modal-email"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="info-card">
                                            <div class="info-label">Teléfono</div>
                                            <div class="info-value" id="modal-telefono"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="info-card">
                                            <div class="info-label">Tipo de establecimiento</div>
                                            <div class="info-value chips" id="modal-tipo-establecimiento"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Sección 2: Representante -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-user-tie section-icon"></i>
                                <h6>Información del Representante</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-user"></i> Nombre Completo</div>
                                        <div class="info-value" id="modal-representante">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-id-badge"></i> Identificación</div>
                                        <div class="info-value" id="modal-identificacion">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-envelope"></i> Email Representante</div>
                                        <div class="info-value" id="modal-email-repre">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-phone"></i> Teléfono Representante</div>
                                        <div class="info-value" id="modal-telefono-repre">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Ubicación -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-map-marker-alt section-icon"></i>
                                <h6>Ubicación</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Departamento</div>
                                        <div class="info-value" id="modal-departamento"></div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Ciudad</div>
                                        <div class="info-value" id="modal-ciudad"></div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Dirección</div>
                                        <div class="info-value" id="modal-direccion"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Sección 4:HABITACIONES Y SERVICIOS -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-bed section-icon"></i>
                                <h6>Habitaciones y Servicios</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Tipo de habitación</div>
                                        <div class="info-value chips" id="modal-tipo-habitacion"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Máx. huéspedes</div>
                                        <div class="info-value" id="modal-max-huesped"></div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="info-card">
                                        <div class="info-label">Servicios incluidos</div>
                                        <div class="info-value chips" id="modal-servicios"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- seccion 5 documentacion y pagos -->
                <div class="info-section mb-4">
                    <div class="section-header">
                        <i class="fas fa-file-alt section-icon"></i>
                        <h6>Documentación y Pagos</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-card">
                                <div class="info-label">NIT / RUT</div>
                                <div class="info-value" id="modal-nit"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-card">
                                <div class="info-label">Cámara de comercio</div>
                                <div class="info-value" id="modal-camara"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-card">
                                <div class="info-label">Licencia</div>
                                <div class="info-value" id="modal-licencia"></div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="info-card">
                                <div class="info-label">Métodos de pago</div>
                                <div class="info-value chips" id="modal-metodos-pago"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Footer del Modal -->
                <div class="modal-footer aventura-modal-footer">
                    <a class="btn btn-aventura-success" id="btn-activar-proveedor">
                        <i class="fas fa-check-circle"></i> Activar
                    </a>

                    <a class="btn btn-aventura-danger" id="btn-desactivar-proveedor">
                        <i class="fas fa-ban"></i> Desactivar
                    </a>

                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <?php
    // require_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_hotelero.js"></script>

</body>

</html>