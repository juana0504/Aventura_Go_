<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Reporte | Aventura GO</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layout global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">

    <!-- CSS exclusivo tickets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/tickets.css">
</head>

<body>

<section id="proveedor-actividades">

    <!-- PANEL IZQUIERDO (FIJO) -->
    <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="info">

        <!-- BUSCADOR SUPERIOR -->
        <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>

        <!-- HEADER -->
        <div class="header-section">
            <h1>Soporte y Reportes</h1>
        </div>

        <!-- CARD FORMULARIO -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-ticket-detailed"></i> Nuevo Reporte Administrativo
                </h5>
            </div>

            <div class="card-body">
                <form action="<?= BASE_URL ?>/administrador/guardar-ticket" method="POST">

                    <!-- ASUNTO -->
                    <div class="mb-3">
                        <label class="form-label">Asunto de la Ocurrencia</label>
                        <input type="text"
                               name="asunto"
                               class="form-control"
                               placeholder="Ej: Error en el módulo de proveedores"
                               required>
                    </div>

                    <!-- CATEGORIA -->
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="ERROR">🚨 Error Crítico</option>
                            <option value="SOPORTE">🛠 Soporte Técnico</option>
                            <option value="SUGERENCIA">💡 Sugerencia</option>
                            <option value="QUEJA">⚠ Queja</option>
                        </select>
                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div class="mb-4">
                        <label class="form-label">Descripción Detallada</label>
                        <textarea name="descripcion"
                                  rows="5"
                                  class="form-control"
                                  placeholder="Describe detalladamente el problema..."
                                  required></textarea>
                    </div>

                    <!-- BOTÓN -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send"></i> Registrar Reporte
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
