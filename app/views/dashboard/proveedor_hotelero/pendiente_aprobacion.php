<?php
require_once __DIR__ . '/../../../../config/config.php';
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
require_once BASE_PATH . '/app/controllers/administrador/hotelero.php';

$proveedor = listarHoteles()[0] ?? null; // Assuming the first provider is used


// Lógica intacta
$estadoBadgeClass = static function (string $estado): string {
    if ($estado === 'confirmada') return 'pv-badge pv-badge--confirmed';
    if ($estado === 'pendiente')  return 'pv-badge pv-badge--pending';
    return 'pv-badge pv-badge--cancelled';
};

// Iniciales para el topbar
$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
$partes = explode(' ', trim($nombreProveedor));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta pendiente</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

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
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/buscador_proveedor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- Estilos CSS (siempre al final)-->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/pendiente_aprobacion/pendiente_aprobacion.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
</head>

<body>

    <section class="pendiente-aprobacion">

        <?php $activeSection = 'dashboard'; include __DIR__ . '/_sidebar.php'; ?>

        <!-- Contenido Principal -->
        <main class="informacion-main">

            <!-- TOPBAR -->
            <header class="pv-topbar">

                <div class="pv-topbar__search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Buscar actividades, reservas..." class="pv-topbar__input" id="pv-search-input" autocomplete="off">
                </div>

                <div class="pv-topbar__actions">

                    <!-- Modo oscuro -->
                    <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro">
                        <i class="bi bi-moon-fill" id="pv-dark-icon"></i>
                    </button>

                    <!-- Notificaciones -->
                    <div class="pv-topbar__dropdown-wrap">
                        <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn">
                            <i class="bi bi-bell-fill"></i>
                        </button>
                        <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                            <div class="pv-dropdown__header">
                                <span class="pv-dropdown__title">Notificaciones</span>
                                <button class="pv-dropdown__mark-all">Marcar todas</button>
                            </div>
                            <div class="pv-notif-list">
                                <div class="pv-notif-item pv-notif-item--unread">
                                    <div class="pv-notif-item__icon pv-notif-item__icon--green"><i class="bi bi-check-circle-fill"></i></div>
                                    <div class="pv-notif-item__body">
                                        <p class="pv-notif-item__text">Nueva reserva confirmada en tu actividad.</p>
                                        <span class="pv-notif-item__time">Hace 1 hora</span>
                                    </div>
                                    <span class="pv-notif-item__dot"></span>
                                </div>
                                <div class="pv-notif-item pv-notif-item--unread">
                                    <div class="pv-notif-item__icon pv-notif-item__icon--amber"><i class="bi bi-clock-fill"></i></div>
                                    <div class="pv-notif-item__body">
                                        <p class="pv-notif-item__text">Tienes una reserva <strong>pendiente</strong> de confirmación.</p>
                                        <span class="pv-notif-item__time">Hace 3 horas</span>
                                    </div>
                                    <span class="pv-notif-item__dot"></span>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__footer">Ver todas las notificaciones</a>
                        </div>
                    </div>

                    <!-- Perfil -->
                    <div class="pv-topbar__dropdown-wrap">
                        <button class="pv-profile-btn" id="pv-profile-btn">
                            <div class="pv-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                            <div class="pv-profile-btn__info">
                                <span class="pv-profile-btn__name"><?= htmlspecialchars($nombreProveedor) ?></span>
                                <span class="pv-profile-btn__role">Proveedor Hotelero</span>
                            </div>
                            <i class="bi bi-chevron-down pv-profile-btn__chevron" id="pv-profile-chevron"></i>
                        </button>
                        <div class="pv-dropdown pv-dropdown--profile" id="pv-profile-panel">
                            <div class="pv-dropdown__user-header">
                                <div class="pv-profile-btn__avatar pv-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
                                <div>
                                    <div class="pv-dropdown__user-name"><?= htmlspecialchars($nombreProveedor) ?></div>
                                    <div class="pv-dropdown__user-role">Proveedor Hotelero · AventuraGO</div>
                                </div>
                            </div>
                            <div class="pv-dropdown__divider"></div>
                            <a href="<?= BASE_URL ?>proveedor/perfil" class="pv-dropdown__item">
                                <i class="bi bi-person-circle"></i> Mi perfil
                            </a>
                            <a href="<?= BASE_URL ?>proveedor/consultar-actividad" class="pv-dropdown__item">
                                <i class="bi bi-compass"></i> Mis actividades
                            </a>
                            <a href="<?= BASE_URL ?>proveedor/tickets" class="pv-dropdown__item">
                                <i class="bi bi-headset"></i> Soporte
                            </a>
                            <div class="pv-dropdown__divider"></div>
                            <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            
            <!-- CONTENIDO DE LA PAGINA -->
            <section class="pendiente">

                <div class="container-fluid">

                    <?php if (strtoupper($proveedor['estado'] ?? '') === 'APROBADO'): ?>
                        <div class="alert alert-warning">
                            <strong>Completa tu información para continuar el proceso.</strong>
                            <a href="<?= BASE_URL ?>proveedor_hotelero/completar-informacion" class="btn btn-sm btn-primary ms-2">
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

    <script src="<?= BASE_URL ?>public/assets/dashboard/proveedor_hotelero/registrar_informacion/registrar_informacion.js"></script>

    <script>
        // Toggle sidebar
        const btnMenu = document.getElementById("btnMenu");
        const sidebar = document.querySelector(".sidebar");

        if (btnMenu && sidebar) {
            btnMenu.addEventListener("click", () => {
                sidebar.classList.toggle("activo");
            });
        }

        // Ensure the hamburger menu toggle works
        btnMenu.addEventListener("click", () => {
            sidebar.classList.toggle("activo");
        });
    </script>

    <script>
        (function() {

            /* ─── MODO OSCURO ────────────────────────── */
            const body = document.body;
            const darkBtn = document.getElementById('pv-dark-toggle');
            const darkIcon = document.getElementById('pv-dark-icon');
            const DARK_KEY = 'pv_dark_mode';

            function applyDark(on) {
                body.classList.toggle('pv-dark', on);
                darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
                darkBtn.title = on ? 'Modo claro' : 'Modo oscuro';
                localStorage.setItem(DARK_KEY, on ? '1' : '0');
            }

            applyDark(localStorage.getItem(DARK_KEY) === '1');
            darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));

            /* ─── DROPDOWNS ──────────────────────────── */
            function makeDropdown(btnId, panelId, chevronId) {
                const btn = document.getElementById(btnId);
                const panel = document.getElementById(panelId);
                const chev = chevronId ? document.getElementById(chevronId) : null;
                if (!btn || !panel) return;
                btn.addEventListener('click', e => {
                    e.stopPropagation();
                    const open = panel.classList.toggle('pv-dropdown--open');
                    if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open);
                    document.querySelectorAll('.pv-dropdown--open').forEach(d => {
                        if (d !== panel) {
                            d.classList.remove('pv-dropdown--open');
                            document.querySelectorAll('.pv-profile-btn__chevron--open')
                                .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
                        }
                    });
                });
            }

            makeDropdown('pv-notif-btn', 'pv-notif-panel');
            makeDropdown('pv-profile-btn', 'pv-profile-panel', 'pv-profile-chevron');

            document.addEventListener('click', () => {
                document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open'));
                document.querySelectorAll('.pv-profile-btn__chevron--open')
                    .forEach(c => c.classList.remove('pv-profile-btn__chevron--open'));
            });

            /* ─── NOTIFICACIONES ─────────────────────── */
            const markAll = document.querySelector('.pv-dropdown__mark-all');
            if (markAll) {
                markAll.addEventListener('click', () => {
                    document.querySelectorAll('.pv-notif-item--unread').forEach(el => el.classList.remove('pv-notif-item--unread'));
                    document.querySelector('.pv-icon-btn--notif')?.classList.remove('pv-icon-btn--notif');
                });
            }

            /* ─── BOTÓN FILTRAR ──────────────────────── */
            const btnFiltrar = document.getElementById('btn-filtrar');
            if (btnFiltrar) {
                btnFiltrar.addEventListener('click', () => {
                    const panel = document.getElementById('filtros-reservas');
                    if (panel) panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                });
            }

            /* ─── BÚSQUEDA ───────────────────────────── */
            const searchInput = document.getElementById('pv-search-input');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    const q = searchInput.value.toLowerCase().trim();
                    document.querySelectorAll('#tabla-reservas-proveedor tbody tr').forEach(row => {
                        row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
                    });
                });
            }

        })();
    </script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>

</html>