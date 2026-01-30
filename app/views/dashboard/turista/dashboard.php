<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Datos ficticios para evitar errores
$datos_turista = [
    'nombre' => 'David',
    'actividades' => [
        ['actividad' => 'Paracaidismo', 'fecha' => '2026-02-10', 'estado' => 'Confirmada'],
        ['actividad' => 'Bungee Jumping', 'fecha' => '2026-02-14', 'estado' => 'Pendiente'],
        ['actividad' => 'Escalada en roca', 'fecha' => '2026-02-18', 'estado' => 'Cancelada'],
    ],
    'lugares_visitados' => [
        ['lugar' => 'Cañón del río Colorado', 'visitas' => 3],
        ['lugar' => 'Monte Everest', 'visitas' => 1],
        ['lugar' => 'Playa de Waikiki', 'visitas' => 2],
    ]
];
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

                <p class="h4">¡Bienvenido, <?= $datos_turista['nombre'] ?>!</p>
                <p class="text-muted">Gestiona tus actividades de deportes extremos y experiencias</p>

                <!-- 🗓 Próximas Actividades -->
                <div class="mb-4">
                    <h5 class="fw-bold">📌 Próximas Actividades de Deportes Extremos</h5>
                    <?php if (!empty($datos_turista['actividades'])): ?>
                        <div class="list-group">
                            <?php foreach ($datos_turista['actividades'] as $actividad): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= $actividad['actividad'] ?></strong><br>
                                        <small class="text-muted"><?= $actividad['fecha'] ?></small>
                                    </div>
                                    <span class="badge bg-<?=
                                        $actividad['estado'] === 'Confirmada' ? 'success' :
                                        ($actividad['estado'] === 'Pendiente' ? 'warning' : 'danger')
                                    ?>"><?= $actividad['estado'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-secondary">Aún no tienes actividades programadas.</p>
                    <?php endif; ?>
                </div>

                <!-- 🧭 Lugares Visitados -->
                <div class="mb-4">
                    <h5 class="fw-bold">📍 Lugares Visitados durante tus Actividades</h5>
                    <div class="row">
                        <?php foreach ($datos_turista['lugares_visitados'] as $lugar): ?>
                            <div class="col-md-4">
                                <div class="card text-center mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= $lugar['lugar'] ?></h6>
                                        <p class="card-text"><?= $lugar['visitas'] ?> visitas</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

        </div> <!-- Cierre de la clase "info" -->

    </section>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
