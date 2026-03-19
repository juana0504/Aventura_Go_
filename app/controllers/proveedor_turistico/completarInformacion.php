<?php

require_once __DIR__ . '/../../helpers/session_proveedor.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../helpers/alert_helper.php';
require_once __DIR__ . '/../../models/proveedor_turistico/ProveedorModel.php';
require_once __DIR__ . '/../../helpers/upload_helper.php';

$model = new ProveedorModel();
$idUsuario = $_SESSION['user']['id_usuario'];

class CompletarInformacionController
{
    //aca se maneja la lógica de negocio, es decir, procesar el formulario, validar los datos, subir los archivos 
    // y llamar al modelo para actualizar la información del proveedor.
    private $model;
    private $idUsuario;

    // El constructor recibe el modelo y el ID del usuario para poder trabajar con ellos en los métodos del controlador.
    public function __construct($model, $idUsuario)
    {
        $this->model = $model;
        $this->idUsuario = $idUsuario;
    }

    // Este método se encarga de procesar el formulario cuando se envía. Valida los datos, maneja la subida de archivos
    //  y llama al modelo para actualizar la información del proveedor.
    public function procesarFormulario()
    {
        $nombre_empresa = $_POST['nombre_empresa'] ?? '';
        $nit_rut = $_POST['nit_rut'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $nombre_representante = $_POST['nombre_representante'] ?? '';
        $identificacion_representante = $_POST['identificacion_representante'] ?? '';
        $telefono_representante = $_POST['telefono_representante'] ?? '';
        $id_ciudad = $_POST['id_ciudad'] ?? '';
        $tipo_documento = $_POST['tipo_documento'] ?? '';
        $departamento = $_POST['departamento'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if (
            empty($nombre_empresa) ||
            empty($nit_rut) ||
            empty($email) ||
            empty($telefono) ||
            empty($direccion) ||
            empty($nombre_representante) ||
            empty($identificacion_representante) ||
            empty($telefono_representante) ||
            empty($id_ciudad) ||
            empty($tipo_documento) ||
            empty($departamento) ||
            empty($descripcion)
        ) {
            mostrarSweetAlert(
                'error',
                'Campos incompletos',
                'Por favor completa todos los campos obligatorios.',
                '/aventura_go/proveedor/completar-informacion'
            );
            exit;
        }

        // Manejo de actividades (checkboxes)
        $actividadesArray = $_POST['actividades'] ?? [];
        $actividades = !empty($actividadesArray) ? implode(', ', $actividadesArray) : null;

        $proveedorActual = $this->model->obtenerArchivosActuales($this->idUsuario);

        $nombreLogo = $proveedorActual['logo'];
        $nombreFoto = $proveedorActual['foto_representante'];

        // LOGO - Se llama a la función subirArchivo para manejar la subida del logo. 
        // Si se sube un nuevo logo, se actualiza el nombre del archivo.
        $nuevoLogo = subirArchivo($_FILES['logo'], 'proveedores', 'logo_');

        if ($nuevoLogo) {
            $nombreLogo = $nuevoLogo;
        } elseif (empty($proveedorActual['logo'])) {
            die("Debes subir el logo.");
        }

        // FOTO - Se llama a la función subirArchivo para manejar la subida de la foto del representante.
        // Si se sube una nueva foto, se actualiza el nombre del archivo. Si no se sube una nueva foto y no hay una foto actual, se muestra un error.
        $nuevaFoto = subirArchivo($_FILES['foto_representante'], 'proveedores', 'repre_');

        if ($nuevaFoto) {
            $nombreFoto = $nuevaFoto;
        } elseif (empty($proveedorActual['foto_representante'])) {
            die("Debes subir la foto del representante.");
        }

        // Se prepara un array con todos los datos para actualizar el proveedor.
        $data = [
            ':nombre_empresa' => $nombre_empresa,
            ':nit_rut' => $nit_rut,
            ':email' => $email,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':nombre_representante' => $nombre_representante,
            ':identificacion_representante' => $identificacion_representante,
            ':telefono_representante' => $telefono_representante,
            ':id_ciudad' => $id_ciudad,
            ':tipo_documento' => $tipo_documento,
            ':departamento' => $departamento,
            ':actividades' => $actividades,
            ':descripcion' => $descripcion,
            ':logo' => $nombreLogo,
            ':foto_representante' => $nombreFoto,
            ':id_usuario' => $this->idUsuario
        ];

        // Se llama al modelo para actualizar la información del proveedor. 
        // Si la actualización es exitosa, se muestra un mensaje de éxito. Si no, se muestra un error.
        if ($this->model->actualizarProveedor($data)) {
            mostrarSweetAlert(
                'success',
                'Información actualizada',
                'La información del proveedor ha sido actualizada correctamente.',
                '/aventura_go/proveedor/completar-informacion'
            );
            exit;
        } else {
            die("Error al actualizar la información.");
        }
    }

    // Este método se encarga de mostrar el formulario para completar la información del proveedor.
    public function mostrarFormulario()
    {
        $proveedor = $this->model->obtenerPorUsuario($this->idUsuario);
        require __DIR__ . '/../../views/dashboard/proveedor_turistico/completar_informacion.php';
    }
}

// Se crea una instancia del controlador pasando el modelo y el ID del usuario. 
// Luego se verifica si el formulario fue enviado (método POST) para procesarlo, o si no, se muestra el formulario.
$controller = new CompletarInformacionController($model, $idUsuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->procesarFormulario();
} else {
    $controller->mostrarFormulario();
}
