<?php
require_once BASE_PATH . '/app/helpers/session_administrador.php';
require_once BASE_PATH . '/app/controllers/administrador/turista.php';

$id = $_GET['id'];
$turista = listarTuristaId($id);

// Foto actual
$fotoT     = $turista['foto'] ?? '';
$fotoExist = !empty($fotoT) && file_exists(BASE_PATH . '/public/uploads/usuario/' . $fotoT);
$fotoUrl   = $fotoExist ? BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoT) : '';

// Datos del admin para topbar
$nombreAdmin = $_SESSION['user']['nombre'] ?? 'Administrador';
$iniciales   = '';
$partes      = explode(' ', trim($nombreAdmin));
foreach (array_slice($partes, 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$fotoAdmin     = trim((string) ($_SESSION['user']['foto'] ?? ''));
$usarFotoAdmin = $fotoAdmin !== '' && stripos($fotoAdmin, 'default') !== 0;
$avatarAdminUrl = BASE_URL . 'public/uploads/usuario/' . rawurlencode($fotoAdmin);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turista — AventuraGO</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/administrador/registrar_proveedor/registrar_proveedor_turistico.css">
</head>

<body class="adm-body">

<div class="adm-layout" id="admin-dashboard">

    <!-- SIDEBAR -->
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

        <div class="adm-sidebar__section-label">Gestión</div>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor" class="adm-nav-item">
            <i class="bi bi-people adm-nav-item__icon"></i> Proveedores Turísticos
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-proveedor-hotelero" class="adm-nav-item">
            <i class="bi bi-building adm-nav-item__icon"></i> Proveedores Hoteleros
        </a>
        <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-nav-item adm-nav-item--active">
            <i class="bi bi-person-badge adm-nav-item__icon"></i> Turistas
        </a>

        <div class="adm-sidebar__section-label">Soporte</div>
        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-nav-item">
            <i class="bi bi-headset adm-nav-item__icon"></i> Tickets
        </a>
        <a href="<?= BASE_URL ?>administrador/reporte" class="adm-nav-item">
            <i class="bi bi-file-earmark-bar-graph adm-nav-item__icon"></i> Reportes
        </a>
        <a href="<?= BASE_URL ?>administrador/perfil" class="adm-nav-item">
            <i class="bi bi-person-circle adm-nav-item__icon"></i> Mi Perfil
        </a>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <div class="adm-main">

        <!-- TOPBAR -->
        <header class="adm-topbar">
            <div class="adm-topbar__left">
                <div class="adm-topbar__clock" id="adm-clock">—</div>
            </div>

            <div class="adm-topbar__actions">
                <button class="adm-icon-btn" id="adm-dark-toggle" title="Modo oscuro">
                    <i class="bi bi-moon-fill" id="adm-dark-icon"></i>
                </button>

                <!-- Notificaciones -->
                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-icon-btn" id="adm-notif-btn">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <div class="adm-dropdown adm-dropdown--notif" id="adm-notif-panel">
                        <div class="adm-dropdown__header">
                            <span class="adm-dropdown__title">Notificaciones</span>
                            <button class="adm-dropdown__mark-all">Marcar todas</button>
                        </div>
                        <a href="<?= BASE_URL ?>administrador/tickets" class="adm-dropdown__footer">Ver todas las notificaciones</a>
                    </div>
                </div>

                <!-- Perfil -->
                <div class="adm-topbar__dropdown-wrap">
                    <button class="adm-profile-btn" id="adm-profile-btn">
                        <div class="adm-profile-btn__avatar">
                            <?php if ($usarFotoAdmin): ?>
                                <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar" class="adm-profile-btn__avatar-img">
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
                                    <img src="<?= htmlspecialchars($avatarAdminUrl) ?>" alt="Avatar" class="adm-profile-btn__avatar-img">
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
                        <a href="<?= BASE_URL ?>administrador/cambiar-password" class="adm-dropdown__item">
                            <i class="bi bi-shield-lock"></i> Cambiar contraseña
                        </a>
                        <div class="adm-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="adm-dropdown__item adm-dropdown__item--danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="adm-content">

            <!-- Encabezado -->
            <div class="adm-page-header">
                <div>
                    <div class="adm-greeting__eyebrow">Gestión · Turistas</div>
                    <h1 class="adm-page-title">Editar <span>Turista</span></h1>
                    <p class="adm-greeting__sub">Modifica los datos del turista registrado</p>
                </div>
                <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al listado
                </a>
            </div>

            <!-- Formulario -->
            <form action="<?= BASE_URL ?>administrador/actualizar-turista" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($turista['id_usuario']) ?>">
                <input type="hidden" name="accion" value="actualizar">

                <div class="adm-wizard">
                    <div class="adm-wizard__header">
                        <p class="adm-wizard__header-text">
                            <i class="bi bi-person-badge"></i> Datos del Turista
                        </p>
                    </div>

                    <div style="padding: 28px;">
                        <div class="row g-3">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Nombre completo</label>
                                <input type="text" name="nombre" class="adm-form-input" required
                                       value="<?= htmlspecialchars($turista['nombre']) ?>" placeholder="Juan Pérez">
                            </div>

                            <!-- Género -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Género</label>
                                <select name="genero" class="adm-form-input adm-form-select form-select1" required>
                                    <option value="" disabled hidden>Selecciona</option>
                                    <option value="Masculino" <?= ($turista['genero'] ?? '') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino"  <?= ($turista['genero'] ?? '') === 'Femenino'  ? 'selected' : '' ?>>Femenino</option>
                                    <option value="Otro"      <?= ($turista['genero'] ?? '') === 'Otro'      ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Teléfono</label>
                                <input type="tel" name="telefono" class="adm-form-input" required
                                       value="<?= htmlspecialchars($turista['telefono'] ?? '') ?>" placeholder="+57 300 123 4567">
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Email</label>
                                <input type="email" name="email" class="adm-form-input" required
                                       value="<?= htmlspecialchars($turista['email'] ?? '') ?>" placeholder="correo@ejemplo.com">
                            </div>

                            <!-- Foto actual -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Foto actual</label>
                                <div class="adm-img-preview">
                                    <?php if ($fotoUrl): ?>
                                        <img src="<?= htmlspecialchars($fotoUrl) ?>"
                                             alt="Foto turista" class="adm-img-preview__thumb">
                                    <?php else: ?>
                                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--adm-primary),#1a2b3c);display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:22px;color:#fff;">
                                            <?php
                                            $np = explode(' ', trim($turista['nombre']));
                                            echo mb_strtoupper(mb_substr($np[0] ?? '', 0, 1) . mb_substr($np[1] ?? '', 0, 1));
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Nueva foto -->
                            <div class="col-md-6">
                                <label class="adm-form-label">Cambiar foto (opcional)</label>
                                <input type="file" name="foto" class="adm-form-input adm-form-input--file" accept=".png,.jpg,.jpeg">
                            </div>

                        </div>

                        <!-- Botón guardar -->
                        <div style="margin-top:28px; display:flex; justify-content:flex-end; gap:12px;">
                            <a href="<?= BASE_URL ?>administrador/consultar-turista" class="adm-btn-back">
                                <i class="bi bi-x-lg"></i> Cancelar
                            </a>
                            <button type="submit" class="adm-wizard__btn-next" style="padding:11px 28px;">
                                <i class="bi bi-check-lg"></i> Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </main>
    </div><!-- /.adm-main -->

</div><!-- /.adm-layout -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/admin_notifications.js"></script>

<script>
(function () {
    /* ─── RELOJ ─────────────────────────────── */
    const clockEl = document.getElementById('adm-clock');
    function tick() {
        if (!clockEl) return;
        const now = new Date();
        const dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        const h = now.getHours().toString().padStart(2,'0');
        const m = now.getMinutes().toString().padStart(2,'0');
        clockEl.innerHTML = `<span>${dias[now.getDay()]} ${now.getDate()} De ${meses[now.getMonth()]} De ${now.getFullYear()}</span><br><strong>${h}:${m}</strong>`;
    }
    tick(); setInterval(tick, 30000);

    /* ─── MODO OSCURO ────────────────────────── */
    const body    = document.body;
    const darkBtn = document.getElementById('adm-dark-toggle');
    const darkIco = document.getElementById('adm-dark-icon');
    const DARK_KEY = 'adm_dark_mode';
    function applyDark(on) {
        body.classList.toggle('adm-dark', on);
        darkIco.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        darkBtn.title     = on ? 'Modo claro' : 'Modo oscuro';
        localStorage.setItem(DARK_KEY, on ? '1' : '0');
    }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('adm-dark')));

    /* ─── DROPDOWNS ──────────────────────────── */
    function makeDropdown(btnId, panelId, chevronId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        const chev  = chevronId ? document.getElementById(chevronId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.classList.toggle('adm-dropdown--open');
            if (chev) chev.classList.toggle('adm-profile-btn__chevron--open', open);
            document.querySelectorAll('.adm-dropdown--open').forEach(d => {
                if (d !== panel) d.classList.remove('adm-dropdown--open');
            });
        });
    }
    makeDropdown('adm-notif-btn',   'adm-notif-panel');
    makeDropdown('adm-profile-btn', 'adm-profile-panel', 'adm-profile-chevron');
    document.addEventListener('click', () => {
        document.querySelectorAll('.adm-dropdown--open').forEach(d => d.classList.remove('adm-dropdown--open'));
        document.querySelectorAll('.adm-profile-btn__chevron--open').forEach(c => c.classList.remove('adm-profile-btn__chevron--open'));
    });
})();
</script>

<script src="<?= BASE_URL ?>public/assets/dashboard/administrador/administrador/sidebar-toggle.js"></script>

</body>
</html>
