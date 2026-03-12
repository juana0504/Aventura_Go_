<?php

require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedor hotelero</title>

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
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css"> -->

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_hotelero.css">

    <!-- Estilos CSS (siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_hotelero/registrar_informacion/registrar_informacion.css">

</head>

<body>
    <!-- Layout Principal con Panel y Contenido -->
    <section id="informacion-hotelero">

        <!-- PANEL LATERAL -->
        <aside class="sidebar">
            <?php
            include_once __DIR__ . '/../../layouts/proveedor_hotelero_panel_izq.php';
            ?>
        </aside>

        <!-- Contenido Principal -->
        <main class="informacion-main">

            <!-- BARRA SUPERIOR -->
            <header class="informacion-topbar">
                <button id="btnMenu" class="btn-hamburguesa">
                    <i class="fas fa-bars"></i>
                </button>
                <?php
                include_once __DIR__ . '/../../layouts/buscador_proveedor_hotelero.php';
                ?>
            </header>

            <!-- CONTENIDO DE LA PAGINA -->
            <section class="formulario">

                <div class="container">

                    <div class="row g-4">

                        <div class="col-12 col-md-9 col-lg-9">

                            <!-- Formulario Wizard -->
                            <form id="formProveedor" action="<?= BASE_URL ?>/proveedor_hotelero/guardar-informacion" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="accion" value="registrar">

                                <!-- botones indicadores superiores del wizard -->

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
                                            <div class="step-label">Representante</div>
                                        </div>
                                        <div class="step" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-label">Ubicación</div>
                                        </div>
                                        <div class="step" data-step="4">
                                            <div class="step-circle">4</div>
                                            <div class="step-label">Tipo de habitación</div>
                                        </div>
                                        <div class="step" data-step="5">
                                            <div class="step-circle">5</div>
                                            <div class="step-label">Documentación</div>
                                        </div>
                                        <div class="step" data-step="6">
                                            <div class="step-circle">6</div>
                                            <div class="step-label">Confirmacion</div>
                                        </div>
                                    </div>


                                    <!-- CONTENIUDO DE LOS FIRMULARIOS DE INGRESO -->
                                    <div class="wizard-content">
                                        <!-- Paso 1 Información Básica del Proveedor Hotelero, nombre, email,tel, logo y tipo establecimiento-->
                                        <div class="step-content active" data-step="1">
                                            <h4 class="mb-4"><i class="fas fa-building text-primary"></i> Información Básica del Proveedor Hotelero</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <!-- Nombre establecimiento -->
                                                    <label class="form-label" for="nombre_establecimiento">Nombre del establecimiento:</label>
                                                    <input type="text" name="nombre_establecimiento" id="nombre_establecimiento" class="form-control" maxlength="100" required>
                                                    <br><br>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email:</label>
                                                    <input type="email" name="email" class="form-control" id="email" placeholder="contacto@empresa.com" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Teléfono:</label>
                                                    <input type="number" name="telefono" class="form-control" id="telefono" placeholder="+57 300 123 4567" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Logo</label>
                                                    <input type="file" accept=".jpg, .png, .jpeg" name="logo" class="form-control" id="logo" required>
                                                </div>

                                                <div class="col-md-12 mb-4">
                                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de establecimiento</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hotel" value="Hotel">
                                                                <label class="form-check-label">Hotel</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="cabana" value="Cabaña">
                                                                <label class="form-check-label">Cabaña</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="hostal" value="Hostal">
                                                                <label class="form-check-label">Hostal</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_establecimiento[]" id="glamping" value="Glamping">
                                                                <label class="form-check-label">Glamping</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- paso 2 representante(nombre, cc foto email tel)-->
                                        <div class="step-content" data-step="2">
                                            <h4 class="mb-4"><i class="bi bi-person-fill"></i> Representante</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nombre del Representante:</label>
                                                    <input type="text" name="nombre_representante" class="form-control" id="nombre_repre" placeholder="Juan Pérez" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tipo de documento:</label>
                                                    <select name="tipo_documento" class="form-select" id="tipo_documento">
                                                        <option value="" disabled selected hidden>Tipo de documento</option>
                                                        <option value="CC">CC</option>
                                                        <option value="CE">CE</option>
                                                        <option value="Pasaporte">Pasaporte</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Identificacion:</label>
                                                    <input type="number" name="identificacion_representante" class="form-control" id="identificacion_repre" placeholder="N.°" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Foto:</label>
                                                    <input type="file" accept=".jpg, .png, .jpeg" name="foto_representante" class="form-control" id="foto_representante" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email:</label>
                                                    <input type="email" name="email_representante" class="form-control" id="email_repre" placeholder="contacto@empresa.com" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Teléfono:</label>
                                                    <input type="number" name="telefono_representante" class="form-control" id="telefono_repre" placeholder="+57 300 123 4567" required>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- paso 3 ubicacion (dep ciudad)-->
                                        <div class="step-content" data-step="3">
                                            <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Ubicación</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="departamento">Departamento:</label>
                                                    <select name="departamento" id="departamento" class="form-select" required>
                                                        <option value="">Seleccione un departamento</option>
                                                    </select>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ciudad">Ciudad:</label>
                                                    <select name="id_ciudad" id="id_ciudad" class="form-select" required>
                                                        <option value="">Seleccione una ciudad</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Dirección:</label>
                                                    <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Calle 123 #45-67" required>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- paso 4 Tipo establecimiento, max huesped, servicios incluidos (ENUM) -->
                                        <div class="step-content" data-step="4">
                                            <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de habitación</h4>
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Estandar" value="Estandar">
                                                                <label class="form-check-label">Estándar</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Doble" value="Doble">
                                                                <label class="form-check-label">Doble</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Suite" value="Suite">
                                                                <label class="form-check-label">Suite</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Familiar" value="Familiar">
                                                                <label class="form-check-label">Familiar</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="tipo_habitacion[]" id="Premium" value="Premium">
                                                                <label class="form-check-label">Premium</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Número máximo de huéspedes:</label>
                                                    <input type="number" name="max_huesped" class="form-control" id="max_huesped" placeholder="ej: 40" required>
                                                </div>


                                                <div class="col-md-12 mb-4">
                                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Servicios incluidos</h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="WiFi" value="WiFi">
                                                                <label class="form-check-label">WiFi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Parqueadero" value="Parqueadero">
                                                                <label class="form-check-label">Parqueadero</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Piscina" value="Piscina">
                                                                <label class="form-check-label">Piscina</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Restaurante" value="Restaurante">
                                                                <label class="form-check-label">Restaurante</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Bar" value="Bar">
                                                                <label class="form-check-label">Bar</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Spa" value="Spa">
                                                                <label class="form-check-label">Spa</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Pet_Friendly" value="Pet Friendly">
                                                                <label class="form-check-label">Pet Friendly</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Servicio_al_cuarto" value="Servicio al cuarto">
                                                                <label class="form-check-label">Servicio al cuarto</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Transporte" value="Transporte">
                                                                <label class="form-check-label">Transporte</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Desayuno_incluido" value="Desayuno incluido">
                                                                <label class="form-check-label">Desayuno incluido</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="servicio_incluido[]" id="Accesibilidad" value="Accesibilidad">
                                                                <label class="form-check-label">Accesibilidad</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- paso 5  documentacion (cam comercio, licencia) y pagos-->
                                        <div class="step-content" data-step="5">
                                            <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary"></i> Documentación obligatoria</h4>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">NIT/RUT:</label>
                                                    <input type="text" name="nit_rut" class="form-control" id="nit_rut" placeholder="123456789-0" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Camara de Comercio:</label>
                                                    <input type="number" name="camara_comercio" class="form-control" id="camara_comercio" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Licencia:</label>
                                                    <input type="number" name="licencia" class="form-control" id="licencia" required>
                                                </div>

                                                <div class="col-md-12 mb-4">
                                                    <h4 class="mb-4"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de pago</h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Tarjeta_Crédito" value="Tarjeta de Crédito">
                                                                <label class="form-check-label">Tarjeta de Crédito</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Tarjeta_Débito" value="Tarjeta Débito">
                                                                <label class="form-check-label">Tarjeta Débito</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="PSE" value="PSE">
                                                                <label class="form-check-label">PSE</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="metodo_pago[]" id="Nequi" value="Nequi">
                                                                <label class="form-check-label">Nequi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Paso 6  confirmacion-->
                                        <div class="step-content" data-step="6">
                                            <div class="text-center">
                                                <i class="fas fa-check-circle success-icon"></i>
                                                <h4>Confirma tu Registro</h4>
                                            </div>
                                            <div class="preview-card">
                                                <h6 class="text-primary mb-3"><i class="fas fa-building"></i> Información Básica</h6>
                                                <p><strong>Nombre del establecimiento:</strong> <span id="preview_nombre_establecimiento"></span></p>
                                                <p><strong>Email:</strong> <span id="preview_email"></span></p>
                                                <p><strong>Teléfono:</strong> <span id="preview_telefono"></span></p>
                                                <p><strong>Tipo de establecimiento:</strong> <span id="preview_tipo_establecimiento"></span></p>
                                                <hr>
                                                <h6 class="text-primary mb-3"><i class="bi bi-person-fill"></i> Representante</h6>
                                                <p><strong>Nombre del Representante:</strong> <span id="preview_nombre_representante"></span></p>
                                                <p><strong>Tipo de documento:</strong> <span id="preview_tipo_documento"></span></p>
                                                <p><strong>Identificacion:</strong> <span id="preview_identificacion_representante"></span></p>
                                                <p><strong>Email:</strong> <span id="preview_email_representante"></span></p>
                                                <p><strong>Teléfono:</strong> <span id="preview_telefono_representante"></span></p>
                                                <hr>
                                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt"></i> Ubicación</h6>
                                                <p><strong>Departamento:</strong> <span id="preview_departamento"></span></p>
                                                <p><strong>Ciudad:</strong> <span id="preview_ciudad"></span></p>
                                                <p><strong>Dirección:</strong> <span id="preview_direccion"></span></p>
                                                <hr>
                                                <h6 class="text-primary mb-3"><i class="bi bi-file-earmark-medical-fill"></i> Tipo de habitación</h6>
                                                <p><strong>Tipo de habitación:</strong> <span id="preview_tipo_habitacion"></span></p>
                                                <p><strong>Número máximo de huéspedes:</strong> <span id="preview_max_huesped"></span></p>
                                                <p><strong>Servicios incluidos:</strong> <span id="preview_servicio_incluido"></span></p>
                                                <hr>
                                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt"></i> Documentación obligatoria</h6>
                                                <p><strong>NIT/RUT:</strong> <span id="preview_nit_rut"></span></p>
                                                <p><strong>Camara de Comercio:</strong> <span id="preview_camara_comercio"></span></p>
                                                <p><strong>Licencia:</strong> <span id="preview_licencia"></span></p>
                                                <p><strong>Tipo de pago:</strong> <span id="preview_metodo_pago"></span></p>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="wizard-actions">
                                        <button type="button" class="btn btn-secondary-wizard1" id="prevBtn" style="display:none;">
                                            <i class="fas fa-arrow-left"></i> Anterior
                                        </button>

                                        <button type="button" class="btn btn-primary-wizard" id="nextBtn">
                                            Siguiente <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3 parrafos-informativos">

                            <img src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/registrar_informacion/img/image.png"
                                class="img-fluid mb-3" alt="logo aventura go">
                            <p>
                                <strong>¿Por qué registrar tu empresa?</strong> <br>
                                En Aventura Go conectamos viajeros con experiencias auténticas de turismo de aventura.
                            </p>

                            <hr>

                            <p>
                                <strong>📋 Información clara</strong><br>
                                Completa los datos de tu empresa para mostrar tus actividades de forma profesional.
                            </p>

                            <hr>

                            <p>
                                <strong>🌎 Mayor visibilidad</strong> <br>
                                Los viajeros podrán descubrir y reservar tus experiencias desde la plataforma.
                            </p>

                            <hr>

                            <p>
                                <strong>🤝 Turismo responsable</strong> <br>
                                Promovemos el turismo sostenible, apoyando a prestadores locales y experiencias seguras en la naturaleza.
                            </p>

                            <hr>

                            <p>
                                <strong>🎉 Registro rápido</strong> <br>
                                ¡Registra tu empresa hoy mismo y comienza a atraer a más aventureros a tus experiencias únicas!
                            </p>
                        </div>

                    </div>
                </div>
            </section>
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_hotelero/registrar_informacion/registrar_informacion.js"></script>
    <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_hotelero/registrar_informacion/departamento.js"></script>


</body>

</html>