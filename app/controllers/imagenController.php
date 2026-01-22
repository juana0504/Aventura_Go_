<?php

class ImagenController
{
    public static function turistico($archivo)
    {
        $archivo = basename($archivo);
        $ruta = BASE_PATH . '/public/uploads/turistico/' . $archivo;

        if (!file_exists($ruta)) {
            http_response_code(404);
            exit;
        }

        $mime = mime_content_type($ruta);

        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'])) {
            http_response_code(403);
            exit;
        }

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        exit;
    }
}
