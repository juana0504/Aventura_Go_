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

        /* Información del Turista */
        .info-turista {
            background-color: #f8f9fa;
            border-left: 4px solid #2D4059;
            padding: 15px;
            margin-bottom: 25px;
        }

        .info-turista h3 {
            color: #2D4059;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 10px;
            font-family: 'Raleway', sans-serif;
        }

        .info-item {
            font-size: 12px;
            margin-bottom: 5px;
            font-family: 'Lato', sans-serif;
        }

        .info-item strong {
            color: #2D4059;
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

        /* Actividades Populares */
        .actividades-populares {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 25px;
        }

        .actividades-populares h3 {
            color: #856404;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 10px;
            font-family: 'Raleway', sans-serif;
        }

        .actividades-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .actividad-item {
            font-size: 11px;
            display: flex;
            align-items: center;
            font-family: 'Lato', sans-serif;
        }

        .actividad-item i {
            color: #ffc107;
            margin-right: 8px;
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

        .badge-completada {
            background-color: #007bff;
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

    <h1>Mis Reservas</h1>

    <p>
        El presente documento contiene el registro consolidado de sus reservas realizadas en Aventura Go. Este reporte
        permite evaluar sus actividades turísticas preferidas, analizar su historial de reservas y mantener
        actualizada la información relevante para su gestión personal.
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

    <!-- Actividades Populares -->
    <?php if (!empty($actividades_populares_pdf) && count($actividades_populares_pdf) > 0): ?>
    <div class="actividades-populares">
        <h3><i class="bi bi-star-fill"></i> Sus Actividades Favoritas</h3>
        <div class="actividades-grid">
            <?php foreach ($actividades_populares_pdf as $actividad): ?>
            <div class="actividad-item">
                <i class="bi bi-trophy-fill"></i>
                <strong><?= htmlspecialchars($actividad['nombre_actividad']) ?></strong> - <?= $actividad['veces_reservada'] ?> veces
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tabla de Reservas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Actividad</th>
                <th>Proveedor</th>
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
                $total_invertido = 0;
                $total_personas = 0;
                
                foreach ($reservas_pdf as $reserva): 
                    $total_reservas++;
                    $total_personas += $reserva['cantidad_personas'];
                    $precio_unitario = $reserva['precio'] ?? 0;
                    $total_reserva = $precio_unitario * $reserva['cantidad_personas'];
                    $total_invertido += $total_reserva;
                ?>
                <tr>
                    <td class="text-center"><?= $reserva['id_reserva'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($reserva['nombre_actividad']) ?></strong>
                        <br><small style="color: #666;"><?= htmlspecialchars($reserva['nombre_ciudad']) ?></small>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($reserva['nombre_empresa']) ?></strong>
                        <br><small style="color: #666;"><?= htmlspecialchars($reserva['email_representante']) ?></small>
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
                    <td colspan="9" class="text-center">No se encontraron reservas con los filtros seleccionados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Resumen de Totales -->
    <?php if (!empty($reservas_pdf) && count($reservas_pdf) > 0): ?>
    <div style="margin-top: 20px; text-align: right; font-family: 'Lato', sans-serif;">
        <p style="margin: 5px 0;"><strong>Total Reservas:</strong> <?= number_format($total_reservas) ?></p>
        <p style="margin: 5px 0;"><strong>Total Personas:</strong> <?= number_format($total_personas) ?></p>
        <p style="margin: 5px 0;"><strong>Inversión Total:</strong> $<?= number_format($total_invertido, 0) ?></p>
        <p style="margin: 5px 0;"><strong>Promedio por Reserva:</strong> $<?= number_format($total_reservas > 0 ? $total_invertido / $total_reservas : 0, 0) ?></p>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        © Aventura Go 2025 - Todos los derechos reservados
    </footer>

</body>

</html>