<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';
include_once __DIR__ . '/../../layouts/header_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';

// le asignamos el valor id del registro segun la tabla 
$id = $_GET['id'];
// llamamos la funcion expecifica del controlador y le pasamos los datos a una variable que podamos manipular en este archivo 
$hotelero = listarHotelId($id);

$establecimientoSeleccionado = [];
$habitacionSeleccionada = [];
$servicioSeleccionado = [];
$pagoSeleccionado = [];

if (!empty($hotelero['tipo_establecimiento'])) {
    // Quitar espacios después de la coma para evitar errores
    $establecimientoSeleccionado = array_map('trim', explode(",", $hotelero['tipo_establecimiento']));
}

if (!empty($hotelero['tipo_habitacion'])) {
    // Quitar espacios después de la coma para evitar errores
    $habitacionSeleccionada = array_map('trim', explode(",", $hotelero['tipo_habitacion']));
}

if (!empty($hotelero['servicio_incluido'])) {
    // Quitar espacios después de la coma para evitar errores
    $servicioSeleccionado = array_map('trim', explode(",", $hotelero['servicio_incluido']));
}

if (!empty($hotelero['metodo_pago'])) {
    // Quitar espacios después de la coma para evitar errores
    $pagoSeleccionado = array_map('trim', explode(",", $hotelero['metodo_pago']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_turistico.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">


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
                <input type="hidden" name="id_usuario" value="<?= $hotelero['id_usuario'] ?>">
                <input type="hidden" name="accion" value="actualizar">

                <div class="wizard-container">
                    <div class="wizard-content">
                        <div class="wizard-header">
                            <p class="mb-0">Registro de Proveedor Hotelero</p>
                        </div>

                        <div class="wizard-steps">
                            <div class="step active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">Información Básica</div>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">Servicios</div>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-circle">3</div>
                                <div class="step-label">Ubicación</div>
                            </div>
                            <div class="step" data-step="4">
                                <div class="step-circle">4</div>
                                <div class="step-label">Representante</div>
                            </div>
                            <div class="step" data-step="5">
                                <div class="step-circle">5</div>
                                <div class="step-label">Documentación</div>
                            </div>
                        </div>

                        <div class="wizard-content">
                            <!-- Paso 1 -->
                            <div class="step-content active" data-step="1">
                                <h4 class="mb-4"><i class="fas fa-building text-primary"></i> Información Básica del Proveedor Hotelero</h4>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Logo</label>
                                        <img src="<?= BASE_URL ?>/public/uploads/hoteles/<?= $hotelero['logo'] ?>"
                                            alt="Foto del turista" width="120" class="img-thumbnail mb-2">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <!-- Nombre establecimiento -->
                                        <label class="form-label" for="nombre_establecimiento">Nombre del establecimiento:</label>
                                        <input type="text" name="nombre_establecimiento" id="nombre_establecimiento" maxlength="100" required value="<?= $hotelero['nombre_establecimiento'] ?>">
                                        <br><br>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="contacto@empresa.com" required value="<?= $hotelero['email'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono *</label>
                                        <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+57 300 123 4567" required value="<?= $hotelero['telefono'] ?>">
                                    </div>

                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de establecimiento</h4>
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hotel" value="Hotel"
                                                        <?= in_array("Hotel", $establecimientoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Hotel</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="cabana" value="Cabaña"
                                                        <?= in_array("Cabaña", $establecimientoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Cabaña</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hostal" value="Hostal"
                                                        <?= in_array("Hostal", $establecimientoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Hostal</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="glamping" value="Glamping"
                                                        <?= in_array("Glamping", $establecimientoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Glamping</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" data-step="2">
                                <h4 class="mb-4"><i class="bi bi-person-fill"></i> Representante</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre del Representante *</label>
                                        <input type="text" name="nombre_representante" class="form-control" id="nombre_repre" placeholder="Juan Pérez" required value=" <?= $hotelero['nombre_representante'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de documento *</label>
                                        <select name="tipo_documento">
                                            <option value="" disabled selected hidden>Tipo de documento</option>
                                            <option value="CC" <?= $hotelero['tipo_documento'] == "CC" ? "selected" : "" ?>>CC</option>
                                            <option value="CE" <?= $hotelero['tipo_documento'] == "CE" ? "selected" : "" ?>>CE</option>
                                            <option value="Pasaporte" <?= $hotelero['tipo_documento'] == "Pasaporte" ? "selected" : "" ?>>Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Identificacion *</label>
                                        <input type="tel" name="identificacion_representante" class="form-control" id="identiificacion_repre" placeholder="N.°" required value="<?= $hotelero['identificacion_representante'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Foto</label>
                                        <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $hotelero['foto_representante'] ?>"
                                            alt="Foto del turista" width="120" class="img-thumbnail mb-2">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email_representante" class="form-control" id="email_repre" placeholder="contacto@empresa.com" required value="<?= $hotelero['email_representante'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono *</label>
                                        <input type="tel" name="telefono_representante" class="form-control" id="telefono_repre" placeholder="+57 300 123 4567" required value="<?= $hotelero['telefono_representante'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" data-step="3">
                                <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Ubicación</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Departamento *</label>
                                        <select name="departamento" id="departamento" class="form-control" required></select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ciudad *</label>
                                        <select name="id_ciudad" id="id_ciudad" class="form-control" required></select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Dirección *</label>
                                        <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Calle 123 #45-67" required value="<?= $hotelero['direccion'] ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo establecimiento (ENUM) -->
                            <div class="step-content" data-step="4">
                                <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de habitación</h4>
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Estandar" value="Estandar"
                                                        <?= in_array("Estándar", $habitacionSeleccionada) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Estándar</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Doble" value="Doble"
                                                        <?= in_array("Doble", $habitacionSeleccionada) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Doble</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Suite" value="Suite"
                                                        <?= in_array("Suite", $habitacionSeleccionada) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Suite</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Familiar" value="Familiar"
                                                        <?= in_array("Familiar", $habitacionSeleccionada) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Familiar</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Premium" value="Premium"
                                                        <?= in_array("Premium", $habitacionSeleccionada) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Premium</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Número máximo de huéspedes *</label>
                                        <input type="tel" name="max_huesped" class="form-control" id="max_huesped" placeholder="Juan Pérez" required value="<?= $hotelero['max_huesped'] ?>">
                                    </div>

                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Servicios incluidos</h4>
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="WiFi" value="WiFi"
                                                        <?= in_array("WiFi", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">WiFi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Parqueadero" value="Parqueadero"
                                                        <?= in_array("Parqueadero", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Parqueadero</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Piscina" value="Piscina"
                                                        <?= in_array("Piscina", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Piscina</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Restaurante" value="Restaurante"
                                                        <?= in_array("Restaurante", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Restaurante</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Bar" value="Bar"
                                                        <?= in_array("Bar", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Bar</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Spa" value="Spa"
                                                        <?= in_array("Spa", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Spa</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Pet Friendly" value="Pet Friendly"
                                                        <?= in_array("Pet Friendly", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Pet Friendly</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Servicio al cuarto" value="Servicio al cuarto"
                                                        <?= in_array("Servicio al cuarto", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Servicio al cuarto</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Transporte" value="Transporte"
                                                        <?= in_array("Transporte", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Transporte</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Desayuno incluido" value="Desayuno incluido"
                                                        <?= in_array("Desayuno incluido", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Desayuno incluido</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Accesibilidad" value="Accesibilidad"
                                                        <?= in_array("Accesibilidad", $servicioSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Accesibilidad</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-content" data-step="5">
                                <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Documentación obligatoria</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIT/RUT *</label>
                                        <input type="text" name="nit_rut" class="form-control" id="nit" placeholder="123456789-0" required value="<?= $hotelero['nit_rut'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Camara de Comercio *</label>
                                        <input type="text" name="camara_comercio" class="form-control" id="camara_comercio" required value="<?= $hotelero['camara_comercio'] ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Licencia *</label>
                                        <input type="text" name="licencia" class="form-control" id="licencia" placeholder="Ej: Medellín" required value="<?= $hotelero['licencia'] ?>">
                                    </div>

                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de pago</h4>
                                    <div class="col-md-12 mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Tarjeta de Crédito" value="Tarjeta de Crédito"
                                                        <?= in_array("Tarjeta de Crédito", $pagoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Tarjeta de Crédito</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Tarjeta Débito" value="Tarjeta Débito"
                                                        <?= in_array("Tarjeta Débito", $pagoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Tarjeta Débito</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="PSE" value="PSE"
                                                        <?= in_array("PSE", $pagoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">PSE</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Nequi" value="Nequi"
                                                        <?= in_array("Nequi", $pagoSeleccionado) ? "checked" : "" ?>>
                                                    <label class="form-check-label">Nequi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wizard-actions">
                            <button class="btn btn-secondary-wizard" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                                <i class="fas fa-arrow-left"></i> Anterior
                            </button>

                            <button class="btn btn-primary-wizard" id="nextBtn">
                                Siguiente <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/editar_proveedor.js"></script>

    <script>
        const departamentoActual = "<?= $hotelero['departamento'] ?>";
        const ciudadActual = "<?= $hotelero['id_ciudad'] ?>";
    </script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/departamento.js"></script>
</body>

</html>