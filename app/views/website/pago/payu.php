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
    <title>Redirigiendo a PayU | Aventura Go</title>

    <link rel="icon" type="image/png" href="../public/assets/website_externos/descubre_tours/img/FAVICON.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm text-center">
                    <div class="card-body">

                        <h4 class="fw-bold mb-3">Estás a punto de pagar con PayU</h4>

                        <p class="mb-1"><strong>Referencia:</strong> <?= $pago['reference'] ?></p>
                        <p class="mb-1"><strong>Total:</strong>
                            $<?= number_format($pago['total'], 0, ',', '.') ?> COP
                        </p>

                        <p class="text-muted mt-3">
                            Serás redirigido a PayU para completar tu pago de forma segura.
                        </p>

                        <!-- FORMULARIO SIMULADO PAYU -->
                        <form action="#" method="POST">
                            <!--
                            Aquí irá el endpoint real de PayU (sandbox / producción)
                            En este paso NO se conecta aún
                        -->

                            <button type="submit" class="btn btn-success w-100 mt-3">
                                Continuar a PayU
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>