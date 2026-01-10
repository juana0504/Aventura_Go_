<?php

//impotamos las dependencias
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/administrador/proveedor.php';



//capturamos en ua variable el metodo o solicitud hecha  al servidor
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Valida un archivo de imagen de forma segura
 *
 * @param array $file  Elemento de $_FILES (ej. $_FILES['logo'])
 * @param int $maxSizeBytes  Tamaño máximo en bytes
 * @param array $extPermitidas  Extensiones permitidas (sin punto, en minúsculas)
 * @return true|string  Retorna true si es válido, o un mensaje de error (string)
 */
function validarImagenSegura($file, $maxSizeBytes = 2097152, $extPermitidas = ['png', 'jpg', 'jpeg'])
{
    // 1) Verificar que se haya recibido el archivo
    if (!isset($file) || !isset($file['name']) || $file['name'] === '') {
        return "No se envió ningún archivo.";
    }

    // 2) Verificar errores de upload
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        // Mapear errores comunes
        $code = $file['error'] ?? UPLOAD_ERR_OK;
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "El archivo excede el tamaño permitido por el servidor.";
            case UPLOAD_ERR_PARTIAL:
                return "El archivo se subió de forma parcial.";
            case UPLOAD_ERR_NO_FILE:
                return "No se envió ningún archivo.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Falta carpeta temporal en el servidor.";
            case UPLOAD_ERR_CANT_WRITE:
                return "No se pudo escribir el archivo en disco.";
            case UPLOAD_ERR_EXTENSION:
                return "Subida bloqueada por una extensión PHP en el servidor.";
            default:
                return "Error al subir el archivo (código: {$code}).";
        }
    }

    // 3) Validar tamaño
    if (!isset($file['size']) || $file['size'] > $maxSizeBytes) {
        $maxMB = round($maxSizeBytes / (1024 * 1024), 2);
        return "El archivo supera el tamaño permitido ({$maxMB} MB).";
    }

    // 4) Detectar doble extensión o extensiones peligrosas en el nombre original
    $nombreOriginal = $file['name'];
    // detectar patrones peligrosos o extensiones al final
    if (preg_match('/\.(php|phtml|phar|pl|py|sh|exe|js|html|htm|svg|asp|aspx|jsp)$/i', $nombreOriginal)) {
        return "Nombre de archivo no permitido (extensión peligrosa detectada).";
    }

    // 5) Validar extensión permitida (basado en nombre)
    $ext = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    if (!in_array($ext, $extPermitidas)) {
        return "Extensión no permitida. Solo se permiten: " . implode(', ', $extPermitidas) . ".";
    }

    // 6) Validar MIME real del archivo
    if (!is_uploaded_file($file['tmp_name'])) {
        return "Archivo inválido o no subido a la carpeta temporal.";
    }

    $mimeReal = mime_content_type($file['tmp_name']) ?: '';
    $mimePermitidos = [];
    // construir lista de MIME permitidos a partir de extensiones recibidas
    foreach ($extPermitidas as $e) {
        if ($e === 'jpg' || $e === 'jpeg') $mimePermitidos[] = 'image/jpeg';
        if ($e === 'png') $mimePermitidos[] = 'image/png';
        if ($e === 'gif') $mimePermitidos[] = 'image/gif';
        if ($e === 'webp') $mimePermitidos[] = 'image/webp';
    }
    // evitar duplicados
    $mimePermitidos = array_values(array_unique($mimePermitidos));

    if (!in_array($mimeReal, $mimePermitidos)) {
        return "Tipo de archivo no permitido (MIME inválido).";
    }

    // 7) Comprobar que getimagesize() pueda leerlo (protege contra archivos no-imagen)
    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return "El archivo no es una imagen válida o está corrupto.";
    }

    // 8) Chequeos extra: evitar payloads con <?php o <script dentro del binario (simple heurística)
    $contenido = @file_get_contents($file['tmp_name'], false, null, 0, 1024); // leer primer KB
    if ($contenido !== false && preg_match('/(<\?php|<script|eval\(|base64_decode\(|shell_exec\()/i', $contenido)) {
        return "El archivo contiene código o patrones potencialmente maliciosos.";
    }

    // Si pasa todas las validaciones
    return true;
}

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
        } else if ($accion === 'activar') {
            // esta funcion ACTIVA el proveedor segun su id
            activarProveedorTuristico($_GET['id']);
        } else if ($accion === 'desactivar') {
            // esta funcion DESACTIVA el proveedor segun su id
            desactivarProveedorTuristico($_GET['id']);
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
    $nombre_empresa               = $_POST['nombre_empresa'] ?? '';
    $nit_rut                      = $_POST['nit_rut'] ?? '';
    $email                        = $_POST['email'] ?? '';
    $telefono                     = $_POST['telefono'] ?? '';
    $nombre_representante         = $_POST['nombre_representante'] ?? '';
    $identificacion_representante = $_POST['identificacion_representante'] ?? '';
    $email_representante          = $_POST['email_representante'] ?? '';
    $telefono_representante       = $_POST['telefono_representante'] ?? '';
    $actividades                  = $_POST['actividades'] ?? [];
    $descripcion                  = $_POST['descripcion'] ?? '';
    $departamento                 = $_POST['departamento'] ?? '';
    $ciudad                       = $_POST['ciudad'] ?? '';
    $direccion                    = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($email) ||
        empty($telefono) || empty($nombre_representante) || empty($identificacion_representante) ||
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

        // Validación segura (máx 2MB, mismas extensiones permitidas que tenías)
        $valid = validarImagenSegura($file, 2 * 1024 * 1024, ['png', 'jpg', 'jpeg']);
        if ($valid !== true) {
            mostrarSweetAlert('error', 'Archivo inválido (logo)', $valid);
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $logo_url = uniqid('logo_') . "." . $ext;
        $destinoDir = BASE_PATH . "/public/uploads/turistico/";
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0755, true);
        }
        $destino = $destinoDir . $logo_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $logo_url = 'default_proveedor.png';
    }


    // FOTO PRINCIPAL
    if (!empty($_FILES['foto']['name'])) {
        $file = $_FILES['foto'];

        // Validación segura (máx 3MB para foto principal)
        $valid = validarImagenSegura($file, 3 * 1024 * 1024, ['png', 'jpg', 'jpeg']);
        if ($valid !== true) {
            mostrarSweetAlert('error', 'Archivo inválido (foto principal)', $valid);
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $foto_url = uniqid('foto_') . "." . $ext;
        $destinoDir = BASE_PATH . "/public/uploads/usuario/";
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0755, true);
        }
        $destino = $destinoDir . $foto_url;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_url = 'default_proveedor.png';
    }


    // FOTO ACTIVIDAD
    if (!empty($_FILES['foto_actividad']['name'])) {
        $file = $_FILES['foto_actividad'];

        // Validación segura (máx 3MB)
        $valid = validarImagenSegura($file, 3 * 1024 * 1024, ['png', 'jpg', 'jpeg']);
        if ($valid !== true) {
            mostrarSweetAlert('error', 'Archivo inválido (foto actividad)', $valid);
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $foto_act = uniqid('actividad_') . "." . $ext;
        $destinoDir = BASE_PATH . "/public/uploads/turistico/actividades/";
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0755, true);
        }
        $destino = $destinoDir . $foto_act;
        move_uploaded_file($file['tmp_name'], $destino);
    } else {
        $foto_act = 'default_proveedor.png';
    }

    $claveHash = password_hash($identificacion_representante, PASSWORD_DEFAULT);

    $objProveedor = new Proveedor();

    $data = [
        'nombre_empresa'          => $nombre_empresa,
        'logo'                    => $logo_url,
        'email'                   => $email,
        'telefono'                => $telefono,
        'nit_rut'                 => $nit_rut,
        'nombre_representante'    => $nombre_representante,
        'identificacion_representante' => $identificacion_representante,
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
    $id_usuario            = $_POST['id_usuario'] ?? '';
    $nombre_empresa          = $_POST['nombre_empresa'] ?? '';
    $email                   = $_POST['email'] ?? '';
    $telefono                = $_POST['telefono'] ?? '';
    $nit_rut                 = $_POST['nit_rut'] ?? '';
    $nombre_representante    = $_POST['nombre_representante'] ?? '';
    $identificacion_representante  = $_POST['identificacion_representante'] ?? '';
    $email_representante     = $_POST['email_representante'] ?? '';
    $telefono_representante = $_POST['telefono_representante'] ?? '';
    $actividades             = $_POST['actividades'] ?? [];
    $descripcion             = $_POST['descripcion'] ?? '';
    $departamento            = $_POST['departamento'] ?? '';
    $ciudad                  = $_POST['ciudad'] ?? '';
    $direccion               = $_POST['direccion'] ?? '';

    if (
        empty($nombre_empresa) || empty($nit_rut) || empty($email) ||
        empty($telefono) || empty($nombre_representante) || empty($identificacion_representante) || empty($email_representante) ||
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
        'id_usuario'             => $id_usuario,
        'nombre_empresa'           => $nombre_empresa,
        'email'                    => $email,
        'telefono'                 => $telefono,
        'nit_rut'                  => $nit_rut,
        'nombre_representante'     => $nombre_representante,
        'identificacion_representante'     => $identificacion_representante,
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

// consultar un proveedor (boton ojo de la tabla)
function consultarProveedorOjo()
{
    // Obtener ID desde GET
    $id = $_GET['id'] ?? null;

    // Validar ID
    if (!$id) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'ID del proveedor no especificado']);
        exit;
    }

    // Consultar el modelo directamente
    $objProveedor = new Proveedor();
    $proveedor = $objProveedor->listarProveedor($id);


    // Validar si se encontró el proveedor
    if (!$proveedor) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Proveedor no encontrado']);
        exit;
    }

    // Responder con JSON (ok)
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($proveedor);
    exit;
}

