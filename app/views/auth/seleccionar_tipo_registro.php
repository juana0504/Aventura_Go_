<?php
// seleccionar_tipo_registro.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Elige tu tipo de cuenta | Aventura Go</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/index/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuentes del proyecto -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600;700&family=Lato:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="public/assets/extras/seleccionar_tipo_registro/seleccionar_tipo_registro.css">

</head>

<body>
    <div id="bg-overlay"></div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1>¿Cómo quieres registrarte?</h1>
        </div>

        <!-- FILA 1: TURISTA (ARRIBA, CENTRADO) -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-5">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <h3 class="card-title">Turista</h3>
                        <p class="card-text">Quiero reservar actividades y experiencias.</p>
                        <a href="/aventura_go/registrarse?tipo=turista" class="btn btn-aventura">Elegir</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 2: PROVEEDORES (ABAJO, DOS CARDS) -->
        <div class="row justify-content-center g-4">

            <div class="col-md-5">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <h3 class="card-title">Proveedor turístico</h3>
                        <p class="card-text">Quiero publicar actividades de aventura.</p>
                        <a href="/aventura_go/registrarse?tipo=proveedor_turistico" class="btn btn-aventura">Elegir</a>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <h3 class="card-title">Proveedor hotelero</h3>
                        <p class="card-text">Quiero publicar hospedajes.</p>
                        <a href="/aventura_go/registrarse?tipo=proveedor_hotelero" class="btn btn-aventura">Elegir</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>