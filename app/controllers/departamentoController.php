<?php
// Importa el modelo Departamento.
// Este archivo contiene la clase que se encarga de consultar la tabla `departamentos` en la base de datos.
require_once __DIR__ . '/../models/Departamento.php';

// Creamos una instancia del modelo Departamento. Al instanciarlo, se establece la conexión a la base de datos.
$departamentoModel = new Departamento();

// Llamamos al método que obtiene únicamente los departamentos activos. Este método devuelve un arreglo con el id y el nombre de cada departamento.
$departamentos = $departamentoModel->obtenerDepartamentosActivos();

// Indicamos que la respuesta que enviará este archivo será en formato JSON.
// Esto es obligatorio para que JavaScript (fetch/AJAX) interprete correctamente los datos.
header('Content-Type: application/json');

// Convertimos el arreglo de departamentos a formato JSON y lo enviamos como respuesta al navegador o al frontend.
echo json_encode($departamentos);
