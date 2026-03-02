<?php
session_start();

/*| Validar que exista información de pago*/
if (!isset($_SESSION['pago_tmp']) || !isset($_SESSION['reserva_tmp'])) {
    header('Location: ' . BASE_URL . '/checkout');
    exit;
}

$pago    = $_SESSION['pago_tmp'];
$reserva = $_SESSION['reserva_tmp'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a PayU | Aventura Go</title>
    <link rel="icon" type="image/png" href="../public/assets/website_externos/descubre_tours/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/website_externos/confirmacion/confirmacion.css">
</head>

<body>

    <!-- Fondo decorativo -->
    <div class="pay-orb pay-orb--1" aria-hidden="true"></div>
    <div class="pay-orb pay-orb--2" aria-hidden="true"></div>
    <div class="pay-orb pay-orb--3" aria-hidden="true"></div>
    <div class="pay-lines"          aria-hidden="true"></div>

    <!-- Tarjeta principal -->
    <main class="pay-wrapper">
        <div class="pay-card">
            <div class="pay-card__body">

                <!-- Ícono candado -->
                <div class="pay-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="#2D4059" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="3" y="11" width="18" height="11" rx="3" fill="#2D4059"/>
                        <circle cx="12" cy="16.5" r="1.5" fill="#EA8217"/>
                    </svg>
                </div>

                <!-- Título -->
                <h1 class="pay-card__title">Estás a punto de pagar con PayU</h1>

                <!-- Divisor -->
                <div class="pay-divider">
                    <span></span>
                    <svg viewBox="0 0 14 14" fill="none">
                        <path d="M7 0l1.8 5H14l-4.2 3 1.6 5L7 10.2 2.6 13l1.6-5L0 5h5.2z" fill="#EA8217"/>
                    </svg>
                    <span></span>
                </div>

                <!-- Datos de pago -->
                <div class="pay-info">
                    <div class="pay-info__row">
                        <span class="pay-info__label">Referencia</span>
                        <span class="pay-info__value"><?= htmlspecialchars($pago['reference']) ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Total a pagar</span>
                        <span class="pay-info__total">
                            $<?= number_format($pago['total'], 0, ',', '.') ?><small> COP</small>
                        </span>
                    </div>
                </div>

                <!-- Aviso seguridad -->
                <p class="pay-notice">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="#EA8217" stroke-width="2"/>
                        <path d="M12 8v4M12 16h.01" stroke="#EA8217" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                    Serás redirigido a PayU para completar tu pago de forma segura.
                </p>

                <!-- Formulario -->
                <form class="pay-form" action="#" method="POST">
                    <!--
                        Aquí irá el endpoint real de PayU (sandbox / producción)
                        En este paso NO se conecta aún
                    -->
                    <a href="<?= BASE_URL ?>/pago/payu-demo" class="pay-btn">
                        <span>Continuar a PayU</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>

                    <!-- <a href="<?= BASE_URL ?>/pago/payu-respuesta" class="pay-btn">
                        <span>Continuar a PayU</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a> -->
                </form>

                <!-- Badge SSL -->
                <div class="pay-ssl">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6L12 2z"
                              fill="#16a34a" fill-opacity=".2" stroke="#16a34a" stroke-width="1.5"/>
                    </svg>
                    Pago 100% seguro &nbsp;·&nbsp; Cifrado SSL
                </div>

            </div>
        </div>
    </main>

</body>
</html>