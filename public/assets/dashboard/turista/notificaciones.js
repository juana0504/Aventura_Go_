(function () {
    'use strict';

    const BASE = window.AG_BASE_URL || '/';
    const btn       = document.getElementById('ag-notif-btn');
    const panel     = document.getElementById('ag-notif-panel');
    const list      = document.getElementById('ag-notif-list');
    const badge     = document.getElementById('ag-notif-badge');
    const btnMarcar = document.getElementById('ag-notif-marcar-todas');

    if (!btn || !panel || !list) return;

    let cargado = false;

    /* ── BADGE: contar no leídas al cargar ─────────────── */
    fetch(BASE + 'turista/notificaciones/contar')
        .then(r => r.json())
        .then(d => {
            if (d.ok && d.total > 0) {
                badge.textContent = d.total > 99 ? '99+' : d.total;
                badge.style.display = 'flex';
                btn.classList.add('ag-icon-btn--notif-active');
            }
        })
        .catch(() => {});

    /* ── ABRIR PANEL: cargar notificaciones ────────────── */
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const open = panel.classList.toggle('ag-dropdown--open');
        if (open && !cargado) cargarNotificaciones();
        // Limpiar badge al abrir
        badge.style.display = 'none';
        btn.classList.remove('ag-icon-btn--notif-active');
    });

    /* ── CERRAR al hacer click fuera ───────────────────── */
    document.addEventListener('click', () => panel.classList.remove('ag-dropdown--open'));
    panel.addEventListener('click', e => e.stopPropagation());

    /* ── MARCAR TODAS ──────────────────────────────────── */
    if (btnMarcar) {
        btnMarcar.addEventListener('click', () => {
            fetch(BASE + 'turista/notificaciones/leer-todas', { method: 'POST' })
                .then(() => {
                    document.querySelectorAll('.ag-notif-item--unread')
                        .forEach(el => el.classList.remove('ag-notif-item--unread'));
                    badge.style.display = 'none';
                })
                .catch(() => {});
        });
    }

    /* ── CARGAR LISTA ──────────────────────────────────── */
    function cargarNotificaciones() {
        list.innerHTML = '<div class="ag-notif-loading"><i class="bi bi-arrow-repeat"></i> Cargando...</div>';
        fetch(BASE + 'turista/notificaciones/listar')
            .then(r => r.json())
            .then(d => {
                cargado = true;
                if (!d.ok || !d.notificaciones || d.notificaciones.length === 0) {
                    list.innerHTML = renderVacio();
                    return;
                }
                list.innerHTML = d.notificaciones.map(renderItem).join('');
                // Asignar handlers de archivar
                list.querySelectorAll('.ag-notif-archivar').forEach(b => {
                    b.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const id   = this.dataset.id;
                        const item = this.closest('.ag-notif-item');
                        archivarNotif(id, item);
                    });
                });
            })
            .catch(() => {
                list.innerHTML = '<div class="ag-notif-loading">Error al cargar.</div>';
            });
    }

    /* ── ARCHIVAR ──────────────────────────────────────── */
    function archivarNotif(id, itemEl) {
        const fd = new FormData();
        fd.append('id', id);
        fetch(BASE + 'turista/notificaciones/archivar', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                if (d.ok && itemEl) {
                    itemEl.style.transition = 'opacity .3s';
                    itemEl.style.opacity = '0';
                    setTimeout(() => {
                        itemEl.remove();
                        if (list.querySelectorAll('.ag-notif-item').length === 0) {
                            list.innerHTML = renderVacio();
                        }
                    }, 300);
                }
            })
            .catch(() => {});
    }

    /* ── RENDER ITEM ───────────────────────────────────── */
    function renderItem(n) {
        const iconColor = {
            green:  '#10b981',
            orange: '#EA8217',
            red:    '#ef4444',
            blue:   '#2D4059',
            amber:  '#f59e0b',
        }[n.color] || '#2D4059';

        const unread = n.leida == 0 ? ' ag-notif-item--unread' : '';
        const fecha  = formatFecha(n.fecha_evento);
        const url    = n.url_destino ? `href="${BASE}${n.url_destino}"` : '';
        const tag    = n.url_destino ? 'a' : 'div';

        return `
        <${tag} class="ag-notif-item${unread}" ${url} style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid var(--ag-border,#eee);text-decoration:none;color:inherit;position:relative;">
            <div style="width:34px;height:34px;border-radius:50%;background:${iconColor}22;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi ${n.icono || 'bi-bell-fill'}" style="font-size:15px;color:${iconColor};"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;font-size:13px;color:var(--ag-text,#1a2b3c);margin-bottom:2px;">${escHtml(n.titulo)}</div>
                <div style="font-size:12px;color:var(--ag-muted,#666);line-height:1.4;">${escHtml(n.mensaje)}</div>
                <div style="font-size:11px;color:#aaa;margin-top:4px;">${fecha}</div>
            </div>
            <button class="ag-notif-archivar" data-id="${n.id_notificacion}"
                title="Archivar"
                style="background:none;border:none;cursor:pointer;color:#bbb;font-size:14px;padding:2px 4px;flex-shrink:0;line-height:1;">
                <i class="bi bi-archive"></i>
            </button>
            ${n.leida == 0 ? '<span style="position:absolute;top:14px;right:40px;width:8px;height:8px;border-radius:50%;background:#EA8217;"></span>' : ''}
        </${tag}>`;
    }

    function renderVacio() {
        return `<div style="text-align:center;padding:28px 16px;color:var(--ag-muted,#888);">
            <i class="bi bi-bell-slash" style="font-size:28px;display:block;margin-bottom:8px;"></i>
            Sin notificaciones nuevas
        </div>`;
    }

    function escHtml(str) {
        return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function formatFecha(fechaStr) {
        if (!fechaStr) return '';
        const d   = new Date(fechaStr.replace(' ', 'T'));
        const now = new Date();
        const diff = Math.floor((now - d) / 1000);
        if (diff < 60)   return 'Hace un momento';
        if (diff < 3600) return `Hace ${Math.floor(diff/60)} min`;
        if (diff < 86400)return `Hace ${Math.floor(diff/3600)} h`;
        if (diff < 172800) return 'Ayer';
        return d.toLocaleDateString('es-CO', { day:'2-digit', month:'short' });
    }
})();
