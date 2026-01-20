<link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/tickets.css">

<main class="admin-main-content">
    <div class="table-container">
        <div class="ticket-header">
            <h2>Gestión de Reportes</h2>
            <a href="<?= BASE_URL ?>/administrador/crear-ticket" class="btn-nuevo">Nuevo Reporte</a>
        </div>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Asunto</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listadoTickets)): ?>
                    <?php foreach ($listadoTickets as $t): ?>
                        <tr>
                            <td>#<?= $t['id_ticket'] ?></td>
                            <td><?= htmlspecialchars($t['nombre_usuario'] ?? 'Usuario ID: '.$t['id_usuario']) ?></td>
                            <td><?= htmlspecialchars($t['asunto']) ?></td>
                            <td><span class="tag-category"><?= $t['categoria'] ?></span></td>
                            <td><span class="status-<?= strtolower($t['estado']) ?>"><?= $t['estado'] ?></span></td>
                            <td>
                                <a href="<?= BASE_URL ?>/administrador/ver-ticket?id=<?= $t['id_ticket'] ?>" class="btn-action view">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; padding: 20px;">No hay reportes registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>