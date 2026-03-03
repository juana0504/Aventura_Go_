<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedor Turístico</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Librería AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 Layout global (Este es nuevo) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">


    <!-- CSS solo de esta vista (Siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/proveedorTuristico/proveedorTuristico.css">
</head>

<body>

    <section id="listado">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php';
        ?>

        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
            ?>
            <section id="listado">

                <main class="container">

                    <!-- Encabezado -->
                    <section class="mb-4">
                        <h3 class="fw-bold">Panel del Proveedor Turístico</h3>
                        <p class="text-muted">Gestiona tus experiencias, reservas e ingresos</p>
                    </section>

                    <!-- Tarjetas resumen -->
                    <section class="row g-4 mb-4">
                        <!-- Mis Servicios -->
                        <div class="col-md-3 col-sm-6 col-12 d-flex">
                            <div class="card shadow-sm p-3 w-100">
                                <i class="bi bi-briefcase fs-3"></i>
                                <p class="mt-2 mb-0">Mis Servicios</p>
                                <h3><?= number_format($totalServicios ?? 0) ?></h3>
                            </div>
                        </div>

                        <!-- Reservas -->
                        <div class="col-md-3 col-sm-6 col-12 d-flex">
                            <div class="card shadow-sm p-3 w-100">
                                <i class="bi bi-calendar-check fs-3"></i>
                                <p class="mt-2 mb-0">Reservas</p>
                                <h3><?= number_format($totalReservas ?? 0) ?></h3>
                            </div>
                        </div>

                        <!-- Ingresos -->
                        <div class="col-md-3 col-sm-6 col-12 d-flex">
                            <div class="card shadow-sm p-3 w-100">
                                <i class="bi bi-cash-stack fs-3"></i>
                                <p class="mt-2 mb-0">Ingresos</p>
                                <h3>$<?= number_format($ingresosPotenciales ?? 0, 2) ?></h3>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-3 col-sm-6 col-12 d-flex">
                            <div class="card shadow-sm p-3 w-100">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                                <p class="mt-2 mb-0">Estado</p>
                                <span class="badge bg-success"><?= htmlspecialchars($estado) ?></span>
                            </div>
                        </div>
                    </section>

                    <!-- Acciones rápidas -->
                    <section class="mb-5">
                        <h5 class="mb-3">Acciones rápidas</h5>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="registrar-actividad" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Nuevo actividad
                            </a>
                            <a href="consultar-reservas" class="btn btn-outline-secondary">
                                <i class="bi bi-calendar-event"></i> Ver reservas
                            </a>
                            <a href="<?= BASE_URL ?>/proveedor/ingresos" class="btn btn-outline-secondary">
                                <i class="bi bi-bar-chart-line"></i> Ver ingresos
                            </a>
                        </div>
                    </section>

                    <!-- Section de resumen de reservas con tabla -->
                    <section class="resumen-proveedor mb-5">
                        <div class="resumen-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Listado de Reservas</h5>
                            <button id="btn-filtrar" class="btn-filtrar"><i class="bi bi-funnel"></i> Filtrar</button>
                        </div>
                        <div id="filtros-reservas" style="display:none;">
                            <form id="form-filtros-proveedor" class="mb-3">
                                <div class="row g-3 align-items-end">
                                    <div class="col-auto">
                                        <label for="filtro-tipo-proveedor" class="form-label">Periodo:</label>
                                        <select id="filtro-tipo-proveedor" class="form-select">
                                            <option value="anio" selected>Año</option>
                                            <option value="mes">Mes</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="filtro-anio-container-proveedor">
                                        <label for="filtro-anio-proveedor" class="form-label">Año:</label>
                                        <select id="filtro-anio-proveedor" class="form-select">
                                            <option value="">Todos</option>
                                            <?php
                                                $anioActual = date('Y');
                                                for ($a = $anioActual; $a >= 2020; $a--) {
                                                    echo "<option value=\"$a\">$a</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="filtro-mes-container-proveedor" style="display:none;">
                                        <label for="filtro-mes-proveedor" class="form-label">Mes:</label>
                                        <select id="filtro-mes-proveedor" class="form-select">
                                            <option value="">Todos</option>
                                            <?php
                                                $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                                                foreach ($meses as $i => $m) {
                                                    $num = $i + 1;
                                                    echo "<option value=\"$num\">$m</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="aplicar-filtros-proveedor" class="btn btn-primary btn-sm"><i class="bi bi-check-circle"></i> Aplicar</button>
                                        <button type="button" id="limpiar-filtros-proveedor" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tabla-reservas">
                            <table class="table table-striped align-middle" id="tabla-reservas-proveedor">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Experiencia</th>
                                        <th>Cantidad Personas</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($reservasRecientes)): ?>
                                        <?php foreach ($reservasRecientes as $r): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($r['nombre_turista']) ?></td>
                                                <td><?= htmlspecialchars($r['fecha']) ?></td>
                                                <td><?= htmlspecialchars($r['nombre_actividad']) ?></td>
                                                <td><?= htmlspecialchars($r['cantidad_personas']) ?></td>
                                                <td>$<?= number_format($r['precio'], 2) ?></td>
                                                <td><span class="badge <?= $r['estado']=='confirmada' ? 'bg-success' : ($r['estado']=='pendiente' ? 'bg-warning text-dark' : 'bg-secondary') ?>"><?= htmlspecialchars($r['estado']) ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6" class="text-center">No hay reservas recientes.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                </main>

            </section>

        </div>

    </section>

    <!-- Scripts -->
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- JavaScript variables -->
    <script>
        const PROVEEDOR_DASHBOARD_DATA_URL = "<?= BASE_URL ?>/proveedor/dashboard/data";
    </script>
    <!-- JavaScript -->
    <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/proveedorTuristico/dashboard_proveedor.js"></script>

</body>

</html>