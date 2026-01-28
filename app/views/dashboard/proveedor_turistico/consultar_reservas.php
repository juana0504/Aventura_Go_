<?php
require_once BASE_PATH . '/app/helpers/session_proveedor.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Reservas | Proveedor Turístico</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Layout global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">

    <!-- Componentes comunes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_proveedor_turistico.css">

    <!-- CSS propio de reservas -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/consultar_reservas/consultar_reservas.css">
</head>

<body>

<section id="proveedor-reservas">

    <!-- Panel lateral -->
    <?php require_once __DIR__ . '/../../layouts/proveedor_turistico_panel_izq.php'; ?>

    <!-- Contenido principal -->
    <div class="info">

        <!-- Buscador superior -->
        <?php require_once __DIR__ . '/../../layouts/buscador_proveedor_turistico.php'; ?>

        <!-- Header -->
        <div class="header-section">
            <h1>Consultar Reservas</h1>
           
        </div>

        
          <!-- Filtros Rápidos -->
            <div class="filtros-rapidos">
                <button class="filtro-btn active" data-filter="all">
                    <i class="bi bi-grid"></i> Todos
                </button>
                <button class="filtro-btn" data-filter="pendiente">
                    <i class="bi bi-clock"></i> Pendientes
                </button>
                <button class="filtro-btn" data-filter="confirmada">
                    <i class="bi bi-check-circle"></i> Confirmadas
                </button>
                <button class="filtro-btn" data-filter="cancelada">
                    <i class="bi bi-x-circle"></i> Canceladas
                </button>
                <a href="<?= BASE_URL ?>/proveedor/pdf-reservas?filtro=<?= urlencode($filtro ?? 'all') ?>" class="btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>Generar Reportes
                </a>
            </div>

        <!-- Tabla -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Turista</th>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Personas</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($reservas)): ?>
                                <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($reserva['nombre_turista']) ?></strong>
                                        <?php if ($reserva['email_turista']): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($reserva['email_turista']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($reserva['nombre_actividad']) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($reserva['ubicacion']) ?></small>
                                    </td>
                                    <td>
                                        <?= date('Y-m-d', strtotime($reserva['fecha'])) ?>
                                        <br><small class="text-muted">Reserva: <?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <strong><?= $reserva['cantidad_personas'] ?></strong>
                                    </td>
                                    <td>
                                        <?php
                                        $estadoClass = $reserva['estado'] === 'pendiente' ? 'bg-warning text-dark' : 
                                                      ($reserva['estado'] === 'confirmada' ? 'bg-success' : 'bg-danger');
                                        echo "<span class='badge $estadoClass'>" . ucfirst($reserva['estado']) . "</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn-accion btn-ver" 
                                                data-id="<?= $reserva['id_reserva'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalReserva"
                                                title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if ($reserva['estado'] === 'pendiente'): ?>
                                            <button class="btn-accion btn-confirmar" 
                                                    onclick="confirmarReserva(<?= $reserva['id_reserva'] ?>)"
                                                    title="Confirmar reserva">
                                                <i class="bi bi-check"></i>
                                            </button>
                                            <button class="btn-accion btn-cancelar" 
                                                    onclick="cancelarReserva(<?= $reserva['id_reserva'] ?>)"
                                                    title="Cancelar reserva">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                        <br><strong>No hay reservas registradas</strong>
                                        <br><small>Las reservas aparecerán aquí cuando los turistas realicen reservas en sus actividades</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL DETALLE RESERVA -->
<div class="modal fade" id="modalReserva" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content aventura-modal">

            <div class="modal-header aventura-modal-header">
                <h5 class="modal-title">Detalle de la Reserva</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>ID Reserva:</strong> <span id="modal-id"></span></p>
                        <p><strong>Turista:</strong> <span id="modal-turista"></span></p>
                        <p><strong>Email:</strong> <span id="modal-email"></span></p>
                        <p><strong>Teléfono:</strong> <span id="modal-telefono"></span></p>
                        <p><strong>Fecha Reserva:</strong> <span id="modal-fecha-reserva"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Actividad:</strong> <span id="modal-actividad"></span></p>
                        <p><strong>Ubicación:</strong> <span id="modal-ubicacion"></span></p>
                        <p><strong>Fecha Actividad:</strong> <span id="modal-fecha"></span></p>
                        <p><strong>Personas:</strong> <span id="modal-personas"></span></p>
                        <p><strong>Precio Unitario:</strong> $<span id="modal-precio"></span></p>
                        <p><strong>Total:</strong> $<span id="modal-total"></span></p>
                        <p><strong>Estado:</strong> <span id="modal-estado"></span></p>
                    </div>
                </div>
                <div>
                    <strong>Descripción de la Actividad:</strong>
                    <p id="modal-descripcion"></p>
                </div>
            </div>

            <div class="modal-footer">
                <button id="btn-confirmar-modal" class="btn btn-success" style="display: none;">
                    <i class="bi bi-check"></i> Confirmar Reserva
                </button>
                <button id="btn-cancelar-modal" class="btn btn-danger" style="display: none;">
                    <i class="bi bi-x"></i> Cancelar Reserva
                </button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Cargar detalles en modal
    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            
            // Mostrar indicador de carga
            const modalBody = document.querySelector('#modalReserva .modal-body');
            modalBody.innerHTML = '<div class="text-center py-4"><i class="bi bi-hourglass-split"></i> Cargando detalles...</div>';
            
            fetch(`<?= BASE_URL ?>/proveedor/reserva-detalle?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        modalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        return;
                    }
                    
                    const r = data.data;
                    
                    // Restaurar el contenido original del modal
                    document.getElementById('modal-id').textContent = r.id_reserva;
                    document.getElementById('modal-turista').textContent = r.nombre_turista;
                    document.getElementById('modal-email').textContent = r.email_turista;
                    document.getElementById('modal-telefono').textContent = r.telefono_turista || 'No disponible';
                    document.getElementById('modal-actividad').textContent = r.nombre_actividad;
                    document.getElementById('modal-ubicacion').textContent = r.ubicacion;
                    document.getElementById('modal-fecha').textContent = r.fecha;
                    document.getElementById('modal-fecha-reserva').textContent = new Date(r.created_at).toLocaleDateString('es-CO');
                    document.getElementById('modal-personas').textContent = r.cantidad_personas;
                    document.getElementById('modal-precio').textContent = number_format(r.precio, 0, ',', '.');
                    document.getElementById('modal-total').textContent = number_format(r.total, 0, ',', '.');
                    document.getElementById('modal-estado').textContent = r.estado;
                    document.getElementById('modal-descripcion').textContent = r.descripcion_actividad || 'Sin descripción';
                    
                    // Configurar botones del modal según el estado
                    const btnConfirmar = document.getElementById('btn-confirmar-modal');
                    const btnCancelar = document.getElementById('btn-cancelar-modal');
                    
                    if (r.estado === 'pendiente') {
                        btnConfirmar.style.display = 'inline-block';
                        btnCancelar.style.display = 'inline-block';
                        btnConfirmar.onclick = () => confirmarReserva(r.id_reserva);
                        btnCancelar.onclick = () => cancelarReserva(r.id_reserva);
                    } else {
                        btnConfirmar.style.display = 'none';
                        btnCancelar.style.display = 'none';
                    }
                    
                    // Restaurar el HTML del modal-body si fue modificado
                    if (modalBody.querySelector('.alert')) {
                        location.reload(); // Recargar para restaurar el modal
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = '<div class="alert alert-danger">Error al cargar los detalles. Por favor, intente nuevamente.</div>';
                });
        });
    });
    
    // Filtros rápidos
    document.querySelectorAll('.filtro-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filtro = this.dataset.filter;
            window.location.href = `<?= BASE_URL ?>/proveedor/consultar-reservas?filtro=${filtro}`;
        });
    });
    
    // Restaurar filtro activo basado en la URL
    const currentFilter = '<?= $filtro ?? 'all' ?>';
    document.querySelectorAll('.filtro-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === currentFilter) {
            btn.classList.add('active');
        }
    });
});

// Funciones de acción
function confirmarReserva(id) {
    if (confirm('¿Está seguro de confirmar esta reserva?\n\nUna vez confirmada, el turista será notificado y se esperará su asistencia.')) {
        window.location.href = `<?= BASE_URL ?>/proveedor/consultar-reservas?accion=confirmar&id=${id}`;
    }
}

function cancelarReserva(id) {
    if (confirm('¿Está seguro de cancelar esta reserva?\n\nEsta acción no se puede deshacer y el turista será notificado.')) {
        window.location.href = `<?= BASE_URL ?>/proveedor/consultar-reservas?accion=cancelar&id=${id}`;
    }
}

// Helper para formatear números (moneda colombiana)
function number_format(number, decimals, dec_point, thousands_sep) {
    if (typeof number === 'string') number = parseFloat(number);
    return new Intl.NumberFormat('es-CO', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(number);
}
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
