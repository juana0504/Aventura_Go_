<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Destacados - Aventura Go</title>

  <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">

  <!-- bootstrap para el carrusel -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- bootstrap primero -->
  <link href="path/to/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/destacados/destacados.css">

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
          <li><a class="nav-link" href="<?= BASE_URL ?>">Inicio</a></li>
          <li><a class="nav-link active" href="<?= BASE_URL ?>destacados">Destacados</a></li>
          <li><a class="nav-link" href="<?= BASE_URL ?>acerca-de-nosotros">Acerca de nosotros</a></li>
          <li><a class="nav-link" href="<?= BASE_URL ?>contactanos">Contáctanos</a></li>
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


  <!-- SECCIÓN DESTACADOS -->
  <section id="hero">

    <div class="container-fluid">

      <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">

        <div class="carousel-inner">

          <div class="carousel-item active">
            <img src="<?= BASE_URL ?>public/assets/website_externos/destacados/img/image_11.png" class="d-block w-100"
              alt="Turismo en bote">
            <div class="carousel-caption">
              <h1>Tours destacados</h1>

              <p class="parrafo1">Embárcate en rutas llenas de adrenalina, cultura y naturaleza que te
                harán vibrar.</p>
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
                  <div class="icono"><img src="<?= BASE_URL ?>public/assets/dashboard/turista/reserva/img/image 32 (1).png" alt="" />
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
                  <div class="icono"><img src="<?= BASE_URL ?>public/assets/dashboard/turista/reserva/img/image 31 (1).png" alt="" />
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
                  <div class="icono"><img src="<?= BASE_URL ?>public/assets/dashboard/turista/reserva/img/image 33 (1).png" alt="" />
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
                  <div class="icono"><img src="<?= BASE_URL ?>public/assets/dashboard/turista/reserva/img/image 34 (1).png" alt="" />
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
                  <div class="icono"><img src="<?= BASE_URL ?>public/assets/dashboard/turista/reserva/img/image 48 (1).png" alt="" />
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
            <img src="<?= BASE_URL ?>public/assets/website_externos/destacados/img/img.png" alt="Villeta glamping" />
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
            <img src="<?= BASE_URL ?>public/assets/website_externos/destacados/img/Frame 34.png" alt="Sasaima cabañas" />
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="<?= BASE_URL ?>public/assets/website_externos/destacados/destacados.js"></script>

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