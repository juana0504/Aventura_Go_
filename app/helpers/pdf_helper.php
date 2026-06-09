<?php

require_once __DIR__ . '/../../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function pdf_brand_logo_svg_markup(): string
{
    return '<div style="width:146px;font-family:DejaVu Sans,Arial,sans-serif;line-height:1;">'
        . '<div style="font-size:19px;font-weight:900;letter-spacing:0.2px;color:#f8fafc;text-align:left;">AVENTURA</div>'
    . '<div style="font-size:30px;font-weight:900;letter-spacing:0.2px;color:#ea8217;text-align:right;padding-right:30px;">GO</div>'
        . '</div>';
}

function pdf_replace_images_without_gd(string $html): string
{
    return preg_replace_callback('/<img\b[^>]*>/i', function ($matches) {
        $imgTag = $matches[0];
        $alt = 'Imagen';

        if (preg_match('/alt\s*=\s*(["\'])(.*?)\1/i', $imgTag, $altMatch)) {
            $cleanAlt = trim((string) $altMatch[2]);
            if ($cleanAlt !== '') {
                $alt = htmlspecialchars($cleanAlt, ENT_QUOTES, 'UTF-8');
            }
        }

        return '<span style="display:inline-block;padding:3px 7px;border:1px solid #cbd5e1;border-radius:999px;font-size:8px;color:#334155;background:#f8fafc;">' . $alt . '</span>';
    }, $html) ?? $html;
}
function pdf_asset(string $relativePath): string
{
    $relativePath = ltrim($relativePath, '/\\');

    if (defined('BASE_PATH')) {
        $fullPath = BASE_PATH . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
        $realPath = realpath($fullPath);

        if ($realPath !== false) {
            return 'file:///' . str_replace(' ', '%20', str_replace('\\', '/', $realPath));
        }
    }

    return defined('BASE_URL') ? BASE_URL . str_replace('\\', '/', $relativePath) : $relativePath;
}

function pdf_image_data_uri(string $relativePath, string $fallbackText = ''): string
{
    $relativePath = ltrim($relativePath, '/\\');

    if (!defined('BASE_PATH')) {
        return '';
    }

    $fullPath = BASE_PATH . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    $realPath = realpath($fullPath);

    if ($realPath !== false && is_file($realPath)) {
        $mimeType = function_exists('mime_content_type') ? mime_content_type($realPath) : 'image/png';
        $content = base64_encode(file_get_contents($realPath));

        return 'data:' . $mimeType . ';base64,' . $content;
    }

    $label = $fallbackText !== '' ? htmlspecialchars($fallbackText, ENT_QUOTES, 'UTF-8') : 'Aventura Go';
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="360" height="220" viewBox="0 0 360 220"><rect width="360" height="220" rx="24" fill="#1a2b3c"/><rect x="18" y="18" width="324" height="184" rx="18" fill="#ea8217" opacity="0.12"/><text x="50%" y="50%" fill="#ffffff" font-size="26" font-family="Arial, sans-serif" text-anchor="middle" dominant-baseline="middle">' . $label . '</text></svg>';

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

function pdf_image_data_uri_resized(string $relativePath, int $maxWidth = 420, string $fallbackText = ''): string
{
    $relativePath = ltrim($relativePath, '/\\');

    if (!defined('BASE_PATH')) {
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    $fullPath = BASE_PATH . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    $realPath = realpath($fullPath);

    if ($realPath === false || !is_file($realPath) || !extension_loaded('gd')) {
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    $binary = @file_get_contents($realPath);
    if ($binary === false) {
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    $source = @imagecreatefromstring($binary);
    if ($source === false) {
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);

    if ($sourceWidth <= $maxWidth) {
        imagedestroy($source);
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    $targetWidth = $maxWidth;
    $targetHeight = (int) round(($sourceHeight * $targetWidth) / $sourceWidth);
    $target = imagecreatetruecolor($targetWidth, $targetHeight);

    imagealphablending($target, false);
    imagesavealpha($target, true);
    $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
    imagefilledrectangle($target, 0, 0, $targetWidth, $targetHeight, $transparent);

    imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

    ob_start();
    imagepng($target);
    $resizedBinary = ob_get_clean();

    imagedestroy($source);
    imagedestroy($target);

    if ($resizedBinary === false) {
        return pdf_image_data_uri($relativePath, $fallbackText);
    }

    return 'data:image/png;base64,' . base64_encode($resizedBinary);
}

function generarPDF($html, $filename = "documento.pdf", $download = false)
{
    $previousDisplayErrors = ini_get('display_errors');
    $previousErrorReporting = error_reporting();

    // Evita que avisos de librerias legacy rompan la descarga/visualizacion del PDF.
    ini_set('display_errors', '0');
    error_reporting($previousErrorReporting & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_WARNING);

    try {
        if (!extension_loaded('gd')) {
            $html = pdf_replace_images_without_gd($html);
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // permite imágenes externas

        $dompdf = new Dompdf($options);

        // Cargar el HTML recibido
        $dompdf->loadHtml($html);

        // Opcional: tamaño y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar
        $dompdf->render();

        // Limpiar cualquier salida previa para no romper los headers del PDF.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Descargar o mostrar
        $dompdf->stream($filename, [
            "Attachment" => $download ? 1 : 0
        ]);
    } catch (\Throwable $e) {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: text/html; charset=UTF-8');
        }

        echo '<h2>No fue posible generar el PDF.</h2>';
        if ((int) $previousDisplayErrors === 1) {
            echo '<pre>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</pre>';
        }
    } finally {
        // Restaurar configuracion previa del entorno.
        error_reporting($previousErrorReporting);
        ini_set('display_errors', (string) $previousDisplayErrors);
    }
}