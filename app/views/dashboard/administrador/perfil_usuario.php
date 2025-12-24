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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">
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

            <div class="container">
                <div class="row">

                    <div class="usuario">
                        <h2>Perfil de Administrador</h2>
                        <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $usuario['foto'] ?>"
                            alt="persona"></i>
                        <h3><?= $_SESSION['user']['nombre'] ?></h3>
                        <p><?= $_SESSION['user']['rol'] ?></p>

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
                                    <p><?= $usuario['identificacion'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="editar">

                        <form action="/aventura_go/administrador/actualizar-perfil" method="POST" enctype="multipart/form-data">

                            <h4>Imagen Perfil</h4>
                            <input type="file" name="foto">




                            <h4>Nombre Completo</h4>
                            <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>">

                            <h4>Correo Electrónico</h4>
                            <input type="text" name="email" value="<?= $usuario['email'] ?>">

                            <h4>Teléfono</h4>
                            <input type="number" name="telefono" value="<?= $usuario['telefono'] ?>">

                            <h4>Identificación</h4>
                            <input type="text" name="identificacion" value="<?= $usuario['identificacion'] ?>">

                            <button type="submit" id="actualizar">Actualizar datos</button>

                        </form>

                    </div>



                    <form action="/aventura_go/administrador/cambiar-password" method="POST" class="cambiar">

                        <input type="hidden" name="accion" value="cambiar_password">

                        <h4>Contraseña Actual</h4>
                        <div class="input-password">
                            <input type="password" id="clave_actual" name="clave_actual" placeholder="Contraseña actual" required>
                            <i class="bi bi-eye-fill togglePassword" data-input="clave_actual"></i>
                        </div>

                        <h4>Nueva contraseña</h4>
                        <div class="input-password">
                            <input type="password" id="clave_nueva" name="clave_nueva" placeholder="Ingresa nueva contraseña" required minlength="6">
                            <i class="bi bi-eye-fill togglePassword" data-input="clave_nueva"></i>
                        </div>

                        <h4>Confirmar Contraseña</h4>
                        <div class="input-password">
                            <input type="password" id="confirmar" name="confirmar" placeholder="Confirma nueva contraseña" required minlength="6">
                            <i class="bi bi-eye-fill togglePassword" data-input="confirmar"></i>
                        </div>

                        <button type="submit">Cambiar Contraseña</button>

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