<?php

/**
 * Función para imprimir SweetAlert dinámico con estilo completo de tarjeta Aventura Go
 *
 * @param string      $tipo      Tipo de alerta: 'success' | 'error' | 'warning' | 'info'
 * @param string      $titulo    Título del modal
 * @param string      $mensaje   Mensaje del modal
 * @param string|null $redirect  URL de redirección al cerrar (null = history.back())
 * @param string|null $bgImage   URL de imagen de fondo según rol (null = fondo oscuro por defecto)
 */
function mostrarSweetAlert($tipo, $titulo, $mensaje, $redirect = null, $bgImage = null)
{
    /* ── Fondo y overlay según rol ── */
    $backgroundStyle = $bgImage
        ? "background-image: url('{$bgImage}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        : "background: linear-gradient(135deg, #0f1e2d 0%, #1a2e42 50%, #0d1a26 100%);";

    /* ── Tokens de color según tipo de alerta ── */
    $iconColor = '#2e7d32';
    $iconBg    = 'linear-gradient(135deg, #e8f5e9, #c8e6c9)';
    $ringColor = 'rgba(72,199,100,0.3)';
    $iconSvg   = '<path class="av-icon-path" d="M8 22 L18 32 L36 12"/>';

    if ($tipo === 'error') {
        $iconColor = '#c62828';
        $iconBg    = 'linear-gradient(135deg, #fce4e4, #ffcdd2)';
        $ringColor = 'rgba(220,53,69,0.3)';
        $iconSvg   = '<path class="av-icon-path" d="M13 13 L31 31 M31 13 L13 31"/>';
    } elseif ($tipo === 'warning') {
        $iconColor = '#e65100';
        $iconBg    = 'linear-gradient(135deg, #fff3e0, #ffe0b2)';
        $ringColor = 'rgba(234,130,23,0.3)';
        $iconSvg   = '<path class="av-icon-path" d="M22 12 L22 26"/><circle cx="22" cy="32" r="1.8" fill="#e65100" stroke="none"/>';
    } elseif ($tipo === 'info') {
        $iconColor = '#0277bd';
        $iconBg    = 'linear-gradient(135deg, #e1f5fe, #b3e5fc)';
        $ringColor = 'rgba(2,119,189,0.3)';
        $iconSvg   = '<path class="av-icon-path" d="M22 20 L22 32"/><circle cx="22" cy="14" r="1.8" fill="#0277bd" stroke="none"/>';
    }

    /* ── HTML interno del modal ── */
    $htmlModal = '
        <div class="av-icon-wrap">
            <svg class="av-icon-svg" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                ' . $iconSvg . '
            </svg>
        </div>
        <div class="av-divider">
            <span class="av-star">&#10022;</span>
        </div>
        <p class="av-msg">' . htmlspecialchars($mensaje) . '</p>
    ';

    /* ── Redirección JS ── */
    $redirectJs = $redirect
        ? "window.location.href = " . json_encode($redirect) . ";"
        : "window.history.back();";

    /* ── Salida del HTML completo ── */
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?> | Aventura Go</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ── RESET ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary:   #2D4059;
            --secondary: #EA8217;
        }

        /* ── BODY ── */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-family: 'Lato', sans-serif;
            position: relative;
            <?= $backgroundStyle ?>
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        /* ── LÍNEAS DE LUZ ── */
        .light-lines {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .light-lines::before,
        .light-lines::after {
            content: '';
            position: absolute;
            width: 120%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(234,130,23,0.3), transparent);
            animation: scanLine 8s ease-in-out infinite;
        }

        .light-lines::before { top: 30%; left: -10%; animation-delay: 0s; }
        .light-lines::after  { top: 65%; left: -10%; animation-delay: 4s; }

        @keyframes scanLine {
            0%   { transform: translateX(-100%) skewX(-15deg); opacity: 0; }
            30%  { opacity: 1; }
            70%  { opacity: 1; }
            100% { transform: translateX(100%) skewX(-15deg);  opacity: 0; }
        }

        /* ══════════════════════════════════════════
           SWEETALERT2 — TARJETA
           ══════════════════════════════════════════ */
        .swal2-container { z-index: 100 !important; }

        .swal2-backdrop-show { background: rgba(0,0,0,0) !important; }

        /* Popup */
        .swal2-popup {
            font-family: 'Lato', sans-serif !important;
            border-radius: 24px !important;
            overflow: hidden !important;
            box-shadow:
                0 30px 80px rgba(0,0,0,0.45),
                0 0 0 1px rgba(255,255,255,0.1) !important;
            padding: 0 !important;
            border: none !important;
            background: rgba(255,255,255,0.97) !important;
            position: relative;
            z-index: 10;
            animation: cardEntrance 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards !important;
            opacity: 0;
            transform: translateY(40px) scale(0.97);
        }

        @keyframes cardEntrance {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Franja superior animada */
        .swal2-popup::before {
            content: '';
            display: block;
            height: 6px;
            width: 100%;
            background: linear-gradient(90deg, #2D4059 0%, #EA8217 50%, #2D4059 100%);
            background-size: 200% auto;
            animation: gradientShift 3s linear infinite;
        }

        @keyframes gradientShift {
            0%   { background-position: 0%   center; }
            100% { background-position: 200% center; }
        }

        /* Ocultar ícono nativo de SweetAlert2 */
        .swal2-icon { display: none !important; }

        /* ── ÍCONO PERSONALIZADO ── */
        .av-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: <?= $iconBg ?>;
            margin: 36px auto 0;
            position: relative;
            animation: iconPop 0.65s 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        /* Anillo pulsante exterior */
        .av-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid <?= $ringColor ?>;
            animation: ringPulse 2.2s ease-out 1.1s infinite;
        }

        @keyframes iconPop {
            0%   { transform: scale(0) rotate(-20deg); opacity: 0; }
            55%  { transform: scale(1.15) rotate(5deg); opacity: 1; }
            80%  { transform: scale(0.96) rotate(-2deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        @keyframes ringPulse {
            0%   { transform: scale(1);    opacity: 0.8; }
            100% { transform: scale(1.65); opacity: 0;   }
        }

        /* SVG trazo animado */
        .av-icon-svg {
            width: 44px;
            height: 44px;
            overflow: visible;
        }

        .av-icon-path {
            fill: none;
            stroke: <?= $iconColor ?>;
            stroke-width: 3.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 80;
            stroke-dashoffset: 80;
            animation: drawIcon 0.55s 1.0s cubic-bezier(0.65, 0, 0.35, 1) forwards;
        }

        @keyframes drawIcon {
            to { stroke-dashoffset: 0; }
        }

        /* ── DIVISOR CON ESTRELLA ── */
        .av-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px auto 0;
            max-width: 240px;
            padding: 0 24px;
            animation: fadeUp 0.45s 1.1s ease both;
        }

        .av-divider::before,
        .av-divider::after {
            content: '';
            flex: 1;
            height: 1px;
        }

        .av-divider::before { background: linear-gradient(90deg, transparent, #DEDEDE); }
        .av-divider::after  { background: linear-gradient(90deg, #DEDEDE, transparent); }

        .av-star {
            font-size: 15px;
            color: #EA8217;
            flex-shrink: 0;
            display: inline-block;
            animation: starSpin 0.5s 1.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes starSpin {
            from { transform: scale(0) rotate(-45deg); opacity: 0; }
            to   { transform: scale(1) rotate(0deg);   opacity: 1; }
        }

        /* ── TÍTULO ── */
        .swal2-title {
            font-family: 'Raleway', sans-serif !important;
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #2D4059 !important;
            letter-spacing: 0.4px !important;
            line-height: 1.3 !important;
            padding: 20px 36px 0 !important;
            margin: 0 !important;
            animation: fadeUp 0.5s 1.05s ease both !important;
        }

        /* ── CONTENEDOR HTML SweetAlert2 ── */
        .swal2-html-container {
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
        }

        /* Párrafo del mensaje */
        .av-msg {
            font-family: 'Lato', sans-serif;
            font-size: 15px;
            color: #555;
            line-height: 1.75;
            margin: 18px 0 0;
            padding: 0 36px 36px;
            animation: fadeUp 0.5s 1.2s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── SIN BOTONES ── */
        .swal2-actions { display: none !important; }
        .swal2-footer  { display: none !important; }

        /* ── BARRA DE PROGRESO ── */
        .swal2-timer-progress-bar-container {
            border-radius: 0 0 24px 24px;
            overflow: hidden;
        }

        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #2D4059, #EA8217) !important;
            height: 4px !important;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .swal2-title {
                font-size: 20px !important;
                padding: 16px 20px 0 !important;
            }

            .av-msg {
                font-size: 14px;
                padding: 0 20px 28px;
            }

            .av-icon-wrap { width: 74px; height: 74px; }
            .av-icon-svg  { width: 38px; height: 38px; }
        }
    </style>
</head>

<body>
    <div class="light-lines"></div>

    <script>
        Swal.fire({
            title: <?= json_encode($titulo, JSON_UNESCAPED_UNICODE) ?>,
            html:  <?= json_encode($htmlModal, JSON_UNESCAPED_UNICODE) ?>,
            showConfirmButton: false,
            showCancelButton:  false,
            timer: 6000,
            timerProgressBar: true,
            background: 'rgba(255,255,255,0.97)',
            color: '#2D4059',
            allowOutsideClick: false,
            allowEscapeKey:    false,
        }).then(function() {
            <?= $redirectJs ?>
        });
    </script>
</body>
</html>
<?php
} // fin mostrarSweetAlert