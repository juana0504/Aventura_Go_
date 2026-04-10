<?php
if (!isset($datos_turista)) {
    header('Location: /aventura_go/turista/dashboard');
    exit;
}

$nombreUsuario = $datos_turista['nombre'] ?? ($_SESSION['user']['nombre'] ?? '');
$estadisticas = $datos_turista['estadisticas'] ?? [];
$reservas = $datos_turista['reservas'] ?? [];

$totalReservas = $estadisticas['total_reservas'] ?? 0;
$confirmadas = $estadisticas['confirmadas'] ?? 0;
$pendientes = $estadisticas['pendientes'] ?? 0;
$totalGastado = $estadisticas['total_gastado'] ?? 0;

$estadoBadgeClass = static function (string $estado): string {
    if ($estado === 'confirmada') {
        return 'bg-success';
    }

    if ($estado === 'pendiente') {
        return 'bg-warning text-dark';
    }

    return 'bg-secondary';
};
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Turista</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Librería AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layout global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/layout_admin.css">

    <!-- Estilos comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/panel_turista.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">
</head>

<body>

    <div id="turista">

        <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

        <div class="info">

            <?php require_once __DIR__ . '/../../layouts/buscador_turista.php'; ?>

            <main class="container py-4 dashboard-turista">
                <p class="h4">¡Bienvenido, <?= htmlspecialchars($nombreUsuario) ?>!</p>
                <p class="text-muted">Gestiona tus reservas y experiencias de deportes extremos</p>

                <div class="row g-4 mb-4">
                    <div class="col-md-3 col-sm-6 col-12 d-flex">
                        <div class="card shadow-sm p-3 w-100">
                            <i class="bi bi-calendar-check fs-3"></i>
                            <p class="mt-2 mb-0">Mis Reservas</p>
                            <h3><?= number_format($totalReservas) ?></h3>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 d-flex">
                        <div class="card shadow-sm p-3 w-100">
                            <i class="bi bi-check-circle fs-3"></i>
                            <p class="mt-2 mb-0">Confirmadas</p>
                            <h3><?= number_format($confirmadas) ?></h3>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 d-flex">
                        <div class="card shadow-sm p-3 w-100">
                            <i class="bi bi-clock-history fs-3"></i>
                            <p class="mt-2 mb-0">Pendientes</p>
                            <h3><?= number_format($pendientes) ?></h3>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12 d-flex">
                        <div class="card shadow-sm p-3 w-100">
                            <i class="bi bi-cash-stack fs-3"></i>
                            <p class="mt-2 mb-0">Total Gastado</p>
                            <h3>$<?= number_format($totalGastado, 2) ?></h3>
                        </div>
                    </div>
                </div>

                <section class="resumen-turista mb-5">
                    <div class="resumen-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Mis Reservas</h5>
                    </div>

                    <div class="tabla-reservas">
                        <table class="table table-striped align-middle" id="tabla-reservas-turista">
                            <thead>
                                <tr>
                                    <th>Actividad</th>
                                    <th>Fecha</th>
                                    <th>Ubicación</th>
                                    <th>Personas</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($reservas)): ?>
                                    <?php foreach ($reservas as $r): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($r['nombre_actividad']) ?></td>
                                            <td><?= htmlspecialchars($r['fecha']) ?></td>
                                            <td><?= htmlspecialchars($r['ubicacion']) ?></td>
                                            <td><?= htmlspecialchars($r['cantidad_personas']) ?></td>
                                            <td>$<?= number_format($r['precio'], 2) ?></td>
                                            <td><span class="badge <?= $estadoBadgeClass($r['estado'] ?? '') ?>"><?= htmlspecialchars($r['estado']) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No tienes reservas aún.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>

    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.js"></script>

</body>

</html>