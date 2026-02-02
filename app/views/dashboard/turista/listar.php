<?php
// CAMBIO: Usar sesión de turista
require_once BASE_PATH . '/app/helpers/session_turista.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turista | Mis Tickets</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/listarTickets.css">
</head>

<body>

<section id="listar-tickets">

    <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

    <div class="contenido-principal">
        <?php require_once __DIR__ . '/../../../views/layouts/buscador_turista.php'; ?>

        <div class="info">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Mis Tickets de Soporte</h1>
                <a href="<?= BASE_URL ?>/turista/crear_ticket" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Crear Ticket
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tickets)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No has creado tickets aún</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?= $ticket['id_ticket'] ?></td>
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
                                    <td>
                                        <?php if (!empty($ticket['respuesta'])): ?>
                                            <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#respuesta<?= $ticket['id_ticket'] ?>">
                                                Ver
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">Sin respuesta</span>
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

<?php if (!empty($tickets)): ?>
    <?php foreach ($tickets as $ticket): ?>
        <?php if (!empty($ticket['respuesta'])): ?>
            <div class="modal fade" id="respuesta<?= $ticket['id_ticket'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Respuesta del Administrador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="p-3 bg-light rounded">
                                <strong>Tu consulta:</strong><br>
                                <p class="text-muted"><?= htmlspecialchars($ticket['descripcion']) ?></p>
                                <hr>
                                <strong>Respuesta:</strong><br>
                                <?= nl2br(htmlspecialchars($ticket['respuesta'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>