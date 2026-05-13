<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Proveedores Hoteleros - Aventura Go</title>

    <style>
        @page {
            margin: 20px 22px 40px 22px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1a1a2e;
            font-size: 11px;
            margin: 0;
            background: #ffffff;
        }

        .page-shell { width: 100%; }

        .hero {
            background: #1A2B3C;
            border-top: 6px solid #EA8217;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 16px;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
        }

        .hero table {
            width: 100%;
            border-collapse: collapse;
        }

        .hero__brand {
            width: 26%;
            vertical-align: middle;
        }

        .hero__logo-wrap {
            display: inline-block;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 10px;
            padding: 8px 10px;
        }

        .hero__logo {
            width: 158px;
            height: auto;
            display: block;
        }

        .hero__title {
            width: 50%;
            vertical-align: middle;
            padding: 0 10px;
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
            font-size: 27px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            line-height: 1;
        }

        .hero__title-sub {
            margin: 5px 0 0 0;
            font-size: 9px;
            color: #d7e1ec;
        }

        .hero__meta {
            width: 24%;
            vertical-align: middle;
            text-align: right;
            font-size: 9px;
            line-height: 1.4;
            color: #e2e8f0;
        }

        .hero__meta-date {
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
        }

        .hero__meta-page {
            margin-top: 2px;
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
        }

        .intro {
            text-align: center;
            color: #4b5563;
            font-size: 11px;
            line-height: 1.5;
            margin: 4px 28px 16px;
        }

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
            letter-spacing: .4px;
            color: #1A2B3C;
            line-height: 1;
        }

        .stat--blue { border-left-color: #1A2B3C; }
        .stat--green { border-left-color: #10b981; }
        .stat--red { border-left-color: #ef4444; }

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

        .report tbody tr:nth-child(even) td {
            background: #fafbfd;
        }

        .company-logo {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #d7dee7;
            background: #ffffff;
        }

        .empty-row {
            text-align: center;
            color: #6b7280;
            padding: 16px 8px;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .badge--ok {
            background: #dcfce7;
            color: #166534;
        }

        .badge--soft {
            background: #e2e8f0;
            color: #334155;
        }

        .text-center { text-align: center; }

        footer {
            position: fixed;
            bottom: 12px;
            left: 0;
            right: 0;
            font-size: 8.5px;
            color: #7b8794;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 33.33%;
            vertical-align: middle;
        }

        .footer-left { text-align: left; }
        .footer-center { text-align: center; }

        .footer-right {
            text-align: right;
            color: #5f6b7a;
            font-weight: bold;
        }

        .confidential { color: #5f6b7a; }
    </style>
</head>

<body>

    <div class="page-shell">
        <div class="hero">
            <table>
                <tr>
                    <td class="hero__brand">
                        <span class="hero__logo-wrap">
                            <img class="hero__logo" src="<?= pdf_image_data_uri('public/assets/estilos_globales/img/LOGO-FINAL.png', 'Aventura Go') ?>" alt="Logo Aventura Go">
                        </span>
                    </td>
                    <td class="hero__title">
                        <span class="hero__eyebrow">Módulo Administrador</span>
                        <h1 class="hero__title-main">Reporte de Proveedores Hoteleros</h1>
                        <p class="hero__title-sub">Consolidado oficial de proveedores hoteleros registrados en plataforma</p>
                    </td>
                    <td class="hero__meta">
                        <div class="hero__meta-date"><?= date('d/m/Y H:i') ?></div>
                        <div class="hero__meta-page">Pág. 1 / 1</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="intro">
            Informe ejecutivo para control administrativo de proveedores hoteleros, diseñado para revisión rápida, seguimiento operativo y toma de decisiones.
        </div>

        <?php
        $total = count($hoteles ?? []);
        $activos = count(array_filter($hoteles ?? [], fn($h) => strtolower($h['estado'] ?? '') === 'activo'));
        $inactivos = count(array_filter($hoteles ?? [], fn($h) => strtolower($h['estado'] ?? '') === 'inactivo'));
        ?>
        <table class="stats">
            <tr>
                <td class="stat stat--blue">
                    <div class="stat__label">Total registrados</div>
                    <div class="stat__value"><?= $total ?></div>
                </td>
                <td class="stat stat--green">
                    <div class="stat__label">Activos</div>
                    <div class="stat__value"><?= $activos ?></div>
                </td>
                <td class="stat stat--red">
                    <div class="stat__label">Inactivos</div>
                    <div class="stat__value"><?= $inactivos ?></div>
                </td>
            </tr>
        </table>

        <div class="section-title">Listado detallado</div>

        <table class="report">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Establecimiento</th>
                    <th>Tipo</th>
                    <th>Representante</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($hoteles)) : ?>
                    <?php $contador = 1; ?>
                    <?php foreach ($hoteles as $hotelero): ?>
                        <tr>
                            <td class="text-center"><?= $contador++ ?></td>
                            <td class="text-center"><img class="company-logo" src="<?= pdf_image_data_uri('public/uploads/hoteles/' . ($hotelero['logo'] ?? ''), 'Hotelero') ?>" alt="Logo hotelero"></td>
                            <td><?= htmlspecialchars($hotelero['nombre_establecimiento'] ?? '') ?></td>
                            <td><?= htmlspecialchars($hotelero['tipo_establecimiento'] ?? '') ?></td>
                            <td><?= htmlspecialchars($hotelero['nombre_representante'] ?? '') ?></td>
                            <td><?= htmlspecialchars($hotelero['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($hotelero['telefono'] ?? '') ?></td>
                            <td><?= htmlspecialchars($hotelero['nombre_ciudad'] ?? ($hotelero['id_ciudad'] ?? '')) ?></td>
                            <td class="text-center"><span class="badge <?= strtolower($hotelero['estado'] ?? 'activo') === 'activo' ? 'badge--ok' : 'badge--soft' ?>"><?= htmlspecialchars($hotelero['estado'] ?? 'Activo') ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="empty-row">No hay proveedores hoteleros registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <table class="footer-table">
            <tr>
                <td class="footer-left">Aventura Go © <?= date('Y') ?> — Documento generado automáticamente</td>
                <td class="footer-center confidential">Confidencial — Solo para uso administrativo</td>
                <td class="footer-right">Pág. 1 / 1</td>
            </tr>
        </table>
    </footer>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $pdf->page_text(503, 816, 'Pág. {PAGE_NUM} / {PAGE_COUNT}', $font, 8, array(0.37, 0.43, 0.52));
        }
    </script>

</body>

</html>