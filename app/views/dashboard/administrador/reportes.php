<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';

$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales = '';
$partes = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}

$fotoAdmin = trim((string) ($_SESSION['user']['foto'] ?? ''));
$usarFotoAdmin = $fotoAdmin !== '' && stripos($fotoAdmin, 'default') !== 0;
$avatarAdminUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoAdmin);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/reportes/reportes.css">
</head>

<body class="adm-body">
<div class="adm-layout" id="admin-dashboard">

    <nav class="adm-sidebar">
        <div class="adm-sidebar__logo">
            <div class="adm-sidebar__logo-icon">A</div>
            <div>
                <div class="adm-sidebar__logo-text">AVENTURA GO</div>
                <div class="adm-sidebar__logo-sub">Panel Admin</div>
            </div>
        </div>

        <div class="adm-sidebar__section-label">Principal</div>
        <a href="<?= BASE_URL ?>administrador/dashboard" class="adm-nav-item">
            <i class="bi bi-grid-1x2-fill adm-nav-item__icon"></i> Dashboard
        </a>

        <div class="adm-sidebar__section-label">Gestion</div>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turisticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
            <i class="bi bi-building adm-nav-item__icon"></i> Proveedores Hoteleros
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item">
            <i class="bi bi-person-badge adm-nav-item__icon"></i> Turistas
        </a>

        <div class="adm-sidebar__section-label">Soporte</div>
        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-nav-item">
            <i class="bi bi-headset adm-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>administrador/reporte" class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-file-earmark-bar-graph adm-nav-item__icon"></i> Reportes
        </a>
        <a href="<?= BASE_URL ?>administrador/perfil" class="adm-nav-item">
            <i class="bi bi-person-circle adm-nav-item__icon"></i> Mi Perfil
        </a>
    </nav>

    <div class="adm-main">
        <header class="adm-topbar">
            <div class="adm-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar reporte..." class="adm-topbar__input" id="adm-search-input" autocomplete="off">
            </div>

            <div class="adm-topbar__actions">
                <button class="adm-icon-btn" id="adm-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="adm-dark-icon"></i>
                </button>

                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-profile-btn" id="adm-profile-btn">
                        <div class="adm-profile-btn__avatar">
                            <?php if ($usarFotoAdmin): ?>
                                <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                            <?php else: ?>
                                <?= htmlspecialchars($iniciales) ?>
                            <?php endif; ?>
                        </div>
                        <div class="adm-profile-btn__info">
                            <span class="adm-profile-btn__name"><?= htmlspecialchars($nombreAdmin) ?></span>
                            <span class="adm-profile-btn__role">Administrador</span>
                        </div>
                        <i class="bi bi-chevron-down adm-profile-btn__chevron" id="adm-profile-chevron"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--profile" id="adm-profile-panel">
                        <div class="adm-dropdown__user-header">
                            <div class="adm-profile-btn__avatar adm-profile-btn__avatar--lg">
                                <?php if ($usarFotoAdmin): ?>
                                    <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar administrador" class="adm-profile-btn__avatar-img">
                                <?php else: ?>
                                    <?= htmlspecialchars($iniciales) ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="adm-dropdown__user-name"><?= htmlspecialchars($nombreAdmin) ?></div>
                                <div class="adm-dropdown__user-role">Administrador · AventuraGO</div>
                            </div>
                        </div>
                        <div class="adm-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>administrador/perfil" class="adm-dropdown__item">
                            <i class="bi bi-person-circle"></i> Mi perfil
                        </a>
                        <a href="<?= BASE_URL ?>logout" class="adm-dropdown__item adm-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesion
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="adm-content">
            <div class="adm-greeting">
                <div class="adm-greeting__eyebrow">Centro de reportes</div>
                <h1 class="adm-greeting__name">Genera tus <span>reportes PDF</span></h1>
                <p class="adm-greeting__sub">Descarga reportes con el mismo formato del dashboard administrativo.</p>
            </div>

            <div class="adm-stats-grid adm-report-grid">
                <article class="adm-stat-card adm-report-card" data-report="turistico proveedor">
                    <div class="adm-stat-card__icon adm-stat-card__icon--orange">
                        <i class="bi bi-compass"></i>
                    </div>
                    <div class="adm-stat-card__label">Reporte</div>
                    <div class="adm-stat-card__value adm-report-card__title">Proveedores Turisticos</div>
                    <p class="adm-report-card__text">Listado completo de proveedores turisticos con su estado y datos de contacto.</p>
                    <a href="#" class="adm-btn-pdf adm-report-generate" data-tipo="turistico">
                        <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                    </a>
                </article>

                <article class="adm-stat-card adm-report-card" data-report="hotelero hoteles">
                    <div class="adm-stat-card__icon adm-stat-card__icon--blue">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="adm-stat-card__label">Reporte</div>
                    <div class="adm-stat-card__value adm-report-card__title">Proveedores Hoteleros</div>
                    <p class="adm-report-card__text">Reporte de hoteles registrados para auditoria y seguimiento administrativo.</p>
                    <a href="#" class="adm-btn-pdf adm-report-generate" data-tipo="hoteles">
                        <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                    </a>
                </article>

                <article class="adm-stat-card adm-report-card" data-report="turista turistas usuario usuarios">
                    <div class="adm-stat-card__icon adm-stat-card__icon--green">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div class="adm-stat-card__label">Reporte</div>
                    <div class="adm-stat-card__value adm-report-card__title">Turistas</div>
                    <p class="adm-report-card__text">Listado de turistas con informacion principal para gestion interna.</p>
                    <a href="#" class="adm-btn-pdf adm-report-generate" data-tipo="turista">
                        <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                    </a>
                </article>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>
<script>
(function () {
    const baseUrl = '<?= BASE_URL ?>';
    const body = document.body;
    const darkBtn = document.getElementById('adm-dark-toggle');
    const darkIcon = document.getElementById('adm-dark-icon');
    const DARK_KEY = 'adm_dark_mode';

    function applyDark(on) {
        body.classList.toggle('adm-dark', on);
        darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }

    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('adm-dark')));

    const profileBtn = document.getElementById('adm-profile-btn');
    const profilePanel = document.getElementById('adm-profile-panel');
    const profileChevron = document.getElementById('adm-profile-chevron');

    if (profileBtn && profilePanel) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const open = profilePanel.classList.toggle('adm-dropdown--open');
            profileChevron.classList.toggle('adm-profile-btn__chevron--open', open);
        });

        document.addEventListener('click', () => {
            profilePanel.classList.remove('adm-dropdown--open');
            profileChevron.classList.remove('adm-profile-btn__chevron--open');
        });
    }

    const searchInput = document.getElementById('adm-search-input');
    const cards = document.querySelectorAll('.adm-report-card');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            cards.forEach((card) => {
                const text = card.textContent.toLowerCase();
                const tags = (card.dataset.report || '').toLowerCase();
                card.style.display = (!q || text.includes(q) || tags.includes(q)) ? '' : 'none';
            });
        });
    }

    document.querySelectorAll('.adm-report-generate').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const tipo = btn.dataset.tipo || '';
            if (!tipo) return;

            const url = new URL(baseUrl + 'administrador/reporte');
            url.searchParams.set('tipo', tipo);

            window.open(url.toString(), '_blank');
        });
    });
})();
</script>

</body>
</html>
