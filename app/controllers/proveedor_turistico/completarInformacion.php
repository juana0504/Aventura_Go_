<?php

require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../../config/database.php';

$db = new conexion();
$conexion = $db->getConexion();

$idUsuario = $_SESSION['user']['id_usuario'];

/* =====================================
   SI ES POST → ACTUALIZAR INFORMACIÓN
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_empresa = $_POST['nombre_empresa'] ?? '';
    $nit_rut = $_POST['nit_rut'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $nombre_representante = $_POST['nombre_representante'] ?? '';
    $identificacion_representante = $_POST['identificacion_representante'] ?? '';
    $telefono_representante = $_POST['telefono_representante'] ?? '';
    $id_ciudad = $_POST['id_ciudad'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // Validación básica
    if (
        empty($nombre_empresa) ||
        empty($nit_rut) ||
        empty($email) ||
        empty($telefono) ||
        empty($direccion) ||
        empty($nombre_representante) ||
        empty($identificacion_representante) ||
        empty($telefono_representante) ||
        empty($id_ciudad) ||
        empty($tipo_documento) ||
        empty($departamento) ||
        empty($descripcion)


    ) {
        die("Todos los campos obligatorios deben completarse.");
    }

    // Procesar actividades para que aparezcan como una cadena separada por comas en la base de datos
    $actividadesArray = $_POST['actividades'] ?? [];
    $actividades = !empty($actividadesArray) ? implode(', ', $actividadesArray) : null;

    // Obtener datos actuales del proveedor
    $sqlActual = "SELECT logo, foto_representante FROM proveedor WHERE id_usuario = :id LIMIT 1";
    $stmtActual = $conexion->prepare($sqlActual);
    $stmtActual->bindParam(':id', $idUsuario, PDO::PARAM_INT);
    $stmtActual->execute();
    $proveedorActual = $stmtActual->fetch(PDO::FETCH_ASSOC);

    // Si el proveedor ya tiene logo o foto, mantenemos esos nombres para no perder la referencia si no se suben nuevos archivos
    $nombreLogo = $proveedorActual['logo'];
    $nombreFoto = $proveedorActual['foto_representante'];

    $permitidas = ['jpg', 'jpeg', 'png'];

    /* ============================
    LOGO
    ============================ */

    if (!empty($_FILES['logo']['name'])) {

        $logo = $_FILES['logo'];
        $extLogo = strtolower(pathinfo($logo['name'], PATHINFO_EXTENSION));

        if (!in_array($extLogo, $permitidas)) {
            die("Formato de logo no permitido.");
        }

        $nombreLogo = uniqid('logo_') . '.' . $extLogo;
        $rutaLogo = __DIR__ . '/../../../public/uploads/proveedores/' . $nombreLogo;

        move_uploaded_file($logo['tmp_name'], $rutaLogo);
    } elseif (empty($proveedorActual['logo'])) {
        die("Debes subir el logo.");
    }

    /* ============================
    FOTO REPRESENTANTE
    ============================ */

    if (!empty($_FILES['foto_representante']['name'])) {

        $foto = $_FILES['foto_representante'];
        $extFoto = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

        if (!in_array($extFoto, $permitidas)) {
            die("Formato de foto no permitido.");
        }

        $nombreFoto = uniqid('repre_') . '.' . $extFoto;
        $rutaFoto = __DIR__ . '/../../../public/uploads/proveedores/' . $nombreFoto;

        move_uploaded_file($foto['tmp_name'], $rutaFoto);
    } elseif (empty($proveedorActual['foto_representante'])) {
        die("Debes subir la foto del representante.");
    }

    $sqlUpdate = "
        UPDATE proveedor SET
            nombre_empresa = :nombre_empresa,
            nit_rut = :nit_rut,
            email = :email,
            telefono = :telefono,
            direccion = :direccion,
            nombre_representante = :nombre_representante,
            identificacion_representante = :identificacion_representante,
            telefono_representante = :telefono_representante,
            id_ciudad = :id_ciudad,
            tipo_documento = :tipo_documento,
            departamento = :departamento,
            actividades = :actividades,
            descripcion = :descripcion,
            logo = :logo,
            foto_representante = :foto_representante,
            estado = 'EN_REVISION'
        WHERE id_usuario = :id_usuario
    ";

    $stmt = $conexion->prepare($sqlUpdate);

    $stmt->bindParam(':nombre_empresa', $nombre_empresa);
    $stmt->bindParam(':nit_rut', $nit_rut);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':nombre_representante', $nombre_representante);
    $stmt->bindParam(':identificacion_representante', $identificacion_representante);
    $stmt->bindParam(':telefono_representante', $telefono_representante);
    $stmt->bindParam(':id_usuario', $idUsuario);
    $stmt->bindParam(':id_ciudad', $id_ciudad);
    $stmt->bindParam(':tipo_documento', $tipo_documento);
    $stmt->bindParam(':departamento', $departamento);
    $stmt->bindParam(':actividades', $actividades);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':logo', $nombreLogo);
    $stmt->bindParam(':foto_representante', $nombreFoto);

    if ($stmt->execute()) {

        header('Location: /aventura_go/proveedor/dashboard');
        exit;
    } else {
        die("Error al actualizar la información.");
    }
}

/* =====================================
   SI ES GET → CARGAR INFORMACIÓN
===================================== */

$sql = "SELECT p.*, u.email AS email_login
FROM proveedor p
JOIN usuario u ON p.id_usuario = u.id_usuario
WHERE p.id_usuario = :id
LIMIT 1";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/completar_informacion.php';
