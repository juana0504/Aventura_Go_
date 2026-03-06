<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos - Proveedor</title>

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

    <!-- Layout global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- CSS de proveedor -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/proveedorTuristico/proveedorTuristico.css">

    <!-- CSS de ingresos (Siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/proveedorTuristico/ingresos.css">
</head>

<body>
    <section id="ingresos-proveedor">

        <aside class="sidebar">
            <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>
        </aside>

        <main class="ingresos-main">
            <header class="ingresos-topbar">
                <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>
            </header>

            <section class="ingresos-content">
                <div class="container-fluid">
                <div class="ingresos-header">
                    <div class="header-content flex-grow-1">
                        <h3><i class="bi bi-cash-stack"></i> Ingresos</h3>
                        <p>Listado detallado de ingresos por reservas confirmadas</p>
                    </div>
                    <div>
                        <a href="<?= BASE_URL ?>/proveedor/dashboard" class="btn-volver">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="ingresos-card">
                    <div class="table-responsive">
                        <table class="table ingresos-table">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-calendar"></i> Fecha reserva</th>
                                    <th><i class="bi bi-calendar-event"></i> Fecha experiencia</th>
                                    <th><i class="bi bi-geo-alt"></i> Experiencia</th>
                                    <th class="text-end"><i class="bi bi-people"></i> Cantidad</th>
                                    <th class="text-end"><i class="bi bi-tag"></i> Precio unit.</th>
                                    <th class="text-end"><i class="bi bi-cash"></i> Total</th>
                                    <th><i class="bi bi-info-circle"></i> Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ingresos)): ?>
                                    <?php $sumaTotal = 0; ?>
                                    <?php foreach ($ingresos as $row): ?>
                                        <?php $sumaTotal += (float)$row['total']; ?>
                                        <tr>
                                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['fecha_reserva']))) ?></td>
                                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['fecha_actividad']))) ?></td>
                                            <td><?= htmlspecialchars($row['nombre_actividad']) ?></td>
                                            <td class="text-end"><?= number_format($row['cantidad_personas']) ?></td>
                                            <td class="text-end"><span class="text-currency">$<?= number_format($row['precio'], 2) ?></span></td>
                                            <td class="text-end"><span class="text-currency">$<?= number_format($row['total'], 2) ?></span></td>
                                            <td>
                                                <span class="badge <?= $row['estado'] == 'confirmada' ? 'bg-success' : ($row['estado'] == 'pendiente' ? 'bg-warning text-dark' : 'bg-secondary') ?>">
                                                    <?= htmlspecialchars($row['estado']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="total-row">
                                        <td colspan="5" class="text-end"><i class="bi bi-sum"></i> Total:</td>
                                        <td class="text-end"><span class="text-currency">$<?= number_format($sumaTotal, 2) ?></span></td>
                                        <td></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <p><strong>No se encontraron ingresos</strong></p>
                                                <small>Cuando tengas reservas confirmadas, aparecerán aquí</small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                </div>
            </section>
        </main>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>