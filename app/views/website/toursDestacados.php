<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Destacados - Aventura Go</title>
  <link rel="icon" type="image/png" href="public/assets/website_externos/index/img/FAVICON.png">
  <link rel="stylesheet" href="public/assets/website_externos/destacados/destacados.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->
  <header>
    <nav class="navbar">
      <div class="container">
        <a href="index.html" class="navbar-logo">
          <img src="public/assets/estilos_globales/img/LOGO-FINAL.png " width="150px"
            alt="Aventura Go" />
        </a>

        <!-- Menú principal -->
        <ul class="navbar-nav" id="navbarNav">
          <li><a class="nav-link" href="/aventura_go/">Inicio</a></li>
          <li><a class="nav-link active" href="/aventura_go/destacados">Destacados</a></li>
          <li><a class="nav-link" href="/aventura_go/acerca-de-nosotros">Acerca de nosotros</a></li>
          <li><a class="nav-link" href="/aventura_go/contactanos">Contáctanos</a></li>
        </ul>

        <div class="actions">
          <a href="login" class="btn-login">Ingresa</a>
          <a href="../extras/registrarse.html" class="btn-register">Regístrate</a>
        </div>
      </div>
    </nav>
  </header>

  <!-- SECCIÓN DESTACADOS -->
  <section class="hero-destacados">
    <div class="hero-overlay">
      <h1 class="titulo-hero">DESTACADOS</h1>
      <h2 class="subtitulo-hero">AVENTURA GO</h2>
    </div>
  </section>

  <!-- Barra de búsqueda dentro del banner, no se les olvide copiar el js, el css y las img para los iconos -->
  <div class="search-box fuera-hero">
    <div class="search-item">
      <i class="fas fa-map-marker-alt"></i>
      <div>
        <p>Ubicación</p>
        <input type="text" id="input-busqueda" placeholder="¿A dónde vas?" />
      </div>
    </div>

    <!-- DATEPICKER INTEGRADO -->
    <div class="search-item">
      <i class="fas fa-calendar-alt"></i>
      <div class="date-picker-container">
        <button id="openCalendarBtn" class="date-button" type="button" aria-haspopup="dialog" aria-expanded="false">
          <div>
            <p>Fecha</p>
            <span id="dateText">Fijar fecha</span>
          </div>
        </button>

        <div id="calendar" class="calendar hidden" role="dialog" aria-modal="false" aria-label="Selector de fechas">
          <div class="calendar-header">
            <button id="prevBtn" class="nav-btn" type="button" aria-label="Mes anterior">&laquo;</button>
            <div id="currentLabel" class="clickable" role="button" aria-pressed="false"></div>
            <button id="nextBtn" class="nav-btn" type="button" aria-label="Mes siguiente">&raquo;</button>
          </div>

          <div class="week-names calendar-grid" aria-hidden="true">
            <div>Do</div>
            <div>Lu</div>
            <div>Ma</div>
            <div>Mi</div>
            <div>Ju</div>
            <div>Vi</div>
            <div>Sá</div>
          </div>

          <div id="calendarDays" class="calendar-grid" aria-live="polite"></div>

          <div id="monthGrid" class="grid hidden" aria-hidden="true"></div>
          <div id="yearGrid" class="grid hidden" aria-hidden="true"></div>
        </div>
      </div>
    </div>

    <!-- CONTADOR DE INVITADOS INTEGRADO -->
    <div class="search-item">
      <i class="fas fa-user"></i>
      <div>
        <p>Invitados</p>
        <button id="openGuestCounter" class="guest-button" type="button">
          <span id="guestSummary">0 invitados, 0 habitación</span>
        </button>

        <!-- Panel desplegable del contador -->
        <div id="guestPanel" class="guest-panel hidden">
          <div class="contenedor-reservas">
            <div class="contenedor-blanco">
              <h2>Dinos quién se apunta</h2>

              <div class="grupo">
                <div class="info">
                  <div class="icono"><img src="public/assets/dashboard/turista/reserva/img/image 32 (1).png" alt="" />
                  </div>
                  <div>
                    <h3>Adultos</h3>
                    <p>14 años en adelante</p>
                  </div>
                </div>
                <div class="contador">
                  <button class="btn-menos" data-tipo="adultos">−</button>
                  <span class="valor" id="adultos">0</span>
                  <button class="btn-mas" data-tipo="adultos">+</button>
                </div>
              </div>

              <div class="grupo">
                <div class="info">
                  <div class="icono"><img src="public/assets/dashboard/turista/reserva/img/image 31 (1).png" alt="" />
                  </div>
                  <div>
                    <h3>Niños</h3>
                    <p>De 2 a 13 años</p>
                  </div>
                </div>
                <div class="contador">
                  <button class="btn-menos" data-tipo="ninos">−</button>
                  <span class="valor" id="ninos">0</span>
                  <button class="btn-mas" data-tipo="ninos">+</button>
                </div>
              </div>

              <div class="grupo">
                <div class="info">
                  <div class="icono"><img src="public/assets/dashboard/turista/reserva/img/image 33 (1).png" alt="" />
                  </div>
                  <div>
                    <h3>Bebés</h3>
                    <p>Menos de 2 años</p>
                  </div>
                </div>
                <div class="contador">
                  <button class="btn-menos" data-tipo="bebes">−</button>
                  <span class="valor" id="bebes">0</span>
                  <button class="btn-mas" data-tipo="bebes">+</button>
                </div>
              </div>

              <div class="grupo">
                <div class="info">
                  <div class="icono"><img src="public/assets/dashboard/turista/reserva/img/image 34 (1).png" alt="" />
                  </div>
                  <div>
                    <h3>Mascotas</h3>
                    <p>¿Tienes animal de servicio?</p>
                  </div>
                </div>
                <div class="contador">
                  <button class="btn-menos" data-tipo="mascotas">−</button>
                  <span class="valor" id="mascotas">0</span>
                  <button class="btn-mas" data-tipo="mascotas">+</button>
                </div>
              </div>
            </div>

            <!-- Franja azul separadora -->
            <div class="franja-azul"></div>

            <!-- Sección Habitaciones -->
            <div class="contenedor-blanco habitaciones">
              <div class="grupo">
                <div class="info">
                  <div class="icono"><img src="public/assets/dashboard/turista/reserva/img/image 48 (1).png" alt="" />
                  </div>
                  <div>
                    <h3>Habitaciones</h3>
                  </div>
                </div>
                <div class="contador">
                  <button class="btn-menos" data-tipo="habitaciones">−</button>
                  <span class="valor" id="habitaciones">0</span>
                  <button class="btn-mas" data-tipo="habitaciones">+</button>
                </div>
              </div>
            </div>

            <!-- Franja azul inferior -->
            <div class="franja-azul"></div>

            <!-- Zona de resumen -->
            <div class="resumen">
              <p id="resumen-texto">
                Total: 0 personas (0 adultos, 0 niño), 0 mascota | Total Habitaciones: 0
              </p>
              <button id="btn-confirmar">Confirmar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button class="btn-buscar">
      <i class="fas fa-search"></i> Buscar
    </button>
  </div>



  <section id="tours-populares" class="tours-populares">
    <h2>Tours populares</h2>
    <div id="contenedor-tours" class="contenedor-tours"></div>
  </section>



  <section class="ofertas-temporada">
    <div class="contenedor-ofertas">
      <h2>OFERTAS DE TEMPORADA</h2>
      <p class="descripcion">
        Aprovecha nuestras ofertas de temporada y vive la aventura al mejor
        precio. Descubre promociones especiales en actividades y destinos
        seleccionados para que disfrutes más por menos.
      </p>

      <div class="grid-ofertas">
        <!-- Tarjeta 1 -->
        <div class="tarjeta-oferta">
          <div class="imagen-oferta">
            <img src="public/assets/website_externos/destacados/img/img.png" alt="Villeta glamping" />
            <span class="etiqueta">Más vendido</span>
          </div>
          <div class="contenido-oferta">
            <h3>Villeta cundinamarca, glamping</h3>
            <p>caminata ecológica, visita cascadas naturales</p>
            <div class="info-extra">
              <p>⭐
              <p>4.8</p> (1 Review)</p>
              <p>🕒 2 Días 1 Noche</p>
            </div>
            <p class="precio">
              <span class="tachado">$1.920.000</span>
            <p>$1.500.000</p>
            </p>
          </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="tarjeta-oferta">
          <div class="imagen-oferta">
            <img src="public/assets/website_externos/destacados/img/Frame 34.png" alt="Sasaima cabañas" />
          </div>
          <div class="contenido-oferta">
            <h3>Sasaima cundinamarca</h3>
            <p>Disfruta cabañas equipadas y paseo a caballo</p>
            <div class="info-extra">
              <p>⭐
              <p>4.7</p> (1 Review)</p>
              <p>🕒 3 Días, 2 Noches</p>
            </div>
            <p class="precio">From
            <p>$1.670.000</p>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="footer" class="container-fluid">
    <div class="footer-top">
      <div class="row align-items-center">
        <div class="col-md-12">
          <h2 class="palpitando">¿Quieres que tu negocio aparezca aquí?</h2>
          <a href="/website_externos/contactanos.html">Publicate en Aventura Go</a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="row">
        <div class="col-md-2">
          <div class="logo-section">
            <img src="public/assets/estilos_globales/img/LOGO-FINAL.png" width="150px" alt="logo Aventura Go" />
          </div>
        </div>
        <div class="col-md-2">
          <p class="description">
            Aventura Go conecta viajeros con experiencias de aventura,
            promoviendo el turismo sostenible y apoyando a prestadores locales en destinos naturales."
          </p>
        </div>
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
        <div class="col-md-2">
          <h5 class="contacto-section">Contactos</h5>
          <ul class="list-unstyled contact-list">
            <li><i class="fas fa-phone"></i><span> 321 2263435</span></li>
            <li>
              <i class="fas fa-envelope"></i><span> aventurago2025@gmail.com</span>
            </li>
            <li>
              <i class="fas fa-map-marker-alt"></i><span> Villeta Cundinamarca</span>
            </li>
          </ul>
        </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="public/assets/website_externos/destacados/destacados.js"></script>
</body>

</html>