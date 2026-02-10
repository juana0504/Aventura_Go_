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

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Tema opcional slick carrousel -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="public/assets/website_externos/contactanos/contactanos.css">
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
                    <li><a class="nav-link" href="/aventura_go/acerca-de-nosotros">Acerca de nosotros</a></li>
                    <li><a class="nav-link active" href="/aventura_go/contactanos">Contáctanos</a></li>
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



    <!-- HERO CONTACTANOS_______________________________________________________________________________________________ -->
    <section id="hero">

        <div class="container-fluid">

            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="public/assets/website_externos/contactanos/img/Hero_contactanos.png" class="d-block w-100"
                            alt="Turismo en bote">
                        <div class="carousel-caption">
                            <h1>Contacta con nosotros</h1>
                            <h2>inscribe o descubre tu próximo destino</h2>
                        </div>
                    </div>


                </div>


                <h2 class="marca">AVENTURA<br>GO</h2>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <i class="bi bi-caret-left-fill flecha-prev"></i>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>
        </div>
    </section>


    <!-- SECCIÓN infO -->
    <section id="info">
        <div class="container-fluid">
            <div class="row">
                <div class="hero-info">
                    <div class="col-12 col-sm-4 col-md-4 text-center p-3">
                        <img src="public/assets/website_externos/contactanos/img/hero_icon_email.png" class="icono-email"
                            alt="icono hero_icon_email">
                        <h2 class="h2-email">E-mail</h2>
                        <h3 class="h3-email">aventurago.contacto@gmail.com</h3>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 text-center p-3">
                        <img src="public/assets/website_externos/contactanos/img/hero_icon_phone.png" alt="icono hero_icon_phone">
                        <h2>Telefono</h2>
                        <h3>+57 320 123 4567</h3>
                        <h3>+57 310 987 6543</h3>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 text-center p-3">
                        <img src="public/assets/website_externos/contactanos/img/hero_icon_lugar.png" alt="icono hero_icon_lugar">
                        <h2>Direccion</h2>
                        <h3>Villeta, Cundinamarca</h3>
                        <h3>Colombia</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- SECCIÓN FORMULARIO DE CONTACTO -->
    <section id="formulario">

        <div class="container-fluid">

            <h2 class="titulo-principal">Aclarámos tus dudas, escríbenos</h2>

            <div class="formulario-completo">

                <!-- SECCIÓN IZQUIERDA - IMAGEN Y TEXTO AZUL -->
                <div class="seccion-izquierda">
                    <img src="public/assets/website_externos/contactanos/img/img_formulario.png" alt="img form">
                    <p class="p1">¿No sabes qué destino elegir?</p>
                    <p class="p2 palpitando"><strong>Nosotros podemos ayudarte</strong></p>
                </div>

                <!-- SECCIÓN DERECHA - FORMULARIO -->
                <div class="seccion-derecha">
                    <h2>Formulario de contacto</h2>
                    <p class="descripcion">
                        Nuestro compromiso es brindarte toda la orientación y apoyo que necesitas para hacer de tu
                        experiencia algo extraordinario. Diligencia tus datos y te responderemos lo más pronto posible.
                    </p>

                    <form action="https://formsubmit.co/aventurago.contacto@gmail.com" method="post">
                        <!-- PRIMERA FILA - 2 COLUMNAS -->
                        <div class="fila-campos">
                            <div class="campo">
                                <label for="nombre">Nombre completo</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Ej: María Pérez" required>
                            </div>
                            <div class="campo">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" name="telefono" id="telefono" placeholder="Ej: +57 320 123 4567" required>
                            </div>
                        </div>

                        <!-- SEGUNDA FILA - 2 COLUMNAS -->
                        <div class="fila-campos">
                            <div class="campo">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="Ej: sucorreo@correo.com" required>
                            </div>
                            <div class="campo">
                                <label for="objeto">Objeto de la pregunta</label>
                                <input type="text" id="objeto" placeholder="Ej: Consulta general" required>
                            </div>
                        </div>

                        <!-- TERCERA FILA - 1 COLUMNA -->
                        <div class="fila-campos">
                            <div class="campo-full">
                                <label for="mensaje">Mensaje</label>
                                <textarea name="mensaje" id="mensaje" rows="4" placeholder="Ej: El siguiente mensaje es para..."
                                    required></textarea>
                            </div>
                        </div>


                        <!-- Configuración de FormSubmit para que aparezca mensaje de gracias al enviar el formulario de contacto -->
                        <input type="hidden" name="_captcha" value="false">
                        <input type="hidden" name="_next"
                            value="https://albert-gutierrez.github.io/Aventura-Go/website_externos/contactanos_gracias.html">

                        <!-- BOTÓN se acrivara cuando sea funcional-->
                        <!-- <button type="submit" class="btn-enviar">Enviar mensaje</button> -->

                        <!-- boton provisional de reemplazo, direeciona ala pagina de gracias luego de enviar el formulario-->
                        <button type="submit" class="btn-enviar"
                            onclick="window.location.href='../website_externos/contactanos_gracias.html'">
                            Enviar mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <!-- seccion mapa -->
    <section id="mapa">
        <div class="container-fluid">
            <div class="mapa-section">
                <h2>Encuéntranos fácilmente</h2>
                <div class="mapa-contenedor">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
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
                            <img src="public/assets/website_externos/contactanos/img/LOGO-FINAL.png" width="120px"
                                alt="logo Aventura Go">
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


    <!-- JavaScript de Slick -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- aos animate -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="<?= BASE_URL ?>/public/assets/website_externos/contactanos/contactanos.js"></script>

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
                                    <div class="icono-registro">🎒</div>
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
                                    <div class="icono-registro">⛰️</div>
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
                                    <div class="icono-registro">🏨</div>
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