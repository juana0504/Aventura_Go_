<?php

//impotamos las dependencias
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/administrador/turista.php';


//capturamos en ua variable el metodo o solicitud hecha  al servidor
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'actualizar') {
            actualizarTurista();
        } else {
            registrarTurista();
        }
        break;

    case 'GET':
        // esta variable captura la accion a realizar
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'eliminar') {
            // esta funcion elimina el proveedor segun su id
            eliminarTurista($_GET['id']);
        }

        if (isset($_GET['id'])) {
            // esta funcion llena la tabla con el proveedor segun su id
            listarTuristaId($_GET['id']);
        } else {
            // esta funcion llena la tabla con todos los proveedores
            listarTuristas();
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
function registrarTurista()
{
    $nombre       = $_POST['nombre'] ?? '';
    $genero       = $_POST['genero'] ?? '';
    $telefono     = $_POST['telefono'] ?? '';
    $email        = $_POST['email'] ?? '';
    $clave        = $_POST['clave'] ?? '';

    if (
        empty($nombre) || empty($genero) || empty($telefono) ||
        empty($email) || empty($clave)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // Logica para cargar imagenes
    $foto_url = null;

    if (!empty($_FILES['foto']['name'])) {
        $file = $_FILES['foto'];
        $extencion = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $permitidas = ['png', 'jpg', 'jpeg'];

        if (!in_array($extencion, $permitidas)) {
            mostrarSweetAlert('error', 'Extención no permitida.', 'Las extenciones permitidas son: png, jpg, jpeg.');
            exit();
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Error al cargar la foto.', 'El peso de la foto supera el limite de 2MB.');
            exit();
        }

        $foto_url = uniqid('turista_') . '.' . $extencion;
        $destino = BASE_PATH . "/public/uploads/usuario/" . $foto_url;

        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_url = 'default_turista.png';
    }

    $objTurista = new Turista();

    // correo de la empresa
    if ($objTurista->emailUsuarioExiste($email)) {
        mostrarSweetAlert('error', 'Correo duplicado', 'El correo ya existe.');
        exit();
    }

    $data = [
        'nombre'      => $nombre,
        'genero'      => $genero,
        'telefono'    => $telefono,
        'email'       => $email,
        'clave'       => $claveHash,
        'foto'        => $foto_url,
    ];

    $resultado = $objTurista->registrar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Registro exitoso', 'Proveedor registrado.', '/aventura_go/login');
    } else {
        mostrarSweetAlert('error', 'Error al registrar', 'No se pudo registrar el proveedor.');
    }
}


function listarTuristas()
{
    $resultado = new Turista();
    $turista = $resultado->listar();

    return $turista;
}

function listarTuristaId($id)
{
    $objTurista = new Turista();
    $turista = $objTurista->listarTurista($id);

    return $turista;
}

function actualizarTurista()
{
    $id_usuario         = $_POST['id_usuario'] ?? '';
    $nombre             = $_POST['nombre'] ?? '';
    $genero             = $_POST['genero'] ?? '';
    $telefono           = $_POST['telefono'] ?? '';
    $email              = $_POST['email'] ?? '';

    if (
        empty($nombre) || empty($genero) || empty($telefono) ||
        empty($email)
    ) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos');
        exit();
    }

    $objTurista = new Turista();

    $data = [
        'id_usuario'       => $id_usuario,
        'nombre'           => $nombre,
        'genero'           => $genero,
        'telefono'         => $telefono,
        'email'            => $email,
    ];

    $resultado = $objTurista->actualizar($data);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Actualización exitosa', 'Turista actualizado.', '/aventura_go/administrador/consultar-turista');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar', 'No se pudo actualizar el turista.');
    }
}

function eliminarTurista($id)
{
    $objTurista = new Turista();

    $resultado = $objTurista->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'Turista eliminado.', '/aventura_go/administrador/consultar-turista');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el turista.');
    }
}
