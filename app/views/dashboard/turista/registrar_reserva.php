<?php

require_once BASE_PATH . '/app/helpers/session_turista.php';
require_once __DIR__ . '/../../../helpers/alert_helper.php';

// ENLAZAMOS LA DEPENDENCIA EN ESTE CASO EL CONTROLADOR QUE TIENE LA FUNCION DE CONSULTA
require_once __DIR__ . '/../../../controllers/perfil.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ASIGNAMOS EL VALOR ID DEL REGISTRO SEGUN LA TABLA
$id = $_SESSION['user']['id'];

$usuario = mostrarPerfilTurista($id);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">

    <!-- Estilos CSS (siempre al final)-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/turista/perfil_usuario/perfil.css">

</head>


<body>

    <section id="reserva-turista">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/turista_panel_izq.php';
        ?>

        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../../views/layouts/buscador_turista.php';
            ?>

            <div class="container">

                <div class="info">
                    <h2>ojo este solo es Formulario de prueba de reservar Actividad</h2>

                    <form method="POST" action="<?= BASE_URL ?>/seleccionar-actividad">

                        <label>ID Actividad:</label><br>
                        <input type="number" name="id_actividad" value="1" required><br><br>

                        <label>Fecha:</label><br>
                        <input type="date" name="fecha" value="2025-10-01" required><br><br>

                        <label>Personas:</label><br>
                        <input type="number" name="personas" value="2" min="1" required><br><br>

                        <button type="submit">Probar Reserva</button>

                    </form>




                    <form method="POST" action="<?= BASE_URL ?>/seleccionar-actividad">
                        <h2><br> <br>formulario que viene, el real <br> <br></h2>
                        <!-- ID REAL de la actividad -->
                        <input type="hidden" name="id_actividad" value="<?= $actividad['id_actividad'] ?>">

                        <!-- Estos valores vienen del filtro superior (JS o PHP) -->
                        <input type="hidden" name="fecha" value="<?= $fechaSeleccionada ?>">
                        <input type="hidden" name="personas" value="<?= $cantidadPersonas ?>">

                        <button type="submit" class="btn btn-primary btn-reservar">
                            Reservar
                        </button>

                    </form>


                </div>
            </div>

    </section>


</body>