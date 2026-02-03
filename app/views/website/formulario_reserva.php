<?php

require_once BASE_PATH . '/app/models/turista/ActividadModel.php';

if (
    !isset($_POST['id_actividad']) ||
    !isset($_POST['cantidad_personas']) ||
    !isset($_POST['fecha'])
) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

$idActividad = (int) $_POST['id_actividad'];
$cantidad    = (int) $_POST['cantidad_personas'];
$fecha       = $_POST['fecha'];

$actividadModel = new ActividadModel();
$actividad = $actividadModel->obtenerPorId($idActividad);

if (!$actividad || $actividad['estado'] !== 'ACTIVO') {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

$precioUnitario = (float) $actividad['precio'];
$total = $precioUnitario * $cantidad;

/*
 | Guardamos la reserva temporal
 | (se usará en checkout)
*/
$_SESSION['reserva_tmp'] = [
    'id_actividad' => $idActividad,
    'nombre'       => $actividad['nombre'],
    'imagen'       => $actividad['imagen'],
    'cantidad'     => $cantidad,
    'fecha'        => $fecha,
    'precio'       => $precioUnitario,
    'total'        => $total
];

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - formulario de reserva</title>

    <link rel="icon" type="image/png" href="/public/assets/website_externos/descubre_tours/img/FAVICON.png">

    <!-- bootstrap primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/formulario_reserva/formulario_reserva.css">

</head>


<body>
    <!-- header________________________________________________________________________________________________________________________________ -->
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">Confirma Tu reserva</h1>

                <div class="actions">

                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="profile-dropdown">
                            <button class="profile-btn" id="profileToggle">
                                <i class="fas fa-user-circle"></i>
                                <span class="profile-name">
                                    <?= htmlspecialchars(
                                        ucwords(
                                            explode(' ', $_SESSION['user']['nombre'])[0] . ' ' .
                                                (explode(' ', $_SESSION['user']['nombre'])[1] ?? '')
                                        )
                                    ) ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <ul class="profile-menu" id="profileMenu">
                                <li>
                                    <a href="/aventura_go/turista/perfil">Mi perfil</a>
                                </li>
                                <li>
                                    <a href="/aventura_go/turista/dashboard">Centro de ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="/aventura_go/logout" class="logout">Cerrar sesión</a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>

                        <a href="/aventura_go/login" class="btn-login">
                            Ingresa
                        </a>

                        <a href="/aventura_go/registrarse" class="btn-register">
                            Regístrate
                        </a>

                    <?php endif; ?>

                    <div class="menu-toggle" id="menu-toggle" aria-label="Abrir menú">
                        <i class="fas fa-bars"></i>
                    </div>

                </div>
            </div>
        </nav>
    </header>




    <section id="formulario_confirmacion">

        <div class="container mt-5">
            <h2 class="mb-4">Confirmar Reserva</h2>

            <div class="row">
                <!-- IZQUIERDA -->
                <div class="col-md-8">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Actividad</th>
                                <th>Precio</th>
                                <th>Personas</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= htmlspecialchars($actividad['imagen']) ?>" width="60" class="me-2">

                                    <strong><?= htmlspecialchars($actividad['nombre']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($fecha) ?></small>
                                </td>
                                <td>$<?= number_format($precioUnitario, 0, ',', '.') ?></td>
                                <td><?= $cantidad ?></td>
                                <td>$<?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- DERECHA -->
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5>Total a pagar</h5>
                        <h3 class="mb-3">$<?= number_format($total, 0, ',', '.') ?></h3>

                        <form action="<?= BASE_URL ?>/checkout" method="POST">
                            <button class="btn btn-danger w-100">
                                Confirmar Reserva
                            </button>
                        </form>

                        <a href="<?= BASE_URL ?>/descubre-tours" class="btn btn-link mt-2">
                            ← Seguir explorando
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Abootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- aos animate -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        if (profileToggle && profileMenu) {
            profileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.style.display =
                    profileMenu.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function() {
                profileMenu.style.display = 'none';
            });
        }
    </script>







</body>