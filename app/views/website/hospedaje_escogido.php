<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospedaje Escogido</title>

    <link rel="shortcut icon" href="../../assets/dashboard/turista/hospedaje_escogido/img/FAVICON.png">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="public/assets/website_externos/hospedaje_escogido/hospedaje_escogido.css">


</head>

<body>

    <header>
        <nav class="navbar">
            <div class="container">
                <img src="../../assets/dashboard/turista/hospedaje_escogido/img/LOGO-FINAL.png" alt="Logo Aventura Go"
                    class="navbar-logo">
                <ul class="navbar-nav">
                    <h1>Tu hospedaje en la vega</h1>
                </ul>

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
            </div>
        </nav>
    </header>




    <main>
        <section id="info">

            <div class="container">

                <div class="targeta">

                    <div class="row">

                        <div class="col-md-6 detalle">
                            <h2>Hotel luxury resort la Vega</h2>
                            <span>20% off</span>

                            <p id="direccion"><i class="bi bi-geo-alt"></i> Dg. 2 Sur #11a-65, La Vega, Cundinamarca, 253610 Villeta, Colombia <br></p>
                            <p>Después de reservar, encontrarás todos los datos del alojamiento con el número de
                                teléfono y
                                la
                                <br>
                                dirección en tu confirmación de la reserva y en tu cuenta.
                            </p>
                        </div>

                        <div class="col-md-6 datos">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <samp>(120 Review)</samp>

                            <p><i class="bi bi-clock"></i>1 Noche, 2 Dias</p>
                            <p><samp>From$325000</samp>$282000</p>
                        </div>
                    </div>


                    <div class="imagenes">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp1.png" alt="">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp2.png" alt="">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp3.png" alt="">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp4.png" alt="">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp5.png" alt="">
                        <img src="../../assets/dashboard/turista/hospedaje_escogido/img/hosp6.png" alt="">
                    </div>



                    <div class="dato">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda molestiae quas illum odit
                            maiores
                            facilis laudantium quidem blanditiis, perspiciatis, perferendis neque libero iste architecto ab,
                            voluptatem aut optio fugit quo. Voluptate ea maiores veniam est quo, totam qui quia? Explicabo
                            sequi
                            nostrum mollitia, asperiores omnis assumenda illo atque numquam. Veritatis necessitatibus
                            voluptatibus
                        </p>
                    </div>


                    <!-- seccion mapa -->
                    <div id="mapa" class="mapa-section">
                        <div class="mapa-contenedor">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.166972063625!2d-74.472745125039!3d5.013951139904496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4067dfb5f1a3e7%3A0xeca58a4d9a0f72cb!2sVilleta%2C%20Cundinamarca!5e0!3m2!1ses!2sco!4v1690391856678!5m2!1ses!2sco"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>


    <!-- Footer -->
    <footer id="footer">

        <div class="container-fluid">
            <div class="footer-top">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h2 class="palpitando">¿Quieres que tu negocio aparezca aquí?</h2>
                        <a href="website_externos/contactanos.html">Publicate en Aventura Go</a>
                    </div>
                </div>
            </div>

            <!-- Footer Inferior -->
            <div class="footer-bottom">
                <div class="row">

                    <!-- Columna 1: Logo -->
                    <div class="col-md-2">
                        <div class="logo-section">
                            <img src="../../assets/dashboard/turista/hospedaje_escogido/img/LOGO-FINAL.png"
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>