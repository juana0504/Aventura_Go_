<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';
include_once __DIR__ . '/../../layouts/header_administrador.php';
require_once BASE_PATH . '/app/controllers/hotelero.php';

// le asignamos el valor id del registro segun la tabla 
$id = $_GET['id'];
// llamamos la funcion expecifica del controlador y le pasamos los datos a una variable que podamos manipular en este archivo 
$hotelero = listarHotelId($id);

$actividadesSeleccionadas = [];

if (!empty($hotelero['tipo_establecimiento'])) {
    // Quitar espacios después de la coma para evitar errores
    $actividadesSeleccionadas = array_map('trim', explode(",", $hotelero['tipo_establecimiento']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_hotelero.css">


</head>

<body>
    <!-- Layout Principal con Panel y Contenido -->
    <section id="admin-dashboard">

        <!-- Panel Lateral -->
        <?php
        include_once __DIR__ . '/../../layouts/panel_izq_administrador.php'
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php';
            ?>

            <!-- Formulario Wizard -->
            <form id="formProveedor" action="<?= BASE_URL ?>/administrador/actualizar-proveedor-hotelero" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_proveedor_hotelero" value="<?= $hotelero['id_proveedor_hotelero'] ?>">
                <input type="hidden" name="accion" value="actualizar">

                <div class="wizard-container">
                    <div class="wizard-content">
                        <div class="wizard-header">
                            <p class="mb-0">Registro de Proveedor Hotelero</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                    <label class="form-label">Logo</label>
                                    <input type="file" accept=".jpg, .png, .jpeg" name="foto" class="form-control" id="foto" required>
                                </div>
                            <div class="col-md-6 mb-3">
                                <!-- Nombre establecimiento -->
                                <label class="form-label" for="nombre_establecimiento">Nombre del establecimiento:</label>
                                <input type="text" name="nombre_establecimiento" id="nombre_establecimiento" maxlength="100" required value="<?= $hotelero['nombre_establecimiento'] ?>">
                                <br><br>
                            </div>
                        </div>

                        <!-- Tipo establecimiento (ENUM) -->
                        <div class="step-content">
                            <h4 class="mb-4">Tipo de establecimiento</h4>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hotel" value="Hotel"
                                                    <?= in_array("Hotel", $actividadesSeleccionadas) ? "checked" : "" ?>>
                                                <label class="form-check-label">Hotel</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="cabana" value="Cabaña"
                                                    <?= in_array("Cabaña", $actividadesSeleccionadas) ? "checked" : "" ?>>
                                                <label class="form-check-label">Cabaña</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hostal" value="Hostal"
                                                    <?= in_array("Hostal", $actividadesSeleccionadas) ? "checked" : "" ?>>
                                                <label class="form-check-label">Hostal</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="Glamping" value="GLAMPING"
                                                    <?= in_array("Glamping", $actividadesSeleccionadas) ? "checked" : "" ?>>
                                                <label class="form-check-label">Glamping</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <!-- Número habitaciones -->
                                <label class="form-label" for="numero_habitaciones">Número de habitaciones:</label>
                                <input type="number" name="numero_habitaciones" id="numero_habitaciones" min="1" required value="<?= $hotelero['numero_habitaciones'] ?>">
                                <br><br>
                            </div>
                            <div class="col-md-6 mb-3">
                                <!-- Calificación promedio -->
                                <label class="form-label" for="calificacion_promedio">Calificación promedio:</label>
                                <input type="number" step="0.01" name="calificacion_promedio" id="calificacion_promedio" min="0" max="5" value="<?= $hotelero['calificacion_promedio'] ?>">
                                <br><br>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-wizard" id="nextBtn">
                            Actualizar <i class="fas fa-arrow-right"></i>
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>