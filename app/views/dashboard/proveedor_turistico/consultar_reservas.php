<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Reservas | Proveedor Turístico</title>

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

    <!-- CSS propio de reservas -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/reservas/consultar_reservas.css">
</head>

<body>

<section id="proveedor-reservas">

    <!-- Panel lateral -->
    <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>

    <!-- Contenido principal -->
    <div class="info">

        <!-- Buscador superior -->
        <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>

        <!-- Header -->
        <div class="header-section">
            <h1>Consultar Reservas</h1>
            <p class="text-muted">Listado de reservas realizadas en tus actividades</p>
        </div>

        <!-- Filtros rápidos -->
        <div class="filtros-rapidos">
            <button class="filtro-btn active" data-filter="all">
                <i class="bi bi-grid"></i> Todas
            </button>
            <button class="filtro-btn" data-filter="pendiente">
                <i class="bi bi-clock"></i> Pendientes
            </button>
            <button class="filtro-btn" data-filter="confirmada">
                <i class="bi bi-check-circle"></i> Confirmadas
            </button>
            <button class="filtro-btn" data-filter="cancelada">
                <i class="bi bi-x-circle"></i> Canceladas
            </button>
        </div>

        <!-- Tabla -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Listado de Reservas</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Turista</th>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Personas</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- EJEMPLO -->
                            <tr>
                                <td>1</td>
                                <td>Ana Sofía</td>
                                <td>Rafting</td>
                                <td>2026-02-10</td>
                                <td>3</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalReserva">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Juan Pérez</td>
                                <td>Senderismo</td>
                                <td>2026-02-15</td>
                                <td>2</td>
                                <td>
                                    <span class="badge bg-success">Confirmada</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>María Gómez</td>
                                <td>Camping</td>
                                <td>2026-02-20</td>
                                <td>4</td>
                                <td>
                                    <span class="badge bg-danger">Cancelada</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL DETALLE RESERVA -->
<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content aventura-modal">

            <div class="modal-header aventura-modal-header">
                <h5 class="modal-title">Detalle de la Reserva</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Turista:</strong> Ana Sofía</p>
                <p><strong>Actividad:</strong> Rafting</p>
                <p><strong>Fecha:</strong> 2026-02-10</p>
                <p><strong>Personas:</strong> 3</p>
                <p><strong>Estado:</strong> Pendiente</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Confirmar</button>
                <button class="btn btn-danger">Cancelar</button>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
