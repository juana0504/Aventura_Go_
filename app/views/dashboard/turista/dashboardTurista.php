<?php
if (!isset($datos_turista)) {
    header('Location: /aventura_go/turista/dashboard');
    exit;
}

$nombreUsuario = $datos_turista['nombre'] ?? ($_SESSION['user']['nombre'] ?? '');
$estadisticas = $datos_turista['estadisticas'] ?? [];
$reservas = $datos_turista['reservas'] ?? [];

$totalReservas = $estadisticas['total_reservas'] ?? 0;
$confirmadas = $estadisticas['confirmadas'] ?? 0;
$pendientes = $estadisticas['pendientes'] ?? 0;
$totalGastado = $estadisticas['total_gastado'] ?? 0;

// Badge classes para la tabla — misma lógica, nuevas clases CSS
$estadoBadgeClass = static function (string $estado): string {
    if ($estado === 'confirmada') {
        return 'ag-badge ag-badge--confirmed';
    }
    if ($estado === 'pendiente') {
        return 'ag-badge ag-badge--pending';
    }
    return 'ag-badge ag-badge--cancelled';
};

// Iniciales del usuario para el avatar
$iniciales = '';
$partes = explode(' ', trim($nombreUsuario));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Turista — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Layout global (mantener) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/layout_admin.css">

    <!-- Estilos comunes (mantener) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/layouts/panel_turista.css">

    <!-- CSS rediseñado de esta vista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">
</head>

