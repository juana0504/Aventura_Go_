<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Turistas - Aventura Go</title>

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

    <h1>Reporte de Turistas Inscritos</h1>

    <p>
        El presente documento contiene el registro consolidado de los Turistas inscritos en Aventura Go. Este reporte
        permite evaluar la participación de prestadores turísticos, analizar el crecimiento de la plataforma y mantener
        actualizada la información relevante para la gestión administrativa.
    </p>

    <!-- Tabla de Turistas -->
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($turistas)) : ?>
                <?php foreach ($turistas as $turista) : ?>
                    <tr>
                        <td>
                            <img class="foto"
                                src="<?= BASE_URL ?>/public/uploads/usuario/<?= $turista['foto'] ?>">
                        </td>

                        <td><?= $turista['nombre'] ?></td>
                        <td><?= $turista['genero'] ?></td>
                        <td><?= $turista['telefono'] ?></td>
                        <td><?= $turista['email'] ?></td>
                        <td><?= $turista['estado'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay proveedores registrados.</td>
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