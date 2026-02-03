<?php
require_once BASE_PATH . '/app/helpers/session_turista.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas | Turista</title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/assets/dashboard/administrador/perfil_usuario/img/FAVICON.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/layout_admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/buscador_turista.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/layouts/panel_turista.css">


    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/turista/ver_reservas/ver_reservas.css">


</head>

<body>

    <section id="turista-reservas">

        <?php require_once __DIR__ . '/../../layouts/turista_panel_izq.php'; ?>

        <div class="info">

            <?php require_once __DIR__ . '/../../layouts/buscador_turista.php'; ?>

            <div class="header-section">
                <h1>Mis Reservas</h1>
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

                <a href="<?= BASE_URL ?>/turista/pdf-actividades" class="btn-pdf" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>Generar Reportes
                </a>

            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Imagen</th>
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

                                            <!-- 1 Imagen + Actividad -->
                                            <td>
                                                <?php if (!empty($reserva['imagen'])): ?>
                                                    <img src="<?= BASE_URL ?>/public/uploads/turistico/actividades/<?= htmlspecialchars($reserva['imagen']) ?>">
                                                <?php endif; ?>
                                            </td>



                                            <td>
                                                <strong><?= htmlspecialchars($reserva['nombre_actividad']) ?></strong>
                                            </td>


                                            <!--3  Proveedor -->
                                            <td>
                                                <?= htmlspecialchars($reserva['proveedor']) ?>
                                            </td>

                                            <!--4  Fecha -->
                                            <td>
                                                <?= date('d/m/Y', strtotime($reserva['fecha'])) ?>
                                            </td>

                                            <!--5  Personas -->
                                            <td>
                                                <?= (int)$reserva['cantidad_personas'] ?>
                                            </td>

                                            <!-- 6  Total -->
                                            <td>
                                                <strong>
                                                    $<?= number_format($reserva['precio'], 0, ',', '.') ?>
                                                </strong>
                                            </td>

                                            <!--7  Estado -->
                                            <td>
                                                <?php
                                                $estado = $reserva['estado'];
                                                $clase =
                                                    $estado === 'pendiente' ? 'bg-warning text-dark' : ($estado === 'confirmada' ? 'bg-success' : ($estado === 'cancelada' ? 'bg-danger' : 'bg-secondary'));
                                                ?>
                                                <span class="badge <?= $clase ?>">
                                                    <?= ucfirst($estado) ?>
                                                </span>
                                            </td>

                                            <!--8  Acciones -->
                                            <td>


                                                <button
                                                    class="btn btn-sm btn-outline-primary btn-ver-reserva"
                                                    data-id="<?= $reserva['id_reserva'] ?>">
                                                    <i class="bi bi-eye"></i>
                                                    Ver
                                                </button>




                                            </td>

                                        </tr>

                                    <?php endforeach; ?>
                                <?php else: ?>

                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">
                                            <i class="bi bi-calendar-x" style="font-size:3rem"></i>
                                            <h5 class="mt-3">No tienes reservas registradas</h5>
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- MODAL DETALLE RESERVA -->
    <div class="modal fade" id="modalReserva" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header d-flex justify-content-between align-items-start">
                    <div>
                        <h5 id="modal-nombre-actividad"></h5>
                    </div>

                    <div class="text-end">
                        <span id="modal-estado" class="badge"></span><br>
                        <small id="modal-fecha-reserva" class="text-muted"></small>
                    </div>

                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <div class="row mb-4">

                        <!-- IMÁGENES -->
                        <div class="col-md-5 text-center">
                            <img id="modal-imagen-principal" class="img-fluid rounded mb-2">

                            <div id="modal-galeria" class="d-flex justify-content-center gap-2 flex-wrap">
                                <!-- miniaturas -->
                            </div>
                        </div>

                        <!-- INFO -->
                        <div class="col-md-7">
                            <p><strong>Proveedor:</strong> <span id="modal-proveedor"></span></p>
                            <p><strong>Fecha:</strong> <span id="modal-fecha"></span></p>
                            <p><strong>Personas:</strong> <span id="modal-personas"></span></p>
                            <p><strong>Total:</strong> $<span id="modal-total"></span></p>
                            <p><strong>Estado:</strong> <span id="modal-estado-texto"></span></p>
                        </div>

                    </div>

                    <hr>

                    <div>
                        <h6>Descripción</h6>
                        <p id="modal-descripcion"></p>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button id="btn-confirmar" class="btn btn-success">Confirmar</button>
                    <button id="btn-cancelar" class="btn btn-danger">Cancelar</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script>
        console.log('JS MODAL INLINE CARGADO');

        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('modalReserva');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.btn-ver-reserva').forEach(btn => {
                btn.addEventListener('click', function() {

                    const idReserva = this.dataset.id;
                    if (!idReserva) return;

                    fetch(`<?= BASE_URL ?>/turista/reserva-detalle?id=${idReserva}`)
                        .then(res => res.text())
                        .then(texto => {

                            const jsonLimpio = texto.substring(texto.indexOf('{'));
                            const data = JSON.parse(jsonLimpio);

                            // HEADER
                            document.getElementById('modal-nombre-actividad').textContent = data.nombre_actividad;
                            document.getElementById('modal-estado').textContent = data.estado;
                            document.getElementById('modal-fecha-reserva').textContent = data.fecha;

                            // INFO
                            document.getElementById('modal-proveedor').textContent = data.proveedor;
                            document.getElementById('modal-fecha').textContent = data.fecha;
                            document.getElementById('modal-personas').textContent = data.cantidad_personas;
                            document.getElementById('modal-total').textContent =
                                Number(data.precio).toLocaleString('es-CO');
                            document.getElementById('modal-estado-texto').textContent = data.estado;
                            document.getElementById('modal-descripcion').textContent = data.descripcion ?? '';

                            // IMÁGENES
                            const imgPrincipal = document.getElementById('modal-imagen-principal');
                            const galeria = document.getElementById('modal-galeria');
                            galeria.innerHTML = '';

                            if (data.imagenes && data.imagenes.length > 0) {
                                imgPrincipal.src =
                                    `<?= BASE_URL ?>/public/uploads/turistico/actividades/${data.imagenes[0].imagen}`;

                                data.imagenes.forEach(img => {
                                    const mini = document.createElement('img');
                                    mini.src =
                                        `<?= BASE_URL ?>/public/uploads/turistico/actividades/${img.imagen}`;
                                    mini.style.width = '60px';
                                    mini.style.cursor = 'pointer';
                                    mini.onclick = () => imgPrincipal.src = mini.src;
                                    galeria.appendChild(mini);
                                });
                            } else {
                                imgPrincipal.src = '';
                            }

                            // GUARDAR ID PARA ACCIONES
                            document.getElementById('btn-confirmar').dataset.id = data.id_reserva;
                            document.getElementById('btn-cancelar').dataset.id = data.id_reserva;

                            // MOSTRAR / OCULTAR BOTONES
                            if (data.estado === 'pendiente') {
                                document.getElementById('btn-confirmar').style.display = 'inline-block';
                                document.getElementById('btn-cancelar').style.display = 'inline-block';
                            } else {
                                document.getElementById('btn-confirmar').style.display = 'none';
                                document.getElementById('btn-cancelar').style.display = 'none';
                            }

                            modal.show();
                        });
                });
            });
        });

        // EVENTOS DE BOTONES DEL MODAL
        document.addEventListener('click', function(e) {

            if (e.target.id === 'btn-confirmar' || e.target.id === 'btn-cancelar') {

                const accion = e.target.id === 'btn-confirmar' ? 'confirmar' : 'cancelar';
                const idReserva = document.getElementById('btn-confirmar').dataset.id;
                if (!idReserva) return;

                fetch(`<?= BASE_URL ?>/turista/reserva-accion`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_reserva=${idReserva}&accion=${accion}`
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.ok) location.reload();
                    });
            }
        });
    </script> -->


    <script>
        console.log('JS MODAL INLINE CARGADO');

        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('modalReserva');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.btn-ver-reserva').forEach(btn => {
                btn.addEventListener('click', function() {

                    const idReserva = this.dataset.id;
                    if (!idReserva) return;

                    fetch(`<?= BASE_URL ?>/turista/reserva-detalle?id=${idReserva}`)
                        .then(res => res.text())
                        .then(texto => {

                            const jsonLimpio = texto.substring(texto.indexOf('{'));
                            const data = JSON.parse(jsonLimpio);

                            // HEADER
                            document.getElementById('modal-nombre-actividad').textContent = data.nombre_actividad;
                            document.getElementById('modal-estado').textContent = data.estado;
                            document.getElementById('modal-fecha-reserva').textContent = data.fecha;

                            // INFO
                            document.getElementById('modal-proveedor').textContent = data.proveedor;
                            document.getElementById('modal-fecha').textContent = data.fecha;
                            document.getElementById('modal-personas').textContent = data.cantidad_personas;
                            document.getElementById('modal-total').textContent =
                                Number(data.precio).toLocaleString('es-CO');
                            document.getElementById('modal-estado-texto').textContent = data.estado;
                            document.getElementById('modal-descripcion').textContent = data.descripcion ?? '';

                            // IMÁGENES
                            const imgPrincipal = document.getElementById('modal-imagen-principal');
                            const galeria = document.getElementById('modal-galeria');
                            galeria.innerHTML = '';

                            if (data.imagenes && data.imagenes.length > 0) {
                                imgPrincipal.src =
                                    `<?= BASE_URL ?>/public/uploads/turistico/actividades/${data.imagenes[0].imagen}`;

                                data.imagenes.forEach(img => {
                                    const mini = document.createElement('img');
                                    mini.src =
                                        `<?= BASE_URL ?>/public/uploads/turistico/actividades/${img.imagen}`;
                                    mini.style.width = '60px';
                                    mini.style.cursor = 'pointer';
                                    mini.onclick = () => imgPrincipal.src = mini.src;
                                    galeria.appendChild(mini);
                                });
                            } else {
                                imgPrincipal.src = '';
                            }

                            // 🔴 PASO 2 — AQUÍ EXACTAMENTE
                            document.getElementById('btn-confirmar').dataset.id = data.id_reserva;
                            document.getElementById('btn-cancelar').dataset.id = data.id_reserva;

                            // MOSTRAR / OCULTAR BOTONES
                            if (data.estado === 'pendiente') {
                                document.getElementById('btn-confirmar').style.display = 'inline-block';
                                document.getElementById('btn-cancelar').style.display = 'inline-block';
                            } else {
                                document.getElementById('btn-confirmar').style.display = 'none';
                                document.getElementById('btn-cancelar').style.display = 'none';
                            }

                            modal.show();
                        });
                });
            });
        });

        // ACCIONES DEL MODAL
        document.addEventListener('click', function(e) {

            if (e.target.id === 'btn-confirmar' || e.target.id === 'btn-cancelar') {

                const accion = e.target.id === 'btn-confirmar' ? 'confirmar' : 'cancelar';
                const idReserva = document.getElementById('btn-confirmar').dataset.id;

                if (!idReserva) return;

                fetch(`<?= BASE_URL ?>/turista/reserva-accion`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_reserva=${idReserva}&accion=${accion}`
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.ok) location.reload();
                    });
            }
        });
    </script>


    <!-- <script>
        console.log('JS MODAL INLINE CARGADO');

        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('modalReserva');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.btn-ver-reserva').forEach(btn => {

                btn.addEventListener('click', function() {

                    const idReserva = this.dataset.id;
                    if (!idReserva) return;

                    fetch(`<?= BASE_URL ?>/turista/reserva-detalle?id=${idReserva}`)
                        .then(res => res.text())
                        .then(texto => {

                            const jsonLimpio = texto.substring(texto.indexOf('{'));
                            const data = JSON.parse(jsonLimpio);

                            // HEADER
                            document.getElementById('modal-nombre-actividad').textContent = data.nombre_actividad;
                            document.getElementById('modal-estado').textContent = data.estado;
                            document.getElementById('modal-fecha-reserva').textContent = data.fecha;

                            // INFO
                            document.getElementById('modal-proveedor').textContent = data.proveedor;
                            document.getElementById('modal-fecha').textContent = data.fecha;
                            document.getElementById('modal-personas').textContent = data.cantidad_personas;
                            document.getElementById('modal-total').textContent =
                                Number(data.precio).toLocaleString('es-CO');
                            document.getElementById('modal-estado-texto').textContent = data.estado;
                            document.getElementById('modal-descripcion').textContent = data.descripcion ?? '';

                            // IMÁGENES
                            const imgPrincipal = document.getElementById('modal-imagen-principal');
                            const galeria = document.getElementById('modal-galeria');
                            galeria.innerHTML = '';

                            if (data.imagenes && data.imagenes.length > 0) {
                                imgPrincipal.src =
                                    `<?= BASE_URL ?>/public/uploads/turistico/actividades/${data.imagenes[0].imagen}`;

                                data.imagenes.forEach(img => {
                                    const mini = document.createElement('img');
                                    mini.src =
                                        `<?= BASE_URL ?>/public/uploads/turistico/actividades/${img.imagen}`;
                                    mini.style.width = '60px';
                                    mini.style.cursor = 'pointer';
                                    mini.onclick = () => imgPrincipal.src = mini.src;
                                    galeria.appendChild(mini);
                                });
                            } else {
                                imgPrincipal.src = '';
                            }

                            // GUARDAR ID
                            const btnConfirmar = document.getElementById('btn-confirmar');
                            const btnCancelar = document.getElementById('btn-cancelar');

                            // Reset
                            btnConfirmar.style.display = 'none';
                            btnCancelar.style.display = 'none';

                            // Reglas de negocio
                            if (data.estado === 'pendiente') {
                                btnConfirmar.style.display = 'inline-block';
                                btnCancelar.style.display = 'inline-block';
                            }

                            if (data.estado === 'confirmada') {
                                btnCancelar.style.display = 'inline-block';
                            }

                            // cancelada → no muestra ningún botón (fin)

                            modal.show();
                        });
                });
            });
        });

        // ACCIONES CONFIRMAR / CANCELAR
        document.addEventListener('click', function(e) {

            if (e.target.id === 'btn-confirmar' || e.target.id === 'btn-cancelar') {

                const accion = e.target.id === 'btn-confirmar' ? 'confirmar' : 'cancelar';
                const idReserva = document.getElementById('btn-confirmar').dataset.id;
                if (!idReserva) return;

                fetch(`<?= BASE_URL ?>/turista/reserva-accion`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_reserva=${idReserva}&accion=${accion}`
                    })
                    .then(res => res.json())
                    .then(resp => {

                        if (resp.ok) {

                            // 🔥 CAMBIAR ESTADO EN MODAL
                            document.getElementById('modal-estado').textContent = accion === 'confirmar' ?
                                'confirmada' :
                                'cancelada';

                            document.getElementById('modal-estado-texto').textContent = accion === 'confirmar' ?
                                'confirmada' :
                                'cancelada';

                            // 🔥 CAMBIAR ESTADO EN LA TABLA
                            const fila = document.querySelector(
                                `.btn-ver-reserva[data-id="${idReserva}"]`
                            )?.closest('tr');

                            if (fila) {
                                const celdaEstado = fila.querySelector('td:nth-child(7)');
                                if (celdaEstado) {
                                    celdaEstado.textContent = accion === 'confirmar' ?
                                        'Confirmada' :
                                        'Cancelada';
                                }
                            }

                            // 🔥 CERRAR MODAL
                            bootstrap.Modal.getInstance(
                                document.getElementById('modalReserva')
                            ).hide();
                        }
                    });
            }
        });
    </script> -->




    <!-- <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>

    <script src="<?= BASE_URL ?>/public/assets/dashboard/turista/ver_reservas/modal_reserva.js"></script> -->



</body>

</html>