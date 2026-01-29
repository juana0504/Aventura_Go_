<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas | Turista</title>

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">

    <!-- CSS propio de ver reservas turista -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/proveedor_turistico/consultar_actividad_turistica/consultar_actividad_turistica.css">
</head>

<body>

<section id="turista-reservas">

    <!-- Panel lateral -->
    <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

    <!-- Contenido principal -->
    <div class="info">

        <!-- Buscador superior -->
        <?php require_once __DIR__ . '/../../layouts/buscador_turista.php'; ?>

        <!-- Header -->
        <div class="header-section">
            <h1>Mis Reservas</h1>
           
        </div>

        <!-- Estadísticas -->
        <?php if (isset($estadisticas) && $estadisticas): ?>
        <div class="row mb-4" data-aos="fade-up">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                        <h5 class="card-title mt-2"><?= number_format($estadisticas['total_reservas'] ?? 0) ?></h5>
                        <p class="card-text small text-muted">Total Reservas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                        <h5 class="card-title mt-2"><?= number_format($estadisticas['pendientes'] ?? 0) ?></h5>
                        <p class="card-text small text-muted">Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <h5 class="card-title mt-2"><?= number_format($estadisticas['confirmadas'] ?? 0) ?></h5>
                        <p class="card-text small text-muted">Confirmadas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center border-info">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar text-info" style="font-size: 2rem;"></i>
                        <h5 class="card-title mt-2">$<?= number_format($estadisticas['total_invertido'] ?? 0, 0, ',', '.') ?></h5>
                        <p class="card-text small text-muted">Invertido Total</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Filtros Rápidos -->
        <div class="filtros-rapidos" data-aos="fade-up">
            <button class="filtro-btn active" data-filter="all">
                <i class="bi bi-grid"></i> Todas
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
            <button class="filtro-btn" data-filter="completada">
                <i class="bi bi-check-all"></i> Completadas
            </button>
            <a href="<?= BASE_URL ?>/turista/pdf-reservas?filtro=<?= urlencode($filtro ?? 'all') ?>" class="btn-pdf" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i>Generar Reportes
            </a>
        </div>

        <!-- Tabla -->
        <div class="card shadow-sm mt-4" data-aos="fade-up">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Actividad</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Personas</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($reservas)): ?>
                                <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($reserva['imagen']): ?>
                                            <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= $reserva['imagen'] ?>" 
                                                 alt="Actividad" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                            <div class="rounded me-3 bg-secondary" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-image text-white"></i>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= htmlspecialchars($reserva['nombre_actividad']) ?></strong>
                                                <br><small class="text-muted"><?= htmlspecialchars($reserva['nombre_ciudad']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($reserva['nombre_empresa']) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($reserva['email_representante']) ?></small>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($reserva['fecha'])) ?>
                                        <br><small class="text-muted"><?= date('H:i', strtotime($reserva['created_at'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <strong><?= $reserva['cantidad_personas'] ?></strong>
                                    </td>
                                    <td class="text-end">
                                        <strong>$<?= number_format($reserva['precio'] * $reserva['cantidad_personas'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php
                                        $estadoClass = $reserva['estado'] === 'pendiente' ? 'bg-warning text-dark' : 
                                                      ($reserva['estado'] === 'confirmada' ? 'bg-success' : 
                                                       ($reserva['estado'] === 'cancelada' ? 'bg-danger' : 'bg-primary'));
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
                                        <?php if (in_array($reserva['estado'], ['pendiente', 'confirmada'])): ?>
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
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                                        <br><h5 class="mt-3">No tienes reservas registradas</h5>
                                        <p>Explora nuestras actividades turísticas y comienza a reservar</p>
                                        <a href="<?= BASE_URL ?>/descubre-tours" class="btn btn-primary">
                                            <i class="bi bi-compass"></i> Explorar Actividades
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Actividades Populares -->
        <?php if (!empty($actividades_populares) && count($actividades_populares) > 0): ?>
        <div class="card shadow-sm mt-4" data-aos="fade-up">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-star text-warning"></i> Tus Actividades Favoritas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($actividades_populares as $actividad): ?>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-trophy text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong><?= htmlspecialchars($actividad['nombre_actividad']) ?></strong>
                                <br><small class="text-muted">Reservada <?= $actividad['veces_reservada'] ?> veces</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

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
                        <p><strong>Actividad:</strong> <span id="modal-actividad"></span></p>
                        <p><strong>Descripción:</strong> <span id="modal-descripcion"></span></p>
                        <p><strong>Ubicación:</strong> <span id="modal-ubicacion"></span></p>
                        <p><strong>Ciudad:</strong> <span id="modal-ciudad"></span></p>
                        <p><strong>Fecha Actividad:</strong> <span id="modal-fecha"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Proveedor:</strong> <span id="modal-proveedor"></span></p>
                        <p><strong>Email Proveedor:</strong> <span id="modal-email-proveedor"></span></p>
                        <p><strong>Teléfono Proveedor:</strong> <span id="modal-telefono-proveedor"></span></p>
                        <p><strong>Personas:</strong> <span id="modal-personas"></span></p>
                        <p><strong>Precio Unitario:</strong> $<span id="modal-precio"></span></p>
                        <p><strong>Total:</strong> $<span id="modal-total"></span></p>
                        <p><strong>Estado:</strong> <span id="modal-estado"></span></p>
                    </div>
                </div>
                <div>
                    <strong>Dirección del Proveedor:</strong>
                    <p id="modal-direccion"></p>
                </div>
                <div>
                    <strong>Fecha de Reserva:</strong>
                    <p id="modal-fecha-reserva"></p>
                </div>
            </div>

            <div class="modal-footer">
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
            
            fetch(`<?= BASE_URL ?>/turista/reserva-detalle?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        modalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        return;
                    }
                    
                    const r = data.data;
                    
                    // Restaurar el contenido original del modal
                    document.getElementById('modal-id').textContent = r.id_reserva;
                    document.getElementById('modal-actividad').textContent = r.nombre_actividad;
                    document.getElementById('modal-descripcion').textContent = r.descripcion_actividad || 'Sin descripción';
                    document.getElementById('modal-ubicacion').textContent = r.ubicacion;
                    document.getElementById('modal-ciudad').textContent = r.nombre_ciudad + ', ' + r.nombre_departamento;
                    document.getElementById('modal-fecha').textContent = r.fecha;
                    document.getElementById('modal-proveedor').textContent = r.nombre_empresa;
                    document.getElementById('modal-email-proveedor').textContent = r.email_representante;
                    document.getElementById('modal-telefono-proveedor').textContent = r.telefono_representante || 'No disponible';
                    document.getElementById('modal-personas').textContent = r.cantidad_personas;
                    document.getElementById('modal-precio').textContent = number_format(r.precio, 0, ',', '.');
                    document.getElementById('modal-total').textContent = number_format(r.total, 0, ',', '.');
                    document.getElementById('modal-estado').textContent = r.estado;
                    document.getElementById('modal-direccion').textContent = r.direccion || 'No disponible';
                    document.getElementById('modal-fecha-reserva').textContent = new Date(r.created_at).toLocaleString('es-CO');
                    
                    // Configurar botón de cancelar según el estado
                    const btnCancelar = document.getElementById('btn-cancelar-modal');
                    
                    if (r.estado === 'pendiente' || r.estado === 'confirmada') {
                        btnCancelar.style.display = 'inline-block';
                        btnCancelar.onclick = () => cancelarReserva(r.id_reserva);
                    } else {
                        btnCancelar.style.display = 'none';
                    }
                    
                    // Restaurar el HTML del modal-body si fue modificado
                    if (modalBody.querySelector('.alert')) {
                        location.reload();
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
            window.location.href = `<?= BASE_URL ?>/turista/ver-reservas?filtro=${filtro}`;
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

// Función de acción
function cancelarReserva(id) {
    if (confirm('¿Está seguro de cancelar esta reserva?\n\nEsta acción no se puede deshacer y el proveedor será notificado.')) {
        window.location.href = `<?= BASE_URL ?>/turista/ver-reservas?accion=cancelar&id=${id}`;
    }
}



// Helper para formatear números
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
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

</body>
</html>