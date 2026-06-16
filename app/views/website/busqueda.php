<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda - Aventura Go</title>

    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/assets/website_externos/index/img/FAVICON.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/website_externos/descubre_tours/descubreTours.css">

    <style>
        .search-hero {
            background: linear-gradient(135deg, #1a2b3c 0%, #2D4059 100%);
            padding: 32px 0 28px;
            margin-bottom: 0;
        }
        .search-hero__title {
            font-family: var(--font-titles);
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 16px;
        }
        .search-hero__title span { color: var(--color-secondary); }
        .search-hero__form {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 50px;
            padding: 6px 8px 6px 20px;
            gap: 8px;
            max-width: 560px;
            box-shadow: 0 4px 20px rgba(0,0,0,.18);
        }
        .search-hero__form i { color: #aaa; font-size: 16px; }
        .search-hero__form input {
            flex: 1;
            border: none;
            outline: none;
            font-family: var(--font-text);
            font-size: 15px;
            color: var(--color-primary);
            background: transparent;
        }
        .search-hero__form button {
            background: var(--color-secondary);
            border: none;
            border-radius: 50px;
            color: #fff;
            padding: 9px 22px;
            font-family: var(--font-titles);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background .2s;
        }
        .search-hero__form button:hover { background: #d0710f; }

        .results-header {
            padding: 28px 0 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .results-count {
            font-family: var(--font-titles);
            font-size: 15px;
            color: var(--color-primary);
        }
        .results-count strong { color: var(--color-secondary); }

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .result-badge--actividad {
            background: rgba(234,130,23,.12);
            color: var(--color-secondary);
        }
        .result-badge--hospedaje {
            background: rgba(45,64,89,.1);
            color: var(--color-primary);
        }

        .no-results {
            text-align: center;
            padding: 80px 20px;
            color: #888;
        }
        .no-results i {
            font-size: 52px;
            color: #ddd;
            display: block;
            margin-bottom: 16px;
        }
        .no-results p {
            font-family: var(--font-titles);
            font-size: 17px;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="logo">
                    <img src="<?= BASE_URL ?>public/assets/website_externos/index/img/LOGO-FINAL.png" alt="Logo Aventura Go" class="navbar-logo">
                </div>

                <div class="navbar-center">
                    <a href="<?= BASE_URL ?>" class="nav-pill"><i class="bi bi-house-door-fill"></i> Inicio</a>
                    <a href="<?= BASE_URL ?>descubre-tours" class="nav-pill"><i class="bi bi-compass-fill"></i> Tours</a>
                    <a href="<?= BASE_URL ?>descubre-hospedaje" class="nav-pill"><i class="bi bi-house-heart-fill"></i> Hospedaje</a>
                    <a href="<?= BASE_URL ?>contactanos" class="nav-pill"><i class="bi bi-chat-dots-fill"></i> Contáctanos</a>
                </div>

                <div class="actions">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="profile-dropdown">
                            <button class="profile-btn" id="profileToggle">
                                <i class="fas fa-user-circle"></i>
                                <span class="profile-name">
                                    <?= htmlspecialchars(ucwords(explode(' ', $_SESSION['user']['nombre'])[0])) ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="profile-menu" id="profileMenu">
                                <li><a href="<?= BASE_URL ?>turista/perfil">Mi perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= BASE_URL ?>logout" class="logout">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>login" class="btn-login">Ingresa</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Banner de búsqueda -->
    <div class="search-hero">
        <div class="container">
            <p class="search-hero__title">
                <?php if ($q !== ''): ?>
                    Resultados para: <span>"<?= htmlspecialchars($q) ?>"</span>
                <?php else: ?>
                    Busca tours y hospedajes
                <?php endif; ?>
            </p>
            <form class="search-hero__form" action="<?= BASE_URL ?>busqueda" method="GET">
                <i class="bi bi-search"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Ciudad, actividad o tipo de hospedaje..." autofocus>
                <button type="submit"><i class="bi bi-search"></i> Buscar</button>
            </form>
        </div>
    </div>

    <main>
        <div class="container">

            <?php if ($q !== ''): ?>
                <div class="results-header">
                    <span class="results-count">
                        <?php if (count($resultados) > 0): ?>
                            Se encontraron <strong><?= count($resultados) ?></strong> resultado<?= count($resultados) !== 1 ? 's' : '' ?>
                        <?php else: ?>
                            Sin resultados para <strong>"<?= htmlspecialchars($q) ?>"</strong>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if (!empty($resultados)): ?>
                <div class="activities-grid">
                    <?php foreach ($resultados as $item): ?>
                        <div class="activity-card">

                            <?php
                            $imgPath = $item['tipo'] === 'actividad'
                                ? BASE_URL . 'public/uploads/turistico/actividades/' . rawurlencode($item['imagen'] ?? '')
                                : BASE_URL . 'public/uploads/hoteles/' . rawurlencode($item['imagen'] ?? '');
                            $fallback = BASE_URL . 'public/assets/website_externos/descubre_tours/img/imagen%20tour.png';
                            ?>

                            <img src="<?= $imgPath ?>"
                                alt="<?= htmlspecialchars($item['nombre']) ?>"
                                class="activity-image"
                                onerror="this.onerror=null;this.src='<?= $fallback ?>'">

                            <div class="activity-content">

                                <div class="activity-category">
                                    <span class="result-badge result-badge--<?= $item['tipo'] ?>">
                                        <i class="bi bi-<?= $item['tipo'] === 'actividad' ? 'compass-fill' : 'house-heart-fill' ?>"></i>
                                        <?= $item['tipo'] === 'actividad' ? 'Tour' : 'Hospedaje' ?>
                                    </span>
                                </div>

                                <div class="activity-category" style="margin-top:6px">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span><?= htmlspecialchars($item['ciudad']) ?></span>
                                </div>

                                <h3 class="activity-title"><?= htmlspecialchars($item['nombre']) ?></h3>

                                <p class="activity-description">
                                    <?= substr(htmlspecialchars($item['descripcion']), 0, 90) ?>...
                                </p>

                                <div class="activity-price">
                                    <span class="price-label">Desde</span>
                                    <span class="price-current">$<?= number_format($item['precio'], 0, ',', '.') ?></span>
                                </div>

                                <?php if ($item['tipo'] === 'actividad'): ?>
                                    <div class="button">
                                        <a href="<?= BASE_URL ?>tour-escogido?id=<?= (int)$item['id'] ?>" class="btn-ver-mas">Ver más</a>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($q !== ''): ?>
                <div class="no-results">
                    <i class="bi bi-search"></i>
                    <p>No encontramos resultados para "<?= htmlspecialchars($q) ?>"</p>
                    <p style="font-size:14px;margin-top:8px;font-family:var(--font-text);">Intenta con otro nombre de ciudad o actividad.</p>
                </div>

            <?php else: ?>
                <div class="no-results">
                    <i class="bi bi-compass"></i>
                    <p>Escribe algo en el buscador para encontrar tu próxima aventura.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu   = document.getElementById('profileMenu');
        if (profileToggle && profileMenu) {
            profileToggle.addEventListener('click', e => {
                e.stopPropagation();
                profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', () => profileMenu.style.display = 'none');
        }
    </script>

</body>
</html>