<body class="ag-body">

    <div id="turista" class="ag-layout">

        <!-- ==========================================
             SIDEBAR IZQUIERDO
        =========================================== -->
        <nav class="ag-sidebar">

            <!-- Logo -->
            <div class="ag-sidebar__logo">
                <div class="ag-sidebar__logo-icon">A</div>
                <div>
                    <div class="ag-sidebar__logo-text">AVENTURA GO</div>
                    <div class="ag-sidebar__logo-sub">Panel Turista</div>
                </div>
            </div>

            <!-- Sección menú -->
            <div class="ag-sidebar__section-label">Menú</div>

            <a href="<?= BASE_URL ?>turista/dashboard" class="ag-nav-item ag-nav-item--active">
                <i class="bi bi-grid-1x2-fill ag-nav-item__icon"></i>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-nav-item">
                <i class="bi bi-calendar3 ag-nav-item__icon"></i>
                Ver reservas
            </a>
            <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item">
                <i class="bi bi-ticket-perforated ag-nav-item__icon"></i>
                Tickets
            </a>
            <a href="<?= BASE_URL ?>turista/favoritos" class="ag-nav-item">
                <i class="bi bi-heart ag-nav-item__icon"></i>
                Favoritos
            </a>
            <a href="<?= BASE_URL ?>turista/resenas" class="ag-nav-item">
                <i class="bi bi-star ag-nav-item__icon"></i>
                Reseñas
            </a>

        </nav>

        <!-- ==========================================
             ÁREA PRINCIPAL
        =========================================== -->
        <div class="ag-main">

            <header class="ag-topbar">

                <!-- Buscador -->
                <div class="ag-topbar__search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Buscar actividades, destinos..." class="ag-topbar__input" autocomplete="off">
                </div>

                <div class="ag-topbar__actions">

                    <!-- Modo oscuro -->
                    <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                        <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                    </button>

                    <!-- Notificaciones -->
                    <div class="ag-topbar__dropdown-wrap">
                        <button class="ag-icon-btn ag-icon-btn--notif" id="ag-notif-btn" title="Notificaciones">
                            <i class="bi bi-bell-fill"></i>
                        </button>

                        <!-- Panel de notificaciones -->
                        <div class="ag-dropdown ag-dropdown--notif" id="ag-notif-panel">
                            <div class="ag-dropdown__header">
                                <span class="ag-dropdown__title">Notificaciones</span>
                                <button class="ag-dropdown__mark-all">Marcar todas</button>
                            </div>
                            <div class="ag-notif-list">
                                <div class="ag-notif-item ag-notif-item--unread">
                                    <div class="ag-notif-item__icon ag-notif-item__icon--green">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="ag-notif-item__body">
                                        <p class="ag-notif-item__text">Tu reserva de <strong>Rafting</strong> fue confirmada.</p>
                                        <span class="ag-notif-item__time">Hace 2 horas</span>
                                    </div>
                                    <span class="ag-notif-item__dot"></span>
                                </div>
                                <div class="ag-notif-item ag-notif-item--unread">
                                    <div class="ag-notif-item__icon ag-notif-item__icon--amber">
                                        <i class="bi bi-clock-fill"></i>
                                    </div>
                                    <div class="ag-notif-item__body">
                                        <p class="ag-notif-item__text">Tienes una reserva <strong>pendiente</strong> de pago.</p>
                                        <span class="ag-notif-item__time">Hace 5 horas</span>
                                    </div>
                                    <span class="ag-notif-item__dot"></span>
                                </div>
                                <div class="ag-notif-item">
                                    <div class="ag-notif-item__icon ag-notif-item__icon--blue">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="ag-notif-item__body">
                                        <p class="ag-notif-item__text">¿Cómo fue tu experiencia en <strong>Parapente</strong>?</p>
                                        <span class="ag-notif-item__time">Ayer</span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>turista/notificaciones" class="ag-dropdown__footer">
                                Ver todas las notificaciones
                            </a>
                        </div>
                    </div>

                    <!-- Perfil de usuario -->
                    <div class="ag-topbar__dropdown-wrap">
                        <button class="ag-profile-btn" id="ag-profile-btn">
                            <div class="ag-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                            <div class="ag-profile-btn__info">
                                <span class="ag-profile-btn__name"><?= htmlspecialchars($nombreUsuario) ?></span>
                                <span class="ag-profile-btn__role">Turista</span>
                            </div>
                            <i class="bi bi-chevron-down ag-profile-btn__chevron" id="ag-profile-chevron"></i>
                        </button>

                        <!-- Dropdown perfil -->
                        <div class="ag-dropdown ag-dropdown--profile" id="ag-profile-panel">
                            <div class="ag-dropdown__user-header">
                                <div class="ag-profile-btn__avatar ag-profile-btn__avatar--lg">
                                    <?= htmlspecialchars($iniciales) ?>
                                </div>
                                <div>
                                    <div class="ag-dropdown__user-name"><?= htmlspecialchars($nombreUsuario) ?></div>
                                    <div class="ag-dropdown__user-role">Turista · AventuraGO</div>
                                </div>
                            </div>

                            <div class="ag-dropdown__divider"></div>

                            <a href="<?= BASE_URL ?>turista/perfil" class="ag-dropdown__item">
                                <i class="bi bi-person-circle"></i> Mi perfil
                            </a>
                            <a href="<?= BASE_URL ?>turista/reservas" class="ag-dropdown__item">
                                <i class="bi bi-calendar3"></i> Mis reservas
                            </a>
                            
                            <div class="ag-dropdown__divider"></div>

                            <a href="<?= BASE_URL ?>logout" class="ag-dropdown__item ag-dropdown__item--danger">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Contenido -->
            <main class="ag-content">

                <!-- Saludo -->
                <div class="ag-greeting">
                    <div class="ag-greeting__eyebrow">Bienvenido de nuevo</div>
                    <h1 class="ag-greeting__name">
                        ¡Hola, <span><?= htmlspecialchars($nombreUsuario) ?>!</span>
                    </h1>
                    <p class="ag-greeting__sub">Gestiona tus reservas y experiencias de deportes extremos</p>
                </div>

                <!-- ==============================
                     TARJETAS DE ESTADÍSTICAS
                =============================== -->
                <div class="ag-stats-grid">

                    <div class="ag-stat-card">
                        <div class="ag-stat-card__icon ag-stat-card__icon--orange">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="ag-stat-card__label">Mis Reservas</div>
                        <div class="ag-stat-card__value"><?= number_format($totalReservas) ?></div>
                    </div>

                    <div class="ag-stat-card">
                        <div class="ag-stat-card__icon ag-stat-card__icon--green">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="ag-stat-card__label">Confirmadas</div>
                        <div class="ag-stat-card__value"><?= number_format($confirmadas) ?></div>
                    </div>

                    <div class="ag-stat-card">
                        <div class="ag-stat-card__icon ag-stat-card__icon--amber">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="ag-stat-card__label">Pendientes</div>
                        <div class="ag-stat-card__value"><?= number_format($pendientes) ?></div>
                    </div>

                    <div class="ag-stat-card ag-stat-card--featured">
                        <div class="ag-stat-card__icon ag-stat-card__icon--orange">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="ag-stat-card__label">Total Gastado</div>
                        <div class="ag-stat-card__value">$<?= number_format($totalGastado, 2) ?></div>
                    </div>

                </div>

                <!-- ==============================
                     ACCIONES RÁPIDAS
                =============================== -->
                <div class="ag-section-header">
                    <h2 class="ag-section-title">Acciones <span>rápidas</span></h2>
                </div>

                <div class="ag-quick-grid">
                    <a href="<?= BASE_URL ?>turista/actividades" class="ag-quick-card">
                        <div class="ag-quick-card__icon"><i class="bi bi-compass"></i></div>
                        <div>
                            <div class="ag-quick-card__label">Explorar actividades</div>
                            <div class="ag-quick-card__sub">Encuentra tu próxima aventura</div>
                        </div>
                        <i class="bi bi-chevron-right ag-quick-card__arrow"></i>
                    </a>
                    <a href="<?= BASE_URL ?>turista/destinos" class="ag-quick-card">
                        <div class="ag-quick-card__icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="ag-quick-card__label">Ver destinos</div>
                            <div class="ag-quick-card__sub">Lugares disponibles</div>
                        </div>
                        <i class="bi bi-chevron-right ag-quick-card__arrow"></i>
                    </a>
                    <a href="<?= BASE_URL ?>turista/resenas" class="ag-quick-card">
                        <div class="ag-quick-card__icon"><i class="bi bi-star"></i></div>
                        <div>
                            <div class="ag-quick-card__label">Dejar reseña</div>
                            <div class="ag-quick-card__sub">Comparte tu experiencia</div>
                        </div>
                        <i class="bi bi-chevron-right ag-quick-card__arrow"></i>
                    </a>
                </div>

                <!-- ==============================
                     TABLA DE RESERVAS
                =============================== -->
                <div class="ag-section-header">
                    <h2 class="ag-section-title">Mis <span>Reservas</span></h2>
                    <a href="<?= BASE_URL ?>turista/reservas" class="ag-btn-outline">Ver todas</a>
                </div>

                <div class="ag-table-wrap">
                    <table class="ag-table" id="tabla-reservas-turista">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Ubicación</th>
                                <th>Personas</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reservas)): ?>
                                <?php foreach ($reservas as $r): ?>
                                    <tr>
                                        <td>
                                            <div class="ag-table__act-name"><?= htmlspecialchars($r['nombre_actividad']) ?></div>
                                            <div class="ag-table__act-meta"><?= htmlspecialchars($r['ubicacion']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($r['fecha']) ?></td>
                                        <td><?= htmlspecialchars($r['ubicacion']) ?></td>
                                        <td><?= htmlspecialchars($r['cantidad_personas']) ?></td>
                                        <td>$<?= number_format($r['precio'], 2) ?></td>
                                        <td>
                                            <span class="<?= $estadoBadgeClass($r['estado'] ?? '') ?>">
                                                <span class="ag-badge__dot"></span>
                                                <?= htmlspecialchars($r['estado']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="ag-empty-state">
                                            <i class="bi bi-calendar-x ag-empty-state__icon"></i>
                                            <p>No tienes reservas aún.</p>
                                            <a href="<?= BASE_URL ?>turista/actividades" class="ag-btn-primary">
                                                Explorar actividades
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS específico (mantener) -->
    <script src="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.js"></script>

    <script>
    (function () {
        /* ─── MODO OSCURO ────────────────────────── */
        const body      = document.body;
        const darkBtn   = document.getElementById('ag-dark-toggle');
        const darkIcon  = document.getElementById('ag-dark-icon');
        const DARK_KEY  = 'ag_dark_mode';

        function applyDark(on) {
            body.classList.toggle('ag-dark', on);
            darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
            localStorage.setItem(DARK_KEY, on ? '1' : '0');
        }

        // Restaurar preferencia guardada
        applyDark(localStorage.getItem(DARK_KEY) === '1');

        darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

        /* ─── DROPDOWNS (notif + perfil) ─────────── */
        function makeDropdown(btnId, panelId, chevronId) {
            const btn    = document.getElementById(btnId);
            const panel  = document.getElementById(panelId);
            const chev   = chevronId ? document.getElementById(chevronId) : null;
            if (!btn || !panel) return;

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = panel.classList.toggle('ag-dropdown--open');
                if (chev) chev.classList.toggle('ag-profile-btn__chevron--open', open);
                // Cerrar el otro dropdown si estaba abierto
                document.querySelectorAll('.ag-dropdown--open').forEach(d => {
                    if (d !== panel) {
                        d.classList.remove('ag-dropdown--open');
                        document.querySelectorAll('.ag-profile-btn__chevron--open').forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
                    }
                });
            });
        }

        makeDropdown('ag-notif-btn',    'ag-notif-panel');
        makeDropdown('ag-profile-btn',  'ag-profile-panel', 'ag-profile-chevron');

        // Clic fuera cierra todo
        document.addEventListener('click', () => {
            document.querySelectorAll('.ag-dropdown--open').forEach(d => d.classList.remove('ag-dropdown--open'));
            document.querySelectorAll('.ag-profile-btn__chevron--open').forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
        });

        // "Marcar todas" quita los puntos de no leído
        const markAll = document.querySelector('.ag-dropdown__mark-all');
        if (markAll) {
            markAll.addEventListener('click', () => {
                document.querySelectorAll('.ag-notif-item--unread').forEach(el => el.classList.remove('ag-notif-item--unread'));
                document.querySelector('.ag-icon-btn--notif')?.classList.remove('ag-icon-btn--notif');
            });
        }
    })();
    </script>

</body>

</html>