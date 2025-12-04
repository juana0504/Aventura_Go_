<?php

require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../controllers/perfil.php';


$id = $_SESSION['user']['id'];

$usuario = mostrarPerfilAdmin($id);
?>

<form id="busqueda" action="busqueda">
    <input type="text">
    <i class="bi bi-search"></i>

    <button id="modoOscuroBtn"> <i class="bi bi-moon-fill"></i></button>
    <button id="notificacionesBtn"> <i class="bi bi-bell-fill"></i></button>

    <!-- Dropdown con Bootstrap -->
    <div class="dropdown" id="perfil-dropdown">
        <a href="#" id="perfil" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $usuario['foto'] ?>"
                alt="persona">
            <div class="info-usuario">
                <p><?= $usuario['nombre'] ?></p>
                <h6><?= $usuario['rol'] ?></h6>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= BASE_URL ?>/administrador/perfil"><i class="bi bi-person"></i> Mi Perfil</a>
            </li>
            <hr class="dropdown-divider">
            </li>
             <li>
                <a class="dropdown-item" href="<?= BASE_URL ?>/logout">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>
</form>