<?php
// La sesión y los datos del turista se preparan en el controlador
// Si por alguna razón se carga la vista directamente sin pasar
// por el controlador, hacemos una validación mínima:
if (!isset($datos_turista)) {
    // evitar errores y redirigir a dashboard vía controlador
    header('Location: /aventura_go/turista/dashboard');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Turista</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Estilos comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">

    <!-- CSS específico de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/turista/turista/turista.css">
</head>

<body>

    <section id="turista">

        <!-- Panel Lateral -->
        <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

        <div class="info">

            <!-- Barra de Búsqueda -->
            <?php require_once __DIR__ . '/../../../views/layouts/buscador_turista.php'; ?>

            <div class="container py-4">

                <!-- Saludo -->
                <?php
                // si por alguna razón el modelo no devolvió nombre, usamos la sesión
                $nombreUsuario = $datos_turista['nombre'] ?? '';
                if (empty($nombreUsuario) && isset($_SESSION['user']['nombre'])) {
                    $nombreUsuario = $_SESSION['user']['nombre'];
                }
                ?>
                <p class="h4">¡Bienvenido, <?= htmlspecialchars($nombreUsuario) ?>!</p>
                <p class="text-muted">Gestiona tus actividades de deportes extremos y experiencias</p>

                <!-- Nuevas Actividades -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold">📌 Próximas Actividades de Deportes Extremos</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($datos_turista['actividades'])): ?>
                                    <ul class="list-group">
                                        <?php foreach ($datos_turista['actividades'] as $actividad): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?= htmlspecialchars($actividad['actividad']) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars($actividad['fecha']) ?></small>
                                                </div>
                                                <!-- Mostrar cuántas veces se ha realizado la actividad -->
                                                <span class="badge"><?= htmlspecialchars($actividad['veces']) ?> veces realizada</span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-secondary">Aún no tienes actividades programadas.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas visuales -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold">📊 Estadísticas de Actividades</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="actividadesChart" class="w-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🧭 Lugares Visitados -->
                <div class="mb-4">
                    <h5 class="fw-bold">📍 Lugares Visitados durante tus Actividades</h5>

                    <div class="row">
                        <?php
                        // Solo mostramos 3 tarjetas de lugares visitados
                        $lugares = array_slice($datos_turista['lugares_visitados'], 0, 3);
                        foreach ($lugares as $lugar):
                        ?>
                            <div class="col-md-4">
                                <div class="flip-card">
                                    <div class="flip-card-inner">

                                        <!-- Frente -->
                                        <div class="flip-card-front">
                                            <img
                                                src="<?= BASE_URL ?>/public/assets/dashboard/turista/img/cañon_rosado.jpg"
                                                alt="<?= htmlspecialchars($lugar['lugar']) ?>">
                                        </div>

                                        <!-- Reverso -->
                                        <div class="flip-card-back">
                                            <h6><?= htmlspecialchars($lugar['lugar']) ?></h6>
                                            <p><?= htmlspecialchars($lugar['visitas']) ?> visitas</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div> <!-- Cierre de la clase "info" -->

    </section>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/turista/turista/turista.js"></script>

</body>

</html>
