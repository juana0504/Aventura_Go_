/**
 * Universal sidebar toggle — AventuraGO dashboards
 * Handles pv- (proveedor turístico / hotelero) and ag- (turista) layouts.
 * The adm- (administrador) system has its own sidebar-toggle.js.
 */
(() => {
    'use strict';

    const CONFIGS = [
        {
            layout:    '.pv-layout',
            sidebar:   '.pv-sidebar',
            topbar:    '.pv-topbar',
            btnClass:  'pv-sidebar-toggle',
            bdClass:   'pv-sidebar-backdrop',
            openClass: 'pv-layout--sidebar-open',
            noScroll:  'pv-no-scroll',
            breakpoint: 768,
        },
        {
            layout:    '.ag-layout',
            sidebar:   '.ag-sidebar',
            topbar:    '.ag-topbar',
            btnClass:  'ag-sidebar-toggle',
            bdClass:   'ag-sidebar-backdrop',
            openClass: 'ag-layout--sidebar-open',
            noScroll:  'ag-no-scroll',
            breakpoint: 768,
        },
    ];

    CONFIGS.forEach(cfg => {
        document.querySelectorAll(cfg.layout).forEach(layout => {
            if (layout.dataset.sidebarToggleInit === '1') return;

            const sidebar = layout.querySelector(cfg.sidebar);
            const topbar  = layout.querySelector(cfg.topbar);
            if (!sidebar || !topbar) return;

            /* ── Botón hamburguesa ── */
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.className = cfg.btnClass;
            toggleBtn.setAttribute('aria-label', 'Abrir menú de navegación');
            toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
            topbar.prepend(toggleBtn);

            /* ── Backdrop ── */
            const backdrop = document.createElement('div');
            backdrop.className = cfg.bdClass;
            layout.appendChild(backdrop);

            const closeSidebar = () => {
                layout.classList.remove(cfg.openClass);
                document.body.classList.remove(cfg.noScroll);
            };

            const toggleSidebar = () => {
                const open = layout.classList.toggle(cfg.openClass);
                document.body.classList.toggle(cfg.noScroll, open);
            };

            toggleBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
            backdrop.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeSidebar();
            });

            layout.querySelectorAll(cfg.sidebar + ' a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= cfg.breakpoint) closeSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > cfg.breakpoint) closeSidebar();
            });

            layout.dataset.sidebarToggleInit = '1';
        });
    });

})();
