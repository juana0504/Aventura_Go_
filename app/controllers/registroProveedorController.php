<?php

require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/login.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre         = $_POST['nombre'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';
    $genero         = $_POST['genero'] ?? '';
    $telefono       = $_POST['telefono'] ?? '';
    $email          = $_POST['email'] ?? '';
    $clave          = $_POST['clave'] ?? '';

    if (
        empty($nombre) ||
        empty($tipo_documento) ||
        empty($identificacion) ||
        empty($genero) ||
        empty($telefono) ||
        empty($email) ||
        empty($clave)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos.');
        exit();
    }

    $db = new conexion();
    $conexion = $db->getConexion();

    // Verificar si email ya existe
    $sqlCheck = "SELECT u.id_usuario, p.id_proveedor
                 FROM usuario u
                 LEFT JOIN proveedor p ON p.id_usuario = u.id_usuario
                 WHERE u.email = :email LIMIT 1";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();
    $existing = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Registro huérfano: usuario existe pero sin proveedor (fallo previo)
        if (empty($existing['id_proveedor'])) {
            // Completar el registro creando el proveedor faltante
            $idUsuario = $existing['id_usuario'];
            $sqlProveedor = "
                INSERT INTO proveedor
                    (id_usuario, estado, validado, nombre_empresa, nit_rut, email, telefono,
                     direccion, nombre_representante, tipo_documento, identificacion_representante,
                     telefono_representante, id_ciudad, departamento, actividades, descripcion,
                     logo, foto_representante)
                VALUES
                    (:id_usuario, 'PENDIENTE', 0, '', '', '', '', '', '', '', '', '',
                     (SELECT MIN(id_ciudad) FROM ciudades), '', '', '', '', '')
            ";
            $stmtP = $conexion->prepare($sqlProveedor);
            $stmtP->bindParam(':id_usuario', $idUsuario);
            $stmtP->execute();
            mostrarSweetAlert(
                'success',
                'Registro completado',
                'Tu cuenta ya existía. El registro fue completado correctamente.',
                BASE_URL . 'login'
            );
        } else {
            mostrarSweetAlert('error', 'Correo duplicado', 'El correo ya está registrado.');
        }
        exit();
    }

    // Subida de foto
    $foto_url = 'default_proveedor.png';

    // if (!empty($_FILES['foto']['name'])) {
    //     $file = $_FILES['foto'];
    //     $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    //     $permitidas = ['png', 'jpg', 'jpeg'];

    //     if (!in_array($ext, $permitidas)) {
    //         mostrarSweetAlert('error', 'Extensión no permitida', 'Solo PNG, JPG y JPEG.');
    //         exit();
    //     }

    //     if ($file['size'] > 2 * 1024 * 1024) {
    //         mostrarSweetAlert('error', 'Archivo muy pesado', 'Máximo 2MB.');
    //         exit();
    //     }

    //     $foto_url = uniqid('proveedor_') . '.' . $ext;
    //     $destino = BASE_PATH . "/public/uploads/usuario/" . $foto_url;
    //     move_uploaded_file($file['tmp_name'], $destino);
    // }

    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    $sqlInsert = "
        INSERT INTO usuario 
        (nombre, identificacion, tipo_documento, genero, telefono, email, clave, rol, estado, foto, intentos_fallidos)
        VALUES
        (:nombre, :identificacion, :tipo_documento, :genero, :telefono, :email, :clave, 'proveedor', 'activo', :foto, 0)
    ";

    $stmtInsert = $conexion->prepare($sqlInsert);

    $stmtInsert->bindParam(':nombre', $nombre);
    $stmtInsert->bindParam(':identificacion', $identificacion);
    $stmtInsert->bindParam(':tipo_documento', $tipo_documento);
    $stmtInsert->bindParam(':genero', $genero);
    $stmtInsert->bindParam(':telefono', $telefono);
    $stmtInsert->bindParam(':email', $email);
    $stmtInsert->bindParam(':clave', $claveHash);
    $stmtInsert->bindParam(':foto', $foto_url);

    $conexion->beginTransaction();
    try {
        $stmtInsert->execute();
        $idUsuario = $conexion->lastInsertId();

        $sqlProveedor = "
            INSERT INTO proveedor
                (id_usuario, estado, validado, nombre_empresa, nit_rut, email, telefono,
                 direccion, nombre_representante, tipo_documento, identificacion_representante,
                 telefono_representante, id_ciudad, departamento, actividades, descripcion,
                 logo, foto_representante)
            VALUES
                (:id_usuario, 'PENDIENTE', 0, '', '', '', '', '', '', '', '', '',
                 (SELECT MIN(id_ciudad) FROM ciudades), '', '', '', '', '')
        ";

        $stmtProveedor = $conexion->prepare($sqlProveedor);
        $stmtProveedor->bindParam(':id_usuario', $idUsuario);

        if (!$stmtProveedor->execute()) {
            mostrarSweetAlert('error', 'Error interno', 'No se pudo crear el perfil de proveedor. Intenta de nuevo.');
            exit();
        }

        $conexion->commit();

        mostrarSweetAlert(
            'success',
            'Registro exitoso',
            'Tu registro fue enviado correctamente. En un plazo de 7 días hábiles validaremos tu información.',
            BASE_URL . 'login'
        );
    } catch (Exception $e) {
        $conexion->rollBack();
        mostrarSweetAlert('error', 'Error interno', 'No se pudo completar el registro. Intenta de nuevo.');
    }
}
