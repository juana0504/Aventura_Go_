<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedor Hotelero</title>

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
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css"> -->

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_hotelero.css">


    <!-- CSS solo de esta vista (Siempre al final) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_hotelero/dashboard/dashboard.css">
</head>



<body>
    <!-- Layout Principal con Panel y Contenido -->
    <section id="dashboard-hotelero">

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

            <!-- AQUI VA EL CONTENIDO DE LA PAGINA -->
            <section class="dashboard-content">

                <div class="container-fluid">

                    <p><strong>aca va todo el dashboard</strong></p>

                </div>


            </section>
        </main>
    </section>


    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- JavaScript -->
    <!-- <script src="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/dashboard/dashboard.js"></script> -->

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