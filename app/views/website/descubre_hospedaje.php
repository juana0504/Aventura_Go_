<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Descubre Tu Hospedaje</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../../assets/dashboard/turista/hospedaje_vega/hospedajeVega.css">
</head>

<body>

  <!-- HEADER -->
  <header>
    <nav class="navbar">
      <div class="container">
        <img src="../../assets/dashboard/turista/hospedaje_vega/img/LOGO-FINAL copy.png" alt="Logo Aventura Go" class="navbar-logo">
        <ul class="navbar-nav">
          <li><a href="#" class="nav-link active">Tours y Aventura</a></li>
          <li><a href="#" class="nav-link">Hospedaje</a></li>
        </ul>

        <div class="actions">

          <?php if (isset($_SESSION['user'])): ?>

            <span class="Bienvenido">
              Bienvenido, <?= htmlspecialchars($_SESSION['user']['nombre']) ?>
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
        <button class="principal">Atrás</button>

      </div>
    </nav>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="container hospedaje-container">
    <h2 class="titulo-seccion text-center mt-5">Descubre tu hospedaje</h2>

    <!-- Filtros -->
    <div class="filtros mt-4 d-flex flex-wrap justify-content-center gap-3">
      <input type="text" id="buscador" class="form-control buscador" placeholder="Buscar hospedaje específico...">
      <button class="secundario" id="btnBuscar">Buscar</button>
    </div>

    <div class="tabs-container">
      <a href="<?= BASE_URL ?>/descubre-tours" class="tab-btn"> TOURS Y AVENTURA </a>
      <a href="<?= BASE_URL ?>/descubre-hospedaje" class="tab-btn"> HOSPEDAJE </a>
    </div>

    <!-- Tarjetas dinámicas -->
    <div id="contenedorHospedajes" class="contenedor-grid mt-5"></div>
  </main>

  <!-- MODAL -->

  <div class="modal fade" id="modalHospedaje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitulo"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img id="modalImagen" class="img-fluid rounded mb-3" alt="Imagen hospedaje">
          <p id="modalDescripcion"></p>
          <ul>
            <li>Noches: <span id="modalNoches"></span></li>
            <li>Días: <span id="modalDias"></span></li>
            <li>Precio: $<span id="modalPrecio"></span></li>
          </ul>
        </div>
        <div class="modal-footer">
          <a href="hospedaje_escogido.html"><button class="secundario" id="btnReservar">Más Información</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- F O O T E R_____________________________________________________________________________________________________________________________ -->
  <footer id="footer" class="container-fluid">

    <!-- footer superior -->
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
            <img src="/assets/estilos_globales/img/LOGO-FINAL copy.png" alt="logo Aventura Go">
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


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="../../assets/dashboard/turista/hospedaje_vega/hospedajeVega.js"></script>
</body>

</html>