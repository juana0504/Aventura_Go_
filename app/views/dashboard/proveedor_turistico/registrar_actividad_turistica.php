<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';


?>

<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actividad Tturisitica</title>

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

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- Estilos CSS (siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/registrar_actividad_turistica/registrar_actividad_turistica.css">

</head>




<body>

    <!-- Panel Lateral -->
    <?php
    include_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php';
    ?>



    <!-- Barra de Búsqueda Superior -->
    <?php
    include_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
    ?>

    <div class="contenido-principal">

        <h2>Registrar actividad turística</h2>

        <form id="formActividad" action="<?= BASE_URL ?>/proveedor/guardar-actividad" method="POST" enctype="multipart/form-data">

            <!-- proveedor oculto -->
            <input type="hidden" name="accion" value="registrar">


            <!-- ================= PASO 1 ================= -->
            <div class="wizard-step active" id="step-1">
                <h3>Paso 1: Información básica</h3>

                <label>Nombre de la actividad</label>
                <input type="text" name="nombre" required>

                <label>Destino</label>
                <select name="id_ciudad" required>
                    <!-- luego lo llenas dinámico -->
                    <option value="">Seleccione destino</option>
                    <option value="1">Villeta</option>
                    <option value="2">Útica</option>
                </select>

                <label>Ubicación</label>
                <input type="text" name="ubicacion" required>

                <div class="wizard-actions">
                    <span></span>
                    <button type="button" onclick="nextStep(2)">Siguiente</button>
                </div>
            </div>

            <!-- ================= PASO 2 ================= -->
            <div class="wizard-step" id="step-2">
                <h3>Paso 2: Detalles de la actividad</h3>

                <label>Descripción</label>
                <textarea name="descripcion" required></textarea>

                <label>Cupos disponibles</label>
                <input type="number" name="cupos" required>

                <div class="wizard-actions">
                    <button type="button" onclick="prevStep(1)">Atrás</button>
                    <button type="button" onclick="nextStep(3)">Siguiente</button>
                </div>
            </div>

            <!-- ================= PASO 3 ================= -->
            <div class="wizard-step" id="step-3">
                <h3>Paso 3: Precio y estado</h3>

                <label>Precio</label>
                <input type="number" name="precio" required>

                <label>Estado</label>
                <select name="estado">
                    <option value="activa">Activa</option>
                    <option value="pausada">Pausada</option>
                </select>

                <label>Imágenes de la actividad (máx. 5)</label>
                <input
                    type="file"
                    name="imagenes[]"
                    multiple accept="image/jpeg,image/png"
                    required>
                <small>Selecciona hasta 5 imágenes (JPG o PNG)</small>


                <div class="wizard-actions">
                    <button type="button" onclick="prevStep(2)">Atrás</button>
                    <button type="submit">Guardar actividad</button>
                </div>
            </div>

        </form>

    </div>



    <script>
        function nextStep(step) {
            document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
        }

        function prevStep(step) {
            nextStep(step);
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>



</body>

</html>