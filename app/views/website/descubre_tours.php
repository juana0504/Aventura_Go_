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

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/turista/tour_escogido/tour-escogido.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="/public/assets/turista/tour_escogido/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">Descubre Todo lo que Villeta Tiene para Ofrecerte</h1>

                <div class="actions">
                    <a href="#" class="btn-login">Atrás</a>
                    <div class="menu-toggle" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="tabs-container">
                <button class="tab-btn active">TOURS Y AVENTURA</button>
                <button class="tab-btn">HOSPEDAJE</button>
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

            <div class="activities-grid">
                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?w=400&h=300&fit=crop"
                        alt="Cabalgata en Villeta" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">villeta</div>
                        <h3 class="activity-title">Explora y disfruta del campo a caballo en villeta</h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>2 días, 1 noche</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-current">$450.000</span>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1571942676516-bcab84649e44?w=400&h=300&fit=crop"
                        alt="Represa natural" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">Villeta</div>
                        <h3 class="activity-title">Conoce una represa natural y disfruta un buen sancocho en villeta
                        </h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>Pasadía</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-current">$130.000</span>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop"
                        alt="Vías del tren" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">Villeta</div>
                        <h3 class="activity-title">Explora las vías del tren y disfruta de la naturaleza en villeta</h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>Pasadía</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-original">$95.000</span>
                            <span class="price-current">$95.000</span>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?w=400&h=300&fit=crop"
                        alt="Piscina Villeta" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">Pasadía</div>
                        <h3 class="activity-title">Pasadía en villeta, transporte desde bogotá</h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>Pasadía</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-original">$120.000</span>
                            <span class="price-current">$120.000</span>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=300&fit=crop"
                        alt="Puente tibetano" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">villeta</div>
                        <h3 class="activity-title">Vive la experiencia del puente tibetano en villeta</h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★☆</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>2 días, 1 noche</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-current">$99.000</span>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <img src="https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?w=400&h=300&fit=crop"
                        alt="Piscina centro" class="activity-image">
                    <div class="activity-content">
                        <div class="activity-category">villeta</div>
                        <h3 class="activity-title">Tarde de piscina en el centro de villeta (MUESTRA)</h3>
                        <div class="activity-rating">
                            <span class="stars">★★★★☆</span>
                            <span class="reviews">(1 Review)</span>
                        </div>
                        <div class="activity-duration">
                            <i class="fas fa-clock"></i>
                            <span>10 Nights, 9 days</span>
                        </div>
                        <div class="activity-price">
                            <span class="price-label">Desde</span>
                            <span class="price-current">$85.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-banner">
                <div class="search-banner-text">
                    <i class="fas fa-search"></i>
                    <span>¿Buscas alguna actividad específica?</span>
                </div>
                <button class="search-banner-btn">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
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