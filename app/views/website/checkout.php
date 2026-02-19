<?php
$reserva = $_SESSION['reserva_tmp'];
// reference único por intento
if (!isset($_SESSION['reference_code'])) {
    $_SESSION['reference_code'] = 'RES-' . time() . '-' . rand(100, 999);
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventura Go - formulario de reserva</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/descubre_tours/img/FAVICON.png">

    <!-- bootstrap primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/checkout/checkout.css">

</head>

<body>
    <!-- header________________________________________________________________________________________________________________________________ -->
    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="public/assets/website_externos/descubre_tours/img/LOGO-NEGATIVO.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <h1 class="page-title">Confirma Tu reserva</h1>

                <!-- <div class="actions">

                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="profile-dropdown">
                            <button class="profile-btn" id="profileToggle">
                                <i class="fas fa-user-circle"></i>
                                <span class="profile-name">
                                    <?= htmlspecialchars(
                                        ucwords(
                                            explode(' ', $_SESSION['user']['nombre'])[0] . ' ' .
                                                (explode(' ', $_SESSION['user']['nombre'])[1] ?? '')
                                        )
                                    ) ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <ul class="profile-menu" id="profileMenu">
                                <li>
                                    <a href="/aventura_go/turista/perfil">Mi perfil</a>
                                </li>
                                <li>
                                    <a href="/aventura_go/turista/dashboard">Centro de ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="/aventura_go/logout" class="logout">Cerrar sesión</a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>

                        <a href="/aventura_go/login" class="btn-login">
                            Ingresa
                        </a>

                        <a href="/aventura_go/registrarse" class="btn-register">
                            Regístrate
                        </a>

                    <?php endif; ?>

                    <div class="menu-toggle" id="menu-toggle" aria-label="Abrir menú">
                        <i class="fas fa-bars"></i>
                    </div>

                </div> -->
            </div>
        </nav>
    </header>

    <main>

        <section id="formulario_confirmacion">
            <div class="container my-5">
                <div class="row g-4">

                    <!-- ================== RESUMEN RESERVA ================== -->
                    <div class="col-md-7">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h1 class="mb-0">Resumen de tu reserva</h1>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <img src="<?= BASE_URL ?>/public/uploads/actividades/<?= $reserva['imagen'] ?>"
                                            class="img-fluid rounded"
                                            alt="<?= htmlspecialchars($reserva['nombre']) ?>">
                                    </div>

                                    <div class="col-md-8">
                                        <h5 class="fw-bold">Nombre de la actividad que reservaste</h5>
                                        <h6 class="fw-bold"><?= htmlspecialchars($reserva['nombre']) ?></h6>
                                        <p class="mb-1"><strong>Fecha:</strong> <?= $reserva['fecha'] ?></p>
                                        <p class="mb-1"><strong>Personas:</strong> <?= $reserva['cantidad'] ?></p>

                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-1">
                                        <strong>Precio por persona:</strong>
                                        $<?= number_format($reserva['precio'], 0, ',', '.') ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Total a pagar: </strong>
                                        <span class="fs-4 fw-bold text-success">
                                            $<?= number_format($reserva['total'], 0, ',', '.') ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================== CHECKOUT / PAGO ================== -->
                    <div class="col-md-5">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Datos y método de pago</h5>
                            </div>

                            <div class="card-body">

                                <form action="<?= BASE_URL ?>/pago" method="POST">

                                    <h6 class="fw-bold mb-3">Datos del turista</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Nombre completo</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ej: Juan Pérez">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" name="email" placeholder="correo@email.com">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" name="telefono" placeholder="3001234567">
                                    </div>

                                    <h6 class="fw-bold mb-3">Método de pago</h6>

                                    <div class="form-check border rounded p-3 mb-2">
                                        <input class="form-check-input" type="radio" name="metodo_pago" value="payu" checked>
                                        <label class="form-check-label fw-bold">PayU</label>
                                        <small class="d-block text-muted">Tarjeta, PSE, Nequi, Daviplata</small>
                                    </div>

                                    <div class="form-check border rounded p-3 mb-4">
                                        <input class="form-check-input" type="radio" name="metodo_pago" value="mercadopago">
                                        <label class="form-check-label fw-bold">MercadoPago</label>
                                        <small class="d-block text-muted">Tarjeta, PSE, Wallet MercadoPago</small>
                                    </div>

                                    <!-- OCULTOS -->
                                    <input type="hidden" name="reference" value="<?= $_SESSION['reference_code'] ?>">
                                    <input type="hidden" name="total" value="<?= $reserva['total'] ?>">
                                    <input type="hidden" name="currency" value="COP">
                                    <input type="hidden" name="descripcion" value="Reserva tour Aventura Go">

                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        Confirmar y pagar
                                    </button>

                                </form>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');

        if (profileToggle && profileMenu) {
            profileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.style.display =
                    profileMenu.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function() {
                profileMenu.style.display = 'none';
            });
        }
    </script>

</body>

</html>