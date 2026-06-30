<?php

/**
 * Genera un PDF de ticket de reserva y retorna el contenido como string.
 *
 * $datos esperados:
 *   id_reserva, nombre_turista, tipo ('actividad'|'hospedaje'),
 *   nombre_servicio, proveedor, fecha (Y-m-d), cantidad_personas, precio, estado
 */
function generarTicketPDF(array $d): string
{
    require_once BASE_PATH . '/vendor/dompdf/src/Autoloader.php';
    \Dompdf\Autoloader::register();

    $opt = new \Dompdf\Options();
    $opt->set('defaultFont', 'dejavu sans');
    $opt->set('isHtml5ParserEnabled', true);
    $opt->set('isRemoteEnabled', false);
    $opt->setTempDir(sys_get_temp_dir());

    $dompdf = new \Dompdf\Dompdf($opt);

    $num         = str_pad((int)$d['id_reserva'], 6, '0', STR_PAD_LEFT);
    $fecha       = date('d/m/Y', strtotime($d['fecha']));
    $precio      = '$' . number_format((float)$d['precio'], 0, ',', '.') . ' COP';
    $tipo        = $d['tipo'] === 'hospedaje' ? 'Hospedaje' : 'Actividad';
    $estado      = strtolower($d['estado'] ?? 'pendiente');
    $estadoLabel = ucfirst($estado);
    $estadoColor = $estado === 'confirmada' ? '#059669' : '#d97706';
    $estadoBg    = $estado === 'confirmada' ? '#d1fae5' : '#fef3c7';
    $emision     = date('d/m/Y H:i');

    $turista   = htmlspecialchars($d['nombre_turista'] ?? '—');
    $servicio  = htmlspecialchars($d['nombre_servicio'] ?? '—');
    $proveedor = htmlspecialchars($d['proveedor'] ?? '—');
    $personas  = (int)($d['cantidad_personas'] ?? 1);

    $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body{font-family:"DejaVu Sans",sans-serif;margin:0;padding:24px;background:#f1f5f9;}
.ticket{max-width:420px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;}
.hdr{background:#EA8217;padding:22px 20px;text-align:center;}
.hdr h1{color:#fff;margin:0;font-size:22px;letter-spacing:1px;}
.hdr p{color:rgba(255,255,255,0.85);margin:5px 0 0;font-size:11px;}
.num{background:#c96e0f;padding:7px;text-align:center;}
.num span{color:#fff;font-size:11px;letter-spacing:4px;font-weight:bold;}
.bdy{padding:18px 22px;}
table.r{width:100%;border-collapse:collapse;}
table.r td{padding:7px 2px;border-bottom:1px solid #f3f4f6;font-size:11px;vertical-align:middle;}
table.r tr:last-child td{border-bottom:none;}
.lb{color:#6b7280;width:40%;}
.vl{color:#111827;font-weight:bold;text-align:right;}
.sep{border:none;border-top:2px dashed #e5e7eb;margin:13px 0;}
.note{color:#9ca3af;font-size:9px;text-align:center;margin:0;}
.ftr{background:#f9fafb;padding:11px;text-align:center;border-top:1px solid #e5e7eb;}
.ftr p{color:#9ca3af;font-size:9px;margin:0;}
</style>
</head>
<body>
<div class="ticket">
  <div class="hdr">
    <h1>AventuraGO</h1>
    <p>Comprobante de Reserva</p>
  </div>
  <div class="num">
    <span>RESERVA #' . $num . '</span>
  </div>
  <div class="bdy">
    <table class="r">
      <tr><td class="lb">Turista</td><td class="vl">' . $turista . '</td></tr>
      <tr><td class="lb">Tipo</td><td class="vl">' . $tipo . '</td></tr>
      <tr><td class="lb">Servicio</td><td class="vl">' . $servicio . '</td></tr>
      <tr><td class="lb">Proveedor</td><td class="vl">' . $proveedor . '</td></tr>
      <tr><td class="lb">Fecha</td><td class="vl">' . $fecha . '</td></tr>
      <tr><td class="lb">Personas</td><td class="vl">' . $personas . '</td></tr>
      <tr><td class="lb">Precio</td><td class="vl">' . $precio . '</td></tr>
      <tr>
        <td class="lb">Estado</td>
        <td class="vl">
          <span style="background:' . $estadoBg . ';color:' . $estadoColor . ';padding:2px 9px;font-size:10px;font-weight:bold;">' . $estadoLabel . '</span>
        </td>
      </tr>
    </table>
    <hr class="sep">
    <p class="note">Emitido el ' . $emision . ' &bull; Conserva este comprobante</p>
  </div>
  <div class="ftr">
    <p>AventuraGO &bull; Tu aventura, nuestra pasi&oacute;n</p>
  </div>
</div>
</body>
</html>';

    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper([0, 0, 380, 520], 'portrait');
    $dompdf->render();

    return $dompdf->output();
}
