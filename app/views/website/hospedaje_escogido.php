<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

$hospedajeModel = new Hospedaje();
$hospedaje      = $hospedajeModel->obtenerPublico($id);

if (!$hospedaje) {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}

$servicios = array_filter(array_map('trim', explode(',', $hospedaje['servicios'] ?? '')));
$tipos     = array_filter(array_map('trim', explode(',', $hospedaje['tipo'] ?? '')));
$servicios = array_filter(array_map('trim', explode(',', $hospedaje['servicios'] ?? '')));
$tipos     = array_filter(array_map('trim', explode(',', $hospedaje['tipo'] ?? '')));
try {
    $fechasLlenas = $hospedajeModel->obtenerFechasLlenas($id);
} catch (Exception $e) {
    $fechasLlenas = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hospedaje['nombre']) ?> — AventuraGO</title>

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/tour_escogido/tour_escogido.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/tour_escogido/tour_escogido.css">
</head>

<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <a href="<?= BASE_URL ?>">
                        <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png" alt="AventuraGO" class="navbar-logo">
                    </a>
                </div>
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
                                <li><a href="<?= BASE_URL ?>turista/dashboard">Dashboard</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= BASE_URL ?>logout" class="logout">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>login" class="btn-login">Ingresa</a>
                        <a href="#" class="btn-register" data-bs-toggle="modal" data-bs-target="#registroModal">Regístrate</a>
                    <?php endif; ?>
                    <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="info">
            <div class="container">
                <div class="row">

                    <!-- COLUMNA IZQUIERDA: imagen + detalles -->
                    <div class="col-md-8">

                        <!-- Imagen principal -->
                        <section id="galeria-hotel">
                            <div class="cont-img-principal" style="height:420px;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.12)">
                                <?php
                                $imgPrincipal = $hospedaje['imagen'] ?? '';
                                if (!empty($imgPrincipal) && $imgPrincipal !== 'hospedaje_default.png') {
                                    $imgSrc = BASE_URL . 'public/uploads/hotelero/actividades/' . rawurlencode($imgPrincipal);
                                } elseif (!empty($hospedaje['logo_proveedor'])) {
                                    $imgSrc = BASE_URL . 'public/uploads/hoteles/' . rawurlencode($hospedaje['logo_proveedor']);
                                } else {
                                    $imgSrc = BASE_URL . 'public/assets/website_externos/index/img/LOGO-FINAL.png';
                                }
                                ?>
                                <img src="<?= $imgSrc ?>"
                                    alt="<?= htmlspecialchars($hospedaje['nombre']) ?>"
                                    style="width:100%;height:100%;object-fit:cover"
                                    onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png'">
                            </div>
                        </section>

                        <!-- Tarjeta de detalles -->
                        <div class="tarjeta" style="margin-top:20px">
                            <div class="col-md-12 detalle">

                                <?php if (!empty($hospedaje['nombre_establecimiento'])): ?>
                                    <div style="font-size:12px;font-weight:700;color:#EA8217;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">
                                        <i class="bi bi-building"></i> <?= htmlspecialchars($hospedaje['nombre_establecimiento']) ?>
                                    </div>
                                <?php endif; ?>

                                <h2><?= htmlspecialchars($hospedaje['nombre']) ?></h2>

                                <p id="direccion">
                                    <i class="bi bi-geo-alt"></i>
                                    <?= htmlspecialchars($hospedaje['ciudad'] ?? '') ?>, <?= htmlspecialchars($hospedaje['departamento'] ?? '') ?>
                                    <?php if (!empty($hospedaje['ubicacion'])): ?>
                                        &nbsp;·&nbsp; <?= htmlspecialchars($hospedaje['ubicacion']) ?>
                                    <?php endif; ?>
                                </p>

                                <?php if (!empty($hospedaje['descripcion'])): ?>
                                    <p><?= nl2br(htmlspecialchars($hospedaje['descripcion'])) ?></p>
                                <?php endif; ?>

                                <p style="font-size:20px;font-weight:700;color:#EA8217;margin-top:10px">
                                    $<?= number_format($hospedaje['precio'], 0, ',', '.') ?> <small style="font-size:13px;font-weight:400;color:#6b7280">/ noche</small>
                                </p>

                                <?php if (!empty($servicios)): ?>
                                    <div style="margin-top:14px">
                                        <p style="font-size:11px;font-weight:700;color:#2D4059;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">
                                            <i class="bi bi-check2-circle" style="color:#EA8217"></i> Servicios incluidos
                                        </p>
                                        <div style="display:flex;flex-wrap:wrap;gap:5px">
                                            <?php
                                            $iconos = [
                                                'WiFi'         => '📶',
                                                'Piscina'      => '🏊',
                                                'Desayuno'     => '🍳',
                                                'Parking'      => '🅿️',
                                                'Gimnasio'     => '🏋️',
                                                'Spa'          => '💆',
                                                'Restaurante'  => '🍽️',
                                                'Aire acond.'  => '❄️',
                                                'TV Cable'     => '📺',
                                                'Lavandería'   => '👕',
                                                'Bar'          => '🍹',
                                                'Jacuzzi'      => '🛁',
                                                'Terraza'      => '🌿',
                                                'Mascotas'     => '🐾',
                                                'Transporte'   => '🚐',
                                                'Room Service' => '🛎️',
                                            ];
                                            foreach ($servicios as $s): ?>
                                                <span title="<?= htmlspecialchars($s) ?>"
                                                    style="position:static;background:#ffffff;border:1px solid #EA8217;border-radius:20px;
                                                         padding:4px 11px;font-size:12px;color:#2D4059;
                                                         display:inline-flex;align-items:center;gap:5px;white-space:nowrap">
                                                    <span style="position:static;background:transparent;padding:0;font-size:14px;line-height:1;color:inherit"><?= $iconos[$s] ?? '✔' ?></span>
                                                    <span style="position:static;background:transparent;padding:0;font-size:11px;font-weight:600;color:#2D4059"><?= htmlspecialchars($s) ?></span>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Mapa -->
                            <div class="dato" style="margin-top:20px">
                                <section id="mapa" class="mapa-section">
                                    <div class="mapa-contenedor">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                                            allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA: formulario -->
                    <div class="col-md-4">
                        <form class="form-reserva" action="<?= BASE_URL ?>hotel-checkout" method="POST">
                            <h1>Reserva tu hospedaje</h1>
                            <p>Completa el formulario para reservar tu acomodación.</p>

                            <input type="hidden" name="id_hospedaje" value="<?= $hospedaje['id_hospedaje'] ?>">

                            <div class="form-group">
                                <label>Cantidad de personas</label>
                                <input type="number" name="cantidad_personas" class="form-control"
                                    min="1" max="<?= (int)$hospedaje['capacidad'] ?>" value="1" required>
                            </div>

                            <div class="form-group">
                                <label>Fecha de llegada</label>
                                <input type="date" name="fecha" id="fechaReserva"
                                    class="form-control" min="<?= date('Y-m-d') ?>" required>
                                <div id="fechaAviso" style="display:none;margin-top:8px;padding:10px 12px;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;font-size:13px;color:#b91c1c;line-height:1.4">
                                    <i class="bi bi-calendar-x"></i> <strong>Fecha no disponible.</strong><br>
                                    <span style="font-size:12px">Este hospedaje ya está reservado para esa fecha. Por favor elige otra fecha.</span>
                                </div>
                            </div>

                            <button type="submit" id="btnReservar">Reservar</button>
                        </form>
                        <script>
                        (function() {
                            const fechasLlenas = <?= json_encode($fechasLlenas) ?>;
                            const input  = document.getElementById('fechaReserva');
                            const aviso  = document.getElementById('fechaAviso');
                            const btn    = document.getElementById('btnReservar');
                            const form   = btn ? btn.closest('form') : null;

                            function verificarFecha() {
                                const llena = fechasLlenas.includes(input.value);
                                aviso.style.display = llena ? 'block' : 'none';
                                btn.disabled        = llena;
                                btn.style.opacity   = llena ? '0.45' : '1';
                                btn.style.cursor    = llena ? 'not-allowed' : 'pointer';
                            }

                            if (input) {
                                input.addEventListener('change', verificarFecha);
                            }

                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    if (fechasLlenas.includes(input.value)) {
                                        e.preventDefault();
                                        aviso.style.display = 'block';
                                        input.focus();
                                    }
                                });
                            }
                        })();
                        </script>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer id="footer">
        <div class="footer-top">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2 class="palpitando">¿Quieres que tu negocio aparezca aquí?</h2>
                    <a href="<?= BASE_URL ?>contactanos">Publícate en Aventura Go</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-2">
                    <div class="logo-section"><img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png" alt="logo"></div>
                </div>
                <div class="col-md-2">
                    <p class="description">Aventura Go conecta viajeros con experiencias de aventura, promoviendo el turismo sostenible.</p>
                </div>
                <div class="col-md-2">
                    <h5 class="dest-section">Destinos</h5>
                    <ul class="list-unstyled">
                        <li>Villeta</li>
                        <li>Utica</li>
                        <li>La Vega</li>
                        <li>Tobia</li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5 class="enlaces-section">Enlaces útiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>acerca-de-nosotros">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5 class="contacto-section">Contactos</h5>
                    <ul class="list-unstyled contact-list">
                        <li><i class="fas fa-phone"></i><span>321 2263435</span></li>
                        <li><i class="fas fa-envelope"></i><span>aventurago2025@gmail.com</span></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5 class="redes-section">Síguenos</h5>
                    <div class="social-links"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div>
                </div>
            </div>
        </div>
    </footer>

    <!-- MODAL REGISTRO -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Cómo quieres registrarte?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container py-3">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <div class="card-body">
                                        <h3 class="card-title">Turista</h3>
                                        <p class="card-text">Quiero reservar actividades y experiencias.</p>
                                        <a href="<?= BASE_URL ?>registrarse?tipo=turista" class="btn btn-aventura">Elegir</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor turístico</h3>
                                        <p class="card-text">Quiero publicar actividades de aventura.</p>
                                        <a href="<?= BASE_URL ?>registrar-proveedor" class="btn btn-aventura">Elegir</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor hotelero</h3>
                                        <p class="card-text">Quiero publicar hospedajes.</p>
                                        <a href="<?= BASE_URL ?>registrar-proveedor-hotelero" class="btn btn-aventura">Elegir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            profileToggle.addEventListener('click', e => {
                e.stopPropagation();
                profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', () => {
                profileMenu.style.display = 'none';
            });
        }
    </script>
</body>

</html>