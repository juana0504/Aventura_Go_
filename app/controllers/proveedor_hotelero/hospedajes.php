<?php

require_once __DIR__ . '/../../helpers/session_proveedor_hotelero.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_hotelero/hospedaje.php';
require_once __DIR__ . '/../../models/Ciudad.php';


// DATOS PARA VISTAS (GET)

$ciudadModel = new Ciudad();
$destinos = $ciudadModel->obtenerCiudadesActivas();

// MÉTODO HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // POST → REGISTRAR / ACTUALIZAR
    case 'POST':

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'actualizar') {
            actualizarHospedaje();
        } else {
            registrarHospedaje();
        }

        break;

    // GET → LISTAR / CARGAR VISTAS / CAMBIAR ESTADO
    case 'GET':

        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            eliminarHospedaje($_GET['id_usuario']);
            exit;
        }

        if ($accion === 'activar') {
            activarHospedaje($_GET['id_usuario']);
            exit;
        }

        if ($accion === 'desactivar') {
            desactivarHospedaje($_GET['id_usuario']);
            exit;
        }


        if (isset($_GET['id'])) {
            listarHospedajeId($_GET['id']);
        } else {
            listarHospedajes();
        }

        break;

    default:
        http_response_code(405);
        echo "❌ Método no permitido";
        break;
}

// FUNCIONES CRUD

function registrarHospedaje()
{
    require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';

    $proveedorModel = new Proveedor();
    $id_usuario = $_SESSION['user']['id_usuario'];
    $id_proveedor_hotelero = $proveedorModel->obtenerIdProveedorPorUsuario($id_usuario);

    $nombre       = trim($_POST['nombre'] ?? '');
    $descripcion  = $_POST['descripcion'] ?? '';
    $tipo         = $_POST['tipo'] ?? []; // <-- ARRAY
    $id_ciudad    = $_POST['id_ciudad'] ?? '';
    $ubicacion    = trim($_POST['ubicacion'] ?? '');
    $capacidad    = $_POST['capacidad'] ?? '';
    $precio       = $_POST['precio'] ?? '';
    $estado       = $_POST['estado'] ?? 'ACTIVO';

    $servicios = $_POST['servicios'] ?? [];
    $tipo = $_POST['tipo'] ?? [];

    // Validación
    if (
        !$id_proveedor_hotelero ||
        empty($nombre) ||
        empty($descripcion) ||
        empty($tipo) ||
        empty($id_ciudad) ||
        empty($ubicacion) ||
        empty($capacidad) ||
        empty($precio)
    ) {
        mostrarSweetAlert(
            'error',
            'Campos incompletos',
            'Por favor completa todos los campos obligatorios'
        );
        exit;
    }

    // Convertir array de tipos a texto
    $tipoTexto = implode(', ', $tipo);

    // Convertir servicios a texto
    $serviciosTexto = implode(', ', $servicios);

    $objHospedaje = new Hospedaje();

    $data = [
        'id_proveedor_hotelero' => $id_proveedor_hotelero,
        'nombre'                => $nombre,
        'descripcion'           => $descripcion,
        'tipo'                  => $tipoTexto,
        'id_ciudad'             => $id_ciudad,
        'ubicacion'             => $ubicacion,
        'capacidad'             => $capacidad,
        'precio'                => $precio,
        'servicios'             => $serviciosTexto,
        'estado'                => $estado,
        'imagen'                => 'hospedaje_default.png'
    ];

    $id_hospedaje = $objHospedaje->registrar($data);

    if ($id_hospedaje) {

        // Guardar imágenes subidas
        $imagenes = $_FILES['imagenes'] ?? [];
        if (!empty($imagenes['name'][0])) {
            $permitidas = ['jpg', 'jpeg', 'png'];
            $max = min(count($imagenes['name']), 6);
            $esPrimera = true;
            for ($i = 0; $i < $max; $i++) {
                if (($imagenes['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
                $ext = strtolower(pathinfo($imagenes['name'][$i], PATHINFO_EXTENSION));
                if (!in_array($ext, $permitidas)) continue;
                $nombreImg = 'hosp_' . uniqid() . '.' . $ext;
                $ruta = __DIR__ . '/../../../public/uploads/hotelero/actividades/' . $nombreImg;
                if (move_uploaded_file($imagenes['tmp_name'][$i], $ruta)) {
                    $objHospedaje->guardarImagen([
                        'id_hospedaje' => $id_hospedaje,
                        'imagen'       => $nombreImg,
                        'es_principal' => $esPrimera ? 1 : 0,
                    ]);
                    if ($esPrimera) {
                        $objHospedaje->actualizarImagen($id_hospedaje, $nombreImg);
                        $esPrimera = false;
                    }
                }
            }
        }

        mostrarSweetAlert(
            'success',
            'Hospedaje registrado',
            'El hospedaje fue registrado correctamente',
            BASE_URL . 'proveedor_hotelero/registrar-hospedajes'
        );
    } else {

        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo registrar el hospedaje'
        );
    }
}

function actualizarHospedaje()
{
    $id_hospedaje   = $_POST['id_hospedaje'] ?? '';
    $id_proveedor_hotelero = $_POST['id_proveedor_hotelero'] ?? '';

    $nombre         = $_POST['nombre'] ?? '';
    $descripcion         = $_POST['descripcion'] ?? '';
    $tipo           = $_POST['tipo'] ?? [];
    $id_ciudad      = $_POST['id_ciudad'] ?? '';
    $ubicacion      = $_POST['ubicacion'] ?? '';
    $capacidad      = $_POST['capacidad'] ?? '';
    $precio         = $_POST['precio'] ?? '';
    $estado         = $_POST['estado'] ?? 'activa';

    $servicios = $_POST['servicios'] ?? [];
    $servicios = implode(', ', $servicios);

    if (
        empty($nombre) ||
        empty($descripcion) ||
        empty($tipo) ||
        empty($id_ciudad) ||
        empty($ubicacion) ||
        empty($capacidad) ||
        empty($precio)
    ) {
        mostrarSweetAlert(
            'error',
            'Campos incompletos',
            'Todos los campos son obligatorios'
        );
        exit;
    }

    $hospedajeModel = new Hospedaje();

    $data = [
        'id_hospedaje' => $id_hospedaje,
        'id_proveedor_hotelero' => $id_proveedor_hotelero,
        'nombre'       => $nombre,
        'descripcion'       => $descripcion,
        'tipo'         => $tipo,
        'id_ciudad'    => $id_ciudad,
        'ubicacion'    => $ubicacion,
        'capacidad'    => $capacidad,
        'precio'       => $precio,
        'servicios'    => $servicios,
        'estado'       => $estado
    ];

    $resultado = $hospedajeModel->actualizarHospedaje($data);

    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Hospedaje actualizado',
            'El hospedaje fue actualizado correctamente',
            BASE_URL . 'proveedor_hotelero/consultar-hospedajes'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo actualizar el hospedaje'
        );
    }
}

