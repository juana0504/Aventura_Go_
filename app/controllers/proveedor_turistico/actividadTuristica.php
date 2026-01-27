<?php

require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/ActividadTuristica.php';
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
            actualizarActividad();
        } else {
            registrarActividad();
        }

        break;

    // GET → LISTAR / CARGAR VISTAS / CAMBIAR ESTADO
    case 'GET':

        $accion = $_GET['accion'] ?? '';

        if ($accion === 'activar') {
            activarActividad($_GET['id']);
            exit;
        }

        if ($accion === 'desactivar') {
            desactivarActividad($_GET['id']);
            exit;
        }

        if ($accion === 'registrar') {

            // cargar vista registrar actividad
            require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/registrar_actividad_turistica.php';
            exit;
        }

        // 👇 ESTA ES LA RUTA DE "CONSULTAR ACTIVIDADES"
        listarActividadesProveedor();
        exit;

        if (isset($_GET['id'])) {
            listarActividadId($_GET['id']);
        } else {
            listarActividadesProveedor();
        }

        break;

    default:
        http_response_code(405);
        echo "❌ Método no permitido";
        break;
}

// FUNCIONES CRUD

function registrarActividad()
{

    require_once __DIR__ . '/../../models/proveedor_turistico/Proveedor.php';

    $proveedorModel = new Proveedor();
    $id_usuario = $_SESSION['user']['id_usuario'];
    $id_proveedor = $proveedorModel->obtenerIdProveedorPorUsuario($id_usuario);

    $nombre       = $_POST['nombre'] ?? '';
    $id_ciudad    = $_POST['id_ciudad'] ?? '';
    $ubicacion    = $_POST['ubicacion'] ?? '';
    $descripcion  = $_POST['descripcion'] ?? '';
    $cupos        = $_POST['cupos'] ?? '';
    $precio       = $_POST['precio'] ?? '';
    $estado       = $_POST['estado'] ?? 'activa';


    // VALIDACIONES
    if (
        !$id_proveedor ||
        empty($nombre) ||
        empty($id_ciudad) ||
        empty($ubicacion) ||
        empty($descripcion) ||
        empty($cupos) ||
        empty($precio)
    ) {
        mostrarSweetAlert(
            'error',
            'Campos incompletos',
            'Por favor completa todos los campos obligatorios'
        );
        exit;
    }

    // VALIDAR IMÁGENES (máx. 5)
    if (!isset($_FILES['imagenes']) || empty($_FILES['imagenes']['name'][0])) {
        mostrarSweetAlert(
            'error',
            'Imágenes requeridas',
            'Debes subir al menos una imagen'
        );
        exit;
    }

    $cantidadImagenes = count($_FILES['imagenes']['name']);

    if ($cantidadImagenes > 5) {
        mostrarSweetAlert(
            'error',
            'Demasiadas imágenes',
            'Máximo se permiten 5 imágenes por actividad'
        );
        exit;
    }

    // VALIDAR EXTENSIÓN Y TAMAÑO (cada imagen)
    $permitidas = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    foreach ($_FILES['imagenes']['name'] as $index => $nombreArchivo) {

        $tmpName = $_FILES['imagenes']['tmp_name'][$index];
        $size    = $_FILES['imagenes']['size'][$index];

        $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        if (!in_array($ext, $permitidas)) {
            mostrarSweetAlert(
                'error',
                'Extensión no permitida',
                'Solo se permiten imágenes JPG o PNG'
            );
            exit;
        }

        if ($size > $maxSize) {
            mostrarSweetAlert(
                'error',
                'Imagen muy pesada',
                'Cada imagen debe pesar máximo 2MB'
            );
            exit;
        }
    }


    // GUARDAR ACTIVIDAD (SIN IMÁGENES)
    $objActividad = new ActividadTuristica();

    $data = [
        'id_proveedor' => $id_proveedor,
        'nombre'       => $nombre,
        'id_ciudad'    => $id_ciudad,
        'ubicacion'    => $ubicacion,
        'descripcion'  => $descripcion,
        'cupos'        => $cupos,
        'precio'       => $precio,
        'estado'       => $estado,
        'imagen'       => 'actividad_default.png'
    ];

    // Guardar actividad
    $id_actividad = $objActividad->registrar($data);

    if (!$id_actividad) {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo registrar la actividad'
        );
        exit;
    }

    // GUARDAR IMÁGENES DE LA ACTIVIDAD
    $directorio = BASE_PATH . '/public/uploads/turistico/actividades/';

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    foreach ($_FILES['imagenes']['name'] as $index => $nombreArchivo) {

        $ext = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        $nombreFinal = uniqid('actividad_') . '.' . $ext;

        move_uploaded_file(
            $_FILES['imagenes']['tmp_name'][$index],
            $directorio . $nombreFinal
        );

        // Primera imagen = principal
        $esPrincipal = ($index === 0) ? 1 : 0;

        $objActividad->guardarImagen([
            'id_actividad' => $id_actividad,
            'imagen'       => $nombreFinal,
            'es_principal' => $esPrincipal
        ]);
    }

    mostrarSweetAlert(
        'success',
        'Registro exitoso',
        'Actividad turística registrada correctamente',
        '/aventura_go/proveedor/registrar-actividad'
    );
    exit;
}




