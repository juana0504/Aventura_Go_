<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Proveedores Hoteleros - Aventura Go</title>

    <style>
        body {
            margin: 30px;
        }

        /* Encabezado */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .header img {
            width: 120px;
        }

        h1 {
            color: #2D4059;
            font-size: 22px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        p {
            color: #000000;
            font-size: 12px;
            margin-bottom: 25px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 15px;
        }

        table th {
            background-color: #f0f0f0;
            padding: 8px;
            color: #2D4059;
            border: 1px solid #ddd;
            text-align: left;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .foto {
            width: 45px;
            height: auto;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Encabezado -->
    <div class="header">
        <img src="<?= BASE_URL ?>/public/assets/estilos_globales/img/LOGO-FINAL.png" alt="Logo Aventura Go">
    </div>

    <h1>Reporte de Proveedores Hoteleros Inscritos</h1>

    <p>
        El presente documento contiene el registro consolidado de los proveedores inscritos en Aventura Go. Este reporte
        permite evaluar la participación de prestadores turísticos, analizar el crecimiento de la plataforma y mantener
        actualizada la información relevante para la gestión administrativa.
    </p>

    <!-- Tabla de Proveedores -->
    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Empresa</th>
                <th>Establecimiento</th>
                <th>Habitaciones</th>
                <th>Calificacion</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($hoteles)) : ?>
                <?php foreach ($hoteles as $hotelero): ?>
                    <tr>
                        <td><img src="<?= BASE_URL ?>/public/uploads/hoteles/<?= $hotelero['foto'] ?>" width="50px"></td>
                        <td><?= $hotelero['nombre_establecimiento'] ?></td>
                        <td><?= $hotelero['tipo_establecimiento'] ?></td>
                        <td><?= $hotelero['numero_habitaciones'] ?></td>
                        <td><?= $hotelero['calificacion_promedio'] ?></td>
                        <td><span class="badge-activo">Activo</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No hay proveedores registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>

    <!-- Footer -->
    <footer>
        © Aventura Go 2025 - Todos los derechos reservados
    </footer>

</body>

</html>