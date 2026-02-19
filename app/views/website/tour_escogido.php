<?php
session_start();

require_once BASE_PATH . '/app/models/proveedor_turistico/ActividadTuristica.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ' . BASE_URL . '/formulario-reserva');
    exit;
}

$actividadModel = new ActividadTuristica();
$actividad = $actividadModel->obtenerDetalleActividad($id);

if (!$actividad) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - tour-escogido</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/index/img/FAVICON.png">

    <!-- bootstrap para el carrusel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (para las estrellas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Tema opcional slick carrousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/tour_escogido/tour_escogido.css">
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

                        <a href="#" class="btn-register" data-bs-toggle="modal" data-bs-target="#registroModal">
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


    <main>

        <section id="info">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <?php if (!empty($actividad)): ?>
                            <div class="targeta">
                                <div class="col-md-6 detalle">
                                    <h2><?= htmlspecialchars($actividad['nombre']) ?></h2>

                                    <p id="direccion"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($actividad['ubicacion']) ?>, <?= htmlspecialchars($actividad['ciudad']) ?>,
                                        <?= htmlspecialchars($actividad['departamento']) ?>,
                                        253610 Villeta, Colombia <br></p>
                                    <p>Después de reservar, encontrarás todos los datos del alojamiento con el número de
                                        teléfono y la
                                        <br>
                                        dirección en tu confirmación de la reserva y en tu cuenta.
                                    </p>
                                </div>
                                <div class="col-md-6 datos">
                                    <!-- <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <samp>(120 Review)</samp>

                                    <p><i class="bi bi-clock"></i>1 Noche, 2 Dias</p> -->
                                    <p>$<?= htmlspecialchars($actividad['precio']) ?></p>
                                </div>
                            </div>

                            <section id="galeria-hotel">
                                <div class="cont-img-principal">
                                    <button class="btn prev">❮</button>

                                    <div class="carousel-track">
                                        <?php foreach ($actividad['imagenes'] as $img): ?>
                                            <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= $img ?>">
                                        <?php endforeach; ?>
                                    </div>


                                    <button class="btn next">❯</button>
                                </div>
                                <div class="cont-items">
                                    <?php foreach ($actividad['imagenes'] as $index => $img): ?>
                                        <button type="button" class="item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= $img ?>">
                                        </button>
                                    <?php endforeach; ?>
                                </div>

                            </section>

                            <div class="dato">
                                <h2><?= htmlspecialchars($actividad['nombre']) ?></h2>
                                <p><?= htmlspecialchars($actividad['descripcion']) ?></p>


                                <!-- seccion mapa -->
                                <section id="mapa" class="mapa-section">
                                    <div class="mapa-contenedor">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </section>
                            </div>
                        <?php else: ?>
                            <p>No se encontró la actividad.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <!-- BOTON DE RESERVAR____________________________________________________________________________________________________________ -->
                        <form class="form-reserva" action="<?= BASE_URL ?>/formulario-reserva" method="POST">

                            <input type="hidden" name="id_actividad" value="<?= $actividad['id_actividad'] ?>">

                            <div class="form-group">
                                <label>Cantidad de personas</label>
                                <input type="number" name="cantidad_personas" class="form-control" min="1" value="1"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Fecha de la actividad</label>
                                <input type="date" name="fecha" class="form-control" required>
                            </div>

                            <button type="submit">
                                Reservar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- F O O T E R_____________________________________________________________________________________________________________________________ -->
    <footer id="footer" class="container-fluid">

        <!-- footer superior -->
        <div class="footer-top">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2 class="palpitando">¿Quieres que tu negocio aparezca aquí?</h2>
                    <a href="contactanos">Publicate en Aventura Go</a>
                </div>
            </div>
        </div>

        <!-- Footer Inferior -->
        <div class="footer-bottom">
            <div class="row">

                <!-- Columna 1: Logo -->
                <div class="col-md-2">
                    <div class="logo-section">
                       <img src="public/assets/website_externos/index/img/LOGO-FINAL.png" alt="Logo Aventura Go"
                        class="navbar-logo">
                    </div>
                </div>

                <!-- col 2 Descripción  -->
                <div class="col-md-2">
                    <p class="description">
                        Aventura Go conecta viajeros con experiencias de aventura,
                        promoviendo el turismo sostenible y apoyando a prestadores locales en destinos naturales."
                    </p>
                </div>

                <!-- Columna 3: Destinos -->
                <div class="col-md-2">
                    <h5 class="dest-section">Destinos</h5>
                    <ul class="list-unstyled">
                        <li>Villeta</li>
                        <li>Utica</li>
                        <li>La Vega</li>
                        <li>San Francisco</li>
                        <li>Tobia</li>
                    </ul>
                </div>

                <!-- Columna 4: Enlaces Útiles -->
                <div class="col-md-2">
                    <h5 class="enlaces-section">Enlaces útiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Travel Blog</a></li>
                        <li><a href="#">Be Our Partner</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Columna 5: Contacto -->
                <div class="col-md-2">
                    <h5 class="contacto-section">Contactos</h5>
                    <ul class="list-unstyled contact-list">
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>321 2263435</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>aventurago2025@gmail.com</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Villeta Cundinamarca</span>
                        </li>
                    </ul>
                </div>

                <!-- Columna 6: Redes Sociales -->
                <div class="col-md-2">
                    <h5 class="redes-section">Síguenos</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

            </div>
        </div>

    </footer>

    <!-- Abootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="<?= BASE_URL ?>/public/assets/website_externos/tour_escogido/tour_escogido.js"></script>

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

    <!-- MODAL REGISTRO -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">¿Cómo quieres registrarte?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="container py-3">

                        <div class="row g-4 justify-content-center">

                            <!-- TURISTA -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">🎒</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Turista</h3>
                                        <p class="card-text">Quiero reservar actividades y experiencias.</p>
                                        <a href="/aventura_go/registrarse?tipo=turista" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- PROVEEDOR TURÍSTICO -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">⛰️</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor turístico</h3>
                                        <p class="card-text">Quiero publicar actividades de aventura.</p>
                                        <a href="/aventura_go/registrarse?tipo=proveedor_turistico" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- PROVEEDOR HOTELERO -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">🏨</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor hotelero</h3>
                                        <p class="card-text">Quiero publicar hospedajes.</p>
                                        <a href="/aventura_go/registrarse?tipo=proveedor_hotelero" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- FIN MODAL REGISTRO -->

</body>

</html>