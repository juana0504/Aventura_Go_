<?php



require_once __DIR__ . '/../../../helpers/alert_helper.php';
// ENLAZAMOS LA DEPENDENCIA EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCION DE CONSULTA
require_once __DIR__ . '/../../../controllers/perfil.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGUN LA TABLA
$id = $_SESSION['user']['id'];

$usuario = mostrarPerfilAdmin($id);




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/perfil.css">
</head>

<body>

    <div class="perfil">

        <?php
        include_once __DIR__ . '/../../layouts/panel_izq_administrador.php'
        ?>

        <div class="info">

            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php'
            ?>

            <!-- <form action="busqueda">
                <input type="text">
                <i class="bi bi-search"></i>

                <button id="modoOscuroBtn"> <i class="bi bi-moon-fill"></i></button>
                <button id="notificacionesBtn"> <i class="bi bi-bell-fill"></i></button>

                 Dropdown con Bootstrap -->
            <!-- <div class="dropdown" id="perfil-dropdown">
                    <a href="#" id="perfil" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../assets/dashboard/administrador/perfil_usuario/img/perfil.png" alt="persona">
                        <p>AR-Ana</p>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="../../dashboard/administrador/perfil_usuario.html"><i
                                    class="bi bi-person"></i> Mi
                                Perfil</a>
                        </li>
                        <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../../index.html"><i class="bi bi-box-arrow-right"></i>
                                Cerrar Sesión</a>
                        </li>
                    </ul>
                </div> -->
            <!-- </form> -->

            <div class="container">
                <div class="row">

                    <div class="usuario">
                        <h2>Perfil de Administrador</h2>
                        <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $usuario['foto'] ?>"
                            alt="persona"></i>
                        <h3><?= $_SESSION['user']['nombre'] ?></h3>
                        <p><?= $_SESSION['user']['rol'] ?></p>
                        <i class="bi bi-facebook"></i>

                        <button id="btndescripcion">Descripción General</button>
                        <button id="btneditar">Editar Perfil</button>
                        <button id="btncambiar">Cambiar Contraseña</button>
                    </div>

                    <div class="datos">

                        <div class="container">
                            <h3>Detalles del Perfil</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Nombre Completo:</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><?= $usuario['nombre'] ?></p>
                                </div>

                                <div class="col-md-6">
                                    <h4>Correo Electrónico:</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><?= $usuario['email'] ?></p>
                                </div>

                                <div class="col-md-6">
                                    <h4>Teléfono:</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><?= $usuario['telefono'] ?></p>
                                </div>

                             

                                <div class="col-md-6">
                                    <h4>Rol:</h4>
                                </div>
                                <div class="col-md-6">
                                    <p><?= $usuario['rol'] ?></p>
                                </div>

                                <div class="col-md-6">
                                    <h4>Identificacion:</h4>
                                </div>
                                <div class="col-md-6">
                                    <p>K1002006049</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="editar">

                        <h4>Imagen Perfil</h4>
                        <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $usuario['foto'] ?>"
                        alt="persona"><i class="bi bi-pen-fill"></i>

                        <button id="descargar">descargar</button>
                        <button id="eliminar">eliminar</button>

                        <form action="">
                            <h4>Nombre Completo</h4>
                            <input type="text" placeholder="Kevin Anderson">

                            <h4>Correo Electrónico</h4>
                            <input type="text" placeholder="">

                            <h4>Teléfono</h4>
                            <input type="number" placeholder="">

                            <h4>Dirección</h4>
                            <input type="text" placeholder="">

                            <h4>Identificacion</h4>
                            <input type="text" placeholder="">

                        </form>
                    </div>


                    <form action="cambiar" class="cambiar">
                        <h4>Contraseña Actual</h4>
                        <input type="text">

                        <h4>nueva contraseña</h4>
                        <input type="text">

                        <h4>Confirmar Contraseña</h4>
                        <input type="text">

                        <button>Cambiar Contraseña</button>
                    </form>
                </div>
            </div>

        </div>

    </div>


    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/perfil.js"></script>

</body>

</html>