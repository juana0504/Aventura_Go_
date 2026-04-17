<?php
// CAMBIO: Usar sesión de turista
require_once BASE_PATH . '/app/helpers/session_turista.php';

// Iniciales del usuario para el topbar
$nombreUsuario = $_SESSION['user']['nombre'] ?? '';
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
    <title>Mis Tickets — AventuraGO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS del dashboard (variables, sidebar, topbar, dropdowns, dark mode) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">

    <!-- CSS específico de tickets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/tickets/tickets.css">
</head>

<body class="ag-body">

<div class="ag-layout">

    <!-- ==========================================
         SIDEBAR — idéntico al dashboard
    =========================================== -->
    <nav class="ag-sidebar">

        <div class="ag-sidebar__logo">
            <div class="ag-sidebar__logo-icon">A</div>
            <div>
                <div class="ag-sidebar__logo-text">AVENTURA GO</div>
                <div class="ag-sidebar__logo-sub">Panel Turista</div>
            </div>
        </div>

        <div class="ag-sidebar__section-label">Menú</div>

        <a href="<?= BASE_URL ?>turista/dashboard" class="ag-nav-item">
            <i class="bi bi-grid-1x2-fill ag-nav-item__icon"></i>
            Dashboard
        </a>
        <a href="<?= BASE_URL ?>turista/reservas" class="ag-nav-item">
            <i class="bi bi-calendar3 ag-nav-item__icon"></i>
            Ver reservas
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item ag-nav-item--active">
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

        <!-- TOPBAR — idéntico al dashboard -->
        <header class="ag-topbar">

            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar tickets, asuntos..." class="ag-topbar__input" autocomplete="off">
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

                <!-- Perfil -->
                <div class="ag-topbar__dropdown-wrap">
                    <button class="ag-profile-btn" id="ag-profile-btn">
                        <div class="ag-profile-btn__avatar"><?= htmlspecialchars($iniciales) ?></div>
                        <div class="ag-profile-btn__info">
                            <span class="ag-profile-btn__name"><?= htmlspecialchars($nombreUsuario) ?></span>
                            <span class="ag-profile-btn__role">Turista</span>
                        </div>
                        <i class="bi bi-chevron-down ag-profile-btn__chevron" id="ag-profile-chevron"></i>
                    </button>
                    <div class="ag-dropdown ag-dropdown--profile" id="ag-profile-panel">
                        <div class="ag-dropdown__user-header">
                            <div class="ag-profile-btn__avatar ag-profile-btn__avatar--lg"><?= htmlspecialchars($iniciales) ?></div>
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
                        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-dropdown__item">
                            <i class="bi bi-heart"></i> Favoritos
                        </a>
                        <a href="<?= BASE_URL ?>turista/configuracion" class="ag-dropdown__item">
                            <i class="bi bi-gear"></i> Configuración
                        </a>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>auth/logout" class="ag-dropdown__item ag-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ======================================
             CONTENIDO PRINCIPAL
        ======================================= -->
        <main class="ag-content">

            <!-- Encabezado de página -->
            <div class="ag-page-header">
                <div>
                    <div class="ag-greeting__eyebrow">Soporte</div>
                    <h1 class="ag-page-header__title">Mis <span>Tickets</span></h1>
                    <p class="ag-greeting__sub">Gestiona tus solicitudes de soporte y consulta las respuestas</p>
                </div>
                <a href="<?= BASE_URL ?>turista/crear_ticket" class="ag-btn-primary">
                    <i class="bi bi-plus-lg"></i> Nuevo ticket
                </a>
            </div>

            

            <!-- Tabla de tickets -->
            <div class="ag-section-header">
                <h2 class="ag-section-title">Historial de <span>solicitudes</span></h2>
            </div>

            <div class="ag-table-wrap">
                <table class="ag-table" id="tabla-tickets">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tickets)): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="ag-empty-state">
                                        <i class="bi bi-ticket-perforated ag-empty-state__icon"></i>
                                        <p>No has creado tickets aún.</p>
                                        <a href="<?= BASE_URL ?>turista/crear_ticket" class="ag-btn-primary">
                                            <i class="bi bi-plus-lg"></i> Crear mi primer ticket
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td>
                                        <span class="ag-tk-id">#<?= $ticket['id_ticket'] ?></span>
                                    </td>
                                    <td>
                                        <div class="ag-table__act-name"><?= htmlspecialchars($ticket['asunto']) ?></div>
                                        <div class="ag-table__act-meta ag-tk-desc">
                                            <?= mb_strimwidth(htmlspecialchars($ticket['descripcion'] ?? ''), 0, 60, '…') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($ticket['estado'] === 'abierto'): ?>
                                            <span class="ag-badge ag-badge--pending">
                                                <span class="ag-badge__dot"></span> Abierto
                                            </span>
                                        <?php elseif ($ticket['estado'] === 'respondido'): ?>
                                            <span class="ag-badge ag-badge--confirmed">
                                                <span class="ag-badge__dot"></span> Respondido
                                            </span>
                                        <?php else: ?>
                                            <span class="ag-badge ag-badge--cancelled">
                                                <span class="ag-badge__dot"></span> Cerrado
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                    <td>
                                        <?php if (!empty($ticket['respuesta'])): ?>
                                            <button class="ag-btn-ver"
                                                data-bs-toggle="modal"
                                                data-bs-target="#respuesta<?= $ticket['id_ticket'] ?>">
                                                <i class="bi bi-eye"></i> Ver
                                            </button>
                                        <?php else: ?>
                                            <span class="ag-tk-sin-respuesta">Sin respuesta</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div><!-- /.ag-main -->

