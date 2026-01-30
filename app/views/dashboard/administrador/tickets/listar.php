<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tickets de Soporte</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Layouts globales -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/listar.css">
</head>

<body>

<section id="admin-dashboard">

    <!-- Panel lateral -->
    <?php require_once __DIR__ . '/../../../layouts/panel_izq_administrador.php'; ?>

    <!-- Contenido principal -->
    <div class="info">

        <!-- Buscador -->
        <?php require_once __DIR__ . '/../../../layouts/buscador_administrador.php'; ?>

        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fa-solid fa-ticket"></i> Tickets de Soporte
                </h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (empty($tickets)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No hay tickets registrados
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?= $ticket['id_ticket'] ?></td>
                                <td><?= htmlspecialchars($ticket['nombre']) ?></td>
                                <td><?= htmlspecialchars($ticket['asunto']) ?></td>

                                <td>
                                    <?php if ($ticket['estado'] === 'abierto'): ?>
                                        <span class="badge bg-warning text-dark">Abierto</span>
                                    <?php elseif ($ticket['estado'] === 'respondido'): ?>
                                        <span class="badge bg-success">Respondido</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Cerrado</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>

                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>/administrador/tickets/responder?id=<?= $ticket['id_ticket'] ?>">
                                        Responder
                                    </a>


                                    <?php if ($ticket['estado'] !== 'cerrado'): ?>
                                        <a href="<?= BASE_URL ?>/administrador/tickets/cerrar?id=<?= $ticket['id_ticket'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Cerrar este ticket?')">
                                            <i class="fa fa-lock"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
