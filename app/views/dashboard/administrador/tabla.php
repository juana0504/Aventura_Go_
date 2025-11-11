<?php
require_once __DIR__ . '/../../layouts/header_administrador.php';
?>

<body>

    <!-- Layout Principal -->
    <section id="admin-dashboard">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/panel-izq_administrador.php';
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../layouts/buscador_administrador.php';
            ?>

            <!-- Título y Acciones -->
            <div class="header-section">
                <h1>Gestión de Proveedores</h1>
            </div>

            <!-- Filtros Rápidos -->
            <div class="filtros-rapidos">
                <button class="filtro-btn active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="filtro-btn" data-filter="activo">
                    <i class="bi bi-check-circle"></i> Activos
                </button>
                <button class="filtro-btn" data-filter="inactivo">
                    <i class="bi bi-x-circle"></i> Inactivos
                </button>
                <button class="filtro-btn" data-filter="pendiente">
                    <i class="bi bi-clock"></i> Pendientes
                </button>
            </div>

            <!-- Tabla de Datos -->
            <div class="tabla-container">
                <table id="tablaAdmin" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Representante</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Aventuras Extremas</td>
                            <td>Juan Pérez</td>
                            <td>juan@aventuras.com</td>
                            <td>+57 300 123 4567</td>
                            <td>Medellín</td>
                            <td><span class="badge-activo">Activo</span></td>
                            <td>
                                <button class="btn-accion btn-ver" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-accion btn-editar" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-accion btn-eliminar" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Turismo del Valle</td>
                            <td>María López</td>
                            <td>maria@turismo.com</td>
                            <td>+57 310 987 6543</td>
                            <td>Cali</td>
                            <td><span class="badge-activo">Activo</span></td>
                            <td>
                                <button class="btn-accion btn-ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-accion btn-editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-accion btn-eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Ecoturismo Santander</td>
                            <td>Carlos Ruiz</td>
                            <td>carlos@eco.com</td>
                            <td>+57 320 555 8888</td>
                            <td>Bucaramanga</td>
                            <td><span class="badge-pendiente">Pendiente</span></td>
                            <td>
                                <button class="btn-accion btn-ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-accion btn-editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-accion btn-eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>004</td>
                            <td>Aventura Colombia</td>
                            <td>Ana Martínez</td>
                            <td>ana@aventura.co</td>
                            <td>+57 315 444 7777</td>
                            <td>Bogotá</td>
                            <td><span class="badge-inactivo">Inactivo</span></td>
                            <td>
                                <button class="btn-accion btn-ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-accion btn-editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-accion btn-eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>005</td>
                            <td>Parapente Pro</td>
                            <td>Luis Gómez</td>
                            <td>luis@parapente.com</td>
                            <td>+57 318 222 3333</td>
                            <td>San Gil</td>
                            <td><span class="badge-activo">Activo</span></td>
                            <td>
                                <button class="btn-accion btn-ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn-accion btn-editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn-accion btn-eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal para Agregar/Editar -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Agregar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Empresa</label>
                                <input type="text" class="form-control" placeholder="Nombre de la empresa">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Representante</label>
                                <input type="text" class="form-control" placeholder="Nombre completo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="email@empresa.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" placeholder="+57 300 123 4567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" placeholder="Ciudad">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select">
                                    <option>Activo</option>
                                    <option>Inactivo</option>
                                    <option>Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-custom">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php
    require_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>


</body>

</html>