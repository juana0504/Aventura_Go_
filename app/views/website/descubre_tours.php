<?php


require_once BASE_PATH . '/app/controllers/website/websiteController.php';

$actividadModel = new ActividadTuristica();
$q      = trim($_GET['q'] ?? '');
$ciudad = $_GET['ciudad'] ?? null;

if ($q !== '') {
    $actividades = $actividadModel->buscarPublicos($q);
} elseif ($ciudad) {
    $actividades = $actividadModel->obtenerPorCiudad($ciudad);
} else {
    $actividades = $actividadModel->listarActividadesPublicas();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours y Aventura - Aventura Go</title>

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fuentes Google -->
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/descubreTours.css">
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
                    <a href="<?= BASE_URL ?>descubre-tours" class="nav-pill active">
                        <i class="bi bi-compass-fill"></i> Tours
                    </a>
                    <a href="<?= BASE_URL ?>descubre-hospedaje" class="nav-pill">
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
                <a class="tab-btn active" href="<?= BASE_URL ?>descubre-tours">
                    <i class="bi bi-compass tab-icon"></i> Tours y Aventura
                </a>
                <a class="tab-btn" href="<?= BASE_URL ?>descubre-hospedaje">
                    <i class="bi bi-house-heart tab-icon"></i> Hospedaje
                </a>
            </div>

            <!-- Banner informativo con buscador -->
            <div class="tab-intro">
                <div class="tab-intro__icon"><i class="bi bi-compass"></i></div>
                <div style="flex:1">
                    <h2 class="tab-intro__title">Explora nuestros tours y aventuras</h2>
                    <p class="tab-intro__text">Elige la actividad que más te emocione, selecciona una fecha disponible y reserva tu lugar en minutos.</p>
                    <form class="tab-intro__search" action="<?= BASE_URL ?>descubre-tours" method="GET">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Busca por ciudad o actividad...">
                        <?php if ($q !== ''): ?>
                            <a class="tab-intro__clear" href="<?= BASE_URL ?>descubre-tours"><i class="bi bi-x-circle-fill"></i></a>
                        <?php endif; ?>
                        <button type="submit">Buscar</button>
                    </form>
                </div>
            </div>

            <!-- aca va las actividades -->
            <div class="activities-grid">

                <?php if (!empty($actividades)): ?>
                    <?php foreach ($actividades as $actividad): ?>

                        <div class="activity-card">

                            <img
                                src="<?= !empty($actividad['imagen']) ? BASE_URL . 'public/uploads/turistico/actividades/' . rawurlencode($actividad['imagen']) : BASE_URL . 'public/assets/website_externos/descubre_tours/img/imagen%20tour.png' ?>"
                                alt="<?= htmlspecialchars($actividad['nombre']) ?>"
                                class="activity-image"
                                onerror="this.onerror=null;this.src='<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/imagen%20tour.png'">

                            <div class="activity-content">

                                <!-- Ciudad -->
                                <div class="activity-category">
                                    <h6>ubicación</h6>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span> <?= htmlspecialchars($actividad['ciudad']) ?></span>
                                </div>

                                <!-- Nombre -->
                                <h3 class="activity-title">
                                    <?= htmlspecialchars($actividad['nombre']) ?>
                                </h3>

                                <!-- Descripción corta -->
                                <p class="activity-description">
                                    <i class="bi bi-card-heading"></i>
                                    <?= substr(htmlspecialchars($actividad['descripcion']), 0, 90) ?>...
                                </p>

                                <!-- Cupos -->
                                <div class="activity-duration">
                                    <i class="fas fa-users"></i>
                                    <span><?= (int)$actividad['cupos'] ?> cupos disponibles</span>
                                </div>

                                <!-- Precio -->
                                <div class="activity-price">
                                    <span class="price-label">Desde</span>
                                    <span class="price-current">
                                        $<?= number_format($actividad['precio'], 0, ',', '.') ?>
                                    </span>
                                </div>

                                <div class="button">
                                    <button class="btn-resenas"
                                        data-id="<?= $actividad['id_actividad'] ?>"
                                        data-nombre="<?= htmlspecialchars($actividad['nombre']) ?>">
                                        <i class="bi bi-star-fill"></i> Reseñas
                                    </button>
                                    <a href="<?= BASE_URL ?>tour-escogido?id=<?= $actividad['id_actividad'] ?>" class="btn-ver-mas">
                                        Ver más
                                    </a>
                                </div>


                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay actividades disponibles.</p>
                <?php endif; ?>

            </div>



            <!-- barra de busqyeda -->
            <!-- <form class="search-banner" action="<?= BASE_URL ?>busqueda" method="GET">
                <div class="search-banner-text">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="¿Buscas alguna actividad específica?" required>
                </div>

                <button type="submit" class="search-banner-btn">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </form> -->

        </div>
    </main>

    <!-- F O O T E R_____________________________________________________________________________________________________________________________ -->
    <footer id="footer">

        <div class="container-fluid">
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
        </div>
    </footer>



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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- MODAL RESEÑAS PÚBLICAS -->
    <div class="modal fade" id="modalResenasPublico" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content dt-resenas-modal">

                <div class="dt-resenas-modal__header">
                    <div>
                        <div class="dt-resenas-modal__eyebrow"><i class="bi bi-star-fill"></i> Opiniones de turistas</div>
                        <h5 class="dt-resenas-modal__titulo" id="dt-resenas-titulo">—</h5>
                    </div>
                    <button class="dt-resenas-modal__close" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="modal-body dt-resenas-modal__body" id="dt-resenas-body">
                    <div class="dt-resenas-loading">
                        <div class="spinner-border" role="status" style="color:var(--color-secondary)"></div>
                        <span>Cargando reseñas…</span>
                    </div>
                </div>

                <div class="dt-resenas-modal__footer">
                    <button data-bs-dismiss="modal" class="dt-resenas-modal__btn-cerrar">
                        <i class="bi bi-arrow-left"></i> Cerrar
                    </button>
                    <span id="dt-resenas-promedio" class="dt-resenas-avg"></span>
                </div>

            </div>
        </div>
    </div>
    <!-- FIN MODAL RESEÑAS -->

    <script>
        const BASE_URL = '<?= BASE_URL ?>';

        (function() {
            const modalEl = document.getElementById('modalResenasPublico');
            const modalBS = new bootstrap.Modal(modalEl);
            const modalTitulo = document.getElementById('dt-resenas-titulo');
            const modalBody = document.getElementById('dt-resenas-body');
            const modalProm = document.getElementById('dt-resenas-promedio');

            function estrellas(n) {
                n = parseInt(n, 10) || 0;
                return Array.from({
                        length: 5
                    }, (_, i) =>
                    `<i class="bi bi-star${i < n ? '-fill' : ''} dt-star${i < n ? ' dt-star--on' : ''}"></i>`
                ).join('');
            }

            document.querySelectorAll('.btn-resenas').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const nombre = btn.dataset.nombre;

                    modalTitulo.textContent = nombre;
                    modalProm.textContent = '';
                    modalBody.innerHTML = '<div class="dt-resenas-loading"><div class="spinner-border" style="color:var(--color-secondary)" role="status"></div><span>Cargando…</span></div>';
                    modalBS.show();

                    fetch(`${BASE_URL}tours/resenas?id=${id}`)
                        .then(r => {
                            if (!r.ok) throw new Error('red');
                            return r.json();
                        })
                        .then(data => {
                            if (!data.ok) {
                                modalBody.innerHTML = '<div class="dt-resenas-empty"><i class="bi bi-exclamation-circle"></i><p>No se pudieron cargar las reseñas.</p></div>';
                                return;
                            }
                            const resenas = data.resenas;
                            if (!resenas.length) {
                                modalBody.innerHTML = '<div class="dt-resenas-empty"><i class="bi bi-chat-square-text"></i><p>Esta actividad aún no tiene reseñas.</p></div>';
                                return;
                            }

                            const sum = resenas.reduce((a, r) => a + parseInt(r.calificacion, 10), 0);
                            const avg = (sum / resenas.length).toFixed(1);
                            modalProm.innerHTML = `${estrellas(Math.round(avg))} <strong>${avg}</strong> / 5 &nbsp;(${resenas.length} reseña${resenas.length !== 1 ? 's' : ''})`;

                            modalBody.innerHTML = resenas.map(r => `
                                <div class="dt-resena-card">
                                    <div class="dt-resena-card__top">
                                        <div class="dt-resena-card__avatar">${(r.nombre_turista || '?').charAt(0).toUpperCase()}</div>
                                        <div class="dt-resena-card__info">
                                            <div class="dt-resena-card__nombre">${r.nombre_turista || 'Turista'}</div>
                                            <div class="dt-resena-card__fecha">${r.fecha ? r.fecha.slice(0, 10) : ''}</div>
                                        </div>
                                        <div class="dt-resena-card__estrellas">${estrellas(r.calificacion)}</div>
                                    </div>
                                    ${r.comentario ? `<p class="dt-resena-card__comentario">${r.comentario}</p>` : ''}
                                </div>
                            `).join('');
                        })
                        .catch(() => {
                            modalBody.innerHTML = '<div class="dt-resenas-empty"><i class="bi bi-wifi-off"></i><p>Error de conexión.</p></div>';
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