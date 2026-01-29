    <?php

    require_once __DIR__ . '/../../helpers/alert_helper.php';
    require_once __DIR__ . '/../../controllers/perfil.php';

    $id = $_SESSION['user']['id'] ?? null;

    $usuario = mostrarPerfilTurista($id);

    ?>

    <div class="panel">

        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a id="btn-panel">Turista</a>


            <div id="Turistico">

                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>/turista/dashboard" class="bi-speedometer2">Dashboard</a>
                    <a href="<?= BASE_URL ?>/turista/registrar-actividad" class="bi bi-layout-text-sidebar-reverse">Registrar actividad turistica</a>
                    <a href="<?= BASE_URL ?>/turista/ver-reservas" class="bi bi-table">Ver reservas</a>
                    <a href="<?= BASE_URL ?>/turista/crear-ticket" class="bi bi-ticket-perforated">Generar Reporte</a>

                </ul>

            </div>


        </div>

    </div>