    <?php

    require_once __DIR__ . '/../../helpers/alert_helper.php';
    require_once __DIR__ . '/../../controllers/perfil.php';

    $id = $_SESSION['user']['id_usuario'] ?? null;

    $usuario = mostrarPerfilTurista($id);

    ?>

    <div class="panel">

        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a id="btn-panel">Turista</a>


            <div id="Turistico">

                <ul id="menu-panel">
                    <a href="<?= BASE_URL ?>/turista/dashboard" class="bi-speedometer2">Dashboard</a>
                    <a href="<?= BASE_URL ?>/turista/ver-reservas" class="bi bi-table">Ver reservas</a>
                    <a href="<?= BASE_URL ?>/turista/tickets" class="fa fa-ticket"> Tickets</a>
                    <a href="<?= BASE_URL ?>/turista/" class="fa-solid fa-heart">Favoritos</a>
                    <a href="<?= BASE_URL ?>/turista/" class="fa-solid fa-heart">Reseñas</a>


                </ul>

            </div>


        </div>

    </div>