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

$servicios    = array_filter(array_map('trim', explode(',', $hospedaje['servicios'] ?? '')));
$tipos        = array_filter(array_map('trim', explode(',', $hospedaje['tipo'] ?? '')));
$fechasLlenas = $hospedajeModel->obtenerFechasLlenas($id);

$servicioIconos = [
    'WiFi' => '📶', 'Piscina' => '🏊', 'Desayuno' => '🍳', 'Parking' => '🅿️',
    'Gimnasio' => '🏋️', 'Spa' => '💆', 'Restaurante' => '🍽️', 'Aire acond.' => '❄️',
    'TV Cable' => '📺', 'Lavandería' => '👕', 'Bar' => '🍹', 'Jacuzzi' => '🛁',
    'Terraza' => '🌿', 'Mascotas' => '🐾', 'Transporte' => '🚐', 'Room Service' => '🛎️',
];
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
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/hospedaje_escogido/hospedaje_escogido.css">
    <style>
        .he-hero{position:relative;width:100%;height:320px;overflow:hidden;border-radius:0 0 20px 20px;background:#2D4059}
        .he-hero img{width:100%;height:100%;object-fit:cover}
        .he-hero__overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.55),transparent)}
        .he-hero__badge{position:absolute;top:20px;left:24px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:30px;padding:6px 14px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:6px}
        .he-hero__back{position:absolute;top:20px;right:24px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:8px;padding:8px 14px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .2s}
        .he-hero__back:hover{background:rgba(255,255,255,.3);color:#fff}

        .he-container{max-width:1100px;margin:0 auto;padding:32px 20px 60px}
        .he-grid{display:grid;grid-template-columns:1fr 360px;gap:32px;align-items:start}
        @media(max-width:860px){.he-grid{grid-template-columns:1fr}}

        .he-title{font-family:'Raleway',sans-serif;font-size:28px;font-weight:800;color:#2D4059;margin:0 0 6px}
        .he-location{color:#6b7280;font-size:14px;display:flex;align-items:center;gap:6px;margin-bottom:20px}
        .he-section-label{font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:#EA8217;font-weight:700;margin:24px 0 10px;font-family:'Lato',sans-serif}
        .he-desc{color:#374151;line-height:1.7;font-size:15px;font-family:'Lato',sans-serif}

        .he-services{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:8px}
        .he-service{display:flex;align-items:center;gap:8px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;font-size:13px;color:#374151;font-family:'Lato',sans-serif}

        .he-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;box-shadow:0 4px 20px rgba(0,0,0,.07);position:sticky;top:24px}
        .he-card__price{font-size:28px;font-weight:800;color:#2D4059;font-family:'Raleway',sans-serif}
        .he-card__price span{font-size:14px;font-weight:400;color:#6b7280}
        .he-card__capacity{display:flex;align-items:center;gap:6px;color:#6b7280;font-size:13px;margin:8px 0 20px;font-family:'Lato',sans-serif}
        .he-divider{border:none;border-top:1px solid #e5e7eb;margin:20px 0}
        .he-form-group{margin-bottom:16px}
        .he-form-group label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;font-family:'Lato',sans-serif}
        .he-form-group input{width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;color:#111;font-family:'Lato',sans-serif}
        .he-form-group input:focus{outline:none;border-color:#EA8217;box-shadow:0 0 0 3px rgba(234,130,23,.12)}
        .he-btn-reservar{display:block;width:100%;padding:14px;background:#2D4059;color:#fff;font-size:15px;font-weight:700;font-family:'Raleway',sans-serif;border:none;border-radius:10px;cursor:pointer;text-align:center;transition:background .2s;text-decoration:none}
        .he-btn-reservar:hover{background:#EA8217;color:#fff}
        .he-login-notice{margin-top:12px;padding:12px;background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;font-size:13px;color:#92400e;text-align:center;font-family:'Lato',sans-serif}
        .he-login-notice a{color:#EA8217;font-weight:600}

        .he-proveedor{display:flex;align-items:center;gap:12px;padding:16px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;margin-top:20px}
        .he-proveedor img{width:48px;height:48px;border-radius:8px;object-fit:contain;background:#fff;border:1px solid #e5e7eb}
        .he-proveedor__name{font-size:13px;font-weight:600;color:#2D4059;font-family:'Lato',sans-serif}
        .he-proveedor__label{font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:1px;font-family:'Lato',sans-serif}
    </style>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png" alt="AventuraGO" class="navbar-logo">
                </a>
            </div>
            <ul class="navbar-nav" id="navbarNav">
                <li><a class="nav-link" href="<?= BASE_URL ?>">Inicio</a></li>
                <li><a class="nav-link" href="<?= BASE_URL ?>descubre-tours">Tours</a></li>
                <li><a class="nav-link" href="<?= BASE_URL ?>descubre-hospedaje" style="color:#EA8217;font-weight:700;">Hospedaje</a></li>
                <li><a class="nav-link" href="<?= BASE_URL ?>contactanos">Contáctanos</a></li>
            </ul>
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
                    <a href="<?= BASE_URL ?>login" class="btn-register">Regístrate</a>
                <?php endif; ?>
                <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
            </div>
        </div>
    </nav>
</header>

<!-- HERO -->
<div class="he-hero">
    <img src="<?= BASE_URL ?>public/uploads/hoteles/<?= htmlspecialchars($hospedaje['logo_proveedor'] ?? 'default.png') ?>"
         alt="<?= htmlspecialchars($hospedaje['nombre']) ?>"
         onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png'">
    <div class="he-hero__overlay"></div>
    <?php if (!empty($tipos)): ?>
        <div class="he-hero__badge"><i class="bi bi-building"></i> <?= htmlspecialchars(implode(' · ', $tipos)) ?></div>
    <?php endif; ?>
    <a href="<?= BASE_URL ?>descubre-hospedaje" class="he-hero__back"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="he-container">
    <div class="he-grid">

        <!-- DETALLES -->
        <div>
            <?php if (!empty($hospedaje['nombre_establecimiento'])): ?>
                <div style="font-size:12px;font-weight:700;color:#EA8217;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">
                    <i class="bi bi-building"></i> <?= htmlspecialchars($hospedaje['nombre_establecimiento']) ?>
                </div>
            <?php endif; ?>
            <h1 class="he-title"><?= htmlspecialchars($hospedaje['nombre']) ?></h1>
            <div class="he-location">
                <i class="bi bi-geo-alt-fill" style="color:#EA8217"></i>
                <?= htmlspecialchars($hospedaje['ciudad']) ?>, <?= htmlspecialchars($hospedaje['departamento']) ?>
                <?php if (!empty($hospedaje['ubicacion'])): ?>
                    &nbsp;·&nbsp; <?= htmlspecialchars($hospedaje['ubicacion']) ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($hospedaje['descripcion'])): ?>
                <div class="he-section-label"><i class="bi bi-card-text"></i> Descripción</div>
                <p class="he-desc"><?= nl2br(htmlspecialchars($hospedaje['descripcion'])) ?></p>
            <?php endif; ?>

            <?php if (!empty($servicios)): ?>
                <div class="he-section-label"><i class="bi bi-check2-circle"></i> Servicios incluidos</div>
                <div class="he-services">
                    <?php foreach ($servicios as $s): ?>
                        <div class="he-service">
                            <span><?= $servicioIconos[$s] ?? '✅' ?></span>
                            <?= htmlspecialchars($s) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($hospedaje['nombre_establecimiento'])): ?>
                <div class="he-proveedor">
                    <img src="<?= BASE_URL ?>public/uploads/hoteles/<?= htmlspecialchars($hospedaje['logo_proveedor'] ?? '') ?>"
                         alt="logo"
                         onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png'">
                    <div>
                        <div class="he-proveedor__label">Proveedor verificado</div>
                        <div class="he-proveedor__name"><?= htmlspecialchars($hospedaje['nombre_establecimiento']) ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Mapa (estático Villeta) -->
            <div class="he-section-label" style="margin-top:28px"><i class="bi bi-map"></i> Ubicación</div>
            <div style="border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                    width="100%" height="240" style="border:0" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>

        <!-- CARD RESERVA -->
        <div>
            <div class="he-card">
                <div class="he-card__price">
                    $<?= number_format($hospedaje['precio'], 0, ',', '.') ?>
                    <span>/ noche</span>
                </div>
                <div class="he-card__capacity">
                    <i class="bi bi-people-fill"></i>
                    Capacidad: <?= (int)$hospedaje['capacidad'] ?> personas máx.
                </div>
                <hr class="he-divider">

                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['rol'] ?? '') === 'turista'): ?>
                    <form action="<?= BASE_URL ?>guardar-reserva-hospedaje" method="POST" id="formReservaHosp">
                        <input type="hidden" name="id_hospedaje" value="<?= $hospedaje['id_hospedaje'] ?>">
                        <div class="he-form-group">
                            <label><i class="bi bi-calendar3"></i> Fecha de llegada</label>
                            <input type="date" name="fecha" id="fechaReserva"
                                   min="<?= date('Y-m-d') ?>" required>
                            <div id="fechaAviso" style="display:none;margin-top:6px;padding:8px 10px;background:#fef2f2;border:1px solid #fca5a5;border-radius:6px;font-size:12px;color:#b91c1c;">
                                <i class="bi bi-exclamation-circle"></i> Esta fecha está <strong>agotada</strong>. Elige otra.
                            </div>
                        </div>
                        <div class="he-form-group">
                            <label><i class="bi bi-people"></i> Cantidad de personas</label>
                            <input type="number" name="cantidad_personas" min="1"
                                   max="<?= (int)$hospedaje['capacidad'] ?>" value="1" required>
                        </div>
                        <button type="submit" class="he-btn-reservar" id="btnReservar">
                            <i class="bi bi-calendar-check"></i> Reservar ahora
                        </button>
                    </form>
                    <script>
                    (function(){
                        const fechasLlenas = <?= json_encode($fechasLlenas) ?>;
                        const inputFecha   = document.getElementById('fechaReserva');
                        const aviso        = document.getElementById('fechaAviso');
                        const btnReservar  = document.getElementById('btnReservar');

                        inputFecha.addEventListener('change', function(){
                            if (fechasLlenas.includes(this.value)) {
                                aviso.style.display = 'block';
                                btnReservar.disabled = true;
                                btnReservar.style.opacity = '.5';
                            } else {
                                aviso.style.display = 'none';
                                btnReservar.disabled = false;
                                btnReservar.style.opacity = '1';
                            }
                        });
                    })();
                    </script>
                <?php else: ?>
                    <div class="he-login-notice">
                        <i class="bi bi-lock-fill"></i>
                        Para reservar necesitas <a href="<?= BASE_URL ?>login">iniciar sesión</a> como turista.
                    </div>
                    <a href="<?= BASE_URL ?>login" class="he-btn-reservar" style="margin-top:16px">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

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
                <div class="logo-section">
                    <img src="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png" alt="logo">
                </div>
            </div>
            <div class="col-md-2">
                <p class="description">Aventura Go conecta viajeros con experiencias de aventura, promoviendo el turismo sostenible y apoyando a prestadores locales.</p>
            </div>
            <div class="col-md-2">
                <h5 class="dest-section">Destinos</h5>
                <ul class="list-unstyled"><li>Villeta</li><li>Utica</li><li>La Vega</li><li>San Francisco</li><li>Tobia</li></ul>
            </div>
            <div class="col-md-2">
                <h5 class="enlaces-section">Enlaces útiles</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>acerca-de-nosotros">About Us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5 class="contacto-section">Contactos</h5>
                <ul class="list-unstyled contact-list">
                    <li><i class="fas fa-phone"></i><span>321 2263435</span></li>
                    <li><i class="fas fa-envelope"></i><span>aventurago2025@gmail.com</span></li>
                    <li><i class="fas fa-map-marker-alt"></i><span>Villeta, Cundinamarca</span></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5 class="redes-section">Síguenos</h5>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const profileToggle = document.getElementById('profileToggle');
const profileMenu   = document.getElementById('profileMenu');
if (profileToggle && profileMenu) {
    profileToggle.addEventListener('click', e => { e.stopPropagation(); profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block'; });
    document.addEventListener('click', () => { profileMenu.style.display = 'none'; });
}
</script>
</body>
</html>
