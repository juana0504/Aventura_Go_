<form action="busqueda">
                <input type="text">
                <i class="bi bi-search"></i>

                <button id="modoOscuroBtn"> <i class="bi bi-moon-fill"></i></button>
                <button id="notificacionesBtn"> <i class="bi bi-bell-fill"></i></button>

                <!-- Dropdown con Bootstrap -->
                <div class="dropdown" id="perfil-dropdown">
                    <a href="#" id="perfil" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= BASE_URL ?>/public/assets/dashboard/administrador/administrador/img/perfil.png"
                            alt="persona">
                        <p>AR-Ana</p>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/app/views/dashboard/administrador/perfil_usuario.html"><i
                                    class="bi bi-person"></i> Mi
                                Perfil</a>
                        </li>
                        <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/"><i class="bi bi-box-arrow-right"></i>
                                Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </form>