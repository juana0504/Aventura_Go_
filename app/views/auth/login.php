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
    <link rel="stylesheet" href="public/assets/extras/login/login.css">
</head>

<body>

    <div class="login-container">
        <div class="login-box">

            <!-- 🧩 Sección del formulario -->
            <div class="form-section">
                <img src="public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                <h2 class="fw-bold">INICIO DE SESIÓN</h2>
                <p>Por favor ingresa tu usuario y contraseña para iniciar sesión</p>

                <form action="iniciarSesion" method="POST">
                    <input type="email" name="email" class="form-control mb-3 rounded-pill" placeholder="Correo" required>

                    <div class="password-container position-relative mb-3">
                        <input type="password" name="contrasena" class="form-control rounded-pill" id="password" placeholder="Contraseña"
                            required>
                        <i class="bi bi-eye-fill position-absolute top-50 end-0 translate-middle-y me-3 text-secondary"
                            id="togglePassword" style="cursor: pointer;"></i>
                    </div>

                    <p class="forgot-password">
                        <a href="resetPassword.html">¿Olvidaste tu contraseña?</a>
                    </p>

                    <button type="submit" class="btn w-100 rounded-pill fw-bold text-white"
                        style="background-color: #EA8217;">INGRESAR</button>
                </form>

                <div class="extra-links mt-4">
                    <p>¿Aún no tienes cuenta? <a href="#"> Regístrate </a></p>
                </div>
            </div>

            <!-- 🖼️ Sección de la imagen -->
            <div class="image-section">
                <img src="public/assets/extras/login/img/Rectangle 179.png" alt="Aventura en el río">
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/extras/login/login.js"></script>
</body>

</html>