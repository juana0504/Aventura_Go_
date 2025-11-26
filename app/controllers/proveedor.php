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
        }else{
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
    $nombre_empresa        = $_POST['nombre_empresa'] ?? '';
    $nit_rut               = $_POST['nit_rut'] ?? '';
    $nombre_representante  = $_POST['nombre_representante'] ?? '';
    $email                 = $_POST['email'] ?? '';
    $telefono              = $_POST['telefono'] ?? '';
    $actividades           = $_POST['actividades'] ?? [];
    $descripcion           = $_POST['descripcion'] ?? '';
    $departamento          = $_POST['departamento'] ?? '';
    $ciudad                = $_POST['ciudad'] ?? '';
    $direccion             = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($nombre_representante) ||
        empty($email) || empty($telefono) || empty($actividades) ||
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
        $foto_url = uniqid('proveedor_') . '.' . $extencion;

        // definimos el destino donde moveremos el archivo
        $destino = BASE_PATH . "/public/uploads/actividades/" .$foto_url;

        // movemos el archivo al destino
        move_uploaded_file($file['tmp_name'], $destino);
        
    }else{
        // Agregar la logica de la imagen por default
        $foto_url = 'default_proveedor.png';
    }

    $objProveedor = new Proveedor();

    $data = [
        'nombre_empresa'       => $nombre_empresa,
        'nit_rut'              => $nit_rut,
        'nombre_representante' => $nombre_representante,
        'email'                => $email,
        'telefono'             => $telefono,
        'actividades'          => $actividades,
        'descripcion'          => $descripcion,
        'departamento'         => $departamento,
        'ciudad'               => $ciudad,
        'direccion'            => $direccion,
        'foto'                 => $foto_url
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
    $id_proveedor         = $_POST['id_proveedor'] ?? '';
    $nombre_empresa        = $_POST['nombre_empresa'] ?? '';
    $nit_rut               = $_POST['nit_rut'] ?? '';
    $nombre_representante  = $_POST['nombre_representante'] ?? '';
    $email                 = $_POST['email'] ?? '';
    $telefono              = $_POST['telefono'] ?? '';
    $actividades           = $_POST['actividades'] ?? [];
    $descripcion           = $_POST['descripcion'] ?? '';
    $departamento          = $_POST['departamento'] ?? '';
    $ciudad                = $_POST['ciudad'] ?? '';
    $direccion             = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($nombre_representante) ||
        empty($email) || empty($telefono) || empty($actividades) ||
        empty($descripcion) || empty($departamento) || empty($ciudad) || empty($direccion)
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
        'id_proveedor'         => $id_proveedor,
        'nombre_empresa'       => $nombre_empresa,
        'nit_rut'              => $nit_rut,
        'nombre_representante' => $nombre_representante,
        'email'                => $email,
        'telefono'             => $telefono,
        'actividades'          => $actividades,
        'descripcion'          => $descripcion,
        'departamento'         => $departamento,
        'ciudad'               => $ciudad,
        'direccion'            => $direccion
    ];

    $resultado = $objProveedor->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Actualización exitosa', 'Proveedor actualizado.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo actualizar el proveedor.');
    }
}

function eliminarProveedor($id){
    $objProveedor = new Proveedor();

    $resultado = $objProveedor->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Proveedor eliminado.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el proveedor.');
    }
}
