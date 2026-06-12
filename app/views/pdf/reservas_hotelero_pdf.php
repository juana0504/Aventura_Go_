<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas — Hotelero</title>
    <style>
        body { font-family: 'Arial', 'Helvetica', sans-serif; margin: 20px; line-height: 1.4; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #ea8217; padding-bottom: 20px; }
        .logo { max-width: 120px; margin-bottom: 10px; }
        .header h1 { color: #1a2b3c; margin: 10px 0 5px 0; font-size: 24px; }
        .header p { margin: 3px 0; font-size: 12px; color: #666; }
        .estadisticas { margin-bottom: 20px; padding: 15px; background-color: #f0f4f8; border-radius: 5px; border-left: 4px solid #ea8217; }
        .estadisticas h3 { margin: 0 0 10px 0; font-size: 16px; color: #1a2b3c; }
        .estadisticas-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px; }
        .estadistica-item { text-align: center; padding: 10px; background-color: white; border-radius: 3px; border-left: 4px solid #1a2b3c; }
        .estadistica-item strong { display: block; font-size: 14px; color: #333; }
        .estadistica-item .numero { font-size: 18px; font-weight: bold; color: #ea8217; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #1a2b3c; color: white; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge-pendiente { background-color: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-confirmada { background-color: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-cancelada { background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 15px; }
        .no-datos { text-align: center; padding: 20px; font-style: italic; color: #666; }
        .resumen-totales { margin-top: 20px; padding: 10px; background-color: #f0f4f8; border-radius: 5px; text-align: right; border-left: 4px solid #ea8217; }
        .total-item { margin: 5px 0; font-size: 12px; }
        .total-item strong { color: #1a2b3c; }
    </style>
</head>
<body>
    <div class="header">
        <img src="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png" class="logo">
        <h1>Reporte de Reservas — Hospedajes</h1>
        <p><strong>Proveedor:</strong> <?= htmlspecialchars($nombre_proveedor ?? 'Proveedor Hotelero') ?></p>
        <p><strong>Fecha de generación:</strong> <?= date('Y-m-d H:i:s') ?></p>
        <p><strong>Filtro aplicado:</strong> <?= $filtro_actual ? ucfirst($filtro_actual) : 'Todas las reservas' ?></p>
    </div>

    <?php if (!empty($estadisticas_pdf)): ?>
        <div class="estadisticas">
            <h3>Resumen Estadístico</h3>
            <div class="estadisticas-grid">
                <div class="estadistica-item"><strong>Total Reservas</strong><div class="numero"><?= number_format($estadisticas_pdf['total_reservas'] ?? 0) ?></div></div>
                <div class="estadistica-item"><strong>Pendientes</strong><div class="numero"><?= number_format($estadisticas_pdf['pendientes'] ?? 0) ?></div></div>
                <div class="estadistica-item"><strong>Confirmadas</strong><div class="numero"><?= number_format($estadisticas_pdf['confirmadas'] ?? 0) ?></div></div>
                <div class="estadistica-item"><strong>Canceladas</strong><div class="numero"><?= number_format($estadisticas_pdf['canceladas'] ?? 0) ?></div></div>
            </div>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th>Hospedaje</th>
                <th>Huésped</th>
                <th class="text-center">Fecha entrada</th>
                <th class="text-center">Personas</th>
                <th class="text-right">Precio/noche</th>
                <th class="text-right">Total</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reservas_pdf)): ?>
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
                            <strong><?= htmlspecialchars($reserva['nombre_hospedaje']) ?></strong>
                            <?php if (!empty($reserva['ubicacion'])): ?><br><small style="color:#666;"><?= htmlspecialchars($reserva['ubicacion']) ?></small><?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($reserva['nombre_turista']) ?></strong>
                            <?php if (!empty($reserva['email_turista'])): ?><br><small style="color:#666;"><?= htmlspecialchars($reserva['email_turista']) ?></small><?php endif; ?>
                        </td>
                        <td class="text-center"><?= date('Y-m-d', strtotime($reserva['fecha'])) ?></td>
                        <td class="text-center"><?= $reserva['cantidad_personas'] ?></td>
                        <td class="text-right">$<?= number_format($precio_unitario, 0, ',', '.') ?></td>
                        <td class="text-right"><strong>$<?= number_format($total_reserva, 0, ',', '.') ?></strong></td>
                        <td class="text-center"><span class="badge-<?= $reserva['estado'] ?>"><?= ucfirst($reserva['estado']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="no-datos">No se encontraron reservas con los filtros seleccionados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($reservas_pdf)): ?>
        <div class="resumen-totales">
            <div class="total-item"><strong>Total Reservas:</strong> <?= number_format($total_reservas) ?></div>
            <div class="total-item"><strong>Total Personas:</strong> <?= number_format($total_personas) ?></div>
            <div class="total-item"><strong>Ingresos Potenciales:</strong> $<?= number_format($total_ingresos, 0, ',', '.') ?></div>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p><strong>Aventura Go <?= date('Y') ?></strong> — Plataforma de Gestión Turística</p>
        <p>Todos los derechos reservados | Reporte generado automáticamente</p>
    </div>
</body>
</html>
