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
        $usuario = $model->obtenerClaveActual($_SESSION['user']['id']);

        if (!$usuario || !password_verify($clave_actual, $usuario['clave'])) {
            mostrarSweetAlert('error', 'Error', 'La contraseña actual es incorrecta.');
            exit();
        }

        // Actualizar
        $nueva_hash = password_hash($clave_nueva, PASSWORD_DEFAULT);

        if ($model->actualizarClave($_SESSION['user']['id'], $nueva_hash)) {
            mostrarSweetAlert('success', 'Listo', 'Contraseña actualizada correctamente.', '/aventura_go/login');
        } else {
            mostrarSweetAlert('error', 'Error', 'No se pudo actualizar la contraseña.');
        }

        exit();
    }
}
