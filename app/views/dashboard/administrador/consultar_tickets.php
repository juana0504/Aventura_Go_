<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/tickets.css">

<main class="admin-main-content">
    <div class="table-container">
        <div class="ticket-header">
            <h2>Gestión de Tickets y Reportes</h2>
            <p>Listado de incidencias y sugerencias registradas en el sistema.</p>
        </div>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Asunto</th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#001</td>
                    <td>Error en carga de imágenes</td>
                    <td><span class="tag-category">ERROR</span></td>
                    <td>2024-05-20</td>
                    <td><span class="status-pending">Abierto</span></td>
                    <td>
                        <a href="#" class="btn-action view"><i class="bi bi-eye"></i></a>
                        <a href="#" class="btn-action edit"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>