function listarHospedajes()
{
    require_once __DIR__ . '/../../models/proveedor_hotelero/Proveedor_hotelero.php';
    $proveedorModel = new Proveedor();
    $id_usuario = $_SESSION['user']['id_usuario'];

    $id_proveedor = $proveedorModel->obtenerIdProveedorPorUsuario($id_usuario);

    $hospedajeModel = new Hospedaje();
    $hospedaje = $hospedajeModel->listarPorProveedor($id_proveedor);

    return $hospedaje;
}

function listarHospedajeId($id)
{
    $objHospedaje = new Hospedaje();
    return $objHospedaje->listarPorId($id);
}

function activarHospedaje($id)
{
    $objHospedaje = new Hospedaje();
    $resultado = $objHospedaje->activar($id);

    if ($resultado) {
        mostrarSweetAlert(
            'success',
            'Hospedaje activado',
            'El hospedaje fue activado correctamente',
            BASE_URL . 'proveedor_hotelero/consultar-hospedajes'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo activar el hospedaje'
        );
    }
}

function desactivarHospedaje($id)
{
    $objHospedaje = new Hospedaje();
    $resultado = $objHospedaje->desactivar($id);

    if ($resultado) {
        mostrarSweetAlert(
            'success',
            'Hospedaje desactivado',
            'El hospedaje fue desactivado correctamente',
            BASE_URL . 'proveedor_hotelero/consultar-hospedajes'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo desactivar el hospedaje'
        );
    }
}

function eliminarHospedaje($id)
{
    $objHospedaje = new Hospedaje();

    $resultado = $objHospedaje->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'hospedaje eliminado.', BASE_URL . 'proveedor_hotelero/consultar-hospedajes');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el hospedaje.');
    }
}
