<?php
require_once BASE_PATH . '/app/models/proveedor_hotelero/hospedaje.php';

$hospedajeModel = new Hospedaje();
$q      = trim($_GET['q'] ?? '');
$ciudad = $_GET['ciudad'] ?? null;
if ($q !== '') {
    $actividades = $hospedajeModel->buscarPublicos($q);
} elseif ($ciudad) {
    $actividades = $hospedajeModel->listarPublicosPorCiudad($ciudad);
} else {
    $actividades = $hospedajeModel->listarPublicos();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Descubre Tu Hospedaje</title>

  <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Fuentes Google -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/hospedaje_vega/hospedajeVega.css">

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

        <!-- Nav center -->
        <div class="navbar-center">
            <a href="<?= BASE_URL ?>" class="nav-pill">
                <i class="bi bi-house-door-fill"></i> Inicio
            </a>
            <a href="<?= BASE_URL ?>descubre-tours" class="nav-pill">
                <i class="bi bi-compass-fill"></i> Tours
            </a>
            <a href="<?= BASE_URL ?>descubre-hospedaje" class="nav-pill active">
                <i class="bi bi-house-heart-fill"></i> Hospedaje
            </a>
            <a href="<?= BASE_URL ?>contactanos" class="nav-pill">
                <i class="bi bi-chat-dots-fill"></i> Contáctanos
            </a>
        </div>

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


  <main class="main-content">
    <div class="container">
      <div class="tabs-container">
        <a class="tab-btn" href="<?= BASE_URL ?>descubre-tours">
            <i class="bi bi-compass tab-icon"></i> Tours y Aventura
        </a>
        <a class="tab-btn active" href="<?= BASE_URL ?>descubre-hospedaje">
            <i class="bi bi-house-heart tab-icon"></i> Hospedaje
        </a>
      </div>

      <!-- Banner informativo con buscador -->
      <div class="tab-intro">
          <div class="tab-intro__icon"><i class="bi bi-house-heart"></i></div>
          <div style="flex:1">
              <h2 class="tab-intro__title">Encuentra tu lugar de descanso ideal</h2>
              <p class="tab-intro__text">Explora hoteles, hostales, cabañas y glamping disponibles en cada destino.</p>
              <form class="tab-intro__search" action="<?= BASE_URL ?>descubre-hospedaje" method="GET">
                  <i class="bi bi-search"></i>
                  <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Busca por ciudad u hospedaje...">
                  <?php if ($q !== ''): ?>
                      <a class="tab-intro__clear" href="<?= BASE_URL ?>descubre-hospedaje"><i class="bi bi-x-circle-fill"></i></a>
                  <?php endif; ?>
                  <button type="submit">Buscar</button>
              </form>
          </div>
      </div>

      <!-- hospedajes disponibles -->
      <div class="activities-grid">

        <?php if (!empty($actividades)): ?>
          <?php foreach ($actividades as $actividad): ?>

            <?php
              $cuposReservados = (int)($actividad['cupos_reservados'] ?? 0);
              $capacidadTotal  = (int)($actividad['capacidad'] ?? 0);
              $agotado         = $cuposReservados >= $capacidadTotal && $capacidadTotal > 0;

              $imgCard = $actividad['imagen_card'] ?? $actividad['imagen'] ?? '';
              if (!empty($imgCard) && $imgCard !== 'hospedaje_default.png') {
                  $imgSrc = BASE_URL . 'public/uploads/hotelero/actividades/' . rawurlencode($imgCard);
              } elseif (!empty($actividad['logo'])) {
                  $imgSrc = BASE_URL . 'public/uploads/hoteles/' . rawurlencode($actividad['logo']);
              } else {
                  $imgSrc = BASE_URL . 'public/assets/website_externos/index/img/LOGO-FINAL.png';
              }
            ?>
            <div class="activity-card<?= $agotado ? ' activity-card--agotado' : '' ?>">

              <div style="position:relative;">
                <img
                  src="<?= $imgSrc ?>"
                  alt="<?= htmlspecialchars($actividad['nombre']) ?>"
                  class="activity-image"
                  onerror="this.src='<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png'">
                <?php if ($agotado): ?>
                  <span style="position:absolute;top:10px;right:10px;background:#e53e3e;color:#fff;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;letter-spacing:.5px;">AGOTADO</span>
                <?php elseif (!empty($actividad['tipo'])): ?>
                  <span style="position:absolute;top:10px;left:10px;background:rgba(45,64,89,.8);color:#fff;font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;"><?= htmlspecialchars($actividad['tipo']) ?></span>
                <?php endif; ?>
              </div>

              <div class="activity-content">

                <!-- Establecimiento -->
                <?php if (!empty($actividad['nombre_establecimiento'])): ?>
                <div style="font-size:11px;font-weight:700;color:#EA8217;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">
                  <i class="bi bi-building"></i> <?= htmlspecialchars($actividad['nombre_establecimiento']) ?>
                </div>
                <?php endif; ?>

                <!-- Ciudad -->
                <div class="activity-category">
                  <h6>ubicación</h6>
                  <i class="bi bi-geo-alt-fill"></i>
                  <span> <?= htmlspecialchars($actividad['ciudad']) ?></span>
                </div>

                <!-- Nombre unidad -->
                <h3 class="activity-title">
                  <?= htmlspecialchars($actividad['nombre']) ?>
                </h3>

                <!-- Descripción corta -->
                <p class="activity-description">
                  <i class="bi bi-card-heading"></i>
                  <?= substr(htmlspecialchars($actividad['descripcion']), 0, 90) ?>...
                </p>

                <!-- Disponibilidad -->
                <div class="activity-duration">
                  <i class="fas fa-users"></i>
                  <?php if ($agotado): ?>
                    <span style="color:#e53e3e;font-weight:600;">Sin disponibilidad próxima</span>
                  <?php else: ?>
                    <span><?= $capacidadTotal ?> personas máx.</span>
                  <?php endif; ?>
                </div>

                <!-- Precio -->
                <div class="activity-price">
                  <span class="price-label">Desde</span>
                  <span class="price-current">
                    $<?= number_format($actividad['precio'], 0, ',', '.') ?>
                  </span>
                  <span style="font-size:11px;color:#6b7280;margin-left:2px;">/ noche</span>
                </div>

                <!-- Botones -->
                <div class="button">
                  <button class="btn-resenas"
                      data-id="<?= $actividad['id_hospedaje'] ?>"
                      data-nombre="<?= htmlspecialchars($actividad['nombre']) ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#modalResenasHospedaje">
                      <i class="bi bi-star-fill"></i> Reseñas
                  </button>
                  <a href="<?= BASE_URL ?>hospedaje-escogido?id=<?= $actividad['id_hospedaje'] ?>" class="btn-ver-mas">
                      <?= $agotado ? 'Ver fechas' : 'Reservar' ?>
                  </a>
                </div>

              </div>
            </div>

          <?php endforeach; ?>
        <?php else: ?>
          <p>No hay hospedajes disponibles.</p>
        <?php endif; ?>

      </div>



      <!-- barra de busqyeda -->
      <form class="search-banner" action="<?= BASE_URL ?>busqueda" method="GET">
        <div class="search-banner-text">
          <i class="fas fa-search"></i>
          <input type="text" name="q" placeholder="¿Buscas alguna actividad específica?" required>
        </div>

        <button type="submit" class="search-banner-btn">
          <i class="fas fa-search"></i>
          Buscar
        </button>
      </form>

    </div>
  </main>

  <!-- F O O T E R_____________________________________________________________________________________________________________________________ -->
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
            <img src="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png" alt="logo Aventura Go">
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

          

  <!-- MODAL RESEÑAS HOSPEDAJE -->
  <div class="modal fade" id="modalResenasHospedaje" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content dt-resenas-modal">
        <div class="dt-resenas-modal__header">
          <div>
            <div class="dt-resenas-modal__eyebrow"><i class="bi bi-star-fill"></i> Opiniones de turistas</div>
            <h5 class="dt-resenas-modal__titulo" id="dt-resenas-hosp-titulo">—</h5>
          </div>
          <button class="dt-resenas-modal__close" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body dt-resenas-modal__body" id="dt-resenas-hosp-body">
          <div class="dt-resenas-loading">
            <div class="spinner-border" role="status" style="color:#EA8217"></div>
            <span>Cargando reseñas…</span>
          </div>
        </div>
        <div class="dt-resenas-modal__footer">
          <button data-bs-dismiss="modal" class="dt-resenas-modal__btn-cerrar"><i class="bi bi-arrow-left"></i> Cerrar</button>
          <span id="dt-resenas-hosp-promedio" class="dt-resenas-avg"></span>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const BASE_URL = '<?= BASE_URL ?>';
    (function () {
      const modalTitulo = document.getElementById('dt-resenas-hosp-titulo');
      const modalBody   = document.getElementById('dt-resenas-hosp-body');
      const modalProm   = document.getElementById('dt-resenas-hosp-promedio');

      function estrellas(n) {
        n = parseInt(n, 10) || 0;
        return Array.from({length: 5}, (_, i) =>
          `<i class="bi bi-star${i < n ? '-fill' : ''}" style="color:${i < n ? '#f59e0b' : '#d1d5db'}"></i>`
        ).join('');
      }

      document.querySelectorAll('.btn-resenas').forEach(btn => {
        btn.addEventListener('click', () => {
          const id     = btn.dataset.id;
          const nombre = btn.dataset.nombre;
          modalTitulo.textContent = nombre;
          modalProm.textContent   = '';
          modalBody.innerHTML     = '<div class="dt-resenas-loading"><div class="spinner-border" style="color:#EA8217" role="status"></div><span>Cargando…</span></div>';

          fetch(`${BASE_URL}hospedaje/resenas?id=${id}`)
            .then(r => { if (!r.ok) throw new Error('red'); return r.json(); })
            .then(data => {
              if (!data.ok || !data.resenas.length) {
                modalBody.innerHTML = '<div class="dt-resenas-empty" style="text-align:center;padding:32px;color:#6b7280"><i class="bi bi-chat-square-text" style="font-size:32px;display:block;margin-bottom:12px"></i><p>Este hospedaje aún no tiene reseñas.</p></div>';
                return;
              }
              const sum = data.resenas.reduce((a, r) => a + parseInt(r.calificacion, 10), 0);
              const avg = (sum / data.resenas.length).toFixed(1);
              modalProm.innerHTML = `${estrellas(Math.round(avg))} <strong>${avg}</strong>/5 (${data.resenas.length} reseña${data.resenas.length !== 1 ? 's' : ''})`;
              modalBody.innerHTML = data.resenas.map(r => `
                <div class="dt-resena-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;margin-bottom:12px">
                  <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                    <div style="width:36px;height:36px;border-radius:50%;background:#2D4059;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px">
                      ${(r.nombre_turista || '?').charAt(0).toUpperCase()}
                    </div>
                    <div>
                      <div style="font-weight:600;font-size:14px;color:#111">${r.nombre_turista || 'Turista'}</div>
                      <div style="font-size:12px;color:#9ca3af">${r.fecha ? r.fecha.slice(0,10) : ''}</div>
                    </div>
                    <div style="margin-left:auto">${estrellas(r.calificacion)}</div>
                  </div>
                  ${r.comentario ? `<p style="font-size:14px;color:#374151;margin:0">${r.comentario}</p>` : ''}
                </div>
              `).join('');
            })
            .catch(() => {
              modalBody.innerHTML = '<div style="text-align:center;padding:32px;color:#6b7280"><i class="bi bi-wifi-off" style="font-size:28px;display:block;margin-bottom:10px"></i><p>Error de conexión.</p></div>';
            });
        });
      });
    })();
  </script>

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