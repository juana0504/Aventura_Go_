<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aventura GO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/extras/login/login.css">
</head>

<body>

    <div class="login-container">
        <div class="login-box">

            <!-- Sección del formulario -->
            <div class="form-section">
                <img src="public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                <h2 class="fw-bold">INICIO DE SESIÓN</h2>
                <p>Por favor ingresa tu usuario y contraseña para iniciar sesión</p>

                <form action="iniciar-sesion" method="POST">

                    <input type="email" name="email" placeholder="Correo" required>

                    <div class="password-container">
                        <input type="password" name="contrasena" id="password" placeholder="Contraseña" required>
                        <i class="bi bi-eye-fill" id="togglePassword"></i>
                    </div>

                    <p class="forgot-password">
                        <a href="recoverpw">¿Olvidaste tu contraseña?</a>
                    </p>

                    <button type="submit">INGRESAR</button>

                </form>

                <div class="extra-links mt-4">
                    <p>¿Aún no tienes cuenta? <a href="#" class="btn-register" data-bs-toggle="modal" data-bs-target="#registroModal">
                            Regístrate
                        </a></p>
                </div>
            </div>

            <!-- Sección de la imagen -->
            <div class="image-section">
                <img src="public/assets/extras/login/img/Rectangle 179.png" alt="Aventura en el río">
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/extras/login/login.js"></script>

    <!-- MODAL REGISTRO -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">¿Cómo quieres registrarte?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="container py-3">

                        <div class="row g-4 justify-content-center">

                            <!-- TURISTA -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">🎒</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Turista</h3>
                                        <p class="card-text">Quiero reservar actividades y experiencias.</p>
                                        <a href="/aventura_go/registrarse?tipo=turista" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- PROVEEDOR TURÍSTICO -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">⛰️</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor turístico</h3>
                                        <p class="card-text">Quiero publicar actividades de aventura.</p>
                                        <a href="/aventura_go/registrar-proveedor" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- PROVEEDOR HOTELERO -->
                            <div class="col-md-4">
                                <div class="card card-registro text-center p-4">
                                    <!-- <div class="icono-registro">🏨</div> -->
                                    <div class="card-body">
                                        <h3 class="card-title">Proveedor hotelero</h3>
                                        <p class="card-text">Quiero publicar hospedajes.</p>
                                        <a href="/aventura_go/registrar-proveedor-hotelero" class="btn btn-aventura">
                                            Elegir
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- FIN MODAL REGISTRO -->
</body>

</html>