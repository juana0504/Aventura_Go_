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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayU (Demo) | Aventura Go</title>

    <link rel="icon" type="image/png" href="public/assets/website_externos/descubre_tours/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Lato:wght@300;400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tu archivo CSS — crealo con este nombre en tu carpeta css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/website_externos/payu_demo/payu_demo.css">


</head>

<body>

    <!-- Fondo decorativo -->
    <div class="pd-orb pd-orb--1" aria-hidden="true"></div>
    <div class="pd-orb pd-orb--2" aria-hidden="true"></div>
    <div class="pd-lines"         aria-hidden="true"></div>

    <main class="pd-wrapper">
        <div class="pd-card">

            <!-- Franja top animada (CSS ::before) -->

            <div class="pd-body">

                <!-- ── INDICADOR DE PASOS ── -->
                <div class="pd-steps">
                    <div class="pd-step pd-step--done">
                        <div class="pd-step__circle">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Reserva</span>
                    </div>
                    <div class="pd-step__line pd-step__line--done"></div>
                    <div class="pd-step pd-step--done">
                        <div class="pd-step__circle">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Resumen</span>
                    </div>
                    <div class="pd-step__line pd-step__line--done"></div>
                    <div class="pd-step pd-step--active">
                        <div class="pd-step__circle">3</div>
                        <span>Pago</span>
                    </div>
                    <div class="pd-step__line"></div>
                    <div class="pd-step">
                        <div class="pd-step__circle">4</div>
                        <span>Confirmación</span>
                    </div>
                </div>

                <!-- ── CABECERA ── -->
                <div class="pd-header">
                    <h1 class="pd-header__title">Pago con PayU</h1>
                    <p class="pd-header__sub">Esta es una pantalla <strong>DEMO</strong>. No ingreses datos reales.</p>
                </div>

                <!-- ── TARJETA VISUAL ANIMADA ── -->
                <div class="pd-scene">
                    <div class="pd-credit-card" id="pdCard">

                        <!-- Frente -->
                        <div class="pd-card-face pd-card-front">
                            <div class="pd-card-top">
                                <div class="pd-chip"></div>
                                <span class="pd-card-brand" id="pdBrand">AVENTURA GO</span>
                            </div>
                            <div class="pd-card-number" id="pdNumber">
                                •••• •••• •••• ••••
                            </div>
                            <div class="pd-card-bottom">
                                <div class="pd-card-group">
                                    <span class="pd-card-label">Titular</span>
                                    <span class="pd-card-value" id="pdHolder">NOMBRE APELLIDO</span>
                                </div>
                                <div class="pd-card-group">
                                    <span class="pd-card-label">Vence</span>
                                    <span class="pd-card-value" id="pdExpiry">MM/AA</span>
                                </div>
                                <div class="pd-card-logo">
                                    <div class="pd-card-logo__c1"></div>
                                    <div class="pd-card-logo__c2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Reverso -->
                        <div class="pd-card-face pd-card-back">
                            <div class="pd-card-stripe"></div>
                            <div class="pd-card-cvv-wrap">
                                <span class="pd-card-label">CVV</span>
                                <div class="pd-card-cvv-box" id="pdCvv">•••</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ── MÉTODOS DE PAGO ── -->
                <p class="pd-methods-label">Elige tu método de pago</p>
                <div class="pd-methods">

                    <div class="pd-method pd-method--active" data-method="tarjeta">
                        <span class="pd-method__icon">💳</span>
                        <span class="pd-method__name">Tarjeta</span>
                    </div>
                    <div class="pd-method" data-method="pse">
                        <span class="pd-method__icon">🏦</span>
                        <span class="pd-method__name">PSE</span>
                    </div>
                    <div class="pd-method" data-method="nequi">
                        <span class="pd-method__icon">📱</span>
                        <span class="pd-method__name">Nequi</span>
                    </div>
                    <div class="pd-method" data-method="daviplata">
                        <span class="pd-method__icon">📱</span>
                        <span class="pd-method__name">Daviplata</span>
                    </div>

                </div>

                <!-- ── FORMULARIOS ── -->
                <form action="<?= BASE_URL ?>/pago/payu-respuesta" method="POST">

                    <!-- TARJETA -->
                    <div class="pd-form pd-form--active" id="form-tarjeta">

                        <div class="pd-field">
                            <label class="pd-label" for="num_tarjeta">Número de tarjeta</label>
                            <input class="pd-input" id="num_tarjeta" type="text"
                                   maxlength="19" placeholder="4111 1111 1111 1111"
                                   autocomplete="cc-number">
                        </div>

                        <div class="pd-row">
                            <div class="pd-field">
                                <label class="pd-label" for="expiry">Vencimiento</label>
                                <input class="pd-input" id="expiry" type="text"
                                       maxlength="5" placeholder="MM/AA"
                                       autocomplete="cc-exp">
                            </div>
                            <div class="pd-field">
                                <label class="pd-label" for="cvv">CVV</label>
                                <input class="pd-input" id="cvv" type="text"
                                       maxlength="4" placeholder="•••"
                                       autocomplete="cc-csc">
                            </div>
                            <div class="pd-field">
                                <label class="pd-label" for="holder">Nombre en la tarjeta</label>
                                <input class="pd-input" id="holder" type="text"
                                       placeholder="JUAN PEREZ"
                                       autocomplete="cc-name">
                            </div>
                        </div>

                    </div>

                    <!-- PSE -->
                    <div class="pd-form" id="form-pse">
                        <div class="pd-field">
                            <label class="pd-label" for="banco">Selecciona tu banco</label>
                            <select class="pd-select" id="banco" name="banco">
                                <option value="">— Elige un banco —</option>
                                <option>Bancolombia</option>
                                <option>Davivienda</option>
                                <option>BBVA</option>
                                <option>Banco de Bogotá</option>
                            </select>
                        </div>
                        <div class="pd-field">
                            <label class="pd-label" for="tipo_persona">Tipo de persona</label>
                            <select class="pd-select" id="tipo_persona" name="tipo_persona">
                                <option>Persona natural</option>
                                <option>Persona jurídica</option>
                            </select>
                        </div>
                    </div>

                    <!-- NEQUI -->
                    <div class="pd-form" id="form-nequi">
                        <div class="pd-field">
                            <label class="pd-label" for="cel_nequi">Número de celular Nequi</label>
                            <input class="pd-input" id="cel_nequi" type="text"
                                   placeholder="3001234567" maxlength="10">
                        </div>
                    </div>

                    <!-- DAVIPLATA -->
                    <div class="pd-form" id="form-daviplata">
                        <div class="pd-field">
                            <label class="pd-label" for="cel_davi">Número de celular Daviplata</label>
                            <input class="pd-input" id="cel_davi" type="text"
                                   placeholder="3001234567" maxlength="10">
                        </div>
                    </div>

                    <!-- Campo hidden del método -->
                    <input type="hidden" name="metodo_demo" id="metodo_hidden" value="tarjeta">

                    <!-- Alerta demo -->
                    <div class="pd-alert">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 20h20L12 2z" stroke="#EA8217" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M12 9v4M12 17h.01" stroke="#EA8217" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Esto es una <strong>simulación</strong>. El botón solo confirma la compra en modo demo.</span>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="pd-btn">
                        <span>Pagar (Demo)</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                </form>

                <!-- Badge SSL -->
                <div class="pd-ssl">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L4 6v6c0 5.25 3.5 10.15 8 11.35C16.5 22.15 20 17.25 20 12V6L12 2z"
                              fill="#16a34a" fill-opacity=".2" stroke="#16a34a" stroke-width="1.5"/>
                    </svg>
                    Pago 100% seguro &nbsp;·&nbsp; Cifrado SSL &nbsp;·&nbsp; Powered by PayU
                </div>

            </div><!-- /.pd-body -->
        </div><!-- /.pd-card -->
    </main>

    <script>
    // ── Métodos de pago ──
    const methods = document.querySelectorAll('.pd-method');
    const forms   = document.querySelectorAll('.pd-form');
    const hidden  = document.getElementById('metodo_hidden');
    const scene   = document.querySelector('.pd-scene'); // para mostrar/ocultar tarjeta

    methods.forEach(m => {
        m.addEventListener('click', () => {
            methods.forEach(x => x.classList.remove('pd-method--active'));
            forms.forEach(f => f.classList.remove('pd-form--active'));
            m.classList.add('pd-method--active');
            const key = m.dataset.method;
            hidden.value = key;
            document.getElementById('form-' + key).classList.add('pd-form--active');
            // Mostrar tarjeta solo para tarjeta de crédito
            scene.style.display = key === 'tarjeta' ? 'block' : 'none';
        });
    });

    // ── Tarjeta animada ──
    const card     = document.getElementById('pdCard');
    const pdNumber = document.getElementById('pdNumber');
    const pdHolder = document.getElementById('pdHolder');
    const pdExpiry = document.getElementById('pdExpiry');
    const pdCvv    = document.getElementById('pdCvv');
    const pdBrand  = document.getElementById('pdBrand');

    // Número
    const inputNum = document.getElementById('num_tarjeta');
    inputNum.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, '').slice(0, 16);
        e.target.value = v.replace(/(.{4})/g, '$1 ').trim();
        const display = v.padEnd(16, '•').replace(/(.{4})/g, '$1 ').trim();
        pdNumber.textContent = display;
        // Detectar marca
        if      (/^4/.test(v))          pdBrand.textContent = 'VISA';
        else if (/^5[1-5]/.test(v))     pdBrand.textContent = 'MASTERCARD';
        else if (/^3[47]/.test(v))      pdBrand.textContent = 'AMEX';
        else                            pdBrand.textContent = 'AVENTURA GO';
    });

    // Titular
    document.getElementById('holder').addEventListener('input', e => {
        const v = e.target.value.toUpperCase() || 'NOMBRE APELLIDO';
        pdHolder.textContent = v;
    });

    // Vencimiento
    document.getElementById('expiry').addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, '').slice(0, 4);
        if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
        e.target.value = v;
        pdExpiry.textContent = v || 'MM/AA';
    });

    // CVV — voltear tarjeta
    const inputCvv = document.getElementById('cvv');
    inputCvv.addEventListener('focus', () => {
        card.classList.add('pd-flipped');
    });
    inputCvv.addEventListener('blur', () => {
        card.classList.remove('pd-flipped');
    });
    inputCvv.addEventListener('input', e => {
        const v = e.target.value.replace(/\D/g, '').slice(0, 4);
        e.target.value = v;
        pdCvv.textContent = v.padEnd(v.length, '•') || '•••';
    });
    </script>

</body>
</html>