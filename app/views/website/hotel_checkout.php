<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';

// POST desde hospedaje_escogido → guardar en sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_hospedaje      = (int)($_POST['id_hospedaje'] ?? 0);
    $cantidad_personas = (int)($_POST['cantidad_personas'] ?? 1);
    $fecha             = trim($_POST['fecha'] ?? '');

    if (!$id_hospedaje || !$fecha || $cantidad_personas < 1) {
        header('Location: ' . BASE_URL . 'descubre-hospedaje');
        exit;
    }

    $hospedajeModel = new Hospedaje();
    $hospedaje      = $hospedajeModel->obtenerPublico($id_hospedaje);

    if (!$hospedaje) {
        header('Location: ' . BASE_URL . 'descubre-hospedaje');
        exit;
    }

    $precioNoche = (float)$hospedaje['precio'];
    $total       = $precioNoche * $cantidad_personas;

    $_SESSION['hotel_reserva'] = [
        'id_hospedaje'           => $id_hospedaje,
        'nombre_hospedaje'       => $hospedaje['nombre'],
        'nombre_establecimiento' => $hospedaje['nombre_establecimiento'] ?? '',
        'imagen'                 => $hospedaje['imagen'] ?? '',
        'logo_proveedor'         => $hospedaje['logo_proveedor'] ?? '',
        'fecha'                  => $fecha,
        'cantidad_personas'      => $cantidad_personas,
        'precio_noche'           => $precioNoche,
        'total'                  => $total,
    ];
}

