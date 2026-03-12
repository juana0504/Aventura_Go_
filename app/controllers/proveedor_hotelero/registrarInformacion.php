<?php

require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/registrarInformacionModel.php';

$idUsuario = $_SESSION['user']['id_usuario'];

$model = new registrarInformacionModel();

/* =====================================
   SI ES POST → ACTUALIZAR INFORMACIÓN
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datos = [

        'nombre_establecimiento'       => $_POST['nombre_establecimiento'] ?? '',
        'email'                        => $_POST['email'] ?? '',
        'telefono'                     => $_POST['telefono'] ?? '',
        'tipo_establecimiento'         => $_POST['tipo_establecimiento'] ?? [],
        'nombre_representante'         => $_POST['nombre_representante'] ?? '',
        'tipo_documento'               => $_POST['tipo_documento'] ?? '',
        'identificacion_representante' => $_POST['identificacion_representante'] ?? '',
        'email_representante'          => $_POST['email_representante'] ?? '',
        'telefono_representante'       => $_POST['telefono_representante'] ?? '',
        'departamento'                 => $_POST['departamento'] ?? '',
        'id_ciudad'                    => $_POST['id_ciudad'] ?? '',
        'direccion'                    => $_POST['direccion'] ?? '',
        'tipo_habitacion'              => $_POST['tipo_habitacion'] ?? [],
        'max_huesped'                  => $_POST['max_huesped'] ?? '',
        'servicio_incluido'            => $_POST['servicio_incluido'] ?? [],
        'nit_rut'                      => $_POST['nit_rut'] ?? '',
        'camara_comercio'              => $_POST['camara_comercio'] ?? '',
        'licencia'                     => $_POST['licencia'] ?? '',
        'metodo_pago'                  => $_POST['metodo_pago'] ?? []

    ];

    /* =========================
       VALIDACIÓN BÁSICA
    ========================= */

    foreach ($datos as $campo) {
        if (empty($campo)) {
            mostrarSweetAlert(
                'error',
                'Campos incompletos',
                'Por favor completa todos los campos obligatorios.',
                '/aventura_go/proveedor_hotelero/registrar-informacion'
            );
            exit;
        }
    }

    /* =========================
       CONVERTIR ARRAYS
    ========================= */

    $datos['tipo_establecimiento'] = implode(",", $datos['tipo_establecimiento']);
    $datos['tipo_habitacion']      = implode(",", $datos['tipo_habitacion']);
    $datos['servicio_incluido']    = implode(",", $datos['servicio_incluido']);
    $datos['metodo_pago']          = implode(",", $datos['metodo_pago']);

    /* =========================
       LLAMAR MODELO
    ========================= */

    $resultado = $model->actualizarProveedorHotelero(
        $idUsuario,
        $datos,
        $_FILES
    );

    if ($resultado) {

        mostrarSweetAlert(
            'success',
            'Información actualizada',
            'Tu información ha sido actualizada y está en revisión.',
            '/aventura_go/proveedor_hotelero/registrar-informacion'
        );
    } else {

        mostrarSweetAlert(
            'error',
            'Error al actualizar',
            'Hubo un error al actualizar tu información.',
            '/aventura_go/proveedor_hotelero/registrar-informacion'
        );
    }

    exit;
}

/* =====================================
   SI ES GET → CARGAR INFORMACIÓN
===================================== */

$proveedor = $model->obtenerProveedorActual($idUsuario);

require_once __DIR__ . '/../../views/dashboard/proveedor_hotelero/registrar_informacion.php';
