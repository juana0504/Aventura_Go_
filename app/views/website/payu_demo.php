<?php
// Vista DEMO. No proceses ni guardes datos reales aquí.
session_start();

// Seguridad mínima: si no hay operación en curso, regresa al inicio
if (!isset($_SESSION['id_reserva']) || !isset($_SESSION['id_pago'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PayU (Demo) | Aventura Go</title>
    <link rel="icon" type="image/png" href="public/assets/website_externos/descubre_tours/img/FAVICON.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-3">Pago con PayU (Simulación)</h3>
            <p class="text-muted">
                Esta es una pantalla <strong>DEMO</strong>. No ingreses datos reales.
            </p>

            <form action="<?= BASE_URL ?>/pago/payu-respuesta" method="POST">

                <!-- Selector de método -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Elige tu método de pago</label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo_demo" id="metodo_tarjeta" value="tarjeta" checked>
                        <label class="form-check-label" for="metodo_tarjeta">
                            💳 Tarjeta
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo_demo" id="metodo_pse" value="pse">
                        <label class="form-check-label" for="metodo_pse">
                            🏦 PSE
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo_demo" id="metodo_nequi" value="nequi">
                        <label class="form-check-label" for="metodo_nequi">
                            📱 Nequi
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metodo_demo" id="metodo_daviplata" value="daviplata">
                        <label class="form-check-label" for="metodo_daviplata">
                            📱 Daviplata
                        </label>
                    </div>
                </div>

                <!-- ================= TARJETA ================= -->
                <div id="form-tarjeta">
                    <div class="mb-3">
                        <label class="form-label">Número de tarjeta</label>
                        <input type="text" class="form-control" placeholder="4111 1111 1111 1111">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">MM/AA</label>
                            <input type="text" class="form-control" placeholder="12/30">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" placeholder="123">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre en la tarjeta</label>
                            <input type="text" class="form-control" placeholder="JUAN PEREZ">
                        </div>
                    </div>
                </div>

                <!-- ================= PSE ================= -->
                <div id="form-pse" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Selecciona tu banco</label>
                        <select class="form-select">
                            <option>Bancolombia</option>
                            <option>Davivienda</option>
                            <option>BBVA</option>
                            <option>Banco de Bogotá</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de persona</label>
                        <select class="form-select">
                            <option>Persona natural</option>
                            <option>Persona jurídica</option>
                        </select>
                    </div>
                </div>

                <!-- ================= NEQUI ================= -->
                <div id="form-nequi" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Número de celular Nequi</label>
                        <input type="text" class="form-control" placeholder="3001234567">
                    </div>
                </div>

                <!-- ================= DAVIPLATA ================= -->
                <div id="form-daviplata" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Número de celular Daviplata</label>
                        <input type="text" class="form-control" placeholder="3001234567">
                    </div>
                </div>

                <div class="alert alert-warning mt-3">
                    ⚠️ Esto es una <strong>simulación</strong>. El botón solo confirma la compra en modo demo.
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Pagar (Demo)
                </button>
            </form>
        </div>
    </div>

    <script>
        const radios = document.querySelectorAll('input[name="metodo_demo"]');

        const formTarjeta = document.getElementById('form-tarjeta');
        const formPse = document.getElementById('form-pse');
        const formNequi = document.getElementById('form-nequi');
        const formDaviplata = document.getElementById('form-daviplata');

        function ocultarTodos() {
            formTarjeta.style.display = 'none';
            formPse.style.display = 'none';
            formNequi.style.display = 'none';
            formDaviplata.style.display = 'none';
        }

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                ocultarTodos();

                if (this.value === 'tarjeta') formTarjeta.style.display = 'block';
                if (this.value === 'pse') formPse.style.display = 'block';
                if (this.value === 'nequi') formNequi.style.display = 'block';
                if (this.value === 'daviplata') formDaviplata.style.display = 'block';
            });
        });
    </script>

</body>

</html>