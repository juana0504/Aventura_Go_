<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- Estilos CSS (siempre al final) -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turisitco/proveedor_turistico.css"> -->

</head>

<body>

    <?php
    // panel lateral
    require BASE_PATH . '/app/views/layouts/proveedor_turistico_panel_izq.php';
    // barra de busqueda
    include_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
    ?>

    <main class="container-fluid mt-4">

        <!-- Encabezado -->
        <section class="mb-4">
            <h3 class="fw-bold">Panel del Proveedor Turístico</h3>
            <p class="text-muted">Gestiona tus experiencias, reservas e ingresos</p>
        </section>

        <!-- Tarjetas resumen -->
        <section class="row g-4 mb-4">
            <div class="col-md-3 col-12">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-briefcase fs-3"></i>
                    <p class="mt-2 mb-0">Mis Servicios</p>
                    <h3>5</h3>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-calendar-check fs-3"></i>
                    <p class="mt-2 mb-0">Reservas</p>
                    <h3>12</h3>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-cash-stack fs-3"></i>
                    <p class="mt-2 mb-0">Ingresos</p>
                    <h3>$1.250.000</h3>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="card shadow-sm p-3">
                    <i class="bi bi-check-circle fs-3 text-success"></i>
                    <p class="mt-2 mb-0">Estado</p>
                    <span class="badge bg-success">Activo</span>
                </div>
            </div>
        </section>

        <!-- Acciones rápidas -->
        <section class="mb-5">
            <h5 class="mb-3">Acciones rápidas</h5>
            <div class="d-flex gap-3 flex-wrap">
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo servicio
                </a>
                <a href="#" class="btn btn-outline-secondary">
                    <i class="bi bi-calendar-event"></i> Ver reservas
                </a>
                <a href="#" class="btn btn-outline-dark">
                    <i class="bi bi-person"></i> Mi perfil
                </a>
            </div>
        </section>

        <!-- Tabla de reservas -->
        <section class="bg-light p-3 rounded">
            <h5 class="mb-3">Últimas reservas</h5>
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Experiencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan Pérez</td>
                        <td>20-Jul-2025</td>
                        <td>Canopy</td>
                        <td><span class="badge bg-success">Confirmada</span></td>
                    </tr>
                    <tr>
                        <td>María Gómez</td>
                        <td>18-Jul-2025</td>
                        <td>Rafting</td>
                        <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>



</body>

</html>