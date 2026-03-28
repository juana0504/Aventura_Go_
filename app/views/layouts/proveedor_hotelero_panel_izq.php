    <?php

    require_once __DIR__ . '/../../helpers/alert_helper.php';
    require_once __DIR__ . '/../../controllers/perfil.php';

    $id = $_SESSION['user']['id_usuario'] ?? null;

    $usuario = mostrarPerfilProveedorHotelero($id);

    ?>

    <div class="panel">

        <img src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a id="btn-panel">Proveedor Hotelero</a>


            <div id="Hotelero">

                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>proveedor_hotelero/dashboard" class="bi-speedometer2">Dashboard</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-informacion" class="bi bi-layout-text-sidebar-reverse"> Registrar/Actualizar informacion</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedaje" class="bi bi-layout-text-sidebar-reverse">Registrar hospedaje</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hospedaje" class="bi bi-table">Consultar hospedajes</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-reservas" class="bi bi-calendar-check">Consultar reservas</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/tickets"> <i class="fa fa-ticket"></i>Tickets</a>
                    <a href="<?= BASE_URL ?>proveedor_hotelero/ingresos" class="bi bi-cash-stack" id="menu-ingresos">Ingresos</a>
                </ul>

                <script>
                    (function() {
                        try {
                            var links = document.querySelectorAll('#menu-panel a');
                            var path = window.location.pathname.replace(/\/+$/, '');
                            links.forEach(function(link) {
                                var href = link.getAttribute('href') || '';
                                var linkPath = href.replace(window.location.origin, '').replace(/\/+$/, '');
                                if (linkPath === path) {
                                    link.classList.add('active');
                                }
                            });
                        } catch (e) {
                            console && console.error(e);
                        }
                    })();
                </script>

            </div>


        </div>

    </div>