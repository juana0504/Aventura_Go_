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
    $nombre_establecimiento       = $_POST['nombre_establecimiento'] ?? '';
    $tipo_establecimiento         = $_POST['tipo_establecimiento'] ?? '';
    $numero_habitaciones          = $_POST['numero_habitaciones'] ?? '';
    $calificacion_promedio        = $_POST['calificacion_promedio'] ?? '';
    $estado                       = $_POST['estado'] ?? '';

    if (
        empty($nombre_establecimiento) || empty($tipo_establecimiento) || empty($numero_habitaciones) ||
        empty($calificacion_promedio) || empty($estado)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    // Convertir array de actividades en string
    if (is_array($tipo_establecimiento)) {
        $tipo_establecimiento = implode(",", $tipo_establecimiento);
    }



    // Logica para cargar imagenes
    $foto_url = null;

    // Validamos si se envio o no la foto desde el formulario
    // ***Si el proveedorno registro una foto, dejar una imagen por defecto

    if (!empty($_FILES['foto']['name'])) {
        $file =$_FILES['foto'];
        // obtenemos la extencion del archivo
        $extencion = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // definimos las extenciones permitidas
        $permitidas = ['png', 'jpg', 'jpeg'];

        // validar que la extencion de la imagen cargada este dentro de las permitideas
        if (!in_array($extencion, $permitidas)) {
            mostrarSweetAlert('error', 'Extención no permitiva.', 'Las extenciones permitidas son: png, jpg, jpeg.');
            exit();
        }

        // validamos el tamaño o elpeso de la imagen
        if ($file['size']> 2 *1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto.', 'El peso de la foto supera el limite de 2MB.');
            exit();
        }

        // definimos el nombre del archivo y concatenamos la extencion
        $foto_url = uniqid('hoteles_') . '.' . $extencion;

        // definimos el destino donde moveremos el archivo
        $destino = BASE_PATH . "/public/uploads/hoteles/" .$foto_url;

        // movemos el archivo al destino
        move_uploaded_file($file['tmp_name'], $destino);

    }else{
        // Agregar la logica de la imagen por default
        $foto_url = 'default_hoteles.png';
    }

    $objhotelero = new Hotelero();

    $data = [
        'nombre_establecimiento'     => $nombre_establecimiento,
        'tipo_establecimiento'       => $tipo_establecimiento,
        'numero_habitaciones'        => $numero_habitaciones,
        'calificacion_promedio'      => $calificacion_promedio,
        'estado'                     => $estado,
        'foto'                       => $foto_url,
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
