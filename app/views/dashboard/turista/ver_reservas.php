<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas | Turista</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
</head>

<body>

    <section id="turista-reservas">

        <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

        <div class="info">

            <?php require_once __DIR__ . '/../../layouts/buscador_turista.php'; ?>

            <div class="header-section">
                <h1>Mis Reservas</h1>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Actividad</th>
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
                                    <th>Personas</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($reservas)): ?>
                                    <?php foreach ($reservas as $reserva): ?>

                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <?php if (!empty($reserva['imagen'])): ?>
                                                        <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= htmlspecialchars($reserva['imagen']) ?>"
                                                            class="rounded me-3" style="width:50px;height:50px;object-fit:cover;">
                                                    <?php else: ?>
                                                        <div class="rounded me-3 bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width:50px;height:50px;">
                                                            <i class="bi bi-image text-white"></i>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div>
                                                        <strong><?= htmlspecialchars($reserva['nombre_actividad'] ?? 'Actividad') ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?= htmlspecialchars($reserva['nombre_ciudad'] ?? '') ?></small>
                                                    </div>

                                                </div>
                                            </td>

                                            <td>
                                                <strong><?= htmlspecialchars($reserva['nombre_empresa'] ?? 'Proveedor') ?></strong>
                                                <br>
                                                <small class="text-muted"><?= htmlspecialchars($reserva['email_representante'] ?? '') ?></small>
                                            </td>

                                            <td>
                                                <?= !empty($reserva['fecha']) ? date('d/m/Y', strtotime($reserva['fecha'])) : '--/--/----' ?>
                                                <br>
                                                <small class="text-muted">
                                                    <?= !empty($reserva['created_at']) ? date('H:i', strtotime($reserva['created_at'])) : '--:--' ?>
                                                </small>
                                            </td>

                                            <td class="text-center">
                                                <strong><?= (int)($reserva['cantidad_personas'] ?? 0) ?></strong>
                                            </td>

                                            <td class="text-end">
                                                <strong>
                                                    $<?= number_format(
                                                            ($reserva['precio'] ?? 0) * ($reserva['cantidad_personas'] ?? 0),
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <?php
                                                $estado = $reserva['estado'] ?? 'pendiente';
                                                $estadoClass =
                                                    $estado === 'pendiente' ? 'bg-warning text-dark' : ($estado === 'confirmada' ? 'bg-success' : ($estado === 'cancelada' ? 'bg-danger' : 'bg-primary'));
                                                ?>
                                                <span class="badge <?= $estadoClass ?>">
                                                    <?= ucfirst($estado) ?>
                                                </span>
                                            </td>

                                            <td>
                                            <td>

                                                <!-- Botón ver -->
                                                <button class="btn-accion btn-ver"
                                                    data-id="<?= $reserva['id_reserva'] ?? 0 ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalReserva">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Botón cancelar SOLO si está pendiente -->
                                                <?php if (($reserva['estado'] ?? '') === 'pendiente'): ?>
                                                    <a
                                                        href="<?= BASE_URL ?>/turista/ver-reservas?accion=cancelar&id=<?= $reserva['id_reserva'] ?>"
                                                        class="btn btn-sm btn-danger ms-1"
                                                        onclick="return confirm('¿Desea cancelar esta reserva?');">
                                                        Cancelar
                                                    </a>
                                                    <!-- Botón ACTIVAR LA RESERVA -->

                                                    <?php if ($reserva['estado'] === 'pendiente'): ?>
                                                        <a
                                                            href="<?= BASE_URL ?>/turista/confirmar-reserva?id=<?= $reserva['id_reserva'] ?>"
                                                            class="btn btn-success btn-sm mt-1"
                                                            onclick="return confirm('¿Confirmar esta reserva? Se descontarán los cupos.')">
                                                            Confirmar
                                                        </a>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            </td>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>
                                <?php else: ?>

                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <i class="bi bi-calendar-x" style="font-size:3rem"></i>
                                            <h5 class="mt-3">No tienes reservas registradas</h5>
                                        </td>
                                    </tr>

                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>