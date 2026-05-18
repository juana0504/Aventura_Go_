<?php
// Este archivo define configuracion global del proyecto para local y hosting.

// Detectar protocolo real (incluye proxy inverso comun en hosting).
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$protocol = $isHttps ? 'https://' : 'http://';

// Detectar carpeta base a partir de la ruta del front controller.
// En local suele ser /aventura_go/ y en hosting raiz suele ser /.
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = rtrim($scriptDir, '/');
$baseFolder = $scriptDir === '' ? '/' : ($scriptDir . '/');

// Host actual
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// URL base dinamica (funciona en local y en hosting)
define('BASE_URL', $protocol . $host . $baseFolder);

//ruta base del proyecto (pra require o include)
define('BASE_PATH', dirname(__DIR__));

// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
