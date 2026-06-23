<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas - Aventura Go</title>
    <style>
        @page { margin: 20px 22px 40px 22px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1a1a2e;
            font-size: 11px;
            margin: 0;
            background: #ffffff;
        }

        .page-shell { width: 100%; }

        /* ── HERO ── */
        .hero {
            background: #1A2B3C;
            border-top: 6px solid #EA8217;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .hero table { width: 100%; border-collapse: collapse; table-layout: fixed; }

        .hero__brand    { width: 18%; vertical-align: top; text-align: center; }
        .hero__logo-wrap { display: inline-block; padding: 0; max-width: 146px; margin: 30px auto 0; }

        .hero__title    { width: 54%; vertical-align: top; padding: 0 14px 0 12px; }
        .hero__eyebrow  { display: inline-block; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #F5B15A; font-weight: bold; margin-bottom: 4px; }
        .hero__title-main { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; line-height: 1.05; }
        .hero__title-sub  { margin: 5px 0 0 0; font-size: 9.2px; color: #d7e1ec; }

        .hero__meta     { width: 28%; vertical-align: middle; text-align: right; font-size: 9px; line-height: 1.4; color: #e2e8f0; }
        .hero__meta-card { display: inline-block; min-width: 128px; text-align: center; }
        .hero__meta-date { font-size: 10px; font-weight: bold; color: #ffffff; }
        .hero__meta-page { margin-top: 5px; font-size: 8px; letter-spacing: .7px; text-transform: uppercase; color: #b9c7d6; }
        .hero__meta-page-value { margin-top: 2px; font-size: 10px; font-weight: bold; color: #ffffff; }

        .hero__rule { margin-top: 10px; height: 3px; background: #EA8217; border-radius: 999px; }

        /* ── INTRO ── */
        .intro { text-align: center; color: #4b5563; font-size: 11px; line-height: 1.5; margin: 4px 28px 16px; }

        /* ── STATS ── */
        .stats { width: 100%; margin-bottom: 18px; border-collapse: separate; border-spacing: 12px 0; }

        .stat {
            background: #ffffff;
            border: 1px solid #d9e2ec;
            border-left-width: 5px;
            border-radius: 10px;
            padding: 11px 14px 10px;
            width: 25%;
        }
        .stat__label { font-size: 9px; text-transform: uppercase; letter-spacing: 1.3px; color: #6b7280; margin-bottom: 6px; font-weight: bold; }
        .stat__value { font-size: 26px; font-weight: bold; color: #1A2B3C; line-height: 1; }

        .stat--blue   { border-left-color: #1A2B3C; }
        .stat--orange { border-left-color: #EA8217; }
        .stat--green  { border-left-color: #10b981; }
        .stat--red    { border-left-color: #ef4444; }

        /* ── SECTION TITLE ── */
        .section-title {
            margin: 8px 0 10px 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #1a1a2e;
            font-weight: bold;
            padding-bottom: 6px;
            border-bottom: 3px solid #EA8217;
            line-height: 1;
        }

        /* ── TABLE ── */
        table.report { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 8px; }

        .report th {
            background: #1A2B3C;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: .7px;
            font-size: 9px;
            padding: 10px 8px;
            border: 1px solid #90a0b2;
            border-bottom: 3px solid #EA8217;
        }

        .report td { padding: 9px 8px; border: 1px solid #d9e2ec; vertical-align: middle; color: #1a1a2e; }
        .report tbody tr:nth-child(even) td { background: #fafbfd; }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .badge--ok   { background: #dcfce7; color: #166534; }
        .badge--warn { background: #fef9c3; color: #854d0e; }
        .badge--red  { background: #fee2e2; color: #991b1b; }
        .badge--tipo { background: #e0f0ff; color: #1e40af; }

        .empty-row { text-align: center; color: #6b7280; padding: 16px 8px; font-style: italic; }

        /* ── TOTALS ── */
        .totals-box {
            margin-top: 16px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            padding: 12px 18px;
            background: #f8fafc;
            text-align: right;
            font-size: 10px;
            line-height: 1.8;
        }
        .totals-box .total-main { font-size: 13px; font-weight: bold; color: #1A2B3C; }

        /* ── FOOTER ── */
        footer { position: fixed; bottom: 12px; left: 0; right: 0; font-size: 8.5px; color: #7b8794; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { width: 33.33%; vertical-align: middle; }
        .footer-left   { text-align: left; }
        .footer-center { text-align: center; }
        .footer-right  { text-align: right; color: #5f6b7a; font-weight: bold; }
    </style>
</head>
<body>

<?php
$logoHeaderSvg = pdf_brand_logo_svg_markup();

$reservas_pdf   = $reservas_pdf   ?? [];
$filtro_actual  = $filtro_actual  ?? '';
$nombre_turista = $nombre_turista ?? '';
$email_turista  = $email_turista  ?? '';

// Calcular estadísticas desde los datos cargados
$totalRes    = count($reservas_pdf);
$pendientes  = 0; $confirmadas = 0; $canceladas = 0;
foreach ($reservas_pdf as $r) {
    $e = $r['estado'] ?? '';
    if ($e === 'pendiente')  $pendientes++;
    if ($e === 'confirmada') $confirmadas++;
    if ($e === 'cancelada')  $canceladas++;
}

$filtroLabel = match($filtro_actual) {
    'pendiente'  => 'Pendientes',
    'confirmada' => 'Confirmadas',
    'cancelada'  => 'Canceladas',
    default      => 'Todas las reservas',
};
?>

<div class="page-shell">

    <!-- HERO -->
    <div class="hero">
        <table>
            <tr>
                <td class="hero__brand">
                    <div class="hero__logo-wrap"><?= $logoHeaderSvg ?></div>
                </td>
                <td class="hero__title">
                    <span class="hero__eyebrow">Módulo Turista</span>
                    <h1 class="hero__title-main">Mis Reservas</h1>
                    <p class="hero__title-sub">
                        Historial de reservas registradas en Aventura Go
                        <?php if ($nombre_turista): ?>
                            · <?= htmlspecialchars($nombre_turista) ?>
                        <?php endif; ?>
                    </p>
                </td>
                <td class="hero__meta">
                    <div class="hero__meta-card">
                        <div class="hero__meta-date"><?= date('d/m/Y H:i') ?></div>
                        <div class="hero__meta-page">Filtro: <?= $filtroLabel ?></div>
                        <div class="hero__meta-page-value">Pág. 1 / 1</div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="hero__rule"></div>
    </div>

    <!-- INTRO -->
    <div class="intro">
        Registro consolidado de sus reservas de actividades turísticas y hospedajes realizadas en Aventura Go.
        <?php if ($email_turista): ?>
            Cuenta: <strong><?= htmlspecialchars($email_turista) ?></strong>
        <?php endif; ?>
    </div>

    <!-- STATS -->
    <table class="stats">
        <tr>
            <td class="stat stat--blue">
                <div class="stat__label">Total reservas</div>
                <div class="stat__value"><?= $totalRes ?></div>
            </td>
            <td class="stat stat--orange">
                <div class="stat__label">Pendientes</div>
                <div class="stat__value"><?= $pendientes ?></div>
            </td>
            <td class="stat stat--green">
                <div class="stat__label">Confirmadas</div>
                <div class="stat__value"><?= $confirmadas ?></div>
            </td>
            <td class="stat stat--red">
                <div class="stat__label">Canceladas</div>
                <div class="stat__value"><?= $canceladas ?></div>
            </td>
        </tr>
    </table>

    <div class="section-title">Listado detallado</div>

    <!-- TABLA -->
    <table class="report">
        <thead>
            <tr>
                <th>#</th>
                <th>Actividad / Hospedaje</th>
                <th>Tipo</th>
                <th>Proveedor</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Personas</th>
                <th class="text-right">Precio unit.</th>
                <th class="text-right">Total</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reservas_pdf)): ?>
                <?php
                $i = 1;
                $gran_total    = 0;
                $gran_personas = 0;
                foreach ($reservas_pdf as $r):
                    $precio   = (float)($r['precio'] ?? 0);
                    $cantidad = (int)($r['cantidad_personas'] ?? 0);
                    $subtotal = $precio * $cantidad;
                    $gran_total    += $subtotal;
                    $gran_personas += $cantidad;
                    $estado = strtolower($r['estado'] ?? '');
                    $badge = match($estado) {
                        'confirmada' => 'badge--ok',
                        'pendiente'  => 'badge--warn',
                        default      => 'badge--red',
                    };
                    $tipo = $r['tipo_reserva'] ?? 'actividad';
                    $tipoLabel = $tipo === 'hospedaje' ? 'Hospedaje' : 'Tour';
                ?>
                <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><strong><?= htmlspecialchars($r['nombre_actividad'] ?? '—') ?></strong></td>
                    <td class="text-center"><span class="badge badge--tipo"><?= $tipoLabel ?></span></td>
                    <td><?= htmlspecialchars($r['proveedor'] ?? '—') ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                    <td class="text-center"><?= $cantidad ?></td>
                    <td class="text-right">$<?= number_format($precio, 0, ',', '.') ?></td>
                    <td class="text-right"><strong>$<?= number_format($subtotal, 0, ',', '.') ?></strong></td>
                    <td class="text-center"><span class="badge <?= $badge ?>"><?= ucfirst($estado) ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="empty-row">No se encontraron reservas<?= $filtro_actual ? " con filtro \"$filtroLabel\"" : '' ?>.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($reservas_pdf)): ?>
    <div class="totals-box">
        <div>Total personas: <strong><?= number_format($gran_personas) ?></strong></div>
        <div class="total-main">Total invertido: $<?= number_format($gran_total, 0, ',', '.') ?></div>
    </div>
    <?php endif; ?>

</div>

<!-- FOOTER -->
<footer>
    <table class="footer-table">
        <tr>
            <td class="footer-left">© Aventura Go <?= date('Y') ?> — Todos los derechos reservados</td>
            <td class="footer-center">Documento generado automáticamente</td>
            <td class="footer-right">CONFIDENCIAL</td>
        </tr>
    </table>
</footer>

</body>
</html>
