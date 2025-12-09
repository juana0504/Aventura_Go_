<?php

//impotamos las dependencias
require_once __DIR__ . '/../helpers/alert_helper.php';
require_once __DIR__ . '/../models/hotelero.php';


//capturamos en ua variable el metodo o solicitud hecha  al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarHotel();
        } else {
            registrarHotel();
        }
        break;

    case 'GET':
        // esta variable captura la accion a realizar
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // esta funcion elimina el proveedor segun su id
            eliminarHotel($_GET['id']);
        }

        if (isset($_GET['id'])) {
            // esta funcion llena la tabla con el proveedor segun su id
            listarHotelId($_GET['id']);
        } else {
            // esta funcion llena la tabla con todos los proveedores
            listarHoteles();
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
function registrarHotel()
{
    $nombre_establecimiento          = $_POST['nombre_establecimiento'] ?? '';
    $email                           = $_POST['email'] ?? '';
    $telefono                        = $_POST['telefono'] ?? '';
    $tipo_establecimiento            = $_POST['tipo_est$tipo_establecimiento'] ?? '';
    $nombre_representante            = $_POST['nombre_representante'] ?? '';
    $identificacion_representante    = $_POST['identificacion_representante'] ?? '';
    $email_representante             = $_POST['email_representante'] ?? '';
    $telefono_representante          = $_POST['telefono_representante'] ?? '';
    $departamento                    = $_POST['departamento'] ?? '';
    $ciudad                          = $_POST['ciudad'] ?? '';
    $direccion                       = $_POST['direccion'] ?? '';
    $tipo_habitacion                 = $_POST['tipo_habitacion'] ?? '';
    $max_huesped                     = $_POST['max_huesped'] ?? '';
    $capacidad_personas              = $_POST['capacidad_personas'] ?? '';
    $servicio_incluido               = $_POST['servicio_incluido'] ?? '';
    $capacidad_habitacion            = $_POST['capacidad_habitacion'] ?? '';
    $nit_rut                         = $_POST['nit_rut'] ?? '';
    $camara_comercio                 = $_POST['camara_comercio'] ?? '';
    $licencia                        = $_POST['licencia'] ?? '';
    $metodo_pago                     = $_POST['metodo_pago'] ?? '';
    $estado                          = $_POST['estado'] ?? '';

    if (
        empty($nombre_establecimiento) || empty($email) || empty($telefono) ||
        empty($tipo_establecimiento) || empty($nombre_representante) || empty($identificacion_representante) ||
        empty($email_representante) || empty($telefono_representante) || empty($departamento) ||
        empty($ciudad) || empty($direccion) || empty($tipo_habitacion) ||
        empty($max_huesped) || empty($capacidad_personas) || empty($servicio_incluido) ||
        empty($capacidad_habitacion) || empty($nit_rut) || empty($camara_comercio) ||
        empty($licencia) || empty($metodo_pago) || empty($estado)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    // Convertir array de tipo establecimiento en string
    if (is_array($tipo_establecimiento)) {
        $tipo_establecimiento = implode(",", $tipo_establecimiento);
    }

    // Convertir array de tipo habitacion en string
    if (is_array($tipo_habitacion)) {
        $tipo_habitacion = implode(",", $tipo_habitacion);
    }

    // Convertir array de tipo de pago en string
    if (is_array($metodo_pago)) {
        $metodo_pago = implode(",", $metodo_pago);
    }



    // Logica para cargar imagenes
    $logo_url = null;
    $foto_url = null;

    // Validamos si se envio o no la foto desde el formulario
    // ***Si el proveedorno registro una foto, dejar una imagen por defecto

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
        $destino = BASE_PATH . "/public/uploads/hotelero/" . $logo_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $logo_url = 'default_proveedor_hotelero.png';
    }


    // FOTO PRINCIPAL
    if (!empty($_FILES['foto']['name'])) {
        $file = $_FILES['foto'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $foto_url = uniqid('foto_') . "." . $ext;
        $destino = BASE_PATH . "/public/uploads/usuario/" . $foto_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_url = 'default_proveedor_usuario.png';
    }

    $objhotelero = new Hotelero();

    $data = [
        'logo'                       => $logo_url,
        'nombre_establecimiento'     => $nombre_establecimiento,
        'email'                      => $email,
        'telefono'                   => $telefono,
        'tipo_establecimiento'       => $tipo_establecimiento,
        'nombre_representante'       => $nombre_representante,
        'tipo_establecimiento'       => $tipo_establecimiento,
        'foto_representante'         => $foto_url,
        'email_representante'        => $email_representante,
        'telefono_representante'     => $telefono_representante,
        'departamento'               => $departamento,
        'ciudad'                     => $ciudad,
        'direccion'                  => $direccion,
        'tipo_habitacion'            => $tipo_habitacion,
        'max_huesped'                => $max_huesped,
        'capacidad_personas'         => $capacidad_personas,
        'servicio_incluido'          => $servicio_incluido,
        'capacidad_habitacion'       => $capacidad_habitacion,
        'nit_rut'                    => $nit_rut,
        'camara_comercio'            => $camara_comercio,
        'licencia'                   => $licencia,
        'metodo_pago'                => $metodo_pago,
    ];

    $resultado = $objhotelero->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Proveedor registrado.', '/aventura_go/administrador/registrar-proveedor-hotelero');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar el proveedor.');
    }
}

function listarHoteles()
{
    $resultado = new hotelero();
    $hotelero = $resultado->listar();

    return $hotelero;
}

function listarHotelId($id)
{
    $objHotelero = new hotelero();
    $hotelero = $objHotelero->listarHoteles($id);

    return $hotelero;
}

function actualizarHotel()
{
    $id_proveedor_hotelero       = $_POST['id_proveedor_hotelero'] ?? '';
    $nombre_establecimiento      = $_POST['nombre_establecimiento'] ?? '';
    $tipo_establecimiento        = $_POST['tipo_establecimiento'] ?? '';
    $numero_habitaciones         = $_POST['numero_habitaciones'] ?? '';
    $calificacion_promedio       = $_POST['calificacion_promedio'] ?? '';

    if (
        empty($nombre_establecimiento) || empty($tipo_establecimiento) || empty($numero_habitaciones) ||
        empty($calificacion_promedio) 
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    // Convertir array de actividades en string
    if (is_array($tipo_establecimiento)) {
        $tipo_establecimiento = implode(",", $tipo_establecimiento);
    }

    $objHotelero = new Hotelero();

    $data = [
        'id_proveedor_hotelero'      => $id_proveedor_hotelero,
        'nombre_establecimiento'     => $nombre_establecimiento,
        'tipo_establecimiento'       => $tipo_establecimiento,
        'numero_habitaciones'        => $numero_habitaciones,
        'calificacion_promedio'      => $calificacion_promedio,
    ];

    $resultado = $objHotelero->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Actualización exitosa', 'Proveedor actualizado.', '/aventura_go/administrador/consultar-proveedor-hotelero');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo actualizar el proveedor.');
    }
}

function eliminarHotel($id)
{
    $objHotelero = new Hotelero();

    $resultado = $objHotelero->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Proveedor eliminado.', '/aventura_go/administrador/consultar-proveedor-hotelero');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el proveedor.');
    }
}
