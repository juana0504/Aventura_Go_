<?php
// Importamos el modelo Ciudad, que es el encargado de comunicarse con la base de datos
require_once __DIR__ . '/../models/Ciudad.php';

// Validamos que desde la URL venga el id del departamento
// Ejemplo de URL esperada:
// ciudadController.php?id_departamento=14
if (!isset($_GET['id_departamento'])) {
    // Si no llega el id_departamento, devolvemos un arreglo vacío en formato JSON
    // Esto evita errores en el frontend
    echo json_encode([]);
    exit;
}

// Convertimos el valor recibido a entero por seguridad
// Esto previene inyecciones y errores de tipo
$id_departamento = (int) $_GET['id_departamento'];

// Creamos una instancia del modelo Ciudad
$ciudadModel = new Ciudad();

// Llamamos al método del modelo que obtiene las ciudades
// asociadas al departamento seleccionado
$ciudades = $ciudadModel->obtenerPorDepartamento($id_departamento);

// Indicamos que la respuesta será en formato JSON
// Esto es importante para que JavaScript lo pueda leer correctamente
header('Content-Type: application/json');

// Enviamos las ciudades al frontend en formato JSON
// Ejemplo de respuesta:
// [
//   { "id_ciudad": 1, "nombre": "Bogotá" },
//   { "id_ciudad": 2, "nombre": "Soacha" }
// ]
echo json_encode($ciudades);