// GET (después del login) o POST ya procesado — leer de sesión
$reserva = $_SESSION['hotel_reserva'] ?? null;
if (!$reserva) {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

// Referencia única por sesión
if (!isset($_SESSION['hotel_reference'])) {
    $_SESSION['hotel_reference'] = 'HOT-' . time() . '-' . rand(100, 999);
}

// Para redirigir de vuelta aquí tras el login
if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_after_login'] = BASE_URL . 'hotel-checkout';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go — Confirma tu hospedaje</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/FAVICON.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/checkout/checkout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/formulario_reserva/formulario_reserva.css">
</head>
<body>

<!-- HEADER -->
<header>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="logo">
                <img src="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png" alt="AventuraGO" class="navbar-logo">
            </div>
            <h1 class="page-title">Confirma tu hospedaje</h1>
            <div class="actions">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="profile-dropdown">
                        <button class="profile-btn" id="profileToggle">
                            <i class="fas fa-user-circle"></i>
                            <span class="profile-name"><?= htmlspecialchars(explode(' ', $_SESSION['user']['nombre'])[0]) ?></span>
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

                <!-- RESUMEN DE RESERVA -->
                <div class="col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h1 class="mb-0">Resumen de tu reserva</h1>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-start">
                                <div class="col-md-4">
                                    <?php
                                    $img = $reserva['imagen'] ?? '';
                                    if (!empty($img) && $img !== 'hospedaje_default.png') {
                                        $imgSrc = BASE_URL . 'public/uploads/hotelero/actividades/' . rawurlencode($img);
                                    } elseif (!empty($reserva['logo_proveedor'])) {
                                        $imgSrc = BASE_URL . 'public/uploads/hoteles/' . rawurlencode($reserva['logo_proveedor']);
                                    } else {
                                        $imgSrc = BASE_URL . 'public/assets/website_externos/index/img/LOGO-FINAL.png';
                                    }
                                    ?>
                                    <img src="<?= $imgSrc ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($reserva['nombre_hospedaje']) ?>"
                                         onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png'">
                                </div>
                                <div class="col-md-8">
                                    <?php if (!empty($reserva['nombre_establecimiento'])): ?>
                                        <small style="color:#EA8217;font-weight:700;text-transform:uppercase;letter-spacing:.8px">
                                            <i class="bi bi-building"></i> <?= htmlspecialchars($reserva['nombre_establecimiento']) ?>
                                        </small>
                                    <?php endif; ?>
                                    <h5><?= htmlspecialchars($reserva['nombre_hospedaje']) ?></h5>
                                    <p><i class="bi bi-calendar3" style="color:#EA8217"></i> <strong>Fecha:</strong> <?= htmlspecialchars($reserva['fecha']) ?></p>
                                    <p><i class="bi bi-people-fill" style="color:#EA8217"></i> <strong>Personas:</strong> <?= (int)$reserva['cantidad_personas'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-1"><strong>Precio por noche</strong><br>$<?= number_format($reserva['precio_noche'], 0, ',', '.') ?></p>
                                <p class="mb-1 text-end"><strong>Total estimado</strong><br>
                                    <span class="fs-4 fw-bold text-success">$<?= number_format($reserva['total'], 0, ',', '.') ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DATOS Y CONFIRMACIÓN -->
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Datos del turista</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL ?>confirmar-hotel" method="POST">
                                <input type="hidden" name="reference" value="<?= $_SESSION['hotel_reference'] ?>">

                                <div class="mb-3">
                                    <label class="form-label">Nombre completo</label>
                                    <input type="text" class="form-control" name="nombre"
                                           value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['nombre']) : '' ?>"
                                           placeholder="Ej: Juan Pérez" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" name="email"
                                           value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['email'] ?? '') : '' ?>"
                                           placeholder="correo@email.com" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="telefono"
                                           value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['telefono'] ?? '') : '' ?>"
                                           placeholder="3001234567" required>
                                </div>

                                <?php if (isset($_SESSION['user'])): ?>
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Confirmar reserva
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary w-100 py-2"
                                            data-bs-toggle="modal" data-bs-target="#loginModal">
                                        Confirmar reserva
                                    </button>
                                <?php endif; ?>

                                <div class="secure-badge" style="margin-top:12px;text-align:center;font-size:12px;color:#6b7280">
                                    <i class="bi bi-shield-check-fill" style="color:#0a8a4f"></i>
                                    Reserva 100% segura
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<!-- MODAL LOGIN (igual que checkout.php) -->
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
                            <i class="bi bi-eye-fill position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" id="togglePassword" style="cursor:pointer"></i>
                        </div>
                        <p class="forgot-password"><a href="<?= BASE_URL ?>recoverpw">¿Olvidaste tu contraseña?</a></p>
                        <button type="submit" class="btn w-100 rounded-pill fw-bold text-white" style="background-color:#EA8217">INGRESAR</button>
                    </form>
                    <div class="extra-links mt-4">
                        <p>¿Aún no tienes cuenta?
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registroModal" data-bs-dismiss="modal">Regístrate</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REGISTRO -->
<div class="modal fade" id="registroModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p>Debes iniciar sesión o registrarte para confirmar tu reserva.</p>
                <div class="form-section">
                    <img src="<?= BASE_URL ?>public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">
                    <h2 class="fw-bold">REGÍSTRATE</h2>
                    <p>Prepárate para vivir tu próxima aventura.</p>
                    <form action="<?= BASE_URL ?>administrador/guardar-turista" method="POST" enctype="multipart/form-data">
                        <input type="text" placeholder="Nombre" name="nombre">
                        <input type="tel" placeholder="Teléfono" name="telefono">
                        <input type="email" name="email" placeholder="Correo" required>
                        <div class="password-container">
                            <input type="password" name="clave" placeholder="Contraseña" required>
                        </div>
                        <button type="submit">REGISTRARME</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const profileToggle = document.getElementById('profileToggle');
const profileMenu   = document.getElementById('profileMenu');
if (profileToggle && profileMenu) {
    profileToggle.addEventListener('click', e => { e.stopPropagation(); profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block'; });
    document.addEventListener('click', () => { profileMenu.style.display = 'none'; });
}
const togglePw = document.getElementById('togglePassword');
const pwInput  = document.getElementById('password');
if (togglePw && pwInput) {
    togglePw.addEventListener('click', () => {
        pwInput.type = pwInput.type === 'password' ? 'text' : 'password';
    });
}
</script>
</body>
</html>
