<?php
session_start();

/*
|--------------------------------------------------------------------------
| 1. Validar que venga desde el checkout (POST)
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/checkout');
    exit;
}

/*
|--------------------------------------------------------------------------
| 2. Validar que exista la reserva temporal
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['reserva_tmp'])) {
    header('Location: ' . BASE_URL . '/descubre-tours');
    exit;
}

/*
|--------------------------------------------------------------------------
| 3. Validar datos obligatorios del formulario
|--------------------------------------------------------------------------
*/
$required = ['nombre', 'email', 'telefono', 'metodo_pago', 'reference', 'total'];

foreach ($required as $field) {
    if (empty($_POST[$field])) {
        header('Location: ' . BASE_URL . '/checkout');
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| 4. Limpiar y capturar datos
|--------------------------------------------------------------------------
*/
$datosPago = [
    'reference'     => $_POST['reference'],
    'total'         => $_POST['total'],
    'currency'      => $_POST['currency'] ?? 'COP',
    'descripcion'   => $_POST['descripcion'] ?? 'Reserva Aventura Go',
    'metodo_pago'   => $_POST['metodo_pago'],

    'cliente' => [
        'nombre'   => trim($_POST['nombre']),
        'email'    => trim($_POST['email']),
        'telefono' => trim($_POST['telefono']),
    ]
];

/*
|--------------------------------------------------------------------------
| 5. Guardar datos de pago en sesión (TEMPORAL)
|--------------------------------------------------------------------------
|  OJO: aún NO es pago real
*/
$_SESSION['pago_tmp'] = $datosPago;

/*
|--------------------------------------------------------------------------
| 6. Redirigir según el método de pago
|--------------------------------------------------------------------------
*/
switch ($datosPago['metodo_pago']) {

    case 'payu':
        header('Location: ' . BASE_URL . '/pago/payu');
        exit;

    case 'mercadopago':
        header('Location: ' . BASE_URL . '/pago/mercadopago');
        exit;

    default:
        // Método no válido
        header('Location: ' . BASE_URL . '/checkout');
        exit;
}
