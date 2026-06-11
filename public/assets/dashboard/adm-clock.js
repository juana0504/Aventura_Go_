/**
 * adm-clock.js — Reloj de fecha y hora para todos los paneles de AventuraGO.
 * Soporta prefijos: adm-topbar__search / ag-topbar__search / pv-topbar__search
 */
(function () {
    'use strict';

    /* ── Estilos inline (independiente de qué CSS cargue el panel) ── */
    const CSS = `
        .adm-topbar-clock-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            max-width: 380px;
            padding: 0 4px;
        }
        .adm-topbar-clock-widget .clk-icon {
            font-size: 20px;
            color: #EA8217;
            flex-shrink: 0;
        }
        .adm-topbar-clock-widget .clk-body {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        .adm-topbar-clock-widget .clk-date {
            font-size: 12px;
            font-weight: 500;
            color: #6b7280;
            font-family: 'DM Sans', sans-serif;
            line-height: 1.2;
            text-transform: capitalize;
        }
        .adm-topbar-clock-widget .clk-time {
            font-family: 'Bebas Neue', cursive, sans-serif;
            font-size: 22px;
            letter-spacing: 2px;
            color: #EA8217;
            line-height: 1;
        }
        .adm-dark .adm-topbar-clock-widget .clk-date {
            color: #8b95a5;
        }
    `;

    const DIAS  = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
    const MESES = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto',
                   'septiembre','octubre','noviembre','diciembre'];

    function updateClock() {
        const now  = new Date();
        const dia  = DIAS[now.getDay()];
        const num  = now.getDate();
        const mes  = MESES[now.getMonth()];
        const anio = now.getFullYear();
        const hh   = String(now.getHours()).padStart(2, '0');
        const mm   = String(now.getMinutes()).padStart(2, '0');

        const elDate = document.getElementById('adm-clk-date');
        const elTime = document.getElementById('adm-clk-time');
        if (elDate) elDate.textContent =
            dia.charAt(0).toUpperCase() + dia.slice(1) + ' ' + num + ' de ' + mes + ' de ' + anio;
        if (elTime) elTime.textContent = hh + ':' + mm;
    }

    function injectClock() {
        /* Busca la barra de búsqueda: nuevos paneles (topbar__search) o antiguo (.busqueda-wrapper) */
        var searchDiv = document.querySelector(
            '.adm-topbar__search, .ag-topbar__search, .pv-topbar__search, .busqueda-wrapper'
        );
        if (!searchDiv) return;

        /* Inyectar estilos una sola vez */
        if (!document.getElementById('adm-clock-style')) {
            var styleEl = document.createElement('style');
            styleEl.id = 'adm-clock-style';
            styleEl.textContent = CSS;
            document.head.appendChild(styleEl);
        }

        /* Crear widget */
        var clockDiv = document.createElement('div');
        clockDiv.className = 'adm-topbar-clock-widget';
        clockDiv.innerHTML =
            '<i class="bi bi-calendar3 clk-icon"></i>' +
            '<div class="clk-body">' +
                '<span class="clk-date" id="adm-clk-date">—</span>' +
                '<span class="clk-time" id="adm-clk-time">—:—</span>' +
            '</div>';

        searchDiv.replaceWith(clockDiv);

        updateClock();
        setInterval(updateClock, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectClock);
    } else {
        injectClock();
    }
})();