function actualizarActividad()
{
    // DATOS DEL FORMULARIO
    $id_actividad   = $_POST['id_actividad'] ?? '';
    $id_proveedor   = $_SESSION['user']['id_proveedor'] ?? null;
    $nombre         = $_POST['nombre'] ?? '';
    $id_ciudad      = $_POST['id_ciudad'] ?? '';
    $ubicacion      = $_POST['ubicacion'] ?? '';
    $descripcion    = $_POST['descripcion'] ?? '';
    $cupos          = $_POST['cupos'] ?? '';
    $precio         = $_POST['precio'] ?? '';
    $estado         = $_POST['estado'] ?? 'activa';

    // VALIDACIONES
    if (
        empty($id_actividad) ||
        empty($id_proveedor) ||
        empty($nombre) ||
        empty($id_ciudad) ||
        empty($ubicacion) ||
        empty($descripcion) ||
        empty($cupos) ||
        empty($precio)
    ) {
        mostrarSweetAlert(
            'error',
            'Campos incompletos',
            'Todos los campos son obligatorios'
        );
        exit;
    }

    // DATA PARA EL MODELO
    $data = [
        'id_actividad' => $id_actividad,
        'id_proveedor' => $id_proveedor,
        'nombre'       => $nombre,
        'id_ciudad'    => $id_ciudad,
        'ubicacion'    => $ubicacion,
        'descripcion'  => $descripcion,
        'cupos'        => $cupos,
        'precio'       => $precio,
        'estado'       => $estado
    ];

    // MODELO
    $actividadModel = new ActividadTuristica();
    $resultado = $actividadModel->actualizarActividad($data);

    // RESPUESTA
    if ($resultado === true) {
        mostrarSweetAlert(
            'success',
            'Actividad actualizada',
            'La actividad turística fue actualizada correctamente',
            '/aventura_go/proveedor/consultar-actividad'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo actualizar la actividad turística'
        );
    }
}



function listarActividadesProveedor()
{
    require_once __DIR__ . '/../../models/proveedor_turistico/Proveedor.php';

    $proveedorModel = new Proveedor();
    $id_usuario = $_SESSION['user']['id_usuario'];

    $id_proveedor = $proveedorModel->obtenerIdProveedorPorUsuario($id_usuario);

    $actividadModel = new ActividadTuristica();
    $actividades = $actividadModel->listarPorProveedor($id_proveedor);

    require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/consultar_actividad_turistica.php';
}








function listarActividadId($id)
{
    $objActividad = new ActividadTuristica();
    return $objActividad->listarPorId($id);
}


function activarActividad($id)
{
    $objActividad = new ActividadTuristica();
    $resultado = $objActividad->activar($id);

    if ($resultado) {
        mostrarSweetAlert(
            'success',
            'Actividad activada',
            'La actividad fue activada correctamente',
            '/aventura_go/proveedor/consultar-actividades'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo activar la actividad'
        );
    }
}




function desactivarActividad($id)
{
    $objActividad = new ActividadTuristica();
    $resultado = $objActividad->desactivar($id);

    if ($resultado) {
        mostrarSweetAlert(
            'success',
            'Actividad desactivada',
            'La actividad fue desactivada correctamente',
            '/aventura_go/proveedor/consultar-actividades'
        );
    } else {
        mostrarSweetAlert(
            'error',
            'Error',
            'No se pudo desactivar la actividad'
        );
    }
}


function eliminaractividad($id)
{
    $objActividad = new ActividadTuristica();

    $resultado = $objActividad->eliminar($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Eliminación exitosa', 'actividad eliminada.', '/aventura_go/proveedor/consultar-turista');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar el turista.');
    }
}
