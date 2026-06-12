<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actividades Turísticas - Aventura Go</title>
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

        /* ── HERO ─────────────────────────────────────── */
        .hero {
            background: #1A2B3C;
            border-top: 6px solid #EA8217;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .hero table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .hero__brand {
            width: 18%;
            vertical-align: top;
            text-align: center;
        }

        .hero__logo-wrap {
            display: inline-block;
            padding: 0;
            max-width: 146px;
            margin: 30px auto 0;
        }

        .hero__title {
            width: 54%;
            vertical-align: top;
            padding: 0 14px 0 12px;
        }

        .hero__eyebrow {
            display: inline-block;
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #F5B15A;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .hero__title-main {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            line-height: 1.05;
        }

        .hero__title-sub {
            margin: 5px 0 0 0;
            font-size: 9.2px;
            color: #d7e1ec;
        }

        .hero__meta {
            width: 28%;
            vertical-align: middle;
            text-align: right;
            font-size: 9px;
            line-height: 1.4;
            color: #e2e8f0;
        }

        .hero__meta-card {
            display: inline-block;
            min-width: 128px;
            text-align: center;
        }

        .hero__meta-date {
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
        }

        .hero__meta-page {
            margin-top: 5px;
            font-size: 8px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: #b9c7d6;
        }

        .hero__meta-page-value {
            margin-top: 2px;
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
        }

        .hero__rule {
            margin-top: 10px;
            height: 3px;
            background: #EA8217;
            border-radius: 999px;
        }

        /* ── INTRO ────────────────────────────────────── */
        .intro {
            text-align: center;
            color: #4b5563;
            font-size: 11px;
            line-height: 1.5;
            margin: 4px 28px 16px;
        }

        /* ── STATS ────────────────────────────────────── */
        .stats {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: separate;
            border-spacing: 12px 0;
        }

        .stat {
            background: #ffffff;
            border: 1px solid #d9e2ec;
            border-left-width: 5px;
            border-radius: 10px;
            padding: 11px 14px 10px;
            width: 33.33%;
        }

        .stat__label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .stat__value {
            font-size: 26px;
            font-weight: bold;
            color: #1A2B3C;
            line-height: 1;
        }

        .stat--blue  { border-left-color: #1A2B3C; }
        .stat--green { border-left-color: #10b981; }
        .stat--red   { border-left-color: #ef4444; }

        /* ── SECTION TITLE ────────────────────────────── */
        .section-title {
            margin: 8px 0 10px 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #1a1a2e;
            font-weight: bold;
            padding-bottom: 6px;
            border-bottom: 3px solid #EA8217;
            line-height: 1;
        }

        /* ── TABLE ────────────────────────────────────── */
        table.report {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 8px;
        }

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

        .report td {
            padding: 9px 8px;
            border: 1px solid #d9e2ec;
            vertical-align: middle;
            color: #1a1a2e;
        }

        .report tbody tr:nth-child(even) td { background: #fafbfd; }

        .text-center { text-align: center; }

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
        .badge--off  { background: #fee2e2; color: #991b1b; }

        .empty-row {
            text-align: center;
            color: #6b7280;
            padding: 16px 8px;
            font-style: italic;
        }

        /* ── FOOTER ───────────────────────────────────── */
        footer {
            position: fixed;
            bottom: 12px;
            left: 0;
            right: 0;
            font-size: 8.5px;
            color: #7b8794;
        }

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

$total    = count($actividades ?? []);
$activos  = count(array_filter($actividades ?? [], fn($a) => strtoupper($a['estado'] ?? '') === 'ACTIVO'));
$inactivos = $total - $activos;
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
                    <span class="hero__eyebrow">Módulo Proveedor Turístico</span>
                    <h1 class="hero__title-main">Reporte de Actividades Turísticas</h1>
                    <p class="hero__title-sub">Consolidado de actividades turísticas registradas en la plataforma</p>
                </td>
                <td class="hero__meta">
                    <div class="hero__meta-card">
                        <div class="hero__meta-date"><?= date('d/m/Y H:i') ?></div>
                        <div class="hero__meta-page">Generado</div>
                        <div class="hero__meta-page-value">Pág. 1 / 1</div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="hero__rule"></div>
    </div>

    <!-- INTRO -->
    <div class="intro">
        Informe de actividades turísticas registradas por el proveedor. Permite revisar el estado,
        destinos y disponibilidad de cada actividad para control y seguimiento operativo.
    </div>

    <!-- STATS -->
    <table class="stats">
        <tr>
            <td class="stat stat--blue">
                <div class="stat__label">Total actividades</div>
                <div class="stat__value"><?= $total ?></div>
            </td>
            <td class="stat stat--green">
                <div class="stat__label">Activas</div>
                <div class="stat__value"><?= $activos ?></div>
            </td>
            <td class="stat stat--red">
                <div class="stat__label">Inactivas</div>
                <div class="stat__value"><?= $inactivos ?></div>
            </td>
        </tr>
    </table>

    <div class="section-title">Listado detallado</div>

    <!-- TABLA -->
    <table class="report">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Ubicación</th>
                <th class="text-center">Cupos</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($actividades)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($actividades as $actividad) : ?>
                    <?php
                    $estado = strtoupper($actividad['estado'] ?? '');
                    $badgeClass = match($estado) {
                        'ACTIVO'   => 'badge--ok',
                        'INACTIVO' => 'badge--off',
                        default    => 'badge--warn',
                    };
                    ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td><?= htmlspecialchars($actividad['nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($actividad['destino'] ?? '') ?></td>
                        <td><?= htmlspecialchars($actividad['ubicacion'] ?? '') ?></td>
                        <td class="text-center"><?= (int)($actividad['cupos'] ?? 0) ?></td>
                        <td class="text-center">$<?= number_format((float)($actividad['precio'] ?? 0), 0, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge <?= $badgeClass ?>"><?= $estado ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="empty-row">No hay actividades registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

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
