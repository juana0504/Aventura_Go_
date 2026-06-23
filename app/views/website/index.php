<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go</title>

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">


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

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/index/index.css">

    <style>
        /* Overlay hover tarjetas destinos */
        .destino-card { position: relative; overflow: hidden; }
        .destino-card img { transition: transform 0.5s ease; }
        .destino-card:hover img { transform: scale(1.07); }
        .destino-card::after {
            content: 'Ver destino \2192';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 200px;
            background: rgba(45, 64, 89, 0.55);
            color: #fff;
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.35s ease;
            border-radius: 12px 12px 0 0;
            pointer-events: none;
            z-index: 2;
        }
        .destino-card:hover::after { opacity: 1; }
    </style>
</head>


<body>

    <!-- header________________________________________________________________________________________________________________________________ -->
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <!-- Logo -->
                <div class="logo">
                    <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png" alt="Logo Aventura Go"
                        class="navbar-logo">
                </div>

                <!-- Menú principal -->
                <ul class="navbar-nav" id="navbarNav">
                    <li><a class="nav-link active" href="<?= BASE_URL ?>"><i class="bi bi-house-door-fill"></i> Inicio</a></li>
                    <li><a class="nav-link" href="<?= BASE_URL ?>destacados"><i class="bi bi-star-fill"></i> Destacados</a></li>
                    <li><a class="nav-link" href="<?= BASE_URL ?>acerca-de-nosotros"><i class="bi bi-info-circle-fill"></i> Acerca de nosotros</a></li>
                    <li><a class="nav-link" href="<?= BASE_URL ?>contactanos"><i class="bi bi-chat-dots-fill"></i> Contáctanos</a></li>
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
                                    <a href="<?= BASE_URL ?>turista/perfil">Mi perfil</a>
                                </li>
                                <li>
                                    <a href="<?= BASE_URL ?>turista/dashboard">Centro de ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?= BASE_URL ?>logout" class="logout">Cerrar sesión</a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>

                        <a href="<?= BASE_URL ?>login" class="btn-login">
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



    <!-- Sección Hero________________________________________________________________________________________________________________________ -->
    <section id="hero">

        <div class="container-fluid">

            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
                            alt="Turismo en bote">
                        <div class="carousel-caption">
                            <h1>Explora sin límites,</h1>
                            <h2>descubre tu próximo destino</h2>
                            <p class="parrafo1">Embárcate en rutas llenas de adrenalina, cultura y naturaleza que te
                                harán vibrar.</p>


                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
                            alt="...">
                        <div class="carousel-caption">
                            <h1>El mundo te espera,</h1>
                            <h2>atrévete a vivirlo</h2>
                            <p class="parrafo1">Sumérgete en nuevas aventuras, desde montañas imponentes hasta mares
                                cristalinos.</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/rafting1.jpg" class="d-block w-100"
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

        <!-- GRID DE DESTINOS (dinámico desde BD) -->
        <?php
        // Imágenes estáticas de respaldo por nombre de ciudad conocida
        $imagenesEstaticas = [
            'nimaima'      => 'destinos_populares_nimaima.png',
            'villeta'      => 'destinos_visitados_villeta.png',
            'la vega'      => 'destinos_populares_lavega.png',
            'san francisco'=> 'destinos_populares_sanFrancisco.png',
            'sasaima'      => 'destinos_populares_sasaima.png',
            'tobia'        => 'destinos_populares_tobia.png',
        ];
        $imgBase    = BASE_URL . 'public/assets/website_externos/index/img/';
        $imgDefault = BASE_URL . 'public/assets/website_externos/descubre_tours/img/imagen%20tour.png';

        // Mostrar máximo 6 en el inicio; el resto en "descubre-tours"
        $destinosMostrar = array_slice($destinosPopulares, 0, 6);
        ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (empty($destinosMostrar)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>Próximamente más destinos disponibles.</p>
                </div>
            <?php else: ?>
                <?php foreach ($destinosMostrar as $destino):
                    $nombreCiudad = $destino['ciudad'];
                    $clave        = strtolower($nombreCiudad);

                    // Imagen: primero estática si es ciudad conocida, luego la de BD, luego default
                    if (isset($imagenesEstaticas[$clave])) {
                        $imgSrc = $imgBase . $imagenesEstaticas[$clave];
                    } elseif (!empty($destino['imagen_destino'])) {
                        $imgSrc = BASE_URL . 'public/uploads/turistico/actividades/' . rawurlencode($destino['imagen_destino']);
                    } else {
                        $imgSrc = $imgDefault;
                    }
                ?>
                <div class="col">
                    <a href="<?= BASE_URL ?>descubre-tours?ciudad=<?= rawurlencode($nombreCiudad) ?>" class="text-decoration-none">
                        <div class="card destino-card shadow-sm">
                            <img src="<?= htmlspecialchars($imgSrc) ?>"
                                class="card-img-top" alt="<?= htmlspecialchars($nombreCiudad) ?>"
                                onerror="this.onerror=null;this.src='<?= $imgDefault ?>'">
                            <div class="card-body">
                                <h5 class="card-title"><?= strtoupper(htmlspecialchars($nombreCiudad)) ?></h5>
                                <small class="text-muted"><?= $destino['total_actividades'] ?> actividad<?= $destino['total_actividades'] != 1 ? 'es' : '' ?></small>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- BOTÓN MÁS DESTINOS -->
        <div class="text-center mt-5">
            <a href="<?= BASE_URL ?>descubre-tours" class="btn-ver-mas">Más destinos</a>
        </div>
    </section>



    <!-- SECCIÓN TOURS MEJOR CALIFICADOS -->
    <section class="destinos-visitados container my-5">
        <h2 class="titulo-seccion-visitados text-center">Destinos más visitados</h2>

        <div class="slider-visitados">
            <button class="slider-arrow arrow-left"><i class="fas fa-chevron-left"></i></button>

            <div class="slider-contenido">
                <?php if (empty($toursDestacados)): ?>
                    <p class="text-muted text-center w-100 py-4">Próximamente tours disponibles.</p>
                <?php else: ?>
                    <?php foreach ($toursDestacados as $i => $tour):
                        $imgTour    = !empty($tour['imagen'])
                                        ? BASE_URL . 'public/uploads/turistico/actividades/' . rawurlencode($tour['imagen'])
                                        : BASE_URL . 'public/assets/website_externos/descubre_tours/img/imagen%20tour.png';
                        $promedio   = (float) $tour['promedio_calificacion'];
                        $totalRes   = (int)   $tour['total_resenas'];
                        $estrellas  = str_repeat('★', (int) round($promedio)) . str_repeat('☆', 5 - (int) round($promedio));
                        $precio     = '$' . number_format($tour['precio'], 0, ',', '.');
                    ?>
                    <div class="tarjeta-visitado">
                        <a href="<?= BASE_URL ?>tour-escogido?id=<?= $tour['id_actividad'] ?>" class="text-decoration-none">
                            <div class="imagen-container">
                                <img src="<?= htmlspecialchars($imgTour) ?>"
                                     alt="<?= htmlspecialchars($tour['nombre']) ?>"
                                     onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/imagen%20tour.png'">
                                <?php if ($i === 0 && $totalRes > 0): ?>
                                    <span class="etiqueta-oferta">Más reseñas</span>
                                <?php elseif ($promedio >= 4.5 && $totalRes > 0): ?>
                                    <span class="etiqueta-descuento">Top rated</span>
                                <?php endif; ?>
                            </div>
                            <div class="tarjeta-info">
                                <h5 class="tarjeta-titulo"><?= strtoupper(htmlspecialchars($tour['nombre'])) ?></h5>
                                <p class="tarjeta-estrellas">
                                    <?= $estrellas ?>
                                    <span class="reviews">(<?= $totalRes ?> reseña<?= $totalRes !== 1 ? 's' : '' ?>)</span>
                                </p>
                                <div class="tarjeta-detalles">
                                    <p class="duracion"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($tour['ciudad']) ?></p>
                                    <p class="precio">
                                        <span class="precio-anterior">Desde</span>
                                        <span class="precio-actual"><?= $precio ?></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button class="slider-arrow arrow-right"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>descubre-tours" class="btn-ver-mas">Ver todos los tours</a>
        </div>
    </section>


    <!-- SECCIÓN HOSPEDAJES RECOMENDADOS -->
    <section class="hospedajes-recomendados container my-5">
        <h2 class="titulo-seccion-visitados text-center">Hospedajes recomendados</h2>

        <div class="slider-visitados">
            <button class="slider-arrow arrow-left"><i class="fas fa-chevron-left"></i></button>

            <div class="slider-contenido">
                <?php if (empty($hospedajesRecomendados)): ?>
                    <p class="text-muted text-center w-100 py-4">Próximamente hospedajes disponibles.</p>
                <?php else: ?>
                    <?php foreach ($hospedajesRecomendados as $i => $hotel):
                        $imgHotel   = !empty($hotel['imagen'])
                                        ? BASE_URL . 'public/uploads/hotelero/actividades/' . rawurlencode($hotel['imagen'])
                                        : BASE_URL . 'public/assets/website_externos/descubre_tours/img/imagen%20tour.png';
                        $promedio   = (float) $hotel['promedio_calificacion'];
                        $totalRes   = (int)   $hotel['total_resenas'];
                        $estrellas  = str_repeat('★', (int) round($promedio)) . str_repeat('☆', 5 - (int) round($promedio));
                        $precio     = '$' . number_format($hotel['precio'], 0, ',', '.');
                        $tipo       = !empty($hotel['tipo']) ? ucfirst(strtolower($hotel['tipo'])) : 'Hospedaje';
                    ?>
                    <div class="tarjeta-visitado tarjeta-hospedaje">
                        <a href="<?= BASE_URL ?>hospedaje-escogido?id=<?= $hotel['id_hospedaje'] ?>" class="text-decoration-none">
                            <div class="imagen-container">
                                <img src="<?= htmlspecialchars($imgHotel) ?>"
                                     alt="<?= htmlspecialchars($hotel['nombre']) ?>"
                                     onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/imagen%20tour.png'">
                                <span class="etiqueta-tipo-hotel"><?= htmlspecialchars($tipo) ?></span>
                                <?php if ($promedio >= 4.5 && $totalRes > 0): ?>
                                    <span class="etiqueta-descuento">Top rated</span>
                                <?php endif; ?>
                            </div>
                            <div class="tarjeta-info">
                                <h5 class="tarjeta-titulo"><?= strtoupper(htmlspecialchars($hotel['nombre'])) ?></h5>
                                <p class="tarjeta-estrellas">
                                    <?= $estrellas ?>
                                    <span class="reviews">(<?= $totalRes ?> reseña<?= $totalRes !== 1 ? 's' : '' ?>)</span>
                                </p>
                                <div class="tarjeta-detalles">
                                    <p class="duracion"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($hotel['ciudad']) ?></p>
                                    <p class="precio">
                                        <span class="precio-anterior">Noche desde</span>
                                        <span class="precio-actual"><?= $precio ?></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button class="slider-arrow arrow-right"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>descubre-hospedaje" class="btn-ver-mas">Ver todos los hospedajes</a>
        </div>
    </section>



    <!-- _______________________________F O O T E R__________________________________________ -->
    <footer id="footer" class="container-fluid">

        <!-- footer superior -->
        <div class="footer-top">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2 class="palpitando">¿Quieres que tu negocio aparezca aquí?</h2>
                    <a href="<?= BASE_URL ?>contactanos">Publicate en Aventura Go</a>
                </div>
            </div>
        </div>

        <!-- Footer Inferior -->
        <div class="footer-bottom">

            <div class="row">

                <!-- Columna 1: Logo -->
                <div class="col-md-2">
                    <div class="logo-section">
                        <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-NEGATIVO.png" alt="logo Aventura Go">
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
                                    <div class="card-body">
                                        <h3 class="card-title">Turista</h3>
                                        <p class="card-text">Quiero reservar actividades y experiencias.</p>

                                        <a href="<?= BASE_URL ?>registrarse?tipo=turista" class="btn btn-aventura">
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
                                        <a href="<?= BASE_URL ?>registrar-proveedor" class="btn btn-aventura">
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
                                        <a href="<?= BASE_URL ?>registrar-proveedor-hotelero" class="btn btn-aventura">
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