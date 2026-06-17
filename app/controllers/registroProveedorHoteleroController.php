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
    $sqlCheck = "SELECT u.id_usuario, ph.id_proveedor_hotelero
                 FROM usuario u
                 LEFT JOIN proveedor_hotelero ph ON ph.id_usuario = u.id_usuario
                 WHERE u.email = :email LIMIT 1";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();
    $existing = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if (empty($existing['id_proveedor_hotelero'])) {
            $idUsuario = $existing['id_usuario'];
            $sqlPH = "
                INSERT INTO proveedor_hotelero
                    (id_usuario, logo, nombre_establecimiento, email, telefono, tipo_establecimiento,
                     nombre_representante, tipo_documento, identificacion_representante, foto_representante,
                     email_representante, telefono_representante, departamento, id_ciudad, direccion,
                     tipo_habitacion, max_huesped, servicio_incluido, nit_rut, camara_comercio,
                     licencia, metodo_pago, estado)
                VALUES
                    (:id_usuario, '', '', '', '', '', '', '', '', '', '', '', '',
                     (SELECT MIN(id_ciudad) FROM ciudades), '', '', 0, '', '', '', '', '', 'PENDIENTE')
            ";
            $stmtPH = $conexion->prepare($sqlPH);
            $stmtPH->bindParam(':id_usuario', $idUsuario);
            $stmtPH->execute();
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

    $foto_url = 'default_proveedor.png';

    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    $sqlInsert = "
        INSERT INTO usuario
        (nombre, identificacion, tipo_documento, genero, telefono, email, clave, rol, estado, foto, intentos_fallidos)
        VALUES
        (:nombre, :identificacion, :tipo_documento, :genero, :telefono, :email, :clave, 'proveedor_hotelero', 'activo', :foto, 0)
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

        $sqlProveedor_hotelero = "
            INSERT INTO proveedor_hotelero
                (id_usuario, logo, nombre_establecimiento, email, telefono, tipo_establecimiento,
                 nombre_representante, tipo_documento, identificacion_representante, foto_representante,
                 email_representante, telefono_representante, departamento, id_ciudad, direccion,
                 tipo_habitacion, max_huesped, servicio_incluido, nit_rut, camara_comercio,
                 licencia, metodo_pago, estado)
            VALUES
                (:id_usuario, '', '', '', '', '', '', '', '', '', '', '', '',
                 (SELECT MIN(id_ciudad) FROM ciudades), '', '', 0, '', '', '', '', '', 'PENDIENTE')
        ";
        $stmtProveedor_hotelero = $conexion->prepare($sqlProveedor_hotelero);
        $stmtProveedor_hotelero->bindParam(':id_usuario', $idUsuario);
        $stmtProveedor_hotelero->execute();

        $conexion->commit();

        mostrarSweetAlert(
            'success',
            'Registro exitoso',
            'Tu registro fue enviado correctamente. En un plazo de 7 días hábiles validaremos tu información.',
            BASE_URL . 'login'
        );
    } catch (Exception $e) {
        $conexion->rollBack();
        error_log('registroProveedorHotelero error: ' . $e->getMessage());
        mostrarSweetAlert('error', 'Error interno', 'No se pudo completar el registro. Intenta de nuevo.');
    }
}
