<?php

require_once BASE_PATH . '/app/helpers/session_administrador.php';

$getPagoColorClass = static function (string $texto = ''): string {
    $textoNormalizado = strtolower($texto);

    if (strpos($textoNormalizado, 'experiencia') !== false) {
        return 'green_r';
    }

    if (strpos($textoNormalizado, 'operador') !== false) {
        return 'blue_r';
    }

    if (strpos($textoNormalizado, 'reserva') !== false) {
        return 'red_r';
    }

    return 'blue_r';
};

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

    <div id="listado">

        <?php
        include_once __DIR__ . '/../../layouts/panel_izq_administrador.php'
        ?>

        <div class="info">

            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php'
            ?>

            <div class="dashboard-content" data-dashboard-url="<?= BASE_URL ?>/administrador/dashboard/data">

                <main class="main-content">
                    <section class="summary-cards">
                        <div class="card-item">
                            <i class="bi bi-graph-up-arrow"></i>
                            <div>
                                <p>Total de Reservas</p>
                                <h3><?= number_format($totalReservas ?? 0) ?></h3>
                            </div>
                        </div>

                        <div class="card-item green">
                            <i class="bi bi-person-circle"></i>
                            <div>
                                <p>Reservas Diarias</p>
                                <h3><?= number_format($reservasDiarias ?? 0) ?></h3>
                            </div>
                        </div>

                        <div class="card-item blue">
                            <i class="bi bi-globe-central-south-asia-fill"></i>
                            <div>
                                <p>Experiencias Activas</p>
                                <h3><?= number_format($experienciasActivas ?? 0) ?></h3>
                            </div>
                        </div>

                        <div class="card-item purple">
                            <i class="bi bi-tencent-qq"></i>
                            <div>
                                <p>Inversión en Publicidad</p>
                                <h3>$<?= number_format($inversionPublicidad ?? 0, 2) ?></h3>
                            </div>
                        </div>
                    </section>

                    <section class="resumen-reservas">
                        <div class="resumen-header">
                            <h3>Resumen de Reservas</h3>
                            <button class="btn-filtrar"><i class="bi bi-funnel"></i> Filtrar</button>
                        </div>

                        <div id="filtros-reservas" style="display:none;">
                            <form id="form-filtros">
                                <div class="row g-3 align-items-end">
                                    <div class="col-auto">
                                        <label for="filtro-tipo" class="form-label">Período:</label>
                                        <select id="filtro-tipo" class="form-select">
                                            <option value="anio" selected>Año</option>
                                            <option value="mes">Mes</option>
                                        </select>
                                    </div>

                                    <div class="col-auto" id="filtro-anio-container">
                                        <label for="filtro-anio" class="form-label">Año:</label>
                                        <select id="filtro-anio" class="form-select">
                                            <option value="">Todos</option>
                                            <?php
                                            $anioActual = date('Y');
                                            for ($a = $anioActual; $a >= 2020; $a--) {
                                                echo "<option value=\"$a\">$a</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-auto" id="filtro-mes-container" style="display:none;">
                                        <label for="filtro-mes" class="form-label">Mes:</label>
                                        <select id="filtro-mes" class="form-select">
                                            <option value="">Todos</option>
                                            <?php
                                            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                            foreach ($meses as $i => $m) {
                                                $num = $i + 1;
                                                echo "<option value=\"$num\">$m</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" id="aplicar-filtros" class="btn btn-primary btn-sm"><i class="bi bi-check-circle"></i> Aplicar</button>
                                        <button type="button" id="limpiar-filtros" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="grafico-container">
                            <canvas id="reservasChart"></canvas>
                        </div>

                        <div class="mt-4">
                            <?php if (!empty($reservasRecientes)): ?>
                                <div class="tabla-scroll">
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
                                </div>
                            <?php else: ?>
                                <p class="text-secondary">No se encontraron reservas recientes.</p>
                            <?php endif; ?>
                        </div>
                    </section>

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
                        <h4>$<?= number_format($ingresosDisponibles ?? 0, 2) ?></h4>
                        <p>Ingresos Disponibles</p>
                    </div>

                    <div class="pagos">
                        <h6>Próximos Pagos</h6>
                        <?php if (empty($proximosPagos)): ?>
                            <p class="text-secondary">No hay pagos próximos.</p>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($proximosPagos as $pago): ?>
                                    <li><span class="dot <?= $getPagoColorClass($pago['texto'] ?? '') ?>"></span>
                                        <?= htmlspecialchars($pago['texto']) ?>
                                        <span class="amount">$<?= number_format($pago['cantidad'] ?? 0, 2) ?></span>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/administrador.js"></script>



</body>

</html>