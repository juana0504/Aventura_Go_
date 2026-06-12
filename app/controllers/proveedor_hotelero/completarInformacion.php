<?php

require_once BASE_PATH . '/app/helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/ProveedorModel.php';
require_once __DIR__ . '/../../helpers/upload_helper.php';

$model = new ProveedorModel();
$idUsuario = $_SESSION['user']['id_usuario'];

class CompletarInformacionController
{
    private $model;
    private $idUsuario;

    public function __construct($model, $idUsuario)
    {
        $this->model = $model;
        $this->idUsuario = $idUsuario;
    }

    // =========================================
    // PROCESAR FORMULARIO
    // =========================================
    public function procesarFormulario()
    {

        // =========================
        // DATOS DEL FORMULARIO
        // =========================

        $nombre_establecimiento = $_POST['nombre_establecimiento'] ?? '';
        $nit_rut = $_POST['nit_rut'] ?? '';
        $departamento = $_POST['departamento'] ?? '';
        $direccion = $_POST['direccion'] ?? '';

        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        $nombre_representante = $_POST['nombre_representante'] ?? '';
        $identificacion_representante = $_POST['identificacion_representante'] ?? '';
        $telefono_representante = $_POST['telefono_representante'] ?? '';

        $id_ciudad = $_POST['id_ciudad'] ?? '';

        $tipo_documento = $_POST['tipo_documento'] ?? '';
        $tipo_establecimiento = $_POST['tipo_establecimiento'] ?? '';
        $tipo_habitacion_raw = $_POST['tipo_habitacion'] ?? [];
        $tipo_habitacion = is_array($tipo_habitacion_raw)
            ? implode(',', array_filter($tipo_habitacion_raw))
            : $tipo_habitacion_raw;

        $max_huesped = $_POST['max_huesped'] ?? '';

        $metodo_pago_raw = $_POST['metodo_pago'] ?? [];
        $metodo_pago = is_array($metodo_pago_raw)
            ? implode(',', array_filter($metodo_pago_raw))
            : $metodo_pago_raw;

        $servicio_incluido_raw = $_POST['servicio_incluido'] ?? [];
        $servicio_incluido = is_array($servicio_incluido_raw)
            ? implode(',', array_filter($servicio_incluido_raw))
            : $servicio_incluido_raw;

        // =========================
        // VALIDAR CAMPOS
        // =========================

        if (
            empty($nombre_establecimiento) ||
            empty($nit_rut) ||
            empty($departamento) ||
            empty($direccion) ||
            empty($email) ||
            empty($telefono) ||
            empty($nombre_representante) ||
            empty($identificacion_representante) ||
            empty($telefono_representante) ||
            empty($id_ciudad) ||
            empty($tipo_documento) ||
            empty($tipo_establecimiento) ||
            empty($tipo_habitacion) ||
            empty($max_huesped) ||
            empty($metodo_pago) ||
            empty($servicio_incluido)
        ) {

            mostrarSweetAlert(
                'error',
                'Campos incompletos',
                'Por favor completa todos los campos obligatorios.',
                BASE_URL . 'proveedor_hotelero/completar-informacion'
            );

            exit;
        }

        // =========================================
        // OBTENER ARCHIVOS ACTUALES
        // =========================================

        $proveedorActual = $this->model->obtenerArchivosActuales($this->idUsuario);

        $nombreLogo = $proveedorActual['logo'] ?? null;
        $nombreFoto = $proveedorActual['foto_representante'] ?? null;

        // Cámara de comercio y licencia son números de registro (texto)
        $nombreCamara   = $_POST['camara_comercio'] ?? '';
        $nombreLicencia = $_POST['licencia'] ?? '';

        // =========================================
        // SUBIR LOGO
        // =========================================

        $nuevoLogo = subirArchivo(
            $_FILES['logo'] ?? [],
            'hotelero/hospedaje',
            'logo_'
        );

        if ($nuevoLogo) {
            $nombreLogo = $nuevoLogo;
        } elseif (empty($nombreLogo)) {
            mostrarSweetAlert(
                'error',
                'Logo requerido',
                'Debes subir el logo del establecimiento en el paso 1.',
                BASE_URL . 'proveedor_hotelero/completar-informacion'
            );
            exit;
        }

        // =========================================
        // SUBIR FOTO REPRESENTANTE
        // =========================================

        $nuevaFoto = subirArchivo(
            $_FILES['foto_representante'] ?? [],
            'hotelero/hospedaje',
            'repre_'
        );

        if ($nuevaFoto) {
            $nombreFoto = $nuevaFoto;
        } elseif (empty($nombreFoto)) {
            mostrarSweetAlert(
                'error',
                'Foto requerida',
                'Debes subir la foto del representante en el paso 4.',
                BASE_URL . 'proveedor_hotelero/completar-informacion'
            );
            exit;
        }

        // =========================================
        // ARRAY DE DATOS
        // =========================================

        $data = [

            ':nombre_establecimiento' => $nombre_establecimiento,
            ':nit_rut' => $nit_rut,
            ':departamento' => $departamento,
            ':direccion' => $direccion,

            ':email' => $email,
            ':telefono' => $telefono,

            ':nombre_representante' => $nombre_representante,
            ':identificacion_representante' => $identificacion_representante,
            ':telefono_representante' => $telefono_representante,

            ':id_ciudad' => $id_ciudad,

            ':tipo_documento' => $tipo_documento,
            ':tipo_establecimiento' => $tipo_establecimiento,
            ':tipo_habitacion' => $tipo_habitacion,

            ':max_huesped' => $max_huesped,

            ':metodo_pago' => $metodo_pago,
            ':servicio_incluido' => $servicio_incluido,

            ':camara_comercio' => $nombreCamara,
            ':licencia' => $nombreLicencia,

            ':logo' => $nombreLogo,
            ':foto_representante' => $nombreFoto,

            ':id_usuario' => $this->idUsuario
        ];

        // =========================================
        // ACTUALIZAR INFORMACIÓN
        // =========================================

        if ($this->model->actualizarProveedor($data)) {

            mostrarSweetAlert(
                'success',
                'Información actualizada',
                'La información del proveedor hotelero fue actualizada correctamente.',
                BASE_URL . 'proveedor_hotelero/completar-informacion'
            );

            exit;

        } else {

            die("Error al actualizar la información del proveedor hotelero.");
        }
    }

    // =========================================
    // MOSTRAR FORMULARIO
    // =========================================

    public function mostrarFormulario()
    {
        $proveedor = $this->model->obtenerPorUsuario($this->idUsuario);

        require __DIR__ . '/../../views/dashboard/proveedor_hotelero/completar_informacion.php';
    }
}

// =========================================
// EJECUTAR CONTROLADOR
// =========================================

$controller = new CompletarInformacionController($model, $idUsuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $controller->procesarFormulario();

} else {

    $controller->mostrarFormulario();
}