<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

$nombreUsuario = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
$partes = explode(' ', trim($nombreUsuario));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}

$mostrarExito = isset($_GET['ok']);
$errorMsg = match($_GET['error'] ?? '') {
    'datos_invalidos'  => 'Por favor selecciona una calificación válida (1-5 estrellas).',
    'reserva_invalida' => 'La reserva no es válida o no te pertenece.',
    'guardado'         => 'No se pudo guardar la reseña. Inténtalo de nuevo.',
    default            => ''
};
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reseñas — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/ver_reservas/ver_reservas.css">

    <style>
        /* ── Tarjetas de reseña ── */
        .ag-res-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .ag-res-card {
            background: var(--ag-surface, #fff);
            border: 1px solid var(--ag-border, #e5e7eb);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .ag-dark .ag-res-card {
            background: var(--ag-surface-dark, #1e2130);
            border-color: var(--ag-border-dark, #2e3347);
        }

        .ag-res-card__img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .ag-res-card__img-placeholder {
            width: 100%;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            font-size: 2rem;
            color: #9ca3af;
        }

        .ag-dark .ag-res-card__img-placeholder {
            background: #2e3347;
        }

        .ag-res-card__body {
            padding: 1rem 1.1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: .45rem;
        }

        .ag-res-card__title {
            font-weight: 600;
            font-size: .97rem;
            color: var(--ag-text, #111827);
            margin: 0;
        }

        .ag-dark .ag-res-card__title { color: #f9fafb; }

        .ag-res-card__meta {
            font-size: .82rem;
            color: var(--ag-muted, #6b7280);
        }

        .ag-res-card__stars {
            display: flex;
            gap: .2rem;
            font-size: 1.1rem;
        }

        .ag-star-filled { color: #f59e0b; }
        .ag-star-empty  { color: #d1d5db; }

        .ag-res-card__comment {
            font-size: .88rem;
            color: var(--ag-muted, #6b7280);
            border-left: 3px solid #f59e0b;
            padding-left: .6rem;
            margin-top: .25rem;
            font-style: italic;
        }

        .ag-dark .ag-res-card__comment { color: #9ca3af; }

        /* ── Formulario de nueva reseña ── */
        .ag-res-form-card {
            background: var(--ag-surface, #fff);
            border: 1px solid var(--ag-border, #e5e7eb);
            border-radius: 14px;
            padding: 1.25rem 1.4rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .ag-dark .ag-res-form-card {
            background: var(--ag-surface-dark, #1e2130);
            border-color: var(--ag-border-dark, #2e3347);
        }

        .ag-res-form-card__header {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .ag-res-form-card__thumb {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: #f3f4f6;
        }

        .ag-res-form-card__thumb-placeholder {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            font-size: 1.3rem;
            color: #9ca3af;
            flex-shrink: 0;
        }

        .ag-dark .ag-res-form-card__thumb-placeholder { background: #2e3347; }

        .ag-res-form-card__title {
            font-weight: 600;
            font-size: .95rem;
            color: var(--ag-text, #111827);
        }

        .ag-dark .ag-res-form-card__title { color: #f9fafb; }

        .ag-res-form-card__meta {
            font-size: .8rem;
            color: var(--ag-muted, #6b7280);
        }

        /* Star rating interactivo */
        .ag-star-rating {
            display: flex;
            flex-direction: row-reverse;
            gap: .25rem;
            width: fit-content;
        }

        .ag-star-rating input[type="radio"] {
            display: none;
        }

        .ag-star-rating label {
            font-size: 1.6rem;
            color: #d1d5db;
            cursor: pointer;
            transition: color .15s;
        }

        .ag-star-rating input:checked ~ label,
        .ag-star-rating label:hover,
        .ag-star-rating label:hover ~ label {
            color: #f59e0b;
        }

        .ag-res-textarea {
            width: 100%;
            border: 1px solid var(--ag-border, #e5e7eb);
            border-radius: 9px;
            padding: .7rem .9rem;
            font-family: inherit;
            font-size: .9rem;
            resize: vertical;
            min-height: 72px;
            background: var(--ag-bg, #f9fafb);
            color: var(--ag-text, #111827);
            outline: none;
            transition: border-color .2s;
        }

        .ag-res-textarea:focus {
            border-color: #f59e0b;
        }

        .ag-dark .ag-res-textarea {
            background: #141622;
            border-color: #2e3347;
            color: #f9fafb;
        }

        .ag-res-submit {
            align-self: flex-end;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: .5rem 1.25rem;
            font-weight: 600;
            font-size: .9rem;
            cursor: pointer;
            transition: background .2s;
        }

        .ag-res-submit:hover { background: #d97706; }

        /* ── Alertas ── */
        .ag-res-alert {
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .ag-res-alert--success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .ag-res-alert--error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .ag-dark .ag-res-alert--success { background: #064e3b; color: #6ee7b7; border-color: #065f46; }
        .ag-dark .ag-res-alert--error   { background: #450a0a; color: #fca5a5; border-color: #991b1b; }
    </style>
</head>

<body class="ag-body">

<div class="ag-layout">

    <!-- SIDEBAR -->
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
            <i class="bi bi-grid-1x2-fill ag-nav-item__icon"></i> Dashboard
        </a>
        <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-nav-item">
            <i class="bi bi-calendar3 ag-nav-item__icon"></i> Ver reservas
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item">
            <i class="bi bi-ticket-perforated ag-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-nav-item">
            <i class="bi bi-heart ag-nav-item__icon"></i> Favoritos
        </a>
        <a href="<?= BASE_URL ?>turista/resenas" class="ag-nav-item ag-nav-item--active">
            <i class="bi bi-star ag-nav-item__icon"></i> Reseñas
        </a>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="ag-main">

        <!-- TOPBAR -->
        <header class="ag-topbar">
            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar reseñas..." class="ag-topbar__input" autocomplete="off">
            </div>

            <div class="ag-topbar__actions">

                <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                </button>

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
                        <a href="<?= BASE_URL ?>turista/ver-reservas" class="ag-dropdown__item">
                            <i class="bi bi-calendar3"></i> Mis reservas
                        </a>
                        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-dropdown__item">
                            <i class="bi bi-heart"></i> Favoritos
                        </a>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="ag-dropdown__item ag-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </header>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="ag-content">

            <div class="ag-page-header">
                <div>
                    <div class="ag-greeting__eyebrow">Panel Turista</div>
                    <h1 class="ag-page-header__title">Mis <span>Reseñas</span></h1>
                    <p class="ag-greeting__sub">Comparte tu experiencia y ayuda a otros aventureros</p>
                </div>
            </div>

            <!-- Alertas -->
            <?php if ($mostrarExito): ?>
                <div class="ag-res-alert ag-res-alert--success">
                    <i class="bi bi-check-circle-fill"></i>
                    ¡Reseña enviada correctamente! Gracias por compartir tu experiencia.
                </div>
            <?php elseif ($errorMsg !== ''): ?>
                <div class="ag-res-alert ag-res-alert--error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= htmlspecialchars($errorMsg) ?>
                </div>
            <?php endif; ?>

            <!-- ════════════════════════════════════════════
                 SECCIÓN 1: RESERVAS SIN RESEÑA (formularios)
                 ════════════════════════════════════════════ -->
            <?php if (!empty($reservasPendientes)): ?>
                <div class="ag-section-header" style="margin-top: 1.5rem;">
                    <h2 class="ag-section-title">Pendientes de <span>reseña</span></h2>
                    <p class="ag-greeting__sub" style="margin:0;">Estas actividades confirmadas aún no tienen reseña.</p>
                </div>

                <div class="ag-res-grid">
                    <?php foreach ($reservasPendientes as $rv): ?>
                        <div class="ag-res-form-card">
                            <div class="ag-res-form-card__header">
                                <?php if (!empty($rv['imagen'])): ?>
                                    <img src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= htmlspecialchars($rv['imagen']) ?>"
                                         class="ag-res-form-card__thumb"
                                         alt="<?= htmlspecialchars($rv['nombre_actividad']) ?>">
                                <?php else: ?>
                                    <div class="ag-res-form-card__thumb-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="ag-res-form-card__title">
                                        <?= htmlspecialchars($rv['nombre_actividad']) ?>
                                    </div>
                                    <div class="ag-res-form-card__meta">
                                        <?= htmlspecialchars($rv['proveedor']) ?> &bull;
                                        <?= date('d/m/Y', strtotime($rv['fecha'])) ?>
                                    </div>
                                </div>
                            </div>

                            <form action="<?= BASE_URL ?>turista/guardar-resena" method="POST">
                                <input type="hidden" name="id_reserva" value="<?= (int)$rv['id_reserva'] ?>">

                                <!-- Estrellas interactivas -->
                                <div style="margin-bottom: .5rem;">
                                    <div style="font-size:.83rem;color:var(--ag-muted,#6b7280);margin-bottom:.35rem;">
                                        Calificación <span style="color:#f59e0b">*</span>
                                    </div>
                                    <div class="ag-star-rating" id="stars-<?= (int)$rv['id_reserva'] ?>">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <input type="radio"
                                                   id="star-<?= (int)$rv['id_reserva'] ?>-<?= $i ?>"
                                                   name="calificacion"
                                                   value="<?= $i ?>">
                                            <label for="star-<?= (int)$rv['id_reserva'] ?>-<?= $i ?>"
                                                   title="<?= $i ?> estrella<?= $i > 1 ? 's' : '' ?>">
                                                &#9733;
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>

                                <textarea name="comentario"
                                          class="ag-res-textarea"
                                          placeholder="Cuéntanos cómo fue tu experiencia (opcional)..."
                                          maxlength="600"></textarea>

                                <button type="submit" class="ag-res-submit">
                                    <i class="bi bi-send-fill"></i> Enviar reseña
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- ════════════════════════════════════════════
                 SECCIÓN 2: RESEÑAS YA ENVIADAS
                 ════════════════════════════════════════════ -->
            <div class="ag-section-header" style="margin-top: 2rem;">
                <h2 class="ag-section-title">Reseñas <span>enviadas</span></h2>
            </div>

            <?php if (!empty($resenas)): ?>
                <div class="ag-res-grid">
                    <?php foreach ($resenas as $res): ?>
                        <div class="ag-res-card">
                            <?php if (!empty($res['imagen'])): ?>
                                <img src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= htmlspecialchars($res['imagen']) ?>"
                                     class="ag-res-card__img"
                                     alt="<?= htmlspecialchars($res['nombre_actividad']) ?>">
                            <?php else: ?>
                                <div class="ag-res-card__img-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            <?php endif; ?>

                            <div class="ag-res-card__body">
                                <p class="ag-res-card__title"><?= htmlspecialchars($res['nombre_actividad']) ?></p>
                                <span class="ag-res-card__meta">
                                    <i class="bi bi-building"></i>
                                    <?= htmlspecialchars($res['proveedor']) ?>
                                    &bull;
                                    <?= date('d/m/Y', strtotime($res['fecha'])) ?>
                                </span>

                                <div class="ag-res-card__stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?= $i <= $res['calificacion'] ? 'ag-star-filled' : 'ag-star-empty' ?>">
                                            &#9733;
                                        </span>
                                    <?php endfor; ?>
                                </div>

                                <?php if (!empty($res['comentario'])): ?>
                                    <p class="ag-res-card__comment">
                                        "<?= htmlspecialchars($res['comentario']) ?>"
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="ag-empty-state" style="margin-top:1rem;">
                    <i class="bi bi-star ag-empty-state__icon"></i>
                    <p>Aún no has dejado ninguna reseña.</p>
                    <?php if (empty($reservasPendientes)): ?>
                        <p style="font-size:.85rem;color:var(--ag-muted,#6b7280);">
                            Las reseñas estarán disponibles cuando tengas reservas confirmadas.
                        </p>
                        <a href="<?= BASE_URL ?>descubre-tours" class="ag-btn-primary">
                            <i class="bi bi-compass"></i> Explorar actividades
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </main>
    </div><!-- /.ag-main -->

</div><!-- /.ag-layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    /* MODO OSCURO */
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

    /* DROPDOWN PERFIL */
    const profileBtn   = document.getElementById('ag-profile-btn');
    const profilePanel = document.getElementById('ag-profile-panel');
    const profileChev  = document.getElementById('ag-profile-chevron');

    if (profileBtn && profilePanel) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = profilePanel.classList.toggle('ag-dropdown--open');
            profileChev?.classList.toggle('ag-profile-btn__chevron--open', open);
        });
    }

    document.addEventListener('click', () => {
        profilePanel?.classList.remove('ag-dropdown--open');
        profileChev?.classList.remove('ag-profile-btn__chevron--open');
    });

    /* Validación: exigir al menos 1 estrella antes de enviar */
    document.querySelectorAll('.ag-res-form-card form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const checked = this.querySelector('input[name="calificacion"]:checked');
            if (!checked) {
                e.preventDefault();
                alert('Por favor selecciona al menos 1 estrella antes de enviar.');
            }
        });
    });
})();
</script>

    <script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
    <script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
