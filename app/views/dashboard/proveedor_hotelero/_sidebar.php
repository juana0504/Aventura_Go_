<?php
// Variables requeridas: $activeSection (string)
// Valores: 'dashboard', 'info', 'nuevo', 'hospedajes', 'reservas', 'ingresos', 'tickets', 'perfil'
?>
<nav class="pv-sidebar">
    <div class="pv-sidebar__logo">
        <div class="pv-sidebar__logo-icon">A</div>
        <div>
            <div class="pv-sidebar__logo-text">AVENTURA GO</div>
            <div class="pv-sidebar__logo-sub">Proveedor Hotelero</div>
        </div>
    </div>

    <div class="pv-sidebar__section-label">Panel</div>
    <a href="<?= BASE_URL ?>proveedor_hotelero/dashboard" class="pv-nav-item <?= ($activeSection==='dashboard') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-grid-1x2-fill pv-nav-item__icon"></i> Dashboard
    </a>

    <div class="pv-sidebar__section-label">Hospedajes</div>
    <a href="<?= BASE_URL ?>proveedor_hotelero/registrar-hospedajes" class="pv-nav-item <?= ($activeSection==='nuevo') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-plus-circle pv-nav-item__icon"></i> Nuevo Hospedaje
    </a>
    <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-hospedajes" class="pv-nav-item <?= ($activeSection==='hospedajes') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-building pv-nav-item__icon"></i> Mis Hospedajes
    </a>
    <a href="<?= BASE_URL ?>proveedor_hotelero/consultar-reservas" class="pv-nav-item <?= ($activeSection==='reservas') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-calendar3 pv-nav-item__icon"></i> Reservas
    </a>
    <a href="<?= BASE_URL ?>proveedor_hotelero/ingresos" class="pv-nav-item <?= ($activeSection==='ingresos') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-bar-chart-line pv-nav-item__icon"></i> Ingresos
    </a>

    <div class="pv-sidebar__section-label">Soporte</div>
    <a href="<?= BASE_URL ?>proveedor_hotelero/tickets" class="pv-nav-item <?= ($activeSection==='tickets') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-headset pv-nav-item__icon"></i> Tickets
    </a>
    <a href="<?= BASE_URL ?>proveedor_hotelero/perfil" class="pv-nav-item <?= ($activeSection==='perfil') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-person-circle pv-nav-item__icon"></i> Mi Perfil
    </a>
    <a href="<?= BASE_URL ?>proveedor_hotelero/completar-informacion" class="pv-nav-item <?= ($activeSection==='info') ? 'pv-nav-item--active':'' ?>">
        <i class="bi bi-building-gear pv-nav-item__icon"></i> Mi Empresa
    </a>
</nav>
