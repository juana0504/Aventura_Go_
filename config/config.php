<?php
// Este archivo se creo para cuando carguemos a un servidor no se mayor configuracion en ese hosting cuando se publique 
// configuración global del proyecto

// Detectar protocolo (HTTP o HTTPS)
$protocol = isset($_SERVER['HTTPS']) ? 'https//' : 'http://';

// Nombre de la cqrarpeta del proyecto local
$baseFolder = '/aventura_go';

// Host actual
$host = $_SERVER['HTTP_HOST'];

// URL base dinamica (funciona en local y hosting)
define('BASE_URL', $protocol . $host . $baseFolder);

// Ruta base del proyecto (para requiere o include)
define('BASE_PATH', dirname(__DIR__));

?>