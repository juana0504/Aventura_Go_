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
                                    <td><img src="<?= BASE_URL ?>/public/uploads/turistico/<?= $proveedor['logo'] ?>" alt="" style="10px"></td>
                                    <td><?= $proveedor['nombre_empresa'] ?></td>
                                    <td><?= $proveedor['nombre_representante'] ?></td>
                                    <td><?= $proveedor['email'] ?></td>
                                    <td><?= $proveedor['telefono'] ?></td>
                                    <td><?= $proveedor['ciudad'] ?></td>
                                    <td><span class="badge-activo">Activo</span></td>
                                    <td>

                                        <a class="btn-accion btn-ver" title="Ver Proveedor">
                                            <i class="bi bi-eye"></i>
                                        </a>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


</body>

</html>