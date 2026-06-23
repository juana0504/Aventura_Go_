<?php
if (!isset($datos_turista)) {
    header('Location: ' . BASE_URL . 'turista/dashboard');
    exit;
}

$nombreUsuario    = $datos_turista['nombre'] ?? ($_SESSION['user']['nombre'] ?? '');
$estadisticas     = $datos_turista['estadisticas'] ?? [];
$reservas         = $datos_turista['reservas'] ?? [];
$reservasHosp     = $datos_turista['reservas_hospedaje'] ?? [];

$totalReservas = $estadisticas['total_reservas'] ?? 0;
$confirmadas   = $estadisticas['confirmadas'] ?? 0;
$pendientes    = $estadisticas['pendientes'] ?? 0;

$totalGastadoAct  = array_sum(array_column($reservas,     'precio'));
$totalGastadoHosp = array_sum(array_column($reservasHosp, 'precio'));
$totalGastado     = $totalGastadoAct + $totalGastadoHosp;

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
                <i class="bi bi-compass ag-nav-item__icon"></i> Mis Tours
            </a>
            <a href="<?= BASE_URL ?>turista/ver-reservas-hotel" class="ag-nav-item">
                <i class="bi bi-building ag-nav-item__icon"></i> Mis Hoteles
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
                        <button class="ag-icon-btn" id="ag-notif-btn" title="Notificaciones" style="position:relative;">
                            <i class="bi bi-bell-fill"></i>
                            <span id="ag-notif-badge" style="display:none;position:absolute;top:-4px;right:-4px;background:#EA8217;color:#fff;font-size:10px;font-weight:700;min-width:18px;height:18px;border-radius:999px;align-items:center;justify-content:center;padding:0 4px;line-height:1;"></span>
                        </button>
                        <div class="ag-dropdown ag-dropdown--notif" id="ag-notif-panel">
                            <div class="ag-dropdown__header">
                                <span class="ag-dropdown__title">Notificaciones</span>
                                <button class="ag-dropdown__mark-all" id="ag-notif-marcar-todas">Marcar todas</button>
                            </div>
                            <div class="ag-notif-list" id="ag-notif-list"></div>
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

                    <div class="ag-stat-card ag-stat-card--featured" style="flex-direction:column;align-items:flex-start;gap:6px;padding:20px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                            <div class="ag-stat-card__icon ag-stat-card__icon--orange" style="width:36px;height:36px;min-width:36px;">
                                <i class="bi bi-cash-stack" style="font-size:16px;"></i>
                            </div>
                            <span style="color:rgba(255,255,255,.6);font-size:12px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;">Total Gastado</span>
                        </div>
                        <!-- fila actividades -->
                        <div style="display:flex;justify-content:space-between;width:100%;align-items:center;">
                            <span style="color:#fff;font-size:13px;display:flex;align-items:center;gap:5px;">
                                <i class="bi bi-compass" style="color:#EA8217;"></i> Actividades
                            </span>
                            <span style="color:#fff;font-size:14px;font-weight:700;">$<?= number_format($totalGastadoAct, 0, ',', '.') ?></span>
                        </div>
                        <!-- fila hospedajes -->
                        <div style="display:flex;justify-content:space-between;width:100%;align-items:center;">
                            <span style="color:#fff;font-size:13px;display:flex;align-items:center;gap:5px;">
                                <i class="bi bi-building" style="color:#EA8217;"></i> Hospedajes
                            </span>
                            <span style="color:#fff;font-size:14px;font-weight:700;">$<?= number_format($totalGastadoHosp, 0, ',', '.') ?></span>
                        </div>
                        <!-- divisor naranja -->
                        <div style="width:100%;height:2px;background:#EA8217;margin:4px 0;border-radius:2px;"></div>
                        <!-- total -->
                        <div style="display:flex;justify-content:space-between;width:100%;align-items:center;">
                            <span style="color:#EA8217;font-size:13px;font-weight:700;">Total gastado</span>
                            <span style="color:#EA8217;font-size:20px;font-weight:800;">$<?= number_format($totalGastado, 0, ',', '.') ?></span>
                        </div>
                    </div>

                </div>

                <!-- ==============================
                     ACCIONES RÁPIDAS
                =============================== -->
                <div class="ag-section-header">
                    <h2 class="ag-section-title">Acciones <span>rápidas</span></h2>
                </div>

                <div class="ag-quick-grid">
                    <a href="<?= BASE_URL ?>" class="ag-quick-card">
                        <div class="ag-quick-card__icon"><i class="bi bi-compass"></i></div>
                        <div>
                            <div class="ag-quick-card__label">Explorar actividades</div>
                            <div class="ag-quick-card__sub">Encuentra tu próxima aventura</div>
                        </div>
                        <i class="bi bi-chevron-right ag-quick-card__arrow"></i>
                    </a>
                    <a href="<?= BASE_URL ?>descubre-tours" class="ag-quick-card">
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
                     TABLA RESERVAS ACTIVIDADES
                =============================== -->
                <div class="ag-section-header">
                    <h2 class="ag-section-title">Mi Reserva de <span>Actividades</span></h2>
                    <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-btn-outline">Ver todas</a>
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
                                            <div class="ag-table__act-meta"><?= htmlspecialchars($r['ubicacion'] ?? '') ?></div>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                                        <td><?= htmlspecialchars($r['ubicacion'] ?? '—') ?></td>
                                        <td><?= (int)$r['cantidad_personas'] ?></td>
                                        <td>$<?= number_format($r['precio'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="<?= $estadoBadgeClass($r['estado'] ?? '') ?>">
                                                <span class="ag-badge__dot"></span>
                                                <?= ucfirst(htmlspecialchars($r['estado'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="ag-empty-state">
                                            <i class="bi bi-compass ag-empty-state__icon"></i>
                                            <p>No tienes reservas de tours aún.</p>
                                            <a href="<?= BASE_URL ?>descubre-tours" class="ag-btn-primary">Explorar tours</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="background:#2D4059;color:#fff;padding:13px 20px;font-size:14px;font-weight:700;border:none;border-radius:0 0 0 8px;">Total actividades turísticas</td>
                                <td style="background:#2D4059;color:#fff;padding:13px 20px;font-size:14px;font-weight:700;border:none;">$<?= number_format($totalGastadoAct, 0, ',', '.') ?></td>
                                <td style="background:#2D4059;border:none;border-radius:0 0 8px 0;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- ==============================
                     TABLA RESERVAS HOSPEDAJES
                =============================== -->
                <div class="ag-section-header" style="margin-top:32px;">
                    <h2 class="ag-section-title">Mi Reserva de <span>Hospedajes</span></h2>
                    <a href="<?= BASE_URL ?>turista/ver-reservas-hotel" class="ag-btn-outline">Ver todas</a>
                </div>

                <div class="ag-table-wrap">
                    <table class="ag-table" id="tabla-reservas-hospedaje">
                        <thead>
                            <tr>
                                <th>Hospedaje</th>
                                <th>Establecimiento</th>
                                <th>Fecha</th>
                                <th>Personas</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reservasHosp)): ?>
                                <?php foreach ($reservasHosp as $rh): ?>
                                    <tr>
                                        <td>
                                            <div class="ag-table__act-name"><?= htmlspecialchars($rh['nombre_hospedaje']) ?></div>
                                            <div class="ag-table__act-meta"><?= htmlspecialchars($rh['ciudad'] ?? '') ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($rh['establecimiento'] ?? '—') ?></td>
                                        <td><?= date('d/m/Y', strtotime($rh['fecha'])) ?></td>
                                        <td><?= (int)$rh['cantidad_personas'] ?></td>
                                        <td>$<?= number_format($rh['precio'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="<?= $estadoBadgeClass($rh['estado'] ?? '') ?>">
                                                <span class="ag-badge__dot"></span>
                                                <?= ucfirst(htmlspecialchars($rh['estado'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="ag-empty-state">
                                            <i class="bi bi-building ag-empty-state__icon"></i>
                                            <p>No tienes reservas de hospedaje aún.</p>
                                            <a href="<?= BASE_URL ?>descubre-hospedaje" class="ag-btn-primary">Explorar hospedajes</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="background:#2D4059;color:#fff;padding:13px 20px;font-size:14px;font-weight:700;border:none;border-radius:0 0 0 8px;">Total reservas de hospedaje</td>
                                <td style="background:#2D4059;color:#fff;padding:13px 20px;font-size:14px;font-weight:700;border:none;">$<?= number_format($totalGastadoHosp, 0, ',', '.') ?></td>
                                <td style="background:#2D4059;border:none;border-radius:0 0 8px 0;"></td>
                            </tr>
                        </tfoot>
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

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
    <script>window.AG_BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/turista/notificaciones.js"></script>
    <script>
    document.getElementById('ag-reservas-toggle')?.addEventListener('click', function () {
        this.closest('.ag-nav-sub').classList.toggle('ag-nav-sub--open');
    });
    </script>
</body>

</html>