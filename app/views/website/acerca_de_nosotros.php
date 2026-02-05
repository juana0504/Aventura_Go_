<?php session_start(); ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - Acerca de acerca_de_nosotros</title>

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

    <link rel="stylesheet" href="public/assets/website_externos/acerca_de_nosotros/acerca_de_nosotros.css">
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
                    <li><a class="nav-link" href="/aventura_go/">Inicio</a></li>
                    <li><a class="nav-link" href="/aventura_go/destacados">Destacados</a></li>
                    <li><a class="nav-link active" href="/aventura_go/acerca-de-nosotros">Acerca de nosotros</a></li>
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
                        <img src="public/assets/website_externos/acerca_de_nosotros/img/header.png" class="d-block w-100"
                            alt="Turismo en bote">
                        <div class="carousel-caption">
                            <h1>Conecta con la aventura,</h1>
                            <h2>vive la experiencia</h2>
                            <p class="parrafo1">Descubre experiencias únicas, paisajes inolvidables y emociones
                                extremas.
                            </p>
                            <p class="parrafo2">Explora, siente y disfruta con nosotros el turismo de aventura como
                                nunca
                                antes.</p>

                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="public/assets/website_externos/acerca_de_nosotros/img/montanismo.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption">
                            <h1>Descubre tu lado aventurero,</h1>
                            <h2>déjate llevar por la emoción</h2>
                            <p class="parrafo1">Explora montañas, ríos y caminos que despiertan tu espíritu libre.</p>
                            <p class="parrafo2">Cada destino es una historia, y tú eres el protagonista de la aventura.
                            </p>

                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="public/assets/website_externos/acerca_de_nosotros/img/canopy.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption">
                            <h1>vive la naturaleza al máximo,</h1>
                            <h2>Explora en altura</h2>
                            <p class="parrafo1">Atrévete a romper la rutina con experiencias llenas de adrenalina y
                                paisajes
                                únicos.</p>
                            <p class="parrafo2">Aventura Go te conecta con lo mejor del turismo extremo y la magia de
                                Colombia.</p>

                        </div>
                    </div>

                </div>

                <!-- <div class="search-box">
                    <div class="search-item">
                        <strong>Busca tu destino</strong>
                    </div>
                    <a href="../website_externos/destinos.html" class="search-btn bi bi-search "></a>
                </div> -->

                <h2 class="marca">AVENTURA<br>GO</h2>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <i class="bi bi-caret-left-fill"></i>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>
        </div>
    </section>



    <!-- Sección Características____________________________________________________________________________________________________________ -->
    <section id="caracteristicas">

        <div class="container-fluid">

            <h2>Lo que hace diferente a Aventura Go</h2>
            <p class="subtitle">Más que un viaje, una experiencia para recordar</p>

            <div class="container">
                <div class="row justify-content-center"> <!-- Añadí justify-content-center -->

                    <!-- Card 1 -->
                    <div class="col-12 col-md-4 mb-4 d-flex" data-aos="zoom-in" data-aos-duration="1500">
                        <!-- Añadí d-flex -->
                        <div class="feature-card1 p-4 shadow-sm w-100"> <!-- Añadí w-100 -->
                            <img src="public/assets/website_externos/acerca_de_nosotros/img/caracteristicas_icono_reserva.png" alt="logo1"
                                class="icono">
                            <h4>Reserva con confianza</h4>
                            <p>Disfruta experiencias seguras y respaldadas por prestadores locales certificados.</p>
                            <img src="../assets/website_externos/acerca_de_nosotros/img/index_diferente1.png" alt="muchacho casco blanco" class="img-fluid rounded-circle mt-3">
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-12 col-md-4 mb-4 d-flex" data-aos="zoom-in" data-aos-duration="2500">
                        <!-- Añadí d-flex -->
                        <div class="feature-card2 p-4 shadow-sm w-100"> <!-- Añadí w-100 -->
                            <img src="public/assets/website_externos/acerca_de_nosotros/img/caracteristicas_icono_reserva2.png" alt="logo2"
                                class="icono">
                            <h4>Aventura sin complicaciones</h4>
                            <p>Nos encargamos de los detalles para que tú solo vivas la emoción de viajar.</p>
                            <img src="../assets/website_externos/acerca_de_nosotros/img/index_diferente2.png" alt="tecleando"
                                class="img-fluid rounded-circle mt-3">
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-12 col-md-4 mb-4 d-flex" data-aos="zoom-in" data-aos-duration="3000">
                        <!-- Añadí d-flex -->
                        <div class="feature-card3 p-4 shadow-sm w-100"> <!-- Añadí w-100 -->
                            <img src="public/assets/website_externos/acerca_de_nosotros/img/caracteristicas_icono_reserva3.png" alt="logo3"
                                class="icono">
                            <h4>Opciones flexibles</h4>
                            <p>Elige entre distintos destinos y actividades para adaptar tu viaje a tu medida.</p>
                            <img src="../assets/website_externos/acerca_de_nosotros/img/indexDiferente3.png" alt="escribiendo"
                                class="img-fluid rounded-circle mt-3">
                        </div>
                    </div>

                </div>
            </div>

            <div class="features-description mt-4">
                <p>Te ofrecemos experiencias auténticas que combinan naturaleza, emoción y cultura local.
                    Trabajamos de la mano con prestadores de la región, garantizando seguridad y un turismo
                    responsable que deja huella positiva en cada destino.</p>
            </div>
        </div>
    </section>



    <!-- seccion letrero movil -->
    <section id="letrero">
        <div class="home-special">
            <div class="home-special-main-heading dynamiccomponenteditenable" data-id="146915" data-editbuttontext=""
                data-editable="True">
                <div class="marquee1">
                    <div class="marquee__inner">
                        <span class="title--xl home-special-main-title" tabindex="0">Conecta con la aventura.</span>
                        <span class="title--xl home-special-main-title" tabindex="0">Conecta con la aventura.</span>
                        <span class="title--xl home-special-main-title" tabindex="0">Conecta con la aventura.</span>
                        <span class="title--xl home-special-main-title" tabindex="0">Conecta con la aventura.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- seccion testimonios____________________________________________________________________________________________________________________ -->
    <section id="testimonios">

        <div class="container-fluid">

            <!-- Título-->
            <div class="col-12 d-flex align-items-center justify-content-center">
                <h2>¿Qué opinan nuestros usuarios?</h2>
            </div>

            <div class="row">

                <!-- Contenido principal -->
                <div class="col-12 col-md-10">
                    <div class="slider-testimonios">

                        <!-- Card 1 -->
                        <div class="card-testimonio">
                            <div class="cont-img">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/index_foto_opiniones.png" alt="foto mujer">
                            </div>
                            <div class="cont-info">
                                <h3>Kristin Krause</h3>
                                <p>"Gracias a Aventura Go viví una experiencia increíble en Villeta. Todo el proceso
                                    fue
                                    claro y confiable, y las actividades estaban muy bien seleccionadas. Se nota que
                                    trabajan con guías locales comprometidos con el turismo responsable."</p>
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="card-testimonio">
                            <div class="cont-img">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/index_foto_opiniones.png" alt="foto mujer">
                            </div>
                            <div class="cont-info">
                                <h3>Alejandro Catro </h3>
                                <p>"Aventura Go superó mis expectativas. Reservar fue muy fácil y todo el viaje
                                    estuvo
                                    perfectamente organizado. Me encantó la atención personalizada y la seguridad
                                    que
                                    ofrecen en cada actividad. Sin duda volveré a usar la plataforma para mi próxima
                                    escapada."</p>
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="card-testimonio">
                            <div class="cont-img">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/index_foto_opiniones.png" alt="foto mujer">
                            </div>
                            <div class="cont-info">
                                <h3>claudia Sachica</h3>
                                <p>"Me encantó la flexibilidad de Aventura Go. Pude elegir las experiencias que más
                                    se
                                    adaptaban a mi tiempo y presupuesto. La interfaz es intuitiva y el servicio al
                                    cliente excelente. ¡Recomendado al 100%!"</p>
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="card-testimonio">
                            <div class="cont-img">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/index_foto_opiniones.png" alt="foto mujer">
                            </div>
                            <div class="cont-info">
                                <h3>Juana Mendoza</h3>
                                <p>"Gracias a Aventura Go viví una experiencia increíble en Villeta. Todo el proceso
                                    fue
                                    claro y confiable, y las actividades estaban muy bien seleccionadas. Se nota que
                                    trabajan con guías locales comprometidos con el turismo responsable."</p>
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card 5 -->
                        <div class="card-testimonio">
                            <div class="cont-img">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/index_foto_opiniones.png" alt="foto mujer">
                            </div>
                            <div class="cont-info">
                                <h3>Alberto Gongora</h3>
                                <p>"Me encantó la flexibilidad de Aventura Go. Pude elegir las experiencias que más
                                    se
                                    adaptaban a mi tiempo y presupuesto. La interfaz es intuitiva y el servicio al
                                    cliente excelente. ¡Recomendado al 100%!G."</p>
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- seccion equipo -->
    <section id="equipo">
        <div class="container-fluid">

            <!-- Título-->
            <div class="col-12 d-flex align-items-center justify-content-center">
                <h2>nuestro equipo de trabajo</h2>
            </div>

            <div class="row">

                <div class="col-12 col-md-10">
                    <div class="slider-equipo">


                        <!-- Card 1 -->
                        <div class="equipo" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="card1 p-4 shadow-sm w-100">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/foto_albert.png" alt="foto albert" class="foto">
                                <h4>Albert gutierrez</h4>
                                <p>Scrum master</p>
                                <p>Frontend</p>
                            </div>
                        </div>


                        <!-- Card 2 -->
                        <div class="equipo" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="card2 p-4 shadow-sm w-100">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/foto_sofia.png" alt="foto sofia" class="foto">
                                <h4>Sofia Camelo</h4>
                                <p>Scrum master</p>
                                <p>Frontend</p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="equipo" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="card3 p-4 shadow-sm w-100">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/foto_juan.png" alt="foto juan" class="foto">
                                <h4>Juan mahecha</h4>
                                <p>Development Team</p>
                                <p>Frontend</p>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="equipo" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="card4 p-4 shadow-sm w-100">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/foto_juana.png" alt="foto juana" class="foto">
                                <h4>juana rodriguez</h4>
                                <p>Development Team</p>
                                <p>Backend</p>
                            </div>
                        </div>

                        <!-- Card 5 -->
                        <div class="equipo" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="card5 p-4 shadow-sm w-100">
                                <img src="public/assets/website_externos/acerca_de_nosotros/img/foto_stiven.png" alt="foto stiven" class="foto">
                                <h4>Stiven aguilar</h4>
                                <p>Development Team</p>
                                <p>Backend</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



        </div>
    </section>




    <!-- F O O T E R_____________________________________________________________________________________________________________________________ -->
    <footer id="footer">

        <div class="container-fluid">

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
                            <img src="public/assets/website_externos/acerca_de_nosotros/img/LOGO-FINAL.png" width="120px" alt="logo Aventura Go">
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

    <script src="<?= BASE_URL ?>/public/assets/website_externos/acerca_de_nosotros/acerca_de_nosotros.js"></script>

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