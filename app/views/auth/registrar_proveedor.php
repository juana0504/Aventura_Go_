<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register- Aventura GO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/extras/registrarse/registrar_proveedor.css">
</head>

<body>

    <div class="login-container">
        <div class="login-box">

            <div class="form-section">
                <img src="public/assets/extras/login/img/REDES-LOGO 2.png" alt="Aventura GO" class="logo mb-3">

                <h2 class="fw-bold">REGISTRO PROVEEDOR TURÍSTICO</h2>
                <h3 class="fw-bold">Registrate y publica tus actividades.</h3>

                <form action="<?= BASE_URL ?>/guardar-registro-proveedor" method="POST" enctype="multipart/form-data" id="registerForm">

                    <div class="form-grid">

                        <!-- Fila 1 -->
                        <input type="text" placeholder="Nombre" name="nombre">

                        <div class="select-container">
                            <select name="tipo_documento">
                                <option value="" disabled selected hidden>Tipo de documento</option>
                                <option value="cc">Cédula de ciudadanía</option>
                                <option value="ce">Cédula extranjería</option>
                                <option value="Pasaporte">Pasaporte</option>
                            </select>
                        </div>

                        <input type="number" placeholder="Identificación" name="identificacion">

                        <div class="select-container">
                            <select name="genero">
                                <option value="" disabled selected hidden>Género</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                            </select>
                        </div>

                        <!-- Fila 2 -->
                        <input type="tel" placeholder="Teléfono" name="telefono">

                        <input type="email" name="email" placeholder="Correo" required>

                        <div class="password-container">
                            <input type="password" name="clave" placeholder="Contraseña" id="password" required>
                            <i class="bi bi-eye-fill" id="togglePassword"></i>
                        </div>

                        <div class="password-container">
                            <input type="password" placeholder="Confirmar contraseña" id="confirmPassword" required>
                            <i class="bi bi-eye-fill" id="toggleConfirmPassword"></i>
                        </div>

                        <span class="error-msg" id="passwordError" style="display:none;">
                            ⚠ Las contraseñas no coinciden.
                        </span>

                    </div>

                    <button type="submit">REGISTRARME</button>

                </form>
            </div>

            <div class="image-section">
                <img src="public/assets/extras/registrarse/img/REGISTRATE (2).png" alt="Aventura en el río">
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/extras/registrarse/registrarse.js"></script>
</body>

</html>