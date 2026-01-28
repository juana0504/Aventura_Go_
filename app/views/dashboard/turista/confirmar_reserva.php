<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmar Reserva</title>
</head>

<body>

    <h1>Confirmar Reserva</h1>

    <h3><?= htmlspecialchars($actividad['nombre']) ?></h3>

    <p><strong>Fecha:</strong> <?= htmlspecialchars($pendiente['fecha']) ?></p>
    <p><strong>Personas:</strong> <?= htmlspecialchars($pendiente['personas']) ?></p>
    <p><strong>Precio:</strong> $<?= number_format($actividad['precio'], 0, ',', '.') ?></p>

    <form method="POST" action="<?= BASE_URL ?>/turista/registrar-reserva">
        <button type="submit">Confirmar Reserva</button>
    </form>

</body>

</html>