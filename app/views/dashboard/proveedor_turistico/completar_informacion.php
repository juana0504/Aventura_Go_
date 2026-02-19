<?php

require_once BASE_PATH . '/app/helpers/session_proveedor.php';

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedor de Turismo</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- Estilos CSS (siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/completar_informacion/completar_informacion.css">

</head>

<body>
    <!-- Layout Principal con Panel y Contenido -->
    <section id="proveedor-dashboard">

        <!-- Panel Lateral -->
        <?php
        include_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php';
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            include_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
            ?>

            <!-- Formulario Wizard -->
            <form action="<?= BASE_URL ?>/proveedor/guardar-informacion" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="accion" value="registrar">

                <div class="wizard-container">
                    <div class="wizard-header">
                        <p class="mb-0">Registro de Proveedor de Turismo</p>
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
                            <div class="step-label">Confirmación</div>
                        </div>
                    </div>

                    <div class="wizard-content">
                        <!-- Paso 1 -->
                        <div class="step-content active" data-step="1">
                            <h4 class="mb-4"><i class="fas fa-building text-primary"></i> Información Básica del Proveedor</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre de la Empresa *</label>
                                    <input type="text" name="nombre_empresa" class="form-control" id="empresa" placeholder="Ej: Aventuras Extremas SAS" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIT/RUT *</label>
                                    <input type="text" name="nit_rut" class="form-control" id="nit" placeholder="123456789-0" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="contacto@empresa.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+57 300 123 4567" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Logo</label>
                                    <input type="file" accept=".jpg, .png, .jpeg" name="logo" class="form-control" id="logo" required>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2 -->
                        <div class="step-content" data-step="2">
                            <h4 class="mb-4"><i class="fas fa-hiking text-primary"></i> Servicios Ofrecidos</h4>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Tipo de Actividades</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="rafting" value="Rafting">
                                                <label class="form-check-label">🚣 Rafting</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="parapente" value="Parapente">
                                                <label class="form-check-label">🪂 Parapente</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="senderismo" value="Senderismo">
                                                <label class="form-check-label">🥾 Senderismo</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="escalada" value="Escalada">
                                                <label class="form-check-label">🧗 Escalada</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="buceo" value="Buceo">
                                                <label class="form-check-label">🤿 Buceo</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="camping" value="Camping">
                                                <label class="form-check-label">🏕 Camping</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="ciclismo" value="Ciclismo de Montaña">
                                                <label class="form-check-label">🚵 Ciclismo de Montaña</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="actividades[]" id="canopy" value="Canopy">
                                                <label class="form-check-label">🌲 Canopy</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 3 -->
                        <div class="step-content" data-step="3">
                            <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Ubicación</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="departamento">Departamento *</label>
                                    <select name="departamento" id="departamento" class="form-control" required>
                                        <option value="">Seleccione un departamento</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                                        <option value="">Seleccione una ciudad</option>
                                        <?php if (!empty($ciudades)): ?>
                                            <?php foreach ($ciudades as $ciudad): ?>
                                                <option value="<?= $ciudad['id_ciudad']; ?>">
                                                    <?= $ciudad['nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Dirección *</label>
                                    <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Calle 123 #45-67" required>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 4 -->
                        <div class="step-content" data-step="4">
                            <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Representante</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre del Representante *</label>
                                    <input type="text" name="nombre_representante" class="form-control" id="nombre_repre" placeholder="Juan Pérez" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de documento *</label>
                                    <select name="tipo_documento" class="form-select1" id="tipo_documento">
                                        <option value="" disabled selected hidden>Tipo de documento</option>
                                        <option value="CC">CC</option>
                                        <option value="CE">CE</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Identificacion *</label>
                                    <input type="tel" name="identificacion_representante" class="form-control" id="identificacion_repre" placeholder="N.°" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Foto</label>
                                    <input type="file" accept=".jpg, .png, .jpeg" name="foto_representante" class="form-control" id="foto_representante" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email_representante" class="form-control" id="email_repre" placeholder="contacto@empresa.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="tel" name="telefono_representante" class="form-control" id="telefono_repre" placeholder="+57 300 123 4567" required>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 5 -->
                        <div class="step-content" data-step="5">
                            <div class="text-center">
                                <i class="fas fa-check-circle success-icon"></i>
                                <h4>Confirma tu Registro</h4>
                            </div>
                            <div class="preview-card">
                                <h6 class="text-primary mb-3"><i class="fas fa-building"></i> Información Básica</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Empresa</div>
                                        <div class="preview-value" id="prev-empresa">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">NIT/RUT</div>
                                        <div class="preview-value" id="prev-nit">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Representante</div>
                                        <div class="preview-value" id="prev-representante">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Email</div>
                                        <div class="preview-value" id="prev-email">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Telefono</div>
                                        <div class="preview-value" id="prev-telefono">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-card">
                                <h6 class="text-primary mb-3"><i class="fas fa-hiking"></i> Servicios</h6>
                                <div id="prev-actividades">-</div>
                            </div>
                            <div class="preview-card">
                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt"></i> Ubicación</h6>
                                <div class="preview-value" id="prev-ubicacion">-</div>
                            </div>
                            <div class="preview-card">
                                <h6 class="text-primary mb-3"><i class="fas fa-building"></i> Representante</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Nombre del Representante</div>
                                        <div class="preview-value" id="prev-nombre_repre">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Email del Representante</div>
                                        <div class="preview-value" id="prev-email_repre">-</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="preview-label">Telefono del Representante</div>
                                        <div class="preview-value" id="prev-telefono_repre">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-card">
                                <h6 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Descripción</h6>
                                <div class="preview-value" id="prev-descripcion">-</div>
                            </div>
                        </div>

                    </div>

                    <div class="wizard-actions">
                        <button type="button" class="btn btn-secondary-wizard" id="prevBtn" style="display:none;">
                            <i class="fas fa-arrow-left"></i> Anterior
                        </button>

                        <button type="button" class="btn btn-primary-wizard" id="nextBtn">
                            Siguiente <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/completar_informacion/completar_informacion.js"></script>
    <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/completar_informacion/departamento.js"></script>


</body>

</html>