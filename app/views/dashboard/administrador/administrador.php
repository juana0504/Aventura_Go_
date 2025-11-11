<!-- // AQUI VA EL HEADER -->
<?php
include_once __DIR__ . '/../../layouts/header_administrador.php';
?>


<body>
    <section id="listado">

        <!-- // AQUI VA EL MENU -->
        <?php
        include_once __DIR__ . '/../../layouts/panel-izq_administrador.php';
        ?>


        <div class="info">
            <!-- // AQUI VA EL buscador -->
            <?php
            include_once __DIR__ . '/../../layouts/buscador_administrador.php';
            ?>

            <!-- Contenedor principal del dashboard -->
            <div class="dashboard-content">
                <main class="main-content">
                    <!-- Tarjetas de resumen -->
                    <section class="summary-cards">
                        <div class="card-item">
                            <i class="bi bi-graph-up-arrow"></i>
                            <div>
                                <p>Total de Reservas</p>
                                <h3>2,780</h3>
                            </div>
                        </div>

                        <div class="card-item green">
                            <i class="bi bi-person-circle"></i>
                            <div>
                                <p>Reservas Diarias</p>
                                <h3>421</h3>
                            </div>
                        </div>

                        <div class="card-item blue">
                            <i class="bi bi-globe-central-south-asia-fill"></i>
                            <div>
                                <p>Experiencias Activas</p>
                                <h3>548</h3>
                            </div>
                        </div>

                        <div class="card-item purple">
                            <i class="bi bi-tencent-qq"></i>
                            <div>
                                <p>Inversión en Publicidad</p>
                                <h3>$219.0</h3>
                            </div>
                        </div>
                    </section>

                    <!-- Resumen de reservas -->
                    <section class="resumen-reservas">
                        <div class="resumen-header">
                            <h3>Resumen de reservas</h3>
                            <button class="btn-filtrar">Filtrar ▼</button>
                        </div>

                        <div class="grafico-container">
                            <canvas id="reservasChart"></canvas>
                        </div>
                    </section>


                    <!-- Última reserva -->
                    <section class="ultima-reserva bg-light p-3 rounded mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold">Última Reserva</h6>
                            <button class="btn btn-sm text-white">Filtrar</button>
                        </div>
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Precio</th>
                                    <th>Experiencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juan Perez</td>
                                    <td>12-Jul-2025</td>
                                    <td>Ruta Ecológica</td>
                                    <td>Rafting</td>
                                </tr>
                                <tr>
                                    <td>Pepito Mahecha</td>
                                    <td>12-Jul-2025</td>
                                    <td>Ruta Ecológica</td>
                                    <td>Rafting</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </main>

                <!-- Panel derecho -->
                <aside class="summary-panel">
                    <div class="ingresos">
                        <h4>$9,470</h4>
                        <p>Ingresos Disponibles</p>
                        <ul>
                            <li>Reservas: $1,699</li>
                            <li>Comisiones: $799</li>
                            <li>Impuestos: $199</li>
                        </ul>
                        <button>Generar tarjeta digital</button>
                    </div>

                    <div class="pagos">
                        <h6>Próximos Pagos</h6>
                        <ul>
                            <li><span class="dot green_r"></span> Pago Experiencia <span class="amount">$2,852.21</span>
                            </li>
                            <li><span class="dot blue_r"></span> Pago a operador <span class="amount">$910.00</span></li>
                            <li><span class="dot red_r"></span> Pago de reserva <span class="amount">$420.30</span></li>
                        </ul>
                    </div>

                    <div class="gastos">
                        <h6>Estado de Gastos</h6>
                        <canvas id="gastosChart"></canvas>
                    </div>
                </aside>
            </div>

        </div>

    </section>
    <!-- // AQUI VA EL FOOTER -->
    <?php
    include_once __DIR__ . '/../../layouts/footer_administrador.php';
    ?>
</body>

</html>