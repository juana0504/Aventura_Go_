<?php
require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';

$nombreProveedor = $_SESSION['user']['nombre'] ?? '';
$iniciales = '';
foreach (array_slice(explode(' ', trim($nombreProveedor)), 0, 2) as $p) {
    $iniciales .= mb_strtoupper(mb_substr($p, 0, 1));
}
$activeSection = 'tickets';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket — AventuraGO Hotelero</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/dashboard/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
    <style>
        .pv-tk-form-card { max-width:760px; animation:pvFadeIn .4s ease-out; }
        @keyframes pvFadeIn { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        .pv-tk-card { background:var(--pv-surface,#fff); border:1px solid var(--pv-border,#e2e8f0); border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.05); }
        .pv-tk-card__header { background:#1a2b3c; color:#fff; padding:16px 24px; display:flex; align-items:center; gap:10px; font-family:'Bebas Neue',sans-serif; font-size:1.1rem; letter-spacing:1px; border-bottom:3px solid #ea8217; }
        .pv-tk-card__header i { color:#ea8217; }
        .pv-tk-card__body { padding:28px; }
        .pv-tk-label { display:block; font-size:.75rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.6px; margin-bottom:8px; }
        .pv-tk-input, .pv-tk-textarea { width:100%; background:var(--pv-bg,#f8fafc); border:1px solid var(--pv-border,#e2e8f0); border-radius:8px; padding:12px 16px; color:var(--pv-text,#1e293b); font-size:.92rem; font-family:'DM Sans',sans-serif; transition:border-color .2s,box-shadow .2s; }
        .pv-tk-input:focus, .pv-tk-textarea:focus { outline:none; border-color:#ea8217; box-shadow:0 0 0 3px rgba(234,130,23,.12); background:#fff; }
        .pv-tk-textarea { resize:vertical; min-height:160px; }
        .pv-tk-tip { margin-top:6px; font-size:.75rem; color:#94a3b8; }
        .pv-tk-form-actions { display:flex; align-items:center; gap:16px; margin-top:28px; }
        .pv-tk-btn-back { display:inline-flex; align-items:center; gap:6px; color:#64748b; font-size:.88rem; font-weight:500; text-decoration:none; padding:10px 14px; border-radius:8px; transition:all .2s; }
        .pv-tk-btn-back:hover { color:#1a2b3c; background:var(--pv-bg,#f1f5f9); }
    </style>
</head>
<body class="pv-body">
<div class="pv-layout">

    <?php include __DIR__ . '/_sidebar.php'; ?>

    <div class="pv-main">
        <header class="pv-topbar">
            <div class="pv-topbar__search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Buscar..." class="pv-topbar__input" autocomplete="off">
            </div>
            <div class="pv-topbar__actions">
                <button class="pv-icon-btn" id="pv-dark-toggle" title="Modo oscuro"><i class="bi bi-moon-fill" id="pv-dark-icon"></i></button>
                <div class="pv-topbar__dropdown-wrap">
                    <button class="pv-icon-btn pv-icon-btn--notif" id="pv-notif-btn"><i class="bi bi-bell-fill"></i></button>
                    <div class="pv-dropdown pv-dropdown--notif" id="pv-notif-panel">
                        <div class="pv-dropdown__header"><span class="pv-dropdown__title">Notificaciones</span><button class="pv-dropdown__mark-all">Marcar todas</button></div>
                        <div class="pv-notif-list"></div>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__footer">Ver todas</a>
                    </div>
                </div>
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
                        <a href="<?= BASE_URL ?>proveedor_hotelero/perfil" class="pv-dropdown__item"><i class="bi bi-person-circle"></i> Mi perfil</a>
                        <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-dropdown__item"><i class="bi bi-headset"></i> Soporte</a>
                        <div class="pv-dropdown__divider"></div>
                        <a href="<?= BASE_URL ?>logout" class="pv-dropdown__item pv-dropdown__item--danger"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="pv-content">
            <div class="pv-page-header">
                <div>
                    <div class="pv-greeting__eyebrow">Soporte</div>
                    <h1 class="pv-page-title">Nuevo <span>Ticket</span></h1>
                    <p class="pv-greeting__sub">Envía tu consulta o problema al equipo de administración</p>
                </div>
            </div>

            <div class="pv-tk-form-card">
                <div class="pv-tk-card">
                    <div class="pv-tk-card__header">
                        <i class="bi bi-send"></i> Crear ticket de soporte
                    </div>
                    <div class="pv-tk-card__body">
                        <form method="POST" action="<?= BASE_URL ?>proveedor_hotelero/guardar-ticket">
                            <div class="mb-4">
                                <label class="pv-tk-label" for="asunto">Asunto</label>
                                <input type="text" id="asunto" name="asunto" class="pv-tk-input" placeholder="Ej: Problema con mis hospedajes registrados" required maxlength="150">
                                <p class="pv-tk-tip">Escribe un título corto y descriptivo.</p>
                            </div>
                            <div class="mb-2">
                                <label class="pv-tk-label" for="descripcion">Descripción del problema</label>
                                <textarea id="descripcion" name="descripcion" class="pv-tk-textarea" placeholder="Describe con detalle el problema o consulta que tienes..." required></textarea>
                                <p class="pv-tk-tip">Incluye la mayor cantidad de detalle posible para agilizar la respuesta.</p>
                            </div>
                            <div class="pv-tk-form-actions">
                                <button type="submit" class="pv-btn-primary"><i class="bi bi-send"></i> Enviar Ticket</button>
                                <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-tk-btn-back"><i class="bi bi-arrow-left"></i> Volver a mis tickets</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const body = document.body, darkBtn = document.getElementById('pv-dark-toggle'), darkIcon = document.getElementById('pv-dark-icon'), DARK_KEY = 'pv_dark_mode';
    function applyDark(on) { body.classList.toggle('pv-dark', on); darkIcon.className = on ? 'bi bi-sun-fill' : 'bi bi-moon-fill'; localStorage.setItem(DARK_KEY, on ? '1' : '0'); }
    applyDark(localStorage.getItem(DARK_KEY) === '1');
    darkBtn.addEventListener('click', () => applyDark(!body.classList.contains('pv-dark')));
    function makeDropdown(bId, pId, cId) {
        const btn = document.getElementById(bId), panel = document.getElementById(pId), chev = cId ? document.getElementById(cId) : null;
        if (!btn || !panel) return;
        btn.addEventListener('click', e => { e.stopPropagation(); const open = panel.classList.toggle('pv-dropdown--open'); if (chev) chev.classList.toggle('pv-profile-btn__chevron--open', open); });
    }
    makeDropdown('pv-notif-btn','pv-notif-panel'); makeDropdown('pv-profile-btn','pv-profile-panel','pv-profile-chevron');
    document.addEventListener('click', () => { document.querySelectorAll('.pv-dropdown--open').forEach(d => d.classList.remove('pv-dropdown--open')); });
})();
</script>
<script src="<?= BASE_URL ?>public/assets/dashboard/adm-clock.js"></script>
</body>
</html>
