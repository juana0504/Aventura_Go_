<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Actividades turisticas - Aventura Go</title>

    <style>
        /* Fuentes */
        @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap');

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
            font-family: 'Raleway', sans-serif;
        }

        p {
            color: #000000;
            font-size: 12px;
            margin-bottom: 25px;
            font-family: 'Lato', sans-serif;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 15px;
        }

        table th {
            background-color: #2D4059;
            color: #ffffff;
            font-weight: 700;
            font-family: 'Lato', sans-serif;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
            padding: 15px 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-family: 'Lato', sans-serif;
        }

        .foto {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
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

    <h1>Listado de Actividades Turísticas</h1>

    <p>
        El presente documento contiene el registro consolidado de lass actividades turisticas inscritas en Aventura Go. Este reporte
        permite evaluar la participación de prestadores turísticos, analizar el crecimiento de la plataforma y mantener
        actualizada la información relevante para la gestión administrativa.
    </p>

    <!-- Tabla de Proveedores -->
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Ubicacion</th>
                <th>Cupos</th>
                <th>Precio</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($actividades)) : ?>
                <?php foreach ($actividades as $actividad) : ?>
                    <tr>
                        <!-- <td>
                            <img class="foto"
                                src="<?= BASE_URL ?>/public/uploads/turistico/actividades<?= $actividad['logo'] ?>">
                        </td> -->

                        <td><?= $actividad['nombre'] ?></td>
                        <td><?= $actividad['ciudad'] ?></td>
                        <td><?= $actividad['ubicacion'] ?></td>
                        <td><?= $actividad['cupos'] ?></td>
                        <td>$<?= number_format($actividad['precio'], 0) ?></td>
                        <td><?= $actividad['estado'] ?></td>

                        <!-- <td>Activo</td> -->

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay actividades registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <footer>
        © Aventura Go <?= date('Y') ?> - Todos los derechos reservados
    </footer>

</body>

</html>