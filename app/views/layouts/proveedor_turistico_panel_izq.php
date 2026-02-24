    <?php

    require_once __DIR__ . '/../../helpers/alert_helper.php';
    require_once __DIR__ . '/../../controllers/perfil.php';

    $id = $_SESSION['user']['id_usuario'] ?? null;

    $usuario = mostrarPerfilProveedor($id);

    ?>

    <div class="panel">

        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a id="btn-panel">Proveedor Turistico</a>


            <div id="Turistico">

                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>/proveedor/dashboard" class="bi-speedometer2">Dashboard</a>
                    <a href="<?= BASE_URL ?>/proveedor/completar-informacion" class="bi bi-layout-text-sidebar-reverse"> Completar y/o actualizar informacion de registro</a>
                    <a href="<?= BASE_URL ?>/proveedor/registrar-actividad" class="bi bi-layout-text-sidebar-reverse">Registrar actividad turistica</a>
                    <a href="<?= BASE_URL ?>/proveedor/consultar-actividad" class="bi bi-table">Consultar actividades turisiticas</a>
                    <a href="<?= BASE_URL ?>/proveedor/consultar-reservas" class="bi bi-calendar-check">Consultar reservas</a>
                    <a href="<?= BASE_URL ?>/proveedor/tickets">
                        <i class="fa fa-ticket"></i> Tickets
                    </a>
                </ul>

            </div>


        </div>

    </div>