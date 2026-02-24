<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

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

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel.css">

    <!-- CSS SOLO DE ESTA VISTA (SIEMPRE AL FINAL) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/administrador.css">
</head>


<body>

    <section id="listado">

        <!-- aca va el menu o panel izq -->
        <?php
        include_once __DIR__ . '/../../layouts/panel_izq_administrador.php'
        ?>

        <div class="info">

            <!-- aca va el buscador -->
            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php'
            ?>

            <!-- Contenedor principal del dashboard -->
            <div class="dashboard-content">

                <main class="main-content">
                    <!-- Tarjetas de resumen -->
                    <section class="summary-cards">
                        <div class="card-item">
                            <i class="bi bi-graph-up-arrow"></i>
                            <div>
                                <p>Total de Reservas</p>
                                <h3><?= number_format($totalReservas) ?></h3>
                            </div>
                        </div>

                        <div class="card-item green">
                            <i class="bi bi-person-circle"></i>
                            <div>
                                <p>Reservas Diarias</p>
                                <h3><?= number_format($reservasDiarias) ?></h3>
                            </div>
                        </div>

                        <div class="card-item blue">
                            <i class="bi bi-globe-central-south-asia-fill"></i>
                            <div>
                                <p>Experiencias Activas</p>
                                <h3><?= number_format($experienciasActivas) ?></h3>
                            </div>
                        </div>

                        <div class="card-item purple">
                            <i class="bi bi-tencent-qq"></i>
                            <div>
                                <p>Inversión en Publicidad</p>
                                <h3>$<?= number_format($inversionPublicidad ?? 0,2) ?></h3>
                            </div>
                        </div>
                    </section>

                    <!-- Resumen de reservas -->
                    <section class="resumen-reservas">
                        <div class="resumen-header">
                            <h3>Resumen de Reservas</h3>
                            <button class="btn-filtrar">Filtrar ▼</button>
                        </div>
                        <!-- zona de filtros ocultos -->
                        <div id="filtros-reservas" class="mt-2" style="display:none;">
                            <form id="form-filtros">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <label for="filtro-anio" class="col-form-label">Año:</label>
                                    </div>
                                    <div class="col-auto">
                                        <select id="filtro-anio" class="form-select">
                                            <option value="">Todos</option>
                                            <?php
                                                // genera años desde 2020 hasta el actual
                                                $anioActual = date('Y');
                                                for ($a = $anioActual; $a >= 2020; $a--) {
                                                    echo "<option value=\"$a\">$a</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="aplicar-filtros" class="btn btn-primary btn-sm">Aplicar</button>
                                        <button type="button" id="limpiar-filtros" class="btn btn-secondary btn-sm">Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="grafico-container">
                            <canvas id="reservasChart"></canvas>
                        </div>
                        <!-- los datos necesarios para los gráficos se obtienen mediante AJAX desde /administrador/dashboard/data -->

                        <!-- tabla de reservas recientes -->
                        <div class="mt-4">
                            <?php if (!empty($reservasRecientes)): ?>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Precio</th>
                                            <th>Experiencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reservasRecientes as $r): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($r['cliente']) ?></td>
                                                <td><?= htmlspecialchars($r['fecha']) ?></td>
                                                <td><?= htmlspecialchars($r['precio']) ?></td>
                                                <td><?= htmlspecialchars($r['experiencia']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-secondary">No se encontraron reservas recientes.</p>
                            <?php endif; ?>
                        </div>
                    </section>


                    <!-- Última reserva -->
                    <section class="ultima-reserva bg-light p-3 rounded mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold">Última Reserva</h6>
                            <button class="btn btn-sm text-white">Filtrar</button>
                        </div>
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Precio</th>
                                    <th>Experiencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php if (!empty($ultimaReserva)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ultimaReserva['cliente']) ?></td>
                                        <td><?= htmlspecialchars($ultimaReserva['fecha']) ?></td>
                                        <td><?= htmlspecialchars($ultimaReserva['precio']) ?></td>
                                        <td><?= htmlspecialchars($ultimaReserva['experiencia']) ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Sin reservas recientes</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </section>
                </main>

                <!-- Panel derecho -->
                <aside class="summary-panel">
                    <div class="ingresos">
                        <h4>$<?= number_format($ingresosDisponibles,2) ?></h4>
                        <p>Ingresos Disponibles</p>
                    </div>

                    <div class="pagos">
                        <h6>Próximos Pagos</h6>
                        <?php if (empty($proximosPagos)): ?>
                            <p class="text-secondary">No hay pagos próximos.</p>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($proximosPagos as $pago): ?>
                                    <?php
                                        // si la base no guarda color, elegimos uno por palabra clave
                                        $texto = strtolower($pago['texto'] ?? '');
                                        if (strpos($texto, 'experiencia') !== false) {
                                            $color = 'green_r';
                                        } elseif (strpos($texto, 'operador') !== false) {
                                            $color = 'blue_r';
                                        } elseif (strpos($texto, 'reserva') !== false) {
                                            $color = 'red_r';
                                        } else {
                                            $color = 'blue_r';
                                        }
                                    ?>
                                    <li><span class="dot <?= $color ?>"></span>
                                        <?= htmlspecialchars($pago['texto']) ?>
                                        <span class="amount">$<?= number_format($pago['cantidad'] ?? 0,2) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="gastos">
                        <h6>Estado de Gastos</h6>
                        <canvas id="gastosChart"></canvas>
                    </div>
                </aside>


            </div>

        </div>

    </section>




    <!-- aca va los script  -->
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- JavaScript variables needed by scripts -->
    <script>
        // valores que necesita el JS, proporcionados por el servidor pero sin mezclar en el archivo estático
        const DASHBOARD_DATA_URL = "<?= BASE_URL ?>/administrador/dashboard/data";
    </script>
    <!-- JavaScript -->
    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/administrador.js"></script>



</body>

</html>