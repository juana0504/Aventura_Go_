<?php session_start();
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

$actividadModel = new ActividadTuristica();
$actividades = $actividadModel->listarActividadesPublicas();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours y Aventura - Aventura Go</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fuentes Google -->
    <link
        href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/descubre_tours/descubreTours.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="/public/assets/dashboard/turista/descubre_tours/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">Descubre Todo lo que Villeta Tiene para Ofrecerte</h1>

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
                <a href="/aventura_go" class="btn-login">Atrás</a>
                <div class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="tabs-container">
                <button class="tab-btn active">TOURS Y AVENTURA</button>
                <a href="<?= BASE_URL ?>/descubre-hospedaje" class="tab-btn"> HOSPEDAJE </a>
            </div>

            <div class="search-filters">
                <div class="filters-row">
                    <div class="filter-item">
                        <i class="fas fa-calendar"></i>
                        <input type="text" placeholder="01 oct 2025 - 02 oct 2025" readonly>
                    </div>
                    <div class="filter-item">
                        <i class="fas fa-users"></i>
                        <input type="text" placeholder="02 Adultos - 01 Niño - 00 Bebés" readonly>
                    </div>
                    <div class="filter-item">
                        <i class="fas fa-car"></i>
                        <input type="text" placeholder="01" readonly>
                    </div>
                </div>
            </div>

            <!-- aca va las actividdes -->

            <div class="activities-grid">

                <?php if (!empty($actividades)): ?>
                    <?php foreach ($actividades as $actividad): ?>

                        <div class="activity-card">

                            <img
                                src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= $actividad['imagen'] ?>"
                                alt="<?= htmlspecialchars($actividad['nombre']) ?>"
                                class="activity-image">

                            <div class="activity-content">

                                <!-- Ciudad -->
                                <div class="activity-category">
                                    <?= htmlspecialchars($actividad['ciudad']) ?>
                                </div>

                                <!-- Nombre -->
                                <h3 class="activity-title">
                                    <?= htmlspecialchars($actividad['nombre']) ?>
                                </h3>

                                <!-- Descripción corta -->
                                <p class="activity-description">
                                    <?= substr(htmlspecialchars($actividad['descripcion']), 0, 90) ?>...
                                </p>

                                <!-- Cupos -->
                                <div class="activity-duration">
                                    <i class="fas fa-users"></i>
                                    <span><?=htmlspecialchars($actividad['cupos']) ?> cupos disponibles</span>
                                </div>

                                <!-- Precio -->
                                <div class="activity-price">
                                    <span class="price-label">Desde</span>
                                    <span class="price-current">
                                        $<?= number_format($actividad['precio'], 0, ',', '.') ?>
                                    </span>
                                </div>

                            </div>
                        </div>



                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay actividades disponibles.</p>
                <?php endif; ?>

            </div>



            <!-- barra de busqyeda -->
            <form class="search-banner" action="<?= BASE_URL ?>busqueda" method="GET">
                <div class="search-banner-text">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        name="q"
                        placeholder="¿Buscas alguna actividad específica?"
                        required>
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
                        <img src="../turista/img/LOGO-NEGATIVO.png" alt="logo Aventura Go">
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

    <script src="<?= BASE_URL ?>/public/assets/dashboard/turista/tour_escogido/tour_escogido.js"></script>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('navbarNav').classList.toggle('show');
        });
    </script>
</body>

</html>