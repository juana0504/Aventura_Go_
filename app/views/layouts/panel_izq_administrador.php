    <div class="panel">

        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/LOGO-POSITIVO 2 (1).png" alt="logo">

        <div class="items">

            <a href="<?= BASE_URL ?>/administrador/dashboard">
                <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/Dashboard.png"
                    alt="dashboard">
                <p>Dashboard</p>
            </a>

            <div class="dropdown-panel" id="Turistico">
                <a class="btn btn-secondary dropdown-toggle" id="btn-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Proveedor Turistico
                </a>
                <ul class="dropdown-menu" id="menu-panel">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/administrador/registrar-proveedor-turistico" <i class="bi bi-layout-text-sidebar-reverse"></i>Registrar Proveedor</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/administrador/consultar-proveedor-turistico" <i class="bi bi-table"></i>Consultar Proveedor</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" id="btn-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Proveedor Hotelero
                </a>
                <ul class="dropdown-menu" id="menu-panel">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/administrador/registrar-proveedor-hotelero">Registrar Proveedor</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/administrador/consultar-proveedor-hotelero">Consultar Proveedor</a></li>

                </ul>
            </div>

            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle-aventura" id="btn-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Turista
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                </ul>
            </div>

        </div>

    </div>