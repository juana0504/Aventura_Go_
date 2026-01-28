<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket de Reporte</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layouts -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- CSS propio (puedes crear uno luego si quieres) -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/tickets/crear_ticket.css"> -->
</head>

<body>

<section id="crear-ticket">

    <!-- Panel Lateral -->
    <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>

    <!-- Contenido Principal -->
    <div class="contenido-principal">

        <!-- Barra de Búsqueda Superior -->
        <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>

        <div class="info">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h1 class="mb-4">
                        <i class="bi bi-ticket-detailed"></i>
                        Crear Ticket de Reporte
                    </h1>

                    <form action="<?= BASE_URL ?>/proveedor_turistico/tickets?accion=guardar" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Asunto</label>
                            <input
                                type="text"
                                name="asunto"
                                class="form-control"
                                placeholder="Ej: Problema con una actividad"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción del problema</label>
                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="6"
                                placeholder="Describe detalladamente el inconveniente"
                                required
                            ></textarea>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Enviar Ticket
                            </button>

                            <a href="<?= BASE_URL ?>/proveedor_turistico/tickets" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
