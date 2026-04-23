<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Hospedaje</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layouts -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/panel_proveedor_hotelero.css">

    <!-- CSS propio -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/registrar_hospedaje/registrar_hospedaje.css">
</head>

<body>



    <section id="registrar-hospedajes">

        <!-- PANEL LATERAL -->
        <aside class="sidebar">
            <?php
            include_once __DIR__ . '/../../layouts/proveedor_hotelero_panel_izq.php';
            ?>
        </aside>

        <!-- Contenido Principal -->
        <main class="registrar-main">

            <!-- BARRA SUPERIOR -->
            <header class="registrar-topbar">
                <?php
                include_once __DIR__ . '/../../layouts/buscador_proveedor_hotelero.php';
                ?>
            </header>

            <!-- CONTENIDO DE LA PAGINA -->
            <section class="formulario">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-9 col-md-8 col-lg-9">
                            <!-- Formulario Wizard -->
                            <form id="formActividad" action="<?= BASE_URL ?>proveedor_hotelero/guardar-actividad" method="POST" enctype="multipart/form-data">

                                <input type="hidden" name="accion" value="registrar">

                                <div class="wizard-container">

                                    <!-- HEADER -->
                                    <div class="wizard-header">
                                        <p class="mb-0">Registro de Actividades Turísticas</p>
                                    </div>

                                    <!-- PASOS -->
                                    <div class="wizard-steps">

                                        <div class="step active" data-step="1">
                                            <div class="step-circle">1</div>
                                            <div class="step-label">Información</div>
                                        </div>

                                        <div class="step" data-step="2">
                                            <div class="step-circle">2</div>
                                            <div class="step-label">Descripción</div>
                                        </div>

                                        <div class="step" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-label">Precio</div>
                                        </div>

                                        <div class="step" data-step="4">
                                            <div class="step-circle">4</div>
                                            <div class="step-label">Revisar información</div>
                                        </div>

                                    </div>


                                    <div class="wizard-content">

                                        <!-- ================= PASO 1 ================= -->
                                        <div class="wizard-step active" id="step-1">

                                            <h4 class="mb-4"><i class="fas fa-map-marked-alt text-primary"></i> Información básica</h4>

                                            <label>Nombre de la actividad</label>
                                            <input type="text" name="nombre" required>

                                            <div class="row">

                                                <div class="col-md-6 mb-3">

                                                    <label>Departamento</label>
                                                    <select name="id_departamento" id="id_departamento" required>
                                                        <option value="">Seleccione departamento</option>
                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label>Destino (Ciudad)</label>
                                                    <select name="id_ciudad" id="id_ciudad" required>
                                                        <option value="">Seleccione ciudad</option>
                                                    </select>

                                                </div>

                                            </div>

                                            <label>Ubicación</label>
                                            <input type="text" name="ubicacion" required>

                                            <div class="wizard-actions">
                                                <span></span>
                                                <button type="button" onclick="nextStep(2)">Siguiente</button>
                                            </div>

                                        </div>


                                        <!-- ================= PASO 2 ================= -->
                                        <div class="wizard-step" id="step-2">

                                            <h4 class="mb-4"><i class="fas fa-align-left text-primary"></i> Descripción y cupos</h4>

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

                                            <h4 class="mb-4"><i class="fas fa-dollar-sign text-primary"></i> Precio y estado</h4>

                                            <label>Precio</label>
                                            <input type="number" name="precio" required>

                                            <label>Estado</label>
                                            <select name="estado">
                                                <option value="ACTIVO">Activa</option>
                                                <option value="INACTIVO">Inactiva</option>
                                            </select>

                                            <label>Imágenes de la actividad (máx. 5)</label>
                                            <input type="file" name="imagenes[]" multiple required>

                                            <small>
                                                Selecciona hasta 5 imágenes (JPG o PNG) no deben exceder 1 MB cada una
                                            </small>

                                            <div class="wizard-actions">
                                                <button type="button" onclick="prevStep(2)">Atrás</button>
                                                <button type="button" onclick="nextStep(4)">Siguiente</button>
                                            </div>
                                        </div>

                                        <!-- ================= PASO 4 ================= -->
                                        <div class="wizard-step" id="step-4">

                                            <h4 class="mb-4">
                                                <i class="fas fa-check-circle text-success"></i>
                                                Confirmar actividad
                                            </h4>

                                            <div class="preview-card">

                                                <h6 class="text-primary mb-3">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                    Información de la actividad
                                                </h6>

                                                <div class="row">

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Nombre</div>
                                                        <div class="preview-value" id="prev-nombre">-</div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Ubicación</div>
                                                        <div class="preview-value" id="prev-ubicacion">-</div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Departamento</div>
                                                        <div class="preview-value" id="prev-departamento">-</div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Ciudad</div>
                                                        <div class="preview-value" id="prev-ciudad">-</div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Cupos</div>
                                                        <div class="preview-value" id="prev-cupos">-</div>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <div class="preview-label">Precio</div>
                                                        <div class="preview-value" id="prev-precio">-</div>
                                                    </div>

                                                    <div class="col-md-12 mb-2">
                                                        <div class="preview-label">Descripción</div>
                                                        <div class="preview-value" id="prev-descripcion">-</div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="wizard-actions">
                                                <button type="button" onclick="prevStep(3)">Atrás</button>
                                                <button type="submit">Guardar actividad</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-4 parrafos-informativos">

                            <img src="../public/assets/dashboard/proveedor_turistico/completar_informacion/img/image.png" alt="logo aventura go" class="mb-3">

                            <p>
                                <strong>¿Por qué registrar una actividad?</strong> <br>
                                Registra tus actividades de turismo de aventura y permite que más personas descubran y reserven lo que ofreces
                            </p>

                            <hr>

                            <p>
                                <strong>📋 Información detallada</strong><br>
                                Completa los datos básicos de tu actividad para que los viajeros entiendan fácilmente qué experiencia van a vivir.
                            </p>

                            <hr>

                            <p>
                                <strong>Más viajeros te descubrirán</strong> <br>
                                Tu actividad aparecerá en la plataforma para que turistas interesados en aventura puedan encontrarla y reservarla.
                            </p>

                            <hr>

                            <p>
                                <strong>Conecta con aventureros</strong> <br>
                                Comparte actividades únicas en la naturaleza y conecta con viajeros que buscan experiencias reales y memorables.
                            </p>

                            <hr>

                            <p>
                                <strong>Administra tus actividades</strong> <br>
                                Podrás actualizar información, precios y disponibilidad fácilmente desde tu panel de proveedor turistico.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </section>



    <!-- JS DEPARTAMENTO → CIUDAD (NO TOCAR) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const departamentoSelect = document.getElementById('id_departamento');
            const ciudadSelect = document.getElementById('id_ciudad');

            // Cargar departamentos
            fetch('<?= BASE_URL ?>departamentos')
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

                fetch(`<?= BASE_URL ?>ciudades?id_departamento=${departamentoSelect.value}`)
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

    <script>
        function nextStep(step) {

            document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));

            document.getElementById('step-' + step).classList.add('active');

            if (step === 4) {
                cargarResumen();
            }
        }

        function prevStep(step) {
            nextStep(step);
        }


        function cargarResumen() {

            document.getElementById("prev-nombre").textContent =
                document.querySelector('input[name="nombre"]').value;

            document.getElementById("prev-ubicacion").textContent =
                document.querySelector('input[name="ubicacion"]').value;

            document.getElementById("prev-cupos").textContent =
                document.querySelector('input[name="cupos"]').value;

            document.getElementById("prev-precio").textContent =
                document.querySelector('input[name="precio"]').value;

            document.getElementById("prev-descripcion").textContent =
                document.querySelector('textarea[name="descripcion"]').value;


            let departamento =
                document.querySelector('#id_departamento option:checked')?.textContent || "-";

            let ciudad =
                document.querySelector('#id_ciudad option:checked')?.textContent || "-";


            document.getElementById("prev-departamento").textContent = departamento;
            document.getElementById("prev-ciudad").textContent = ciudad;

        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>