<?php
// session_start();
require_once __DIR__ . '/../../controllers/website/websiteController.php';

$actividadModel = new ActividadTuristica();
$actividad = $actividadModel->obtenerPorId($idActividad);
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - formulario de reserva</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/descubre_tours/img/FAVICON.png">


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
                <!-- Logo -->
                <div class="logo">
                    <img src="public/assets/website_externos/index/img/LOGO-FINAL.png" alt="Logo Aventura Go"
                        class="navbar-logo">
                </div>

                <!-- Botones y menú móvil -->
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
                                    <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= htmlspecialchars($actividad['imagen_principal']) ?>" width="60" class="me-2">

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

                        <?php if (isset($_SESSION['user'])): ?>

                            <form action="<?= BASE_URL ?>/checkout" method="POST">
                                <button class="btn btn-danger w-100">
                                    Confirmar Reserva
                                </button>
                            </form>

                        <?php else: ?>

                            <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Confirmar Reserva
                            </button>

                        <?php endif; ?>


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


    <?php
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect_after_login'] = BASE_URL . '/formulario-reserva?id=' . $idActividad;
    }

    ?>


    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <p>Debes iniciar sesión o registrarte para confirmar tu reserva.</p>

                    <div class="form-section">
                        <img src="public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                        <h2 class="fw-bold">INICIO DE SESIÓN</h2>
                        <p>Por favor ingresa tu usuario y contraseña para iniciar sesión</p>

                        <form action="iniciar-sesion" method="POST">
                            <input type="email" name="email" class="form-control mb-3 rounded-pill" placeholder="Correo" required>

                            <div class="password-container position-relative mb-3">
                                <input type="password" name="contrasena" class="form-control rounded-pill" id="password" placeholder="Contraseña" required>
                                <i class="bi bi-eye-fill position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" id="togglePassword" style="cursor: pointer;"></i>
                            </div>

                            <p class="forgot-password">
                                <a href="recoverpw">¿Olvidaste tu contraseña?</a>
                            </p>

                            <button type="submit" class="btn w-100 rounded-pill fw-bold text-white"
                                style="background-color: #EA8217;">INGRESAR</button>
                        </form>

                        <div class="extra-links mt-4">
                            <p>
                                ¿Aún no tienes cuenta?
                                <a href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#registroModal"
                                    data-bs-dismiss="modal">
                                    Regístrate
                                </a>
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Registro -->
    <div class="modal fade" id="registroModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <p>Debes iniciar sesión o registrarte para confirmar tu reserva.</p>

                    <div class="form-section">
                        <img src="public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                        <h2 class="fw-bold">REGISTRATE</h2>
                        <h3>
                            Preparate para vivir tu proxima aventura.<br>
                            <span class="centered-line">Registrate y empieza el viaje.</span>
                        </h3>



                        <form action="<?= BASE_URL ?>/administrador/guardar-turista" method="POST" enctype="multipart/form-data">

                            <input type="text" placeholder="Nombre" name="nombre">
                            <div class="select-container">
                                <select name="genero">
                                    <option value="" disabled selected hidden>Genero</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Masculino">Masculino</option>
                                </select>
                            </div>

                            <input type="tel" placeholder="Teléfono" name="telefono">
                            <input type="email" name="email" placeholder="Correo" required>
                            <div class="password-container">
                                <input type="password" name="clave" placeholder="Contraseña" id="password" required>
                                <i class="bi bi-eye-fill" id="togglePassword"></i>
                            </div>
                            <div class="file-container">
                                <input type="file" id="foto" name="foto" accept=".jpg, .png, .jpeg" required>
                                <span class="file-placeholder">Foto</span>
                            </div>



                            <button type="submit">INICIO</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>





</body>