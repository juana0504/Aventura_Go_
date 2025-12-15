<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - contactanos</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/index/img/FAVICON.png">

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
            <div class="container">
                <!-- Logo -->
                <div class="logo">
                    <img src="public/assets/website_externos/contactanos/img/LOGO-FINAL.png" width="150px" alt="Logo Aventura Go"
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
                    <div class="actions">
                        <a href="login" class="btn-login">Ingresa</a>
                        <a href="registrarse" class="btn-register">Regístrate</a>

                        <!-- menu hambirguesa en responsive -->
                        <div class="menu-toggle" id="menu-toggle" aria-label="Abrir menú">
                            <i class="fas fa-bars"></i>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
    </header>


    <!-- HERO CONTACTANOS_______________________________________________________________________________________________ -->
    <section id="hero-contactanos">

        <div class="container-fluid">

            <div class="row hero-img">
                <div class="col-12 header-arriba">
                    <img src="public/assets/website_externos/contactanos/img/contactanos_1.jpeg" alt="img contactanos">
                    <h1 class="palpitando">CONTACTANOS</h1>
                </div>
            </div>

            <div class="row hero-info">
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
    </section>



    <!-- SECCIÓN FORMULARIO DE CONTACTO -->
    <div id="formulario">

        <div class="container">

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
                                <input type="text" id="nombre" placeholder="Ej: María Pérez" required>
                            </div>
                            <div class="campo">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" placeholder="Ej: +57 320 123 4567" required>
                            </div>
                        </div>

                        <!-- SEGUNDA FILA - 2 COLUMNAS -->
                        <div class="fila-campos">
                            <div class="campo">
                                <label for="email">Email</label>
                                <input type="email" id="email" placeholder="Ej: sucorreo@correo.com" required>
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
                                <textarea id="mensaje" rows="4" placeholder="Ej: El siguiente mensaje es para..."
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
    </div>



    <!-- seccion mapa -->
    <section id="mapa" class="mapa-section">
        <h2>Encuéntranos fácilmente</h2>
        <div class="mapa-contenedor">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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
                        <a href="../index.html">Publicate en Aventura Go</a>
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



    <!-- JavaScript de Slick -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- aos animate -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="public/assets/website_externos/contactanos/contactanos.js"></script>


</body>

</html>