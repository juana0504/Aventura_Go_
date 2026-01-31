<?php
// CAMBIO: Ahora usamos el helper de sesión del turista
require_once BASE_PATH . '/app/helpers/session_turista.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turista | Crear Ticket</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css"> 

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/tickets.css">
</head>

<body>

<section id="crear-ticket">

    <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

    <div class="contenido-principal">

        <?php require_once __DIR__ . '/../../../views/layouts/buscador_turista.php'; ?>

        <div class="info">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Crear Ticket de Soporte (Turista)</h4>

                    <form method="POST" action="<?= BASE_URL ?>/turista/guardar_ticket">

                        <div class="mb-3">
                            <label class="form-label">Asunto</label>
                            <input
                                type="text"
                                name="asunto"
                                class="form-control"
                                placeholder="Ej: Problema con mi reserva"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="6"
                                placeholder="Describe detalladamente tu inconveniente..."
                                required
                            ></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Enviar Ticket
                            </button>

                            <a href="<?= BASE_URL ?>/turista/tickets" class="btn btn-secondary">
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>