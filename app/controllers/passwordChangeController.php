<?php

require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/passwordChange.php';

class PasswordChangeController
{
    public function cambiarClave()
    {
        session_start();

        $clave_actual = $_POST['clave_actual'] ?? '';
        $clave_nueva  = $_POST['clave_nueva'] ?? '';
        $confirmar    = $_POST['confirmar'] ?? '';

        if (empty($clave_actual) || empty($clave_nueva) || empty($confirmar)) {
            mostrarSweetAlert('error', 'Campos vacíos', 'Completa todos los campos.');
            exit();
        }

        if ($clave_nueva !== $confirmar) {
            mostrarSweetAlert('error', 'Error', 'Las contraseñas no coinciden.');
            exit();
        }

        // Modelo
        $model = new PasswordChange();

        // Obtener clave actual
        $usuario = $model->obtenerClaveActual($_SESSION['user']['id_usuario']);

        if (!$usuario || !password_verify($clave_actual, $usuario['clave'])) {
            mostrarSweetAlert('error', 'Error', 'La contraseña actual es incorrecta.');
            exit();
        }

        // Actualizar
        $nueva_hash = password_hash($clave_nueva, PASSWORD_DEFAULT);

        // REGISTRO DE CAMBIO DE CONTRASEÑA (LOG)
        require_once BASE_PATH . '/config/database.php';
        $db = new conexion();
        $conexion = $db->getConexion();

        if ($model->actualizarClave($_SESSION['user']['id_usuario'], $nueva_hash)) {

            $id_usuario = $_SESSION['user']['id_usuario']; // confirma que este índice existe
            $ip = $_SERVER['REMOTE_ADDR'];

            $sqlLog = "INSERT INTO log_cambio_contrasena (id_usuario, ip)
           VALUES (:id_usuario, :ip)";

            $stmtLog = $conexion->prepare($sqlLog);
            $stmtLog->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmtLog->bindParam(':ip', $ip, PDO::PARAM_STR);
            $stmtLog->execute();

            mostrarSweetAlert(
                'success',
                'Listo',
                'Contraseña actualizada correctamente.',
                '/aventura_go/login'
            );
        } else {
            mostrarSweetAlert('error', 'Error', 'No se pudo actualizar la contraseña.');
        }

        exit();
    }
}
