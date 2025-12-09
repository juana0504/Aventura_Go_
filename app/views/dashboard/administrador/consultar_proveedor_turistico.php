<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/proveedor.php';

$datos = listarProveedores();

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
    <title>Turistico</title>

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

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_turistico.css">


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
                <h1>Gestión de Proveedores turisticos</h1>
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
                <a href="<?= BASE_URL ?>/administrador/reporte?tipo=turistico" class="btn-pdf" target="_blank">
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
                                <?php foreach ($datos as $proveedor): ?>
                                    <td><img src="<?= BASE_URL ?>/public/uploads/turistico/<?= $proveedor['logo'] ?>" alt="logo empresa"></td>
                                    <td><?= $proveedor['nombre_empresa'] ?></td>
                                    <td><?= $proveedor['nombre_representante'] ?></td>
                                    <td><?= $proveedor['email'] ?></td>
                                    <td><?= $proveedor['telefono'] ?></td>
                                    <td><?= $proveedor['ciudad'] ?></td>
                                    <td><span class="badge-activo">Activo</span></td>
                                    <td>

                                        <!-- <a class="btn-accion btn-ver" title="Ver Proveedor">
                                            <i class="bi bi-eye"></i>
                                        </a> -->

                                        <button class="btn-accion btn-ver"
                                            data-id="<?= $proveedor['id_proveedor'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#verProveedorModal">
                                            <i class="i bi-eye"></i>
                                        </button>

                                        <a href="<?= BASE_URL ?>/administrador/editar-proveedor?id=<?= $proveedor['id_proveedor'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="bi bi-pencil"></i>

                                        </a>
                                        <a href="<?= BASE_URL ?>/administrador/eliminar-proveedor?accion=eliminar&id=<?= $proveedor['id_proveedor'] ?>" class="btn-accion btn-eliminar" title="Eliminar">
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



    <!-- Modal para ver detalles del proveedor -->
    <div class="modal fade" id="verProveedorModal" tabindex="-1" aria-labelledby="verProveedorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content aventura-modal">

                <!-- Header del Modal -->
                <div class="modal-header aventura-modal-header">
                    <div class="modal-header-content">
                        <div class="modal-logo">
                            <div class="logo-icon-small">
                                <i class="fas fa-mountain"></i>
                            </div>
                            <div class="modal-title">
                                <h5 class="modal-title-text" id="verProveedorModalLabel">
                                    <span class="aventura-text">Detalles del Proveedor</span>
                                </h5>
                                <small class="modal-subtitle">Información completa del proveedor turístico</small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close aventura-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Body del Modal -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Barra de estado -->
                        <div class="status-bar mb-4">
                            <span class="status-badge" id="modal-status"></span>
                            <span class="register-date" id="modal-fecha-registro"></span>
                        </div>

                        <!-- Sección 1: Información Principal -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-building section-icon"></i>
                                <h6>Información Principal</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-signature"></i> Nombre de la Empresa</div>
                                        <div class="info-value" id="modal-empresa">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-id-card"></i> NIT/RUT</div>
                                        <div class="info-value" id="modal-nit">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                                        <div class="info-value" id="modal-email">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-phone"></i> Teléfono</div>
                                        <div class="info-value" id="modal-telefono">-</div>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-align-left"></i> Descripción</div>
                                        <div class="info-value" id="modal-descripcion">-</div>
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
                                <div class="col-md-8 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-image"></i> Foto del Representante</div>
                                        <div class="info-value" id="modal-foto-repre">
                                            <img src="" alt="Foto del representante" class="representante-img" id="modal-img-repre">
                                        </div>
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
                                        <div class="info-label"><i class="fas fa-map"></i> Departamento</div>
                                        <div class="info-value" id="modal-departamento">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-city"></i> Ciudad</div>
                                        <div class="info-value" id="modal-ciudad">-</div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-road"></i> Dirección</div>
                                        <div class="info-value" id="modal-direccion">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 4: Actividades -->
                        <div class="info-section mb-4">
                            <div class="section-header">
                                <i class="fas fa-hiking section-icon"></i>
                                <h6>Actividades Turísticas</h6>
                            </div>
                            <div class="activities-container" id="modal-actividades">
                                <!-- Las actividades se insertarán aquí dinámicamente -->
                            </div>
                        </div>

                        <!-- Sección 5: Multimedia -->
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-images section-icon"></i>
                                <h6>Multimedia</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-image"></i> Logo de la Empresa</div>
                                        <div class="info-value">
                                            <img src="" alt="Logo de la empresa" class="logo-img" id="modal-logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-card">
                                        <div class="info-label"><i class="fas fa-camera"></i> Foto de Actividades</div>
                                        <div class="info-value">
                                            <img src="" alt="Foto de actividades" class="activity-img" id="modal-foto-actividades">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="modal-footer aventura-modal-footer">
                    <button type="button" class="btn btn-aventura-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-aventura-success" id="btn-activar-proveedor">
                            <i class="fas fa-check-circle"></i> Activar
                        </button>
                        <button type="button" class="btn btn-aventura-danger" id="btn-desactivar-proveedor">
                            <i class="fas fa-ban"></i> Desactivar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_turistico.js"></script>
</body>

</html>