<?php
require_once __DIR__ . '/../models/Departamento.php';

$departamentoModel = new Departamento();
$departamentos = $departamentoModel->obtenerDepartamentosActivos();

header('Content-Type: application/json');
echo json_encode($departamentos);
