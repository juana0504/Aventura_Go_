<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
require_once BASE_PATH . '/app/controllers/proveedor_turistico/actividadTuristica.php';

$id = $_GET['id'];

$actividadController = listarActividadId($id);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actividad Turística</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layouts -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- CSS propio -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/registrar_actividad_turistica/registrar_actividad_turistica.css">
</head>

<body>



    <section id="registrar-actividades">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php';
        ?>

        <!-- Contenido Principal -->
        <div class="contenido-principal">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
            ?>

            <div class="info">
                <!-- Formulario Wizard -->
                <form id="formActividad" action="<?= BASE_URL ?>/proveedor/actualizar-actividad" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id_actividad" value="<?= $actividadController['id_actividad'] ?>">
                    <input type="hidden" name="id_proveedor" value="<?= $actividadController['id_proveedor'] ?>">


                    <div class="wizard-header">
                        <h1 class="mb-0">Editar actividad turística</h1>
                    </div>


                    <!-- ================= PASO 1 ================= -->
                    <div class="wizard-step active" id="step-1">
                        <h3>Paso 1 de 3: Información básica</h3>

                        <label>Nombre de la actividad</label>
                        <input type="text" name="nombre" value="<?= $actividadController['nombre'] ?>" required>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <!-- 🔥 NUEVO: DEPARTAMENTO -->
                                <label>Departamento</label>
                                <select name="id_departamento" id="id_departamento" value="<?= $actividadController['departamento'] ?>" required>
                                    <option value="">Seleccione departamento</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <!-- 🔥 NUEVO: CIUDAD (DESTINO REAL) -->
                                <label>Destino (Ciudad)</label>
                                <select name="id_ciudad" id="id_ciudad" value="<?= $actividadController['ciudad'] ?>" required>
                                    <option value="">Seleccione ciudad</option>
                                </select>
                            </div>

                        </div>
                        <label>Ubicación</label>
                        <input type="text" name="ubicacion" value="<?= $actividadController['ubicacion'] ?>" required>

                        <div class="wizard-actions">
                            <span></span>
                            <button type="button" onclick="nextStep(2)">Siguiente</button>
                        </div>
                    </div>

                    <!-- ================= PASO 2 ================= -->
                    <div class="wizard-step" id="step-2">
                        <h3>Paso 2 de 3: Detalles de la actividad</h3>

                        <label>Descripción</label>
                        <textarea name="descripcion" required>
                            <?= htmlspecialchars($actividadController['descripcion']) ?>
                        </textarea>


                        <label>Cupos disponibles</label>
                        <input type="number" name="cupos" value="<?= $actividadController['cupos'] ?>" required>

                        <div class="wizard-actions">
                            <button type="button" onclick="prevStep(1)">Atrás</button>
                            <button type="button" onclick="nextStep(3)">Siguiente</button>
                        </div>
                    </div>

                    <!-- ================= PASO 3 ================= -->
                    <div class="wizard-step" id="step-3">
                        <h3>Paso 3: Precio y estado</h3>

                        <label>Precio</label>
                        <input type="number" name="precio" value="<?= $actividadController['precio'] ?>" required>

                        <label>Estado</label>
                        <select name="estado">
                            <option value="ACTIVO" <?= $actividadController['estado'] === 'ACTIVO' ? 'selected' : '' ?>>Activa</option>
                            <option value="INACTIVO" <?= $actividadController['estado'] === 'INACTIVO' ? 'selected' : '' ?>>Inactiva</option>
                        </select>

                        <label>Imágenes de la actividad (máx. 5)</label>
                        <input type="file" name="imagenes[]" multiple required>
                        <small>Selecciona hasta 5 imágenes (JPG o PNG)</small>

                        <div class="wizard-actions">
                            <button type="button" onclick="prevStep(2)">Atrás</button>
                            <button type="submit">Actualizar actividad</button>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </section>

    <!-- WIZARD JS (NO TOCAR)-->
    <script>
        function nextStep(step) {
            document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
        }

        function prevStep(step) {
            nextStep(step);
        }
    </script>

    <!-- JS DEPARTAMENTO → CIUDAD (NO TOCAR) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const departamentoSelect = document.getElementById('id_departamento');
            const ciudadSelect = document.getElementById('id_ciudad');

            // Cargar departamentos
            fetch('<?= BASE_URL ?>/app/controllers/departamentoController.php')
                .then(res => res.json())
                .then(data => {
                    data.forEach(dep => {
                        const opt = document.createElement('option');
                        opt.value = dep.id_departamento;
                        opt.textContent = dep.nombre;
                        departamentoSelect.appendChild(opt);
                    });
                });

            // Cargar ciudades por departamento
            departamentoSelect.addEventListener('change', () => {
                ciudadSelect.innerHTML = '<option value="">Seleccione ciudad</option>';

                if (!departamentoSelect.value) return;

                fetch(`<?= BASE_URL ?>/app/controllers/ciudadController.php?id_departamento=${departamentoSelect.value}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(ciudad => {
                            const opt = document.createElement('option');
                            opt.value = ciudad.id_ciudad;
                            opt.textContent = ciudad.nombre;
                            ciudadSelect.appendChild(opt);
                        });
                    });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>