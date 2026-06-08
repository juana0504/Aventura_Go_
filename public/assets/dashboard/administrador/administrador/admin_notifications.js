(function () {
  const notifBtn = document.getElementById('adm-notif-btn');
  const notifPanel = document.getElementById('adm-notif-panel');
  if (!notifBtn || !notifPanel) return;

  const notifList = notifPanel.querySelector('.adm-notif-list');
  const markAllBtn = notifPanel.querySelector('.adm-dropdown__mark-all');

  const scriptSrc = document.currentScript ? document.currentScript.src : '';
  const baseUrl = scriptSrc.includes('/public/assets/')
    ? `${scriptSrc.split('/public/assets/')[0]}/`
    : `${window.location.origin}/`;

  const LIST_URL = `${baseUrl}administrador/notificaciones`;
  const MARK_ALL_URL = `${baseUrl}administrador/notificaciones/marcar-todas`;

  function ensureBadge() {
    let badge = notifBtn.querySelector('.adm-notif-badge');
    if (!badge) {
      badge = document.createElement('span');
      badge.className = 'adm-notif-badge';
      notifBtn.appendChild(badge);
    }
    return badge;
  }

  function updateBadge(unreadCount) {
    notifBtn.classList.add('adm-icon-btn--notif');
    const badge = ensureBadge();
    const value = Number(unreadCount) || 0;
    if (value > 0) {
      badge.textContent = value > 99 ? '99+' : String(value);
      badge.style.display = 'inline-flex';
      notifBtn.classList.add('has-count');
    } else {
      badge.style.display = 'none';
      notifBtn.classList.remove('has-count');
    }
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function timeAgo(dateValue) {
    if (!dateValue) return 'Ahora';

    const date = new Date(String(dateValue).replace(' ', 'T'));
    if (Number.isNaN(date.getTime())) return 'Ahora';

    const diffMs = Date.now() - date.getTime();
    const minutes = Math.floor(diffMs / 60000);
    if (minutes < 1) return 'Ahora';
    if (minutes < 60) return `Hace ${minutes} min`;

    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `Hace ${hours} h`;

    const days = Math.floor(hours / 24);
    return days === 1 ? 'Ayer' : `Hace ${days} dias`;
  }

  function renderItems(notificaciones) {
    if (!notifList) return;

    if (!Array.isArray(notificaciones) || notificaciones.length === 0) {
      notifList.innerHTML = `
        <div class="adm-notif-item">
          <div class="adm-notif-item__icon adm-notif-item__icon--blue"><i class="bi bi-bell-slash"></i></div>
          <div class="adm-notif-item__body">
            <p class="adm-notif-item__text">No hay notificaciones pendientes.</p>
            <span class="adm-notif-item__time">Sin novedades</span>
          </div>
        </div>
      `;
      return;
    }

    notifList.innerHTML = notificaciones.map((item) => {
      const unread = Number(item.leida) === 0;
      const titulo = escapeHtml(item.titulo ? String(item.titulo) : 'Notificacion');
      const mensaje = escapeHtml(item.mensaje ? String(item.mensaje) : 'Sin detalles');

      const iconCandidate = item.icono ? String(item.icono) : 'bi-bell-fill';
      const iconClass = /^[a-z0-9\-\s]+$/i.test(iconCandidate) ? iconCandidate : 'bi-bell-fill';

      const colorCandidate = (item.color ? String(item.color) : 'blue').toLowerCase();
      const color = ['green', 'amber', 'blue'].includes(colorCandidate) ? colorCandidate : 'blue';

      const bodyHtml = `
        <p class="adm-notif-item__text"><strong>${titulo}</strong>: ${mensaje}</p>
        <span class="adm-notif-item__time">${timeAgo(item.fecha_evento)}</span>
      `;

      let bodyTemplate = `<div class="adm-notif-item__body">${bodyHtml}</div>`;
      if (item.url_destino) {
        const cleanPath = String(item.url_destino).replace(/^\/+/, '');
        bodyTemplate = `<a class="adm-notif-item__body" href="${baseUrl}${encodeURI(cleanPath)}">${bodyHtml}</a>`;
      }

      return `
        <div class="adm-notif-item ${unread ? 'adm-notif-item--unread' : ''}">
          <div class="adm-notif-item__icon adm-notif-item__icon--${color}"><i class="bi ${iconClass}"></i></div>
          ${bodyTemplate}
          ${unread ? '<span class="adm-notif-item__dot"></span>' : ''}
        </div>
      `;
    }).join('');
  }

  async function cargarNotificaciones() {
    try {
      const response = await fetch(LIST_URL, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
      });

      if (!response.ok) {
        return;
      }

      const payload = await response.json();
      if (!payload || payload.ok !== true) {
        return;
      }

      renderItems(payload.notificaciones || []);
      updateBadge(payload.noLeidas || 0);
    } catch (error) {
      console.error('No se pudieron cargar notificaciones admin:', error);
    }
  }

  async function marcarTodasLeidas(event) {
    event.preventDefault();
    event.stopImmediatePropagation();

    try {
      const response = await fetch(MARK_ALL_URL, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        },
        credentials: 'same-origin',
        body: 'accion=marcar_todas',
      });

      if (!response.ok) return;

      const payload = await response.json();
      if (!payload || payload.ok !== true) return;

      await cargarNotificaciones();
    } catch (error) {
      console.error('No se pudieron marcar notificaciones:', error);
    }
  }

  if (markAllBtn) {
    markAllBtn.addEventListener('click', marcarTodasLeidas, true);
  }

  cargarNotificaciones();
})();
