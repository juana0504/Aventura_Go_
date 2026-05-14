(() => {
  'use strict';

  const MOBILE_BREAKPOINT = 992;

  const syncBodyScroll = () => {
    const anyOpen = !!document.querySelector('.adm-layout.adm-layout--sidebar-open');
    document.body.classList.toggle('adm-no-scroll', anyOpen);
  };

  const closeSidebar = (layout) => {
    layout.classList.remove('adm-layout--sidebar-open');
    syncBodyScroll();
  };

  const initLayout = (layout) => {
    if (!layout || layout.dataset.sidebarToggleInit === '1') return;

    const sidebar = layout.querySelector('.adm-sidebar');
    const topbar = layout.querySelector('.adm-topbar');
    if (!sidebar || !topbar) return;

    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.className = 'adm-sidebar-toggle';
    toggleBtn.setAttribute('aria-label', 'Abrir menu de navegacion');
    toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
    topbar.prepend(toggleBtn);

    const backdrop = document.createElement('div');
    backdrop.className = 'adm-sidebar-backdrop';
    layout.appendChild(backdrop);

    const toggleSidebar = () => {
      layout.classList.toggle('adm-layout--sidebar-open');
      syncBodyScroll();
    };

    toggleBtn.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      toggleSidebar();
    });

    backdrop.addEventListener('click', () => closeSidebar(layout));

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeSidebar(layout);
      }
    });

    layout.querySelectorAll('.adm-sidebar a').forEach((link) => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= MOBILE_BREAKPOINT) {
          closeSidebar(layout);
        }
      });
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > MOBILE_BREAKPOINT) {
        closeSidebar(layout);
      }
    });

    layout.dataset.sidebarToggleInit = '1';
  };

  const boot = () => {
    document.querySelectorAll('.adm-layout').forEach(initLayout);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
