    <?php

    require_once __DIR__ . '/../../helpers/alert_helper.php';
    require_once __DIR__ . '/../../controllers/perfil.php';

    $id = $_SESSION['user']['id'] ?? null;

    $usuario = mostrarPerfilProveedor($id);

    ?>

    <div class="panel">

        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a href="<?= BASE_URL ?>/proveedor/dashboard">
                <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/Dashboard.png"
                    alt="dashboard">
                <p>Dashboard</p>
            </a>

            <div id="Turistico">
                <a id="btn-panel" type="button">
                    Proveedor Turistico
                </a>
                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>/proveedor/registrar-actividad" class="bi bi-layout-text-sidebar-reverse">Registrar actividad turistica</a>
                    <a href="<?= BASE_URL ?>/proveedor/consultar-actividad" class="bi bi-table">Consultar actividades turisiticas</a>
                    <a href="<?= BASE_URL ?>/proveedor/consultar-reservas" class="bi bi-calendar-check">Consultar reservas</a>

                </ul>
            </div>

        </div>

    </div>