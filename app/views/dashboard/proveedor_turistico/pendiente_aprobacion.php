<?php require_once BASE_PATH . '/app/helpers/session_proveedor.php'; ?>

<?php if ($proveedor['validado'] == 0): ?>
    <div class="alert alert-warning">
        <!-- <strong>Cuenta en proceso de validación.</strong><br> -->
        <strong>Completa tu información para continuar el proceso.</strong>
        <a href="<?= BASE_URL ?>/proveedor/completar-informacion" class="btn btn-sm btn-primary ms-2">
            Completar información
        </a>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cuenta pendiente</title>
    <!-- Estilos CSS (siempre al final)-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/pendiente_aprobacion/pendiente_aprobacion.css">
</head>

<body>

    <h2>Tu cuenta está pendiente de aprobación</h2>


    <p> Debes continuar y completar el proceso de registro.</p>
    <p> Nuestro equipo validará tus documentos en un plazo máximo de 7 días hábiles
        recibirás una notificación cuando tu cuenta sea activada.. </p>
    <p> Si tienes alguna pregunta, no dudes en contactarnos a través de nuestro correo de soporte: soporte@aventurago.com</p>

</body>

</html>