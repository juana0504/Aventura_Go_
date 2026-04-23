<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['reserva'] = [
        'id_actividad' => $_POST['id_actividad'],
        'cantidad' => $_POST['cantidad_personas'],
        'fecha' => $_POST['fecha']
    ];
}

if (
    !isset($_SESSION['reserva']['id_actividad']) ||
    !isset($_SESSION['reserva']['cantidad']) ||
    !isset($_SESSION['reserva']['fecha'])
) {
    echo "Error: datos de reserva incompletos.";
    exit;
}

$idActividad = $_SESSION['reserva']['id_actividad'];
$cantidad = $_SESSION['reserva']['cantidad'];
$fecha = $_SESSION['reserva']['fecha'];

$actividadModel = new ActividadTuristica();
$actividad = $actividadModel->obtenerPorId($idActividad);

if (!$actividad) {
    echo "Error: actividad no encontrada.";
    exit;
}

$precioUnitario = $actividad['precio'];
$total = $precioUnitario * $cantidad;

$_SESSION['reserva']['nombre'] = $actividad['nombre'];
$_SESSION['reserva']['imagen'] = $actividad['imagen_principal'];
$_SESSION['reserva']['precio'] = $precioUnitario;
$_SESSION['reserva']['total'] = $total;

// 🔴 OBTENER RESERVA
$reserva = $_SESSION['reserva'] ?? null;

// 🔴 VALIDAR
if (!$reserva) {
    echo "Error: no hay datos de reserva.";
    exit;
}

// reference único por intento
if (!isset($_SESSION['reference_code'])) {
    $_SESSION['reference_code'] = 'RES-' . time() . '-' . rand(100, 999);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - Confirma tu reserva</title>

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Checkout CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/checkout/checkout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/formulario_reserva/formulario_reserva.css">

</head>

<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png"
                        alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">Confirma tu reserva</h1>

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
                                <li><a href="<?= BASE_URL ?>turista/perfil">Mi perfil</a></li>
                                <li><a href="<?= BASE_URL ?>turista/dashboard">Centro de ayuda</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= BASE_URL ?>logout" class="logout">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>login" class="btn-login">Ingresa</a>
                        <a href="<?= BASE_URL ?>registrarse" class="btn-register">Regístrate</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="formulario_confirmacion">
            <div class="container my-5">
                <div class="row g-4">

                    <!-- ── RESUMEN DE RESERVA ── -->
                    <div class="col-md-7">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h1 class="mb-0">Resumen de tu reserva</h1>
                            </div>

                            <div class="card-body">
                                <div class="row g-3 align-items-start">
                                    <div class="col-md-4">
                                        <img src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= $reserva['imagen'] ?>"
                                            class="img-fluid rounded"
                                            alt="<?= htmlspecialchars($reserva['nombre']) ?>">
                                    </div>

                                    <div class="col-md-8">
                                        <h5>Actividad seleccionada</h5>
                                        <h6><?= htmlspecialchars($reserva['nombre']) ?></h6>
                                        <p>
                                            <i class="bi bi-calendar3" style="color:#EA8217"></i>
                                            <strong>Fecha:</strong> <?= $reserva['fecha'] ?>
                                        </p>
                                        <p>
                                            <i class="bi bi-people-fill" style="color:#EA8217"></i>
                                            <strong>Personas:</strong> <?= $reserva['cantidad'] ?>
                                        </p>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-1">
                                        <strong>Precio por persona</strong>
                                        $<?= number_format($reserva['precio'], 0, ',', '.') ?>
                                    </p>
                                    <p class="mb-1 text-end">
                                        <strong>Total a pagar</strong>
                                        <span class="fs-4 fw-bold text-success d-block">
                                            $<?= number_format($reserva['total'], 0, ',', '.') ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── CHECKOUT / PAGO ── -->
                    <div class="col-md-5">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Datos y método de pago</h5>
                            </div>

                            <div class="card-body">
                                <form action="<?= BASE_URL ?>pago" method="POST">

                                    <h6 class="fw-bold mb-3">Datos del turista</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Nombre completo</label>
                                        <input type="text" class="form-control" name="nombre"
                                            placeholder="Ej: Juan Pérez">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="correo@email.com">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" name="telefono"
                                            placeholder="3001234567">
                                    </div>

                                    <h6 class="fw-bold mb-3">Método de pago</h6>

                                    <div class="form-check border rounded p-3 mb-2" data-badge="PSE · Nequi">
                                        <input class="form-check-input" type="radio"
                                            name="metodo_pago" value="payu" id="payu" checked>
                                        <label class="form-check-label" for="payu">PayU</label>
                                        <small class="d-block text-muted">Tarjeta, PSE, Nequi, Daviplata</small>
                                    </div>

                                    <div class="form-check border rounded p-3 mb-4" data-badge="Wallet">
                                        <input class="form-check-input" type="radio"
                                            name="metodo_pago" value="mercadopago" id="mp">
                                        <label class="form-check-label" for="mp">MercadoPago</label>
                                        <small class="d-block text-muted">Tarjeta, PSE, Wallet MercadoPago</small>
                                    </div>

                                    <!-- OCULTOS -->
                                    <input type="hidden" name="reference" value="<?= $_SESSION['reference_code'] ?>">
                                    <input type="hidden" name="total" value="<?= $reserva['total'] ?>">
                                    <input type="hidden" name="currency" value="COP">
                                    <input type="hidden" name="descripcion" value="Reserva tour Aventura Go">

                                    <?php if (isset($_SESSION['user'])): ?>

                                        
                                        <button class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-lock-fill me-2"></i>
                                            Confirmar y pagar
                                        </button>
                                        

                                    <?php else: ?>

                                        <button type="button" class="btn btn-primary w-100 py-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                            Confirmar y pagar
                                        </button>

                                    <?php endif; ?>

                                    <!-- Badge de seguridad -->
                                    <div class="secure-badge">
                                        <i class="bi bi-shield-check-fill"></i>
                                        Pago 100% seguro y encriptado
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect_after_login'] = BASE_URL . 'checkout';
    }

    ?>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <p>Debes iniciar sesión o registrarte para confirmar tu reserva.</p>

                    <div class="form-section">
                        <img src="<?= BASE_URL ?>public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                        <h2 class="fw-bold">INICIO DE SESIÓN</h2>
                        <p>Por favor ingresa tu usuario y contraseña para iniciar sesión</p>

                        <form action="<?= BASE_URL ?>iniciar-sesion" method="POST">
                            <input type="email" name="email" class="form-control mb-3 rounded-pill" placeholder="Correo" required>

                            <div class="password-container position-relative mb-3">
                                <input type="password" name="contrasena" class="form-control rounded-pill" id="password" placeholder="Contraseña" required>
                                <i class="bi bi-eye-fill position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" id="togglePassword" style="cursor: pointer;"></i>
                            </div>

                            <p class="forgot-password">
                                <a href="<?= BASE_URL ?>recoverpw">¿Olvidaste tu contraseña?</a>
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
                        <img src="<?= BASE_URL ?>public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                        <h2 class="fw-bold">REGISTRATE</h2>
                        <h3>
                            Preparate para vivir tu proxima aventura.<br>
                            <span class="centered-line">Registrate y empieza el viaje.</span>
                        </h3>



                        <form action="<?= BASE_URL ?>administrador/guardar-turista" method="POST" enctype="multipart/form-data">

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

</html>