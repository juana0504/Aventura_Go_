<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$conf = $_SESSION['hotel_confirmacion'] ?? null;
if (!$conf) {
    header('Location: ' . BASE_URL . 'descubre-hospedaje');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada | Aventura Go</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/img/FAVICON.png">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/confirmacion/confirmacion.css">
</head>
<body>

    <div class="pay-orb pay-orb--1" aria-hidden="true"></div>
    <div class="pay-orb pay-orb--2" aria-hidden="true"></div>
    <div class="pay-orb pay-orb--3" aria-hidden="true"></div>
    <div class="pay-lines" aria-hidden="true"></div>

    <main class="pay-wrapper">
        <div class="pay-card">
            <div class="pay-card__body">

                <!-- Ícono check -->
                <div class="pay-icon" style="background:rgba(10,138,79,.12)">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" fill="#0a8a4f" fill-opacity=".15"/>
                        <path d="M7 12.5l3.5 3.5 6.5-7" stroke="#0a8a4f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <h1 class="pay-card__title">¡Reserva registrada!</h1>

                <div class="pay-divider">
                    <span></span>
                    <svg viewBox="0 0 14 14" fill="none">
                        <path d="M7 0l1.8 5H14l-4.2 3 1.6 5L7 10.2 2.6 13l1.6-5L0 5h5.2z" fill="#EA8217"/>
                    </svg>
                    <span></span>
                </div>

                <div class="pay-info">
                    <?php if (!empty($conf['nombre_establecimiento'])): ?>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Establecimiento</span>
                        <span class="pay-info__value"><?= htmlspecialchars($conf['nombre_establecimiento']) ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <?php endif; ?>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Hospedaje</span>
                        <span class="pay-info__value"><?= htmlspecialchars($conf['nombre_hospedaje']) ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Fecha</span>
                        <span class="pay-info__value"><?= htmlspecialchars($conf['fecha']) ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Personas</span>
                        <span class="pay-info__value"><?= (int)$conf['cantidad_personas'] ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Referencia</span>
                        <span class="pay-info__value"><?= htmlspecialchars($conf['reference']) ?></span>
                    </div>
                    <div class="pay-info__separator"></div>
                    <div class="pay-info__row">
                        <span class="pay-info__label">Total estimado</span>
                        <span class="pay-info__total">
                            $<?= number_format($conf['total'], 0, ',', '.') ?><small> COP</small>
                        </span>
                    </div>
                </div>

                <p class="pay-notice">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="#EA8217" stroke-width="2"/>
                        <path d="M12 8v4M12 16h.01" stroke="#EA8217" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                    El proveedor revisará tu solicitud y te confirmará la reserva pronto.
                </p>

                <div class="pay-form">
                    <a href="<?= BASE_URL ?>turista/dashboard" class="pay-btn">
                        <span>Ver mis reservas</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>

                <div class="pay-ssl">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6L12 2z"
                            fill="#16a34a" fill-opacity=".2" stroke="#16a34a" stroke-width="1.5"/>
                    </svg>
                    Reserva 100% segura &nbsp;·&nbsp; Datos encriptados
                </div>

            </div>
        </div>
    </main>

</body>
</html>
