<?php

require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/actividadTuristica.php';
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

        if ($accion === 'eliminar') {
            eliminaractividad($_GET['id'] ?? null);
            exit;
        }

        if ($accion === 'activar') {
            activarActividad($_GET['id'] ?? null);
            exit;
        }

        if ($accion === 'desactivar') {
            desactivarActividad($_GET['id'] ?? null);
            exit;
        }

        if ($accion === 'registrar') {

            // cargar vista registrar actividad
            require_once __DIR__ . '/../../views/dashboard/proveedor_turistico/registrar_actividad_turistica.php';
            exit;
        }


        if (isset($_GET['id'])) {
            listarActividadId($_GET['id']);
        } else {
            listarActividades();
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
    if (!$id_proveedor) {
        mostrarSweetAlert('error', 'Error de cuenta', 'No se encontró el perfil de proveedor. Contacta al soporte.');
        exit;
    }
    if (empty($nombre) || empty($id_ciudad) || empty($ubicacion) || empty($descripcion) || empty($cupos) || empty($precio)) {
        $faltante = match(true) {
            empty($nombre)      => 'Nombre',
            empty($id_ciudad)   => 'Ciudad (debes seleccionar departamento y luego ciudad)',
            empty($ubicacion)   => 'Ubicación exacta',
            empty($descripcion) => 'Descripción',
            empty($cupos)       => 'Cupos',
            empty($precio)      => 'Precio',
            default             => 'campo desconocido',
        };
        mostrarSweetAlert('error', 'Campo requerido', "Falta completar: $faltante", BASE_URL . 'proveedor/registrar-actividad');
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

        $size = $_FILES['imagenes']['size'][$index];

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
        BASE_URL . 'proveedor/registrar-actividad'
    );
    exit;
}




function actualizarActividad()
{
    // DATOS DEL FORMULARIO
    $id_actividad   = $_POST['id_actividad'] ?? '';
    $id_proveedor   = $_POST['id_proveedor'] ?? '';
    $nombre         = $_POST['nombre'] ?? '';
    $id_ciudad      = $_POST['id_ciudad'] ?? '';
    $ubicacion      = $_POST['ubicacion'] ?? '';
    $descripcion    = $_POST['descripcion'] ?? '';
    $cupos          = $_POST['cupos'] ?? '';
    $precio         = $_POST['precio'] ?? '';
    $estado         = $_POST['estado'] ?? 'activa';

    // VALIDACIONES
    if (
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

    $actividadModel = new ActividadTuristica();
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
    $resultado = $actividadModel->actualizarActividad($data);

    if ($resultado !== true) {
        mostrarSweetAlert('error', 'Error', 'No se pudo actualizar la actividad turística');
        exit;
    }

    // IMÁGENES OPCIONALES: si se subieron archivos nuevos, reemplazar
    if (!empty($_FILES['imagenes']['name'][0])) {

        $cantidadImagenes = count($_FILES['imagenes']['name']);

        if ($cantidadImagenes > 5) {
            mostrarSweetAlert('error', 'Demasiadas imágenes', 'Máximo se permiten 5 imágenes por actividad');
            exit;
        }

        $permitidas = ['jpg', 'jpeg', 'png'];
        $maxSize    = 2 * 1024 * 1024;

        foreach ($_FILES['imagenes']['name'] as $index => $nombreArchivo) {
            $ext  = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            $size = $_FILES['imagenes']['size'][$index];

            if (!in_array($ext, $permitidas)) {
                mostrarSweetAlert('error', 'Extensión no permitida', 'Solo se permiten imágenes JPG o PNG');
                exit;
            }
            if ($size > $maxSize) {
                mostrarSweetAlert('error', 'Imagen muy pesada', 'Cada imagen debe pesar máximo 2MB');
                exit;
            }
        }

        // Eliminar imágenes anteriores y guardar las nuevas
        $actividadModel->eliminarImagenes($id_actividad);

        $directorio = BASE_PATH . '/public/uploads/turistico/actividades/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        foreach ($_FILES['imagenes']['name'] as $index => $nombreArchivo) {
            $ext         = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            $nombreFinal = uniqid('actividad_') . '.' . $ext;
            move_uploaded_file($_FILES['imagenes']['tmp_name'][$index], $directorio . $nombreFinal);

            $actividadModel->guardarImagen([
                'id_actividad' => $id_actividad,
                'imagen'       => $nombreFinal,
                'es_principal' => ($index === 0) ? 1 : 0,
            ]);
        }
    }

    mostrarSweetAlert(
        'success',
        'Actividad actualizada',
        'La actividad turística fue actualizada correctamente',
        BASE_URL . 'proveedor/consultar-actividad'
    );
}



function listarActividades()
{
    require_once __DIR__ . '/../../models/proveedor_turistico/Proveedor.php';
    $proveedorModel = new Proveedor();
    $id_usuario = $_SESSION['user']['id_usuario'];

    $id_proveedor = $proveedorModel->obtenerIdProveedorPorUsuario($id_usuario);

    $actividadModel = new ActividadTuristica();
    $actividad = $actividadModel->listarPorProveedor($id_proveedor);

    return $actividad;
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
            BASE_URL . 'proveedor/consultar-actividad'
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
            BASE_URL . 'proveedor/consultar-actividad'
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
        mostrarSweetAlert('success', 'Eliminación exitosa', 'actividad eliminada.', BASE_URL . 'proveedor/consultar-actividad');
    } else {
        mostrarSweetAlert('error', 'Error al eliminar', 'No se pudo eliminar la actividad.');
    }
}

function consultarActividadOjo()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'ID no especificado']);
        exit;
    }

    $objActividad = new ActividadTuristica();
    $actividad = $objActividad->listarParaModal($id);

    if (!$actividad) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Actividad no encontrada']);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($actividad);
    exit;
}
