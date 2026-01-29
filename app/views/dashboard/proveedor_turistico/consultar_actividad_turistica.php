<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turistico</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LIBRERIA AOS ANIMATE -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Icono de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- 🔹 LAYOUT GLOBAL (ESTE ES NUEVO) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- CSS SOLO DE ESTA VISTA (SIEMPRE AL FINAL) -->
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/consultar_proveedor/consultar_proveedor_turistico.css"> -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">


</head>

<body>

    <!-- Layout Principal -->
    <section id="proveedor-actividades">

        <!-- Panel Lateral -->
        <?php
        require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php';
        ?>

        <!-- Contenido Principal -->
        <div class="info">

            <!-- Barra de Búsqueda Superior -->
            <?php
            require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php';
            ?>

            <!-- Título y Acciones -->
            <div class="header-section">
                <h1>Gestión de Actividades turisticas</h1>
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

                <a href="<?= BASE_URL ?>/proveedor/pdf-actividades" class="btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>Generar Reportes
                </a>

            </div>






            <div class="card shadow-sm mt-4">

                <div class="table-responsive">
                    <table id="tablaActividades" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>IMAGEN</th>
                                <th>NOMBRE</th>
                                <th>DESTINO</th>
                                <th>UBICACIÓN</th>
                                <th>CUPOS</th>
                                <th>PRECIO</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($actividades)): ?>
                                <?php foreach ($actividades as $actividad): ?>
                                    <tr>
                                        <!-- Imagen -->
                                        <td>
                                            <img
                                                src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= $actividad['imagen_principal'] ?? 'actividad_default.png' ?>"
                                                alt="Actividad" class="rounded">

                                        </td>

                                        <!-- Nombre -->
                                        <td><?= htmlspecialchars($actividad['nombre']) ?></td>

                                        <!-- Destino / ciudad -->
                                        <td><?= htmlspecialchars($actividad['destino'] ?? 'N/A') ?></td>

                                        <!-- Ubicación -->
                                        <td><?= htmlspecialchars($actividad['ubicacion']) ?></td>

                                        <!-- Cupos -->
                                        <td><?= $actividad['cupos'] ?></td>

                                        <!-- Precio -->
                                        <td>$<?= number_format($actividad['precio'], 0, ',', '.') ?></td>

                                        <!-- Estado -->
                                        <td>
                                            <?php if ($actividad['estado'] === 'activa'): ?>
                                                <span class="badge bg-success">Activa</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactiva</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Acciones -->
                                        <td>
                                            <button
                                                class="btn-accion btn-ver"
                                                data-id="<?= $actividad['id_actividad'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalActividad">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <a href="<?= BASE_URL ?>/proveedor/editar-actividad?id=<?= $proveedor['id_actividad'] ?>" class="btn-accion btn-editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="<?= BASE_URL ?>/proveedor/eliminar-actividad?accion=eliminar&id=<?= $proveedor['id_actividad'] ?>" class="btn-accion btn-eliminar">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No hay actividades registradas
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>

    <div class="modal fade" id="modalActividad" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content aventura-modal">

                <div class="modal-header aventura-modal-header">
                    <h5 class="modal-title">Detalle de la Actividad</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <img id="modal-imagen" class="img-fluid rounded">
                        </div>

                        <div class="col-md-8">
                            <p><strong>Nombre:</strong> <span id="modal-nombre"></span></p>
                            <p><strong>Ciudad:</strong> <span id="modal-destino"></span></p>
                            <p><strong>Ubicación:</strong> <span id="modal-ubicacion"></span></p>
                            <p><strong>Cupos:</strong> <span id="modal-cupos"></span></p>
                            <p><strong>Precio:</strong> $<span id="modal-precio"></span></p>
                            <p><strong>Estado:</strong> <span id="modal-estado"></span></p>
                        </div>
                    </div>

                    <div>
                        <strong>Descripción:</strong>
                        <p id="modal-descripcion"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <a id="btn-desactivar" class="btn btn-danger">Pausar</a>
                    <a id="btn-activar" class="btn btn-success">Activar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll('.btn-ver').forEach(btn => {
                btn.addEventListener('click', () => {

                    const id = btn.dataset.id;

                    fetch(`<?= BASE_URL ?>/app/controllers/proveedor_turistico/actividadDetalle.php?id=${id}`)
                        .then(res => res.json())
                        .then(data => {

                            if (data.error) {
                                alert(data.error);
                                return;
                            }

                            document.getElementById('modal-nombre').textContent = data.nombre;
                            document.getElementById('modal-descripcion').textContent = data.descripcion;
                            document.getElementById('modal-ubicacion').textContent = data.ubicacion;
                            document.getElementById('modal-cupos').textContent = data.cupos;
                            document.getElementById('modal-precio').textContent = data.precio;
                            document.getElementById('modal-estado').textContent = data.estado;
                        });
                });
            });

        });
    </script>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>



</body>