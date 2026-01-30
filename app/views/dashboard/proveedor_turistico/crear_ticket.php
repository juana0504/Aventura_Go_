<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ticket</title>

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

    <!-- Layout global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/tickets.css">

</head>

<body>

<section id="crear-ticket">

    <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>

    <div class="contenido-principal">

        <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>

        <div class="info">

            <div class="card">
                <div class="card-body">

                    <h4 class="mb-4">Crear Ticket de Soporte</h4>

                    <form method="POST" action="<?= BASE_URL ?>/proveedor/tickets/guardar">

                        <div class="mb-3">
                            <label class="form-label">Asunto</label>
                            <input
                                type="text"
                                name="asunto"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="6"
                                required
                            ></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Enviar Ticket
                            </button>

                            <a href="<?= BASE_URL ?>/proveedor/tickets" class="btn btn-secondary">
                                Volver
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
