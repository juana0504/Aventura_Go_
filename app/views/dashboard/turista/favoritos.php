<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';

$nombreUsuario = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreUsuario)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$totalFavs = count($actividades) + count($hospedajes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos — AventuraGO</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/turista/turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/turista/ver_reservas/ver_reservas.css">
    <style>
    .ag-fav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 20px;
        margin-top: 16px;
    }
    .ag-fav-card {
        background: var(--ag-card-bg, #fff);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        transition: transform .2s, box-shadow .2s;
        position: relative;
    }
    .ag-fav-card:hover { transform: translateY(-3px); box-shadow: 0 6px 24px rgba(0,0,0,.12); }
    .ag-fav-card__img {
        width: 100%;
        height: 170px;
        object-fit: cover;
    }
    .ag-fav-card__img-placeholder {
        width: 100%;
        height: 170px;
        background: linear-gradient(135deg, #1a2b3c 0%, #2D4059 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.3);
        font-size: 48px;
    }
    .ag-fav-card__body { padding: 16px; }
    .ag-fav-card__tipo {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #EA8217;
        margin-bottom: 4px;
    }
    .ag-fav-card__title {
        font-size: 15px;
        font-weight: 600;
        color: var(--ag-text, #1a2b3c);
        margin: 0 0 4px;
        line-height: 1.3;
    }
    .ag-fav-card__meta {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .ag-fav-card__price {
        font-size: 16px;
        font-weight: 700;
        color: #EA8217;
        margin-bottom: 12px;
    }
    .ag-fav-card__actions { display: flex; gap: 8px; }
    .ag-fav-card__btn-ver {
        flex: 1;
        padding: 8px;
        border-radius: 8px;
        background: #2D4059;
        color: #fff;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s;
    }
    .ag-fav-card__btn-ver:hover { background: #EA8217; color: #fff; }
    .ag-fav-card__btn-rm {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1.5px solid #fee2e2;
        background: #fff5f5;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 15px;
        transition: background .2s;
        flex-shrink: 0;
    }
    .ag-fav-card__btn-rm:hover { background: #fee2e2; }
    .ag-dark .ag-fav-card { background: #1e2d3d; }
    .ag-dark .ag-fav-card__title { color: #e2e8f0; }
    .ag-fav-tabs { display: flex; gap: 8px; margin-bottom: 8px; flex-wrap: wrap; }
    .ag-fav-tab {
        padding: 7px 18px;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all .2s;
    }
    .ag-fav-tab--active { background: #EA8217; color: #fff; border-color: #EA8217; }
    .ag-dark .ag-fav-tab { background: #1e2d3d; border-color: #2d3748; color: #94a3b8; }
    .ag-dark .ag-fav-tab--active { background: #EA8217; color: #fff; }
    .ag-fav-empty {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }
    .ag-fav-empty i { font-size: 52px; display: block; margin-bottom: 12px; color: #d1d5db; }
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
            <i class="bi bi-compass ag-nav-item__icon"></i> Mis Tours
        </a>
        <a href="<?= BASE_URL ?>turista/ver-reservas-hotel" class="ag-nav-item">
            <i class="bi bi-building ag-nav-item__icon"></i> Mis Hoteles
        </a>
        <a href="<?= BASE_URL ?>turista/tickets" class="ag-nav-item">
            <i class="bi bi-ticket-perforated ag-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-nav-item ag-nav-item--active">
            <i class="bi bi-heart ag-nav-item__icon"></i> Favoritos
        </a>
        <a href="<?= BASE_URL ?>turista/resenas" class="ag-nav-item">
            <i class="bi bi-star ag-nav-item__icon"></i> Reseñas
        </a>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="ag-main">

        <!-- TOPBAR -->
        <header class="ag-topbar">
            <div class="ag-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar en favoritos..." class="ag-topbar__input" id="ag-search-fav" autocomplete="off">
            </div>
            <div class="ag-topbar__actions">
                <button class="ag-icon-btn" id="ag-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="ag-dark-icon"></i>
                </button>
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
                        <a href="<?= BASE_URL ?>turista/perfil" class="ag-dropdown__item"><i class="bi bi-person-circle"></i> Mi perfil</a>
                        <a href="<?= BASE_URL ?>turista/favoritos" class="ag-dropdown__item"><i class="bi bi-heart"></i> Mis favoritos</a>
                        <div class="ag-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="ag-dropdown__item ag-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="ag-content">

            <div class="ag-page-header">
                <div>
                    <div class="ag-greeting__eyebrow">Panel Turista</div>
                    <h1 class="ag-page-header__title">Mis <span>Favoritos</span></h1>
                    <p class="ag-greeting__sub"><?= $totalFavs ?> elemento<?= $totalFavs !== 1 ? 's' : '' ?> guardado<?= $totalFavs !== 1 ? 's' : '' ?></p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="ag-fav-tabs">
                <button class="ag-fav-tab ag-fav-tab--active" data-tab="todos">
                    <i class="bi bi-grid"></i> Todos (<?= $totalFavs ?>)
                </button>
                <button class="ag-fav-tab" data-tab="actividad">
                    <i class="bi bi-compass"></i> Tours (<?= count($actividades) ?>)
                </button>
                <button class="ag-fav-tab" data-tab="hospedaje">
                    <i class="bi bi-building"></i> Hoteles (<?= count($hospedajes) ?>)
                </button>
            </div>

            <?php if ($totalFavs === 0): ?>
                <div class="ag-fav-empty">
                    <i class="bi bi-heart"></i>
                    <p style="font-size:16px;font-weight:600;color:#4b5563;">Aún no tienes favoritos</p>
                    <p style="font-size:14px;">Dale al corazón en cualquier tour o hotel para guardarlo aquí.</p>
                    <div style="display:flex;gap:12px;justify-content:center;margin-top:20px;">
                        <a href="<?= BASE_URL ?>descubre-tours" class="ag-btn-primary" style="padding:10px 22px;border-radius:8px;text-decoration:none;font-weight:600;">
                            <i class="bi bi-compass"></i> Explorar tours
                        </a>
                        <a href="<?= BASE_URL ?>descubre-hospedaje" class="ag-btn-outline" style="padding:10px 22px;border-radius:8px;text-decoration:none;font-weight:600;">
                            <i class="bi bi-building"></i> Explorar hoteles
                        </a>
                    </div>
                </div>
            <?php else: ?>

            <div class="ag-fav-grid" id="ag-fav-grid">

                <!-- TOURS -->
                <?php foreach ($actividades as $act): ?>
                <div class="ag-fav-card" data-tipo="actividad" data-nombre="<?= htmlspecialchars(strtolower($act['nombre'])) ?>">
                    <?php if (!empty($act['imagen'])): ?>
                        <img src="<?= BASE_URL ?>public/uploads/turistico/actividades/<?= htmlspecialchars($act['imagen']) ?>"
                             class="ag-fav-card__img"
                             alt="<?= htmlspecialchars($act['nombre']) ?>"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="ag-fav-card__img-placeholder" style="display:none;"><i class="bi bi-compass"></i></div>
                    <?php else: ?>
                        <div class="ag-fav-card__img-placeholder"><i class="bi bi-compass"></i></div>
                    <?php endif; ?>
                    <div class="ag-fav-card__body">
                        <div class="ag-fav-card__tipo"><i class="bi bi-compass"></i> Tour</div>
                        <h3 class="ag-fav-card__title"><?= htmlspecialchars($act['nombre']) ?></h3>
                        <div class="ag-fav-card__meta">
                            <?php if (!empty($act['ciudad'])): ?>
                                <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($act['ciudad']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($act['proveedor'])): ?>
                                <span><i class="bi bi-person"></i> <?= htmlspecialchars($act['proveedor']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="ag-fav-card__price">$<?= number_format($act['precio'], 0, ',', '.') ?></div>
                        <div class="ag-fav-card__actions">
                            <a href="<?= BASE_URL ?>tour-escogido?id=<?= $act['id_actividad'] ?>" class="ag-fav-card__btn-ver">
                                <i class="bi bi-eye"></i> Ver tour
                            </a>
                            <button class="ag-fav-card__btn-rm" data-tipo="actividad" data-id="<?= $act['id_actividad'] ?>" title="Quitar de favoritos">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- HOSPEDAJES -->
                <?php foreach ($hospedajes as $hosp): ?>
                <?php
                $imgH = $hosp['imagen'] ?? '';
                $imgHValida = !empty($imgH) && $imgH !== 'hospedaje_default.png';
                ?>
                <div class="ag-fav-card" data-tipo="hospedaje" data-nombre="<?= htmlspecialchars(strtolower($hosp['nombre'])) ?>">
                    <?php if ($imgHValida): ?>
                        <img src="<?= BASE_URL ?>public/uploads/hotelero/actividades/<?= htmlspecialchars($imgH) ?>"
                             class="ag-fav-card__img"
                             alt="<?= htmlspecialchars($hosp['nombre']) ?>"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="ag-fav-card__img-placeholder" style="display:none;"><i class="bi bi-building"></i></div>
                    <?php else: ?>
                        <div class="ag-fav-card__img-placeholder"><i class="bi bi-building"></i></div>
                    <?php endif; ?>
                    <div class="ag-fav-card__body">
                        <div class="ag-fav-card__tipo"><i class="bi bi-building"></i> Hospedaje<?= !empty($hosp['tipo_hospedaje']) ? ' · ' . htmlspecialchars($hosp['tipo_hospedaje']) : '' ?></div>
                        <h3 class="ag-fav-card__title"><?= htmlspecialchars($hosp['nombre']) ?></h3>
                        <div class="ag-fav-card__meta">
                            <?php if (!empty($hosp['ciudad'])): ?>
                                <span><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($hosp['ciudad']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($hosp['proveedor'])): ?>
                                <span><i class="bi bi-building"></i> <?= htmlspecialchars($hosp['proveedor']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="ag-fav-card__price">$<?= number_format($hosp['precio'], 0, ',', '.') ?> <span style="font-size:11px;font-weight:400;color:#9ca3af;">/ noche</span></div>
                        <div class="ag-fav-card__actions">
                            <a href="<?= BASE_URL ?>hospedaje-escogido?id=<?= $hosp['id_hospedaje'] ?>" class="ag-fav-card__btn-ver">
                                <i class="bi bi-eye"></i> Ver hotel
                            </a>
                            <button class="ag-fav-card__btn-rm" data-tipo="hospedaje" data-id="<?= $hosp['id_hospedaje'] ?>" title="Quitar de favoritos">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>const BASE_URL = '<?= BASE_URL ?>';</script>
<script>
(function () {
    /* Dark mode */
    const body     = document.body;
    const darkBtn  = document.getElementById('ag-dark-toggle');
    const darkIcon = document.getElementById('ag-dark-icon');
    function applyDark(on) {
        body.classList.toggle('ag-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        localStorage.setItem('ag_dark_mode', on ? '1' : '0');
    }
    applyDark(localStorage.getItem('ag_dark_mode') === '1');
    darkBtn?.addEventListener('click', () => applyDark(!body.classList.contains('ag-dark')));

    /* Profile dropdown */
    const profileBtn   = document.getElementById('ag-profile-btn');
    const profilePanel = document.getElementById('ag-profile-panel');
    const profileChev  = document.getElementById('ag-profile-chevron');
    profileBtn?.addEventListener('click', e => {
        e.stopPropagation();
        const open = profilePanel.classList.toggle('ag-dropdown--open');
        profileChev?.classList.toggle('ag-profile-btn__chevron--open', open);
    });
    document.addEventListener('click', () => {
        profilePanel?.classList.remove('ag-dropdown--open');
        profileChev?.classList.remove('ag-profile-btn__chevron--open');
    });

    /* Tabs */
    const tabs  = document.querySelectorAll('.ag-fav-tab');
    const cards = document.querySelectorAll('.ag-fav-card');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('ag-fav-tab--active'));
            tab.classList.add('ag-fav-tab--active');
            const filtro = tab.dataset.tab;
            cards.forEach(card => {
                card.style.display = (filtro === 'todos' || card.dataset.tipo === filtro) ? '' : 'none';
            });
        });
    });

    /* Búsqueda */
    document.getElementById('ag-search-fav')?.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        cards.forEach(card => {
            card.style.display = (!q || card.dataset.nombre.includes(q)) ? '' : 'none';
        });
    });

    /* Quitar favorito */
    document.querySelectorAll('.ag-fav-card__btn-rm').forEach(btn => {
        btn.addEventListener('click', function () {
            const tipo = this.dataset.tipo;
            const id   = this.dataset.id;
            const card = this.closest('.ag-fav-card');
            fetch(BASE_URL + 'turista/toggle-favorito', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `tipo=${tipo}&id_referencia=${id}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok && data.estado === 'eliminado') {
                    card.style.transition = 'opacity .3s, transform .3s';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(.9)';
                    setTimeout(() => card.remove(), 320);
                }
            }).catch(() => {});
        });
    });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/sidebar-toggle-universal.js"></script>
</body>
</html>
