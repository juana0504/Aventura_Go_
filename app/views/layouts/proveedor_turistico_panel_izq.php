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
                <a id="btn-panel" type="button">Proveedor Turistico</a>
                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>/proveedor/registrar-actividad" class="bi bi-layout-text-sidebar-reverse">Registrar actividad turistica</a>
                    <a href="<?= BASE_URL ?>/proveedor/consultar-actividad" class="bi bi-table">Consultar actividades turisiticas</a>
                </ul>
            </div>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" id="btn-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Soporte y Reportes
                </a>
                <ul class="dropdown-menu" id="menu-panel">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/proveedor/crear-ticket">Generar Reporte</a></li>
                </ul>
            </div>

        </div>

    </div>