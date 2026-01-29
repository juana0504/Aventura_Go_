<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas - Aventura Go</title>

    <style>
        /* Fuentes */
        @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap');

        body {
            margin: 30px;
        }

        /* Encabezado */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .header img {
            width: 120px;
        }

        h1 {
            color: #2D4059;
            font-size: 22px;
            margin-top: 10px;
            text-transform: uppercase;
            font-family: 'Raleway', sans-serif;
        }

        p {
            color: #000000;
            font-size: 12px;
            margin-bottom: 25px;
            font-family: 'Lato', sans-serif;
        }

        /* Estadísticas */
        .estadisticas-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .estadistica-item {
            background-color: #f8f9fa;
            border-left: 4px solid #2D4059;
            padding: 15px;
            text-align: center;
        }

        .estadistica-item .numero {
            font-size: 20px;
            font-weight: bold;
            color: #2D4059;
            font-family: 'Raleway', sans-serif;
        }

        .estadistica-item .label {
            font-size: 11px;
            color: #666;
            font-family: 'Lato', sans-serif;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 15px;
        }

        table th {
            background-color: #2D4059;
            color: #ffffff;
            font-weight: 700;
            font-family: 'Lato', sans-serif;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            padding: 15px 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-family: 'Lato', sans-serif;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-pendiente {
            background-color: #ffc107;
            color: #000;
        }

        .badge-confirmada {
            background-color: #28a745;
            color: #fff;
        }

        .badge-cancelada {
            background-color: #dc3545;
            color: #fff;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        strong {
            font-weight: 700;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Encabezado -->
    <div class="header">
        <img src="<?= BASE_URL ?>/public/assets/estilos_globales/img/LOGO-FINAL.png" alt="Logo Aventura Go">
    </div>

    <h1>Reporte de Reservas</h1>

    <p>
        El presente documento contiene el registro consolidado de las reservas gestionadas por su empresa en Aventura Go. Este reporte
        permite evaluar el rendimiento de sus actividades turísticas, analizar el comportamiento de los clientes y mantener
        actualizada la información relevante para la gestión administrativa.
    </p>

    <p>
        <strong>Proveedor:</strong> <?= htmlspecialchars($_SESSION['nombre_empresa']) ?><br>
        <strong>Fecha de generación:</strong> <?= date('Y-m-d H:i:s') ?><br>
        <strong>Filtro aplicado:</strong> <?= $filtro_actual ? ucfirst($filtro_actual) : 'Todas las reservas' ?>
    </p>

    <!-- Estadísticas -->
    <?php if (isset($estadisticas_pdf) && $estadisticas_pdf): ?>
    <div class="estadisticas-grid">
        <div class="estadistica-item">
            <div class="numero"><?= number_format($estadisticas_pdf['total_reservas'] ?? 0) ?></div>
            <div class="label">Total Reservas</div>
        </div>
        <div class="estadistica-item">
            <div class="numero"><?= number_format($estadisticas_pdf['pendientes'] ?? 0) ?></div>
            <div class="label">Pendientes</div>
        </div>
        <div class="estadistica-item">
            <div class="numero"><?= number_format($estadisticas_pdf['confirmadas'] ?? 0) ?></div>
            <div class="label">Confirmadas</div>
        </div>
        <div class="estadistica-item">
            <div class="numero"><?= number_format($estadisticas_pdf['canceladas'] ?? 0) ?></div>
            <div class="label">Canceladas</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tabla de Reservas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Actividad</th>
                <th>Turista</th>
                <th>Fecha</th>
                <th>Personas</th>
                <th>Precio Unit.</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($reservas_pdf) && count($reservas_pdf) > 0): ?>
                <?php 
                $total_reservas = 0;
                $total_ingresos = 0;
                $total_personas = 0;
                
                foreach ($reservas_pdf as $reserva): 
                    $total_reservas++;
                    $total_personas += $reserva['cantidad_personas'];
                    $precio_unitario = $reserva['precio'] ?? 0;
                    $total_reserva = $precio_unitario * $reserva['cantidad_personas'];
                    $total_ingresos += $total_reserva;
                ?>
                <tr>
                    <td class="text-center"><?= $reserva['id_reserva'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($reserva['nombre_actividad']) ?></strong>
                        <br><small style="color: #666;"><?= htmlspecialchars($reserva['ubicacion']) ?></small>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($reserva['nombre_turista']) ?></strong>
                        <br><small style="color: #666;"><?= htmlspecialchars($reserva['email_turista']) ?></small>
                    </td>
                    <td class="text-center"><?= date('Y-m-d', strtotime($reserva['fecha'])) ?></td>
                    <td class="text-center"><?= $reserva['cantidad_personas'] ?></td>
                    <td class="text-right">$<?= number_format($precio_unitario, 0) ?></td>
                    <td class="text-right"><strong>$<?= number_format($total_reserva, 0) ?></strong></td>
                    <td class="text-center">
                        <?php
                        $badgeClass = 'badge-' . $reserva['estado'];
                        echo "<span class='$badgeClass'>" . ucfirst($reserva['estado']) . "</span>";
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No se encontraron reservas con los filtros seleccionados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Resumen de Totales -->
    <?php if (!empty($reservas_pdf) && count($reservas_pdf) > 0): ?>
    <div style="margin-top: 20px; text-align: right; font-family: 'Lato', sans-serif;">
        <p style="margin: 5px 0;"><strong>Total Reservas:</strong> <?= number_format($total_reservas) ?></p>
        <p style="margin: 5px 0;"><strong>Total Personas:</strong> <?= number_format($total_personas) ?></p>
        <p style="margin: 5px 0;"><strong>Ingresos Potenciales:</strong> $<?= number_format($total_ingresos, 0) ?></p>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        © Aventura Go 2025 - Todos los derechos reservados
    </footer>

</body>

</html>