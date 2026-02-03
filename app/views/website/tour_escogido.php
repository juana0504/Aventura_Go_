<?php
session_start();
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';

$actividadModel = new ActividadTuristica();
$actividades = $actividadModel->listarActividadesPublicas();

/* Para el título del header: tomar ciudad de la primera actividad si existe */
$ciudadHeader = 'tu destino';
if (!empty($actividades) && isset($actividades[0]['ciudad'])) {
    $ciudadHeader = $actividades[0]['ciudad'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - tour-escogido</title>

    <link rel="icon" type="image/png" href="../public/assets/website_externos/index/img/FAVICON.png">

    <!-- bootstrap para el carrusel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (para las estrellas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Tema opcional slick carrousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/hospedaje_escogido/hospedaje_escogido.css">
</head>

<body>

    <!-- header________________________________________________________________________________________________________________________________ -->
    <header>
        <nav class="navbar">
            <div class="container">
                <img src="../../../public/assets/website_externos/tour_escogido/img/logo nav.png" alt="Logo Aventura Go"
                    class="navbar-logo">
                <ul class="navbar-nav">
                    <h1>Tour escogido</h1>
                </ul>
                <div class="actions">
                    <button class="principal">Atrás</button>
                    <button class="secundario">Salir</button>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="info">
            <div class="container">
                <div class="row">

                    <!-- TARJETA DEL TOUR -->
                    <div class="col-md-8">
                        <div class="targeta">
                            <div class="row">

                                <div class="col-md-6 detalle">
                                    <h2>Hotel luxury resort la Vega</h2>
                                    <span class="badge bg-warning text-dark">20% off</span>

                                    <p id="direccion">
                                        <i class="bi bi-geo-alt"></i>
                                        Dg. 2 Sur #11a-65, La Vega, Cundinamarca, 253610 Villeta, Colombia
                                    </p>

                                    <p>
                                        Después de reservar, encontrarás todos los datos del alojamiento con el número de
                                        teléfono y la dirección en tu confirmación de la reserva y en tu cuenta.
                                    </p>
                                </div>

                                <div class="col-md-6 datos">
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span>(120 Review)</span>
                                    </div>

                                    <p><i class="bi bi-clock"></i> 1 Noche, 2 Días</p>
                                    <p>
                                        <del>$325.000</del>
                                        <strong class="text-warning fs-4">$282.000</strong>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- PANEL FIJO DE RESERVA -->
                    <div class="col-md-4">
                        <div class="panel-reserva">
                            <h4>Reserva tu tour</h4>
                            <p>Precio final:</p>
                            <h3>$282.000</h3>

                            <button class="btn btn-warning w-100 mt-3">
                                Reservar ahora
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>



    </main>

















    <!-- Abootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript de Slick -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- aos animate -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <script src="<?= BASE_URL ?>/public/assets/website_externos/tour_escogido/tour_escogido.js"></script>

    <!-- FIX: Evitar errores si no existen esos elementos -->
    <script>
        // Dropdown (tu código, pero protegido con if)
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        if (profileToggle && profileMenu) {
            profileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.style.display = (profileMenu.style.display === 'block') ? 'none' : 'block';
            });

            document.addEventListener('click', function() {
                profileMenu.style.display = 'none';
            });
        }
    </script>

</body>

</html>