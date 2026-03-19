<?php
//funcion para subir archivos (logo y foto representante) esta, para evitar repetir código en el controlador 
// y recibir el mismo mensaje de error si el formato no es permitido o si no se sube un archivo cuando es obligatorio.
function subirArchivo($archivo, $carpetaDestino, $prefijo = 'file_')
{

    if (empty($archivo['name'])) {
        return null;
    }

    $permitidas = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $permitidas)) {
        die("Formato no permitido.");
    }

    $nombre = uniqid($prefijo) . '.' . $ext;
    $ruta = __DIR__ . '/../../public/uploads/' . $carpetaDestino . '/' . $nombre;

    move_uploaded_file($archivo['tmp_name'], $ruta);

    return $nombre;
}
