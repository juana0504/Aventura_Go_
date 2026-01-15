<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

$id_proveedor = $_SESSION['user']['id'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar actividad | Aventura Go</title>

    <link rel="stylesheet" href="/aventura_go/public/assets/dashboard/proveedor/actividad.css">

    <style>
        /* Wizard básico */
        .wizard-step {
            display: none;
        }

        .wizard-step.active {
            display: block;
        }

        .wizard-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>Registrar actividad turística</h2>

    <form action="/aventura_go/proveedor/guardar-actividad" method="POST">

        <!-- proveedor oculto -->
        <input type="hidden" name="id_proveedor" value="<?= $id_proveedor ?>">

        <!-- ================= PASO 1 ================= -->
        <div class="wizard-step active" id="step-1">
            <h3>Paso 1: Información básica</h3>

            <label>Nombre de la actividad</label>
            <input type="text" name="nombre" required>

            <label>Destino</label>
            <select name="id_destino" required>
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
            <textarea name="descripcion" rows="4" required></textarea>

            <label>Cupos disponibles</label>
            <input type="number" name="cupos" min="1" required>

            <div class="wizard-actions">
                <button type="button" onclick="prevStep(1)">Atrás</button>
                <button type="button" onclick="nextStep(3)">Siguiente</button>
            </div>
        </div>

        <!-- ================= PASO 3 ================= -->
        <div class="wizard-step" id="step-3">
            <h3>Paso 3: Precio y estado</h3>

            <label>Precio</label>
            <input type="number" name="precio" step="0.01" required>

            <label>Estado</label>
            <select name="estado">
                <option value="activa">Activa</option>
                <option value="pausada">Pausada</option>
            </select>

            <div class="wizard-actions">
                <button type="button" onclick="prevStep(2)">Atrás</button>
                <button type="submit">Guardar actividad</button>
            </div>
        </div>

    </form>

    <script>
        function nextStep(step) {
            document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
        }

        function prevStep(step) {
            nextStep(step);
        }
    </script>

</body>

</html>