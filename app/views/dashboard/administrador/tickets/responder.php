<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

/*
  Se espera que el controller envíe:
  $ticket => array con la info del ticket
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Ticket</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Layouts -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">
</head>

<body>

<section id="admin-dashboard">

    <!-- PANEL IZQUIERDO -->
    <?php require_once __DIR__ . '/../../../layouts/panel_izq_administrador.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="info">

        <!-- BUSCADOR -->
        <?php require_once __DIR__ . '/../../../layouts/buscador_administrador.php'; ?>

        <div class="container-fluid mt-4">

            <h2 class="mb-4">
                <i class="fa fa-ticket-alt"></i> Responder Ticket #<?= $ticket['id_ticket'] ?>
            </h2>

            <!-- INFO DEL TICKET -->
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>Proveedor:</strong> <?= htmlspecialchars($ticket['nombre'] ?? 'N/A') ?></p>
                    <p><strong>Asunto:</strong> <?= htmlspecialchars($ticket['asunto']) ?></p>
                    <p><strong>Descripción:</strong></p>
                    <p class="border rounded p-3 bg-light">
                        <?= nl2br(htmlspecialchars($ticket['descripcion'])) ?>
                    </p>
                    <p>
                        <strong>Estado:</strong>
                        <span class="badge bg-warning text-dark">
                            <?= ucfirst($ticket['estado']) ?>
                        </span>
                    </p>
                </div>
            </div>

            <!-- FORMULARIO RESPUESTA -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-reply"></i> Respuesta del Administrador
                </div>

                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/administrador/tickets/guardar-respuesta">

                        <input type="hidden" name="id_ticket" value="<?= $ticket['id_ticket'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Respuesta</label>
                            <textarea
                                name="respuesta"
                                class="form-control"
                                rows="6"
                                required
                            ><?= htmlspecialchars($ticket['respuesta'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= BASE_URL ?>/administrador/tickets" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> Enviar respuesta
                            </button>
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
