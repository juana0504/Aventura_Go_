<?php
//este archivo es para cuando carguemos a un servuidor no se haga mayor configuracion en ese hosting cuando se publique, ni cambiar carpetas
//configuracion global del proyecto

//detectar protocolo (http o https)
$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

//nombre de la carpeta del proyecto en el local
$baseFolder = '/aventura_go';

//host actual
$host = $_SERVER['HTTP_HOST'];

//URL base dinamica (funciona en local y en hosting)
define('BASE_URL', $protocol . $host . $baseFolder);

//ruta base del proyecto (pra require o include)
define('BASE_PATH', dirname(__DIR__));

?>