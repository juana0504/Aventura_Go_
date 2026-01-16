<?php
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor/editarPerfilProveedor.php';

session_start();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        actualizarPerfilProveedor();
        break;

    case 'GET':
        mostrarPerfilProveedor();
        break;

    default:
        http_response_code(405);
        echo "❌ Método no permitido";
        break;
}


// ------------------------------------------------------------
// MOSTRAR PERFIL DEL PROVEEDOR TURISITICO
// ------------------------------------------------------------

function mostrarPerfilProveedor()
{
    if (!isset($_SESSION['user'])) {
        mostrarSweetAlert('error', 'Sesión no iniciada', 'Debes iniciar sesión.');
        exit();
    }

    // Aseguramos índices correctos
    $user = $_SESSION['user'];

    // Normalizamos nombres
    $data = [
        'id_usuario'    => $user['id_usuario'] ?? null,
        'nombre'        => $user['nombre'] ?? '',
        'telefono'      => $user['telefono'] ?? '',
        'email'         => $user['email'] ?? '',
        'foto'          => $user['foto'] ?? '',
        'identificacion' => $user['identificacion'] ?? '',
        'rol'           => $user['rol'] ?? '',
        'estado'        => $user['estado'] ?? ''
    ];

    // Retornamos un array limpio
    return $data;
}



// ------------------------------------------------------------
// ACTUALIZAR PERFIL DEL PROVEEDOR TURISTICO
// ------------------------------------------------------------

function actualizarPerfilProveedor()
{
    if (!isset($_SESSION['user'])) {
        mostrarSweetAlert('error', 'Sesión no iniciada', 'Debes iniciar sesión.');
        exit();
    }

    // OJO: el ID real de tu tabla es id_usuario
    $id_usuario = $_SESSION['user']['id'];

    $nombre     = $_POST['nombre'] ?? '';
    $telefono   = $_POST['telefono'] ?? '';
    $email      = $_POST['email'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';

    if (empty($nombre) || empty($email) || empty($telefono)) {
        mostrarSweetAlert('error', 'Campos vacíos', 'Por favor completa todos los campos.');
        exit();
    }

    // --------------------------------------------------------
    // FOTO / IMAGEN DE PERFIL
    // --------------------------------------------------------

    $foto = $_SESSION['user']['foto']; // Deja la actual si no cambia

    if (!empty($_FILES['foto']['name'])) {

        $file = $_FILES['foto'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $permitidas = ['png', 'jpg', 'jpeg'];

        if (!in_array($extension, $permitidas)) {
            mostrarSweetAlert('error', 'Extensión no permitida', 'Carga una imagen PNG, JPG o JPEG.');
            exit();
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            mostrarSweetAlert('error', 'Foto muy pesada', 'La imagen no debe superar los 2MB.');
            exit();
        }

        $foto = uniqid('user_') . "." . $extension;
        $destino = BASE_PATH . "/public/uploads/usuario/" . $foto;
        move_uploaded_file($file['tmp_name'], $destino);
    }

    // --------------------------------------------------------
    // ACTUALIZAR BASE DE DATOS
    // --------------------------------------------------------
    $obj = new EditarPerfilProveedor();

    $data = [
        'id_usuario'    => $id_usuario,
        'nombre'        => $nombre,
        'telefono'      => $telefono,
        'email'         => $email,
        'foto'          => $foto,
        'identificacion' => $identificacion
    ];

    $resultado = $obj->actualizar($data);

    if ($resultado) {

        // Actualizamos la sesión
        $_SESSION['user'] = array_merge($_SESSION['user'], $data);

        mostrarSweetAlert('success', 'Actualizado', 'Tu perfil ha sido actualizado.', '/aventura_go/proveedor/perfil');
    } else {
        mostrarSweetAlert('error', 'Error', 'No se pudo actualizar el perfil.');
    }
}
