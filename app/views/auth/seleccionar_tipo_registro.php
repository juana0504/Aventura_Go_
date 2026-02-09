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

    <style>
        body {
            background: #F8F9FA;
            font-family: 'Lato', sans-serif;
        }

        h1 {
            font-family: 'Raleway', sans-serif;
            color: #2D4059;
        }

        .card {
            border-radius: 12px;
            border: 1px solid #E0E0E0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            color: #2D4059;
            font-family: 'Raleway', sans-serif;
        }

        .btn-aventura {
            background-color: #EA8217;
            color: #FFFFFF;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-aventura:hover {
            background-color: #2D4059;
            color: #FFFFFF;
        }
    </style>
</head>

<body>

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