</div><!-- /.ag-layout -->


<!-- ==========================================
     MODALES DE RESPUESTA — lógica intacta
=========================================== -->
<?php if (!empty($tickets)): ?>
    <?php foreach ($tickets as $ticket): ?>
        <?php if (!empty($ticket['respuesta'])): ?>
            <div class="modal fade" id="respuesta<?= $ticket['id_ticket'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content ag-modal">
                        <div class="ag-modal__header">
                            <div>
                                <div class="ag-modal__eyebrow">Ticket #<?= $ticket['id_ticket'] ?></div>
                                <h5 class="ag-modal__title"><?= htmlspecialchars($ticket['asunto']) ?></h5>
                            </div>
                            <button type="button" class="ag-modal__close" data-bs-dismiss="modal" aria-label="Cerrar">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="ag-modal__body">
                            <div class="ag-modal__block ag-modal__block--query">
                                <div class="ag-modal__block-label">
                                    <i class="bi bi-person-circle"></i> Tu consulta
                                </div>
                                <p><?= nl2br(htmlspecialchars($ticket['descripcion'])) ?></p>
                            </div>
                            <div class="ag-modal__block ag-modal__block--reply">
                                <div class="ag-modal__block-label">
                                    <i class="bi bi-headset"></i> Respuesta del equipo
                                </div>
                                <p><?= nl2br(htmlspecialchars($ticket['respuesta'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    /* ─── MODO OSCURO ────────────────────────── */
    const body     = document.body;
    const darkBtn  = document.getElementById('ag-dark-toggle');
    const darkIcon = document.getElementById('ag-dark-icon');
    const DARK_KEY = 'ag_dark_mode';

    function applyDark(on) {
        body.classList.toggle('ag-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title      = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

    /* ─── DROPDOWNS ──────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = panel.classList.toggle('ag-dropdown--open');
            if (chev) chev.classList.toggle('ag-profile-btn__chevron--open', open);
            document.querySelectorAll('.ag-dropdown--open').forEach(d => {
                if (d !== panel) {
                    d.classList.remove('ag-dropdown--open');
                    document.querySelectorAll('.ag-profile-btn__chevron--open')
                        .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
                }
            });
        });
    }

    makeDropdown('ag-notif-btn',   'ag-notif-panel');
    makeDropdown('ag-profile-btn', 'ag-profile-panel', 'ag-profile-chevron');

    document.addEventListener('click', () => {
        document.querySelectorAll('.ag-dropdown--open').forEach(d => d.classList.remove('ag-dropdown--open'));
        document.querySelectorAll('.ag-profile-btn__chevron--open')
            .forEach(c => c.classList.remove('ag-profile-btn__chevron--open'));
    });

    /* ─── MARCAR NOTIFICACIONES ──────────────── */
    const markAll = document.querySelector('.ag-dropdown__mark-all');
    if (markAll) {
        markAll.addEventListener('click', () => {
            document.querySelectorAll('.ag-notif-item--unread')
                .forEach(el => el.classList.remove('ag-notif-item--unread'));
            document.querySelector('.ag-icon-btn--notif')
                ?.classList.remove('ag-icon-btn--notif');
        });
    }

    /* ─── FILTRO LOCAL DE LA TABLA ───────────── */
    const searchInput = document.querySelector('.ag-topbar__input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            document.querySelectorAll('#tabla-tickets tbody tr').forEach(row => {
                row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        });
    }
})();
</script>

</body>
</html>