//cambiar estado del proveedor a ACTIVO
function activarProveedorTuristico($id)
{
    $objProveedor = new Proveedor();

    $resultado = $objProveedor->activarProveedor($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Activación Exítosa del proveedor', 'Proveedor turistico activo en el sistema.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al activar ', 'No se pudo activar el proveedor turistico.');
    }
}

//cambiar estado del proveedor a INACTIVO
function desactivarProveedorTuristico($id)
{
    $objProveedor = new Proveedor();

    $resultado = $objProveedor->desactivarProveedor($id);

    if ($resultado === true) {
        mostrarSweetAlert('success', 'Desactivación Exítosa del proveedor', 'Proveedor turistico inactivo en el sistema.', '/aventura_go/administrador/consultar-proveedor-turistico');
    } else {
        mostrarSweetAlert('error', 'Error al Desactivar', 'No se pudo activar el proveedor turistico.');
    }
}

/**
 * Obtener proveedor por ID (AJAX)
 * Retorna JSON
 */
function obtenerProveedorPorIdAjax()
{
    header('Content-Type: application/json');

    if (!isset($_GET['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID no recibido'
        ]);
        exit;
    }

    $id = intval($_GET['id']);

    // reutilizamos la función que YA EXISTE
    $proveedor = listarProveedorId($id);

    if (!$proveedor) {
        echo json_encode([
            'success' => false,
            'message' => 'Proveedor no encontrado'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data' => $proveedor
    ]);
    exit;
}
