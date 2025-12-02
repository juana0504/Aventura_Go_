<?php

//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/proveedor.php';


//capturamos en ua variable el metodo o solicitud hecha  al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarProveedor();
        } else {
            registrarProveedor();
        }
        break;

    case 'GET':
        // esta variable captura la accion a realizar
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // esta funcion elimina el proveedor segun su id
            eliminarProveedor($_GET['id']);
        }

        if (isset($_GET['id'])) {
            // esta funcion llena la tabla con el proveedor segun su id
            listarProveedorId($_GET['id']);
        } else {
            // esta funcion llena la tabla con todos los proveedores
            listarProveedores();
        }

        break;

    // case 'PUT':

    //     actualizarProveedor();
    //     break;

    // case 'DELETE':
    //     eliminarProveedor();
    //     break;

    default:
        http_response_code(405);
        echo "❌ Método no permitido";
        break;
}

//FUNCIONES CRUD
function registrarProveedor()
{
    $nombre_empresa          = $_POST['nombre_empresa'] ?? '';
    $nit_rut                 = $_POST['nit_rut'] ?? '';
    $email                   = $_POST['email'] ?? '';
    $telefono                = $_POST['telefono'] ?? '';
    $nombre_representante    = $_POST['nombre_representante'] ?? '';
    $identificacion_representante         = $_POST['identificacion_representante'] ?? '';
    $identificacion         = $_POST['identificacion'] ?? '';
    $email_representante     = $_POST['email_representante'] ?? '';
    $telefono_representante = $_POST['telefono_representante'] ?? '';
    $actividades             = $_POST['actividades'] ?? [];
    $descripcion             = $_POST['descripcion'] ?? '';
    $departamento            = $_POST['departamento'] ?? '';
    $ciudad                  = $_POST['ciudad'] ?? '';
    $direccion               = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($email) ||
        empty($telefono) || empty($nombre_representante) || empty($identificacion) || empty($identificacion_representante) ||
        empty($email_representante) || empty($telefono_representante) || empty($actividades) || 
        empty($descripcion) || empty($departamento) || empty($ciudad) || empty($direccion)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    // Convertir array de actividades en string
    if (is_array($actividades)) {
        $actividades = implode(",", $actividades);
    }


    // Logica para cargar imagenes
    $foto_url = null;
    $logo_url = null;
    $foto_act = null;

    // ---- SUBIDA DE IMÁGENES ----

    // LOGO
    if (!empty($_FILES['logo']['name'])) {
        $file = $_FILES['logo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $permitidas = ['png', 'jpg', 'jpeg'];

        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert('error', 'Extensión no permitida', 'Solo PNG, JPG y JPEG');
            exit;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Archivo muy pesado', 'Máximo 2MB');
            exit;
        }

        $logo_url = uniqid('logo_') . "." . $ext;
        $destino = BASE_PATH . "/public/uploads/turistico/" . $logo_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $logo_url = 'default_proveedor.png';
    }


    // FOTO PRINCIPAL
    if (!empty($_FILES['foto']['name'])) {
        $file = $_FILES['foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $foto_url = uniqid('foto_') . "." . $ext;
        $destino = BASE_PATH . "/public/uploads/usuario/" . $foto_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_url = 'default_proveedor.png';
    }


    // FOTO ACTIVIDAD
    if (!empty($_FILES['foto_actividad']['name'])) {
        $file = $_FILES['foto_actividad'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $foto_act = uniqid('actividad_') . "." . $ext;
        $destino = BASE_PATH . "/public/uploads/turistico/actividades/" . $foto_act;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_act = 'default_proveedor.png';
    }

    $claveHash = password_hash($identificacion, PASSWORD_DEFAULT);

    $objProveedor = new Proveedor();

    $data = [
        'nombre_empresa'          => $nombre_empresa,
        'logo'                    => $logo_url,
        'email'                   => $email,
        'telefono'                => $telefono,
        'nit_rut'                 => $nit_rut,
        'nombre_representante'    => $nombre_representante,
        'identificacion_representante' =>$identificacion_representante,
        'identificacion'          => $claveHash,
        'foto_representante'      => $foto_url,
        'email_representante'     => $email_representante,
        'telefono_representante'  => $telefono_representante,
        'actividades'             => $actividades,
        'descripcion'             => $descripcion,
        'departamento'            => $departamento,
        'ciudad'                  => $ciudad,
        'direccion'               => $direccion,
        'foto_actividades'          => $foto_act
    ];

    $resultado = $objProveedor->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Proveedor registrado.', '/aventura_go/administrador/registrar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar el proveedor.');
    }
}

function listarProveedores()
{
    $resultado = new Proveedor();
    $proveedor = $resultado->listar();

    return $proveedor;
}

function listarProveedorId($id)
{
    $objProveedor = new Proveedor();
    $proveedor = $objProveedor->listarProveedor($id);

    return $proveedor;
}

function actualizarProveedor()
{
    $id_proveedor            = $_POST['id_proveedor'] ?? '';
    $nombre_empresa          = $_POST['nombre_empresa'] ?? '';
    $email                   = $_POST['email'] ?? '';
    $telefono                = $_POST['telefono'] ?? '';
    $nit_rut                 = $_POST['nit_rut'] ?? '';
    $nombre_representante    = $_POST['nombre_representante'] ?? '';
    $email_representante     = $_POST['email_representante'] ?? '';
    $telefono_representante = $_POST['telefono_representante'] ?? '';
    $actividades             = $_POST['actividades'] ?? [];
    $descripcion             = $_POST['descripcion'] ?? '';
    $departamento            = $_POST['departamento'] ?? '';
    $ciudad                  = $_POST['ciudad'] ?? '';
    $direccion               = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($email) ||
        empty($telefono) || empty($nombre_representante) || empty($email_representante) ||
        empty($telefono_representante) || empty($actividades) || empty($descripcion) ||
        empty($departamento) || empty($ciudad) || empty($direccion)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    // Convertir array de actividades en string
    if (is_array($actividades)) {
        $actividades = implode(",", $actividades);
    }

    $objProveedor = new Proveedor();

    $data = [
        'id_proveedor'             => $id_proveedor,
        'nombre_empresa'           => $nombre_empresa,
        'email'                    => $email,
        'telefono'                 => $telefono,
        'nit_rut'                  => $nit_rut,
        'nombre_representante'     => $nombre_representante,
        'email_representante'      => $email_representante,
        'telefono_representante'   => $telefono_representante,
        'actividades'              => $actividades,
        'descripcion'              => $descripcion,
        'departamento'             => $departamento,
        'ciudad'                   => $ciudad,
        'direccion'                => $direccion
    ];

    $resultado = $objProveedor->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Actualización exitosa', 'Proveedor actualizado.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo actualizar el proveedor.');
    }
}

function eliminarProveedor($id)
{
    $objProveedor = new Proveedor();

    $resultado = $objProveedor->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Proveedor eliminado.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el proveedor.');
    }
}
