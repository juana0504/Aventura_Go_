<?php session_start(); ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - contactanos</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/index/img/FAVICON.png">


    <!-- bootstrap para el carrusel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- bootstrap primero -->
    <link href="path/to/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (para las estrellas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Tema opcional slick carrousel -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="public/assets/website_externos/index/index.css">
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

                <!-- Menú principal -->
                <ul class="navbar-nav" id="navbarNav">
                    <li><a class="nav-link active" href="/aventura_go/">Inicio</a></li>
                    <li><a class="nav-link" href="/aventura_go/destacados">Destacados</a></li>
                    <li><a class="nav-link" href="/aventura_go/acerca-de-nosotros">Acerca de nosotros</a></li>
                    <li><a class="nav-link" href="/aventura_go/contactanos">Contáctanos</a></li>
                </ul>

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

                        <a href="/aventura_go/registro" class="btn-register">
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



    <!-- Sección Hero________________________________________________________________________________________________________________________ -->
    <section id="hero">

        <div class="container-fluid">

            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
                            alt="Turismo en bote">
                        <div class="carousel-caption">
                            <h1>Explora sin límites,</h1>
                            <h2>descubre tu próximo destino</h2>
                            <p class="parrafo1">Embárcate en rutas llenas de adrenalina, cultura y naturaleza que te
                                harán vibrar.</p>


                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
                            alt="...">
                        <div class="carousel-caption">
                            <h1>El mundo te espera,</h1>
                            <h2>atrévete a vivirlo</h2>
                            <p class="parrafo1">Sumérgete en nuevas aventuras, desde montañas imponentes hasta mares
                                cristalinos.</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
                            alt="...">
                        <div class="carousel-caption">
                            <h1>Destinos que inspiran,</h1>
                            <h2>aventuras que transforman</h2>
                            <p class="parrafo1">Viaja a lugares mágicos donde cada paso cuenta una historia y cada
                                paisaje deja huella.</p>

                        </div>
                    </div>

                </div>

                <!-- <div class="search-box">
                    <div class="search-item">
                        <strong>Busca tu destino</strong>
                    </div>
                    <a href="website_externos/destinos.html" class="search-btn bi bi-search "></a>
                </div> -->

                <h2 class="marca">AVENTURA<br>GO</h2>



                <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <i class="bi bi-caret-left-fill"></i>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>
        </div>
    </section>



    <!-- SECCIÓN DESTINOS POPULARES -->
    <section class="destinos-populares container my-5">

        <!-- FILA 1: SOLO EL TÍTULO CENTRADO -->
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="titulo-seccion">Destinos populares</h2>
            </div>
        </div>

        <!-- FILA 2: SUBTÍTULO IZQUIERDA / BUSCADOR DERECHA -->
        <div class="row align-items-center mt-3 fila-subtitulo-buscador">

            <!-- Subtítulo -->
            <div class="col-md-9 text-md-start text-center">
                <p class="subtitulo-seccion">
                    Atrévete a vivir emociones únicas en los destinos más extremos de Colombia.
                </p>
            </div>

            <!-- Buscador -->
            <div class="col-md-3 text-md-end text-center mt-3 mt-md-0">
                <div class="buscador">
                    <input type="text" placeholder="Busca tu destino">
                    <i class="fas fa-search"></i>
                </div>
            </div>

        </div>

        <!-- GRID DE DESTINOS -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Tarjeta 1 -->
            <div class="col">
                <div class="card destino-card shadow-sm">
                    <img src="public/assets/website_externos/index/img/destinos_populares_nimaima.png"
                        class="card-img-top" alt="Nimaima">
                    <div class="card-body">
                        <h5 class="card-title">NIMAIMA</h5>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col">
                <a href="/aventura_go/descubre-tours" class="text-decoration-none">
                    <div class="card destino-card shadow-sm">
                        <img src="public/assets/website_externos/index/img/destinos_visitados_villeta.png"
                            class="card-img-top" alt="Villeta">
                        <div class="card-body">
                            <h5 class="card-title">VILLETA</h5>
                        </div>
                    </div>
                </a>
            </div>


            <!-- Tarjeta 3 -->
            <div class="col">
                <div class="card destino-card shadow-sm">
                    <img src="public/assets/website_externos/index/img/destinos_populares_lavega.png"
                        class="card-img-top" alt="La Vega">
                    <div class="card-body">
                        <h5 class="card-title">LA VEGA</h5>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4 -->
            <div class="col">
                <div class="card destino-card shadow-sm">
                    <img src="public/assets/website_externos/index/img/destinos_populares_sanFrancisco.png"
                        class="card-img-top" alt="San Francisco">
                    <div class="card-body">
                        <h5 class="card-title">SAN FRANCISCO</h5>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 5 -->
            <div class="col">
                <div class="card destino-card shadow-sm">
                    <img src="public/assets/website_externos/index/img/destinos_populares_sasaima.png"
                        class="card-img-top" alt="Sasaima">
                    <div class="card-body">
                        <h5 class="card-title">SASAIMA</h5>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 6 -->
            <div class="col">
                <div class="card destino-card shadow-sm">
                    <img src="public/assets/website_externos/index/img/destinos_populares_tobia.png"
                        class="card-img-top" alt="Tobia">
                    <div class="card-body">
                        <h5 class="card-title">TOBIA</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTÓN MÁS DESTINOS -->
        <div class="text-center mt-5">
            <a href="#" class="btn-ver-mas">Más destinos </a>
        </div>
    </section>



    <!-- SECCIÓN DESTINOS MÁS VISITADOS -->
    <section class="destinos-visitados container my-5">
        <h2 class="titulo-seccion-visitados text-center">Destinos más visitados</h2>

        <div class="slider-visitados">
            <!-- Flecha izquierda -->
            <button class="slider-arrow arrow-left">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Contenedor de tarjetas -->
            <div class="slider-contenido">
                <!-- Tarjeta 1 -->
                <div class="tarjeta-visitado">
                    <div class="imagen-container">
                        <img src="public/assets/website_externos/index/img/destinos_visitados_villeta.png"
                            alt="Villeta Cundinamarca">
                        <span class="etiqueta-oferta">Oferta especial</span>
                    </div>
                    <div class="tarjeta-info">
                        <h5 class="tarjeta-titulo">VILLETA CUNDINAMARCA</h5>
                        <p class="tarjeta-estrellas">★★★★★ <span class="reviews">(1 Review)</span></p>
                        <div class="tarjeta-detalles">
                            <p class="duracion"><i class="far fa-clock"></i> Pasadía</p>
                            <p class="precio">
                                <span class="precio-anterior">Desde $180.000</span>
                                <span class="precio-actual">$120.000</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2 -->
                <div class="tarjeta-visitado">
                    <div class="imagen-container">
                        <img src="public/assets/website_externos/index/img/destinos_populares_sasaima.png"
                            alt="Villeta Cundinamarca">
                    </div>
                    <div class="tarjeta-info">
                        <h5 class="tarjeta-titulo">SASAIMA CUNDINAMARCA</h5>
                        <p class="tarjeta-estrellas">★★★★★ <span class="reviews">(1 Review)</span></p>
                        <div class="tarjeta-detalles">
                            <p class="duracion"><i class="far fa-clock"></i> 2 días, 1 noche</p>
                            <p class="precio">
                                <span class="precio-anterior">Desde</span>
                                <span class="precio-actual">$165.000</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3 -->
                <div class="tarjeta-visitado">
                    <div class="imagen-container">
                        <img src="public/assets/website_externos/index/img/destinos_populares_lavega.png"
                            alt="La Vega Cundinamarca">
                        <span class="etiqueta-descuento">20% off</span>
                    </div>
                    <div class="tarjeta-info">
                        <h5 class="tarjeta-titulo">LA VEGA CUNDINAMARCA</h5>
                        <p class="tarjeta-estrellas">★★★★★ <span class="reviews">(1 Review)</span></p>
                        <div class="tarjeta-detalles">
                            <p class="duracion"><i class="far fa-clock"></i> 2 días, 1 noche</p>
                            <p class="precio">
                                <span class="precio-anterior">Desde</span>
                                <span class="precio-actual">$195.000</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flecha derecha -->
            <button class="slider-arrow arrow-right">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </section>



    <!-- _______________________________F O O T E R__________________________________________ -->
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
                        <img src="public/assets/website_externos/index/img/LOGO-NEGATIVO.png" alt="logo Aventura Go">
                    </div>
                </div>

                <!-- col 2 Descripción  -->
                <div class="col-md-2">
                    <p class="description">
                        Aventuras únicas, seguras y confiables.
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

    <script src="public/assets/website_externos/index/index.js"></script>


</body>

</html>