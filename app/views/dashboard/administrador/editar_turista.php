<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
require_once BASE_PATH . '/app/controllers/turista.php';

// le asignamos el valor id del registro segun la tabla 
$id = $_GET['id'];
// llamamos la funcion expecifica del controlador y le pasamos los datos a una variable que podamos manipular en este archivo 
$turista = listarTuristaId($id);

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_turistico.css">

</head>

<body>
    <!-- Layout Principal con Panel y Contenido -->
    <section id="admin-dashboard">

        <!-- Panel Lateral -->
        <?php
        include_once __DIR__ . '/../../layouts/panel_izq_administrador.php';
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php';
            ?>

            <!-- Formulario Wizard -->
            <form id="formProveedor" action="<?= BASE_URL ?>/administrador/actualizar-turista" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_usuario" value="<?= $turista['id_usuario'] ?>">
                <input type="hidden" name="accion" value="actualizar">


                <div class="wizard-container">
                    <div class="wizard-header">
                        <p class="mb-0">Registro de Proveedor de Turismo</p>
                    </div>

                    <div class="wizard-content">
                        <!-- Paso 1 -->
                        <div class="step-content active" data-step="1">
                            <h4 class="mb-4"><i class="fas fa-building text-primary"></i> Información Básica del Turista</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" name="nombre" class="form-control" id="empresa" placeholder="Ej: Aventuras Extremas SAS" required value="<?= $turista['nombre'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select name="genero" class="form-control" required>
                                        <option value="" disabled hidden>Genero</option>
                                        <option value="Femenino" <?= $turista['genero'] == "Femenino" ? "selected" : "" ?>>Femenino</option>
                                        <option value="Masculino" <?= $turista['genero'] == "Masculino" ? "selected" : "" ?>>Masculino</option>
                                    </select>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+57 300 123 4567" required value="<?= $turista['telefono'] ?>"">
                                </div>
                                <div class=" col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="contacto@empresa.com" required value="<?= $turista['email'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Foto actual:</label><br>
                                    <img src="<?= BASE_URL ?>/public/uploads/usuario/<?= $turista['foto'] ?>"
                                        alt="Foto del turista" width="120" class="img-thumbnail mb-2">
                                </div>

                            </div>
                        </div>

                    </div>

                    <button type="submit">
                        Actualizar<i class="fas fa-arrow-left"></i> 
                    </button>


                </div>
            </form>
        </div>
    </section>

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/registrar_proveedor/editar_proveedor.js"></script>
</body>

</html>