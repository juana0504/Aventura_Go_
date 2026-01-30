<?php session_start();
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

$actividadModel = new ActividadTuristica();
$actividades = $actividadModel->listarActividadesPublicas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - tour-escogido</title>

    <!-- bootstrap para el carrusel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (para las estrellas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Tema opcional slick carrousel -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

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
                <div class="logo">
                    <img src="../public/assets/website_externos/tour_escogido/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">
                    Tu reserva de tours en <?= htmlspecialchars($_GET['ciudad'] ?? 'tu destino') ?>
                </h1>

                <div class="actions">

                    <?php if (isset($_SESSION['user'])): ?>

                        <span class="Bienvenido">
                            Bienvenido, <?= htmlspecialchars(ucwords(explode(' ', $_SESSION['user']['nombre'])[0] . ' ' . (explode(' ', $_SESSION['user']['nombre'])[1] ?? ''))) ?>
                        </span>

                        <a href="/aventura_go/logout" class="btn-register">
                            Salir
                        </a>

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

                <a href="#" class="btn-login">Atrás</a>
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </nav>

    </header>


    <main>

        <!-- Sección barra busqueda____________________________________________________________________________________________________________ -->
        <section id="filtros">
            <div class="container">
                <div class="search-filters">
                    <div class="row">
                        <div class="filters-row">
                            <div class="col-md-4">
                                <div class="filter-item">
                                    <i class="fas fa-calendar"></i>
                                    <input type="text" placeholder="01 oct 2025 - 02 oct 2025" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="filter-item">
                                    <i class="fas fa-users"></i>
                                    <input type="text" placeholder="02 Adultos - 01 Niño - 00 Bebés" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="filter-item">
                                    <i class="fas fa-car"></i>
                                    <input type="text" placeholder="01" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Características____________________________________________________________________________________________________________ -->
        <section id="datos">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <h1>Explora las vias del tren y disfruta de la naturaleza en villeta.</h1>
                        <p>Dg. 2 Sur #11a-65, La Vega, Cundinamarca, 253610 Villeta, Colombia</p>
                        <p>Después de reservar, encontrarás todos los datos de tu actividad con el número de teléfono y la
                            dirección en tu confirmación de la reserva y en tu cuenta.</p>
                    </div>
                    <div class="col-md-3 stars">
                        <p>1 Noche, 2 Días</p>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span>(120 Review)</span> <br>
                        <span> From $325000 <strong>$282000</strong></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección fotos____________________________________________________________________________________________________________ -->
        <section id="fotos">
            <div class="container">
                <div class="galeria-container p-3 bg-white shadow-sm rounded-4">
                    <div class="row g-2">
                        <!-- Imágenes -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <img src="../turista/img/imagen tour.png" class="img-fluid rounded" alt="foto 1">
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="../turista/img/imagen tour.png" class="img-fluid rounded" alt="foto 2">
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <img src="../turista/img/imagen tour.png" class="img-fluid rounded" alt="foto 3">
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="../turista/img/imagen tour.png" class="img-fluid rounded" alt="foto 4">
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <img src="../turista/img/imagen tour.png" class="img-fluid rounded" alt="foto 5">
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Sección descripcion____________________________________________________________________________________________________________ -->
        <section id="descripcion">
            <div class="container">
                <h5 class="fw-bold">Explora las vías del tren y disfruta de la naturaleza en Villeta 🚞🌿</h5>
                <p>
                    Embárcate en una experiencia auténtica que combina historia, aventura y paisajes inolvidables.
                    En este recorrido, te invitamos a caminar por las antiguas vías del tren que atraviesan las montañas
                    y valles de Villeta, un municipio lleno de encanto y tradición.
                </p>
                <p>A lo largo del trayecto, disfrutarás del sonido del río, el canto de las aves y la frescura del aire puro
                    que caracteriza a esta tierra cundinamarquesa.</p>
                <p>Durante la actividad, podrás admirar la belleza natural del entorno, tomar fotografías y conocer más
                    sobre el legado ferroviario que alguna vez conectó esta región con el resto del país.
                </p>
                <p>Nuestros guías locales te acompañarán en todo momento, compartiendo datos curiosos, historias y
                    anécdotas que hacen de este recorrido una vivencia cultural además de recreativa.</p>
            </div>
        </section>


        <!-- Sección mapa____________________________________________________________________________________________________________ -->
        <section id="mapa" class="mapa-section">
            <div class="row">
                <div class="col-md-8">
                    <div class="mapa-contenedor">
                        <iframe title="Mapa de Villeta, Cundinamarca"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                            allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <h2>Encuéntranos fácilmente</h2>
                </div>
            </div>
        </section>

        <!-- BOTON DE RESERVAR____________________________________________________________________________________________________________ -->
        <div class="button">
            <a href="<?= BASE_URL ?>/turista/preparar-reserva?id=<?= $actividad['id_actividad'] ?>"
                class="btn-ver-mas">
                RESERVAR
            </a>
        </div>

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
                        <img src="../public/assets/website_externos/tour_escogido/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
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

    <!-- JavaScript de Slick -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- aos animate -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="/public/assets/website_externos/tour_escogido/tour_escogido.js"></script>
    <!-- ../../assets/dashboard/turista/tour_escogido/tour_escogido.js -->
</body>

</html>