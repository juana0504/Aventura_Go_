<?php require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta pendiente</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- Estilos CSS (siempre al final)-->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_hotelero/pendiente_aprobacion/pendiente_aprobacion.css">
</head>

<body>

    <section class="pendiente-aprobacion">

        <!-- PANEL LATERAL -->
        <aside class="sidebar">
            <?php
            include_once __DIR__ . '/../../layouts/proveedor_hotelero_panel_izq.php';
            ?>
        </aside>

        <!-- Contenido Principal -->
        <main class="informacion-main">

            <!-- BARRA SUPERIOR -->
            <header class="informacion-topbar">
                <button id="btnMenu" class="btn-hamburguesa">
                    <i class="fas fa-bars"></i>
                </button>
                <?php
                include_once __DIR__ . '/../../layouts/buscador_proveedor_hotelero.php';
                ?>
            </header>

            <!-- CONTENIDO DE LA PAGINA -->
            <section class="pendiente">

                <div class="container-fluid">

                    <?php if ($proveedor['validado'] == 0): ?>
                        <div class="alert alert-warning">
                            <strong>Completa tu información para continuar el proceso.</strong>
                            <a href="<?= BASE_URL ?>/proveedor_hotelero/registrar-informacion" class="btn btn-sm btn-primary ms-2">
                                Completar información
                            </a>
                        </div>
                    <?php endif; ?>

                    <h2>Tu cuenta está pendiente de aprobación</h2>

                    <p> Debes continuar y completar el proceso de registro.</p>
                    <p> Nuestro equipo validará tus documentos en un plazo máximo de 7 días hábiles
                        recibirás una notificación cuando tu cuenta sea activada.. </p>
                    <p> Si tienes alguna pregunta, no dudes en contactarnos a través de nuestro correo de soporte: soporte@aventurago.com</p>

                </div>

            </section>

        </main>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar
        const btnMenu = document.getElementById("btnMenu");
        const sidebar = document.querySelector(".sidebar");

        if (btnMenu && sidebar) {
            btnMenu.addEventListener("click", () => {
                sidebar.classList.toggle("activo");
            });
        }
    </script>

</body>

</html>