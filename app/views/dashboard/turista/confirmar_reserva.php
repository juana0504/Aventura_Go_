<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

//  actualizar datos de la reserva en sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['fecha'])) {
        $_SESSION['actividad_pendiente']['fecha'] = $_POST['fecha'];
    }

    if (isset($_POST['personas'])) {
        $_SESSION['actividad_pendiente']['personas'] = (int) $_POST['personas'];
    }
}

$pendiente = $_SESSION['actividad_pendiente'];
$actividad = $pendiente['actividad'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turísta</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Librería AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 Layout global (Este es nuevo) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">


    <!-- CSS solo de esta vista (Siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/proveedorTuristico/proveedorTuristico.css">
</head>


<body>

    <section id="turista-confirmar-reserva">

        <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

        <div class="info">

            <?php require_once __DIR__ . '/../../layouts/buscador_turista.php'; ?>

            <h1>Confirmar Reserva</h1>

            <?php if (!empty($actividad['imagen_principal'])): ?>
                <img
                    src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= htmlspecialchars($actividad['imagen_principal']) ?>"
                    style="max-width:300px; margin-bottom:15px;">
            <?php endif; ?>

            <h3><?= htmlspecialchars($actividad['nombre']) ?></h3>

            <p><strong>Destino:</strong> <?= htmlspecialchars($actividad['ciudad']) ?></p>

            <!-- FORMULARIO PARA ACTUALIZAR FECHA Y PERSONAS -->
            <form method="POST" style="margin-bottom:20px;">

                <label>
                    <strong>Fecha:</strong><br>
                    <input
                        type="date"
                        name="fecha"
                        value="<?= htmlspecialchars($pendiente['fecha']) ?>"
                        required>
                </label>

                <br><br>

                <label>
                    <strong>Personas:</strong><br>
                    <input
                        type="number"
                        name="personas"
                        min="1"
                        max="<?= (int)$actividad['cupos'] ?>"
                        value="<?= htmlspecialchars($pendiente['personas']) ?>"
                        required>
                </label>

                <br><br>

                <p>
                    <strong>Precio:</strong>
                    $<?= number_format($actividad['precio'], 0, ',', '.') ?>
                </p>

                <button type="submit" name="actualizar">
                    Actualizar
                </button>

            </form>

            <form method="POST" action="<?= BASE_URL ?>/turista/crear-reserva">
                <button type="submit">Confirmar Reserva</button>
            </form>


        </div>
    </section>

</body>