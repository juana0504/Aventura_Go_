<?php
// 1. Helpers de sesión y controlador (Igual que en Turistas)
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/ticketController.php';

// 2. Obtención de datos (Simulando el flujo de $datos = listarTuristas())
// Instanciamos el modelo para traer la información que ya confirmaste en la BD
require_once BASE_PATH . '/app/models/Ticket.php';
$ticketModel = new Ticket();
$listadoTickets = $ticketModel->listarTodo(); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reportes | Aventura GO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/consultaTickets.css">
</head>

<body>

    <section id="admin-dashboard">

        <?php require_once __DIR__ . '/../../layouts/panel_izq_administrador.php'; ?>

        <div class="info">

            <?php require_once __DIR__ . '/../../layouts/buscador_administrador.php'; ?>

            <div class="header-section">
                <h1>Soporte y Reportes</h1>
            </div>

            <div class="filtros-rapidos d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <button class="filtro-btn active" data-filter="all">
                        <i class="bi bi-grid"></i> Todos
                    </button>
                    </div>
                
                <a href="<?= BASE_URL ?>/proveedor/crear-ticket" class="btn-nuevo text-white text-decoration-none bg-success p-2 rounded fw-bold shadow-sm">
                    <i class="bi bi-plus-circle"></i> Nuevo Reporte
                </a>
            </div>

            <div class="tabla-container mt-4">
                <table id="tablaAdmin" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Asunto</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listadoTickets)) : ?>
                            <?php foreach ($listadoTickets as $t): ?>
                                <tr>
                                    <td>#<?= $t['id_ticket'] ?></td>
                                    <td>
                                        <?= htmlspecialchars($t['nombre_usuario'] ?? 'Usuario ID: '.$t['id_usuario']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($t['asunto']) ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= $t['categoria'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $t['estado'] === 'ABIERTO' ? 'bg-warning' : 'bg-success' ?>">
                                            <?= $t['estado'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/administrador/ver-ticket?id=<?= $t['id_ticket'] ?>" class="btn-accion btn-editar" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="#" class="btn-accion btn-eliminar" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay reportes registrados actualmente.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php require_once __DIR__ . '/../../layouts/footer_administrador.php'; ?>

</body>
</html>