<?php
// Router for PHP built-in server to handle static files
if (php_sapi_name() == 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // First check if file exists in public directory
    $publicFile = __DIR__ . '/public' . $path;
    if (file_exists($publicFile)) {
        // Set proper MIME type
        $ext = pathinfo($publicFile, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: text/javascript');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'ico':
                header('Content-Type: image/x-icon');
                break;
            case 'woff':
                header('Content-Type: font/woff');
                break;
            case 'woff2':
                header('Content-Type: font/woff2');
                break;
        }
        readfile($publicFile);
        exit;
    }
    
    // Check if file exists in root
    $rootFile = __DIR__ . $path;
    if (file_exists($rootFile) && !is_dir($rootFile)) {
        return false; // Let PHP serve it
    }
}

// Fall back to index.php for CodeIgniter routing
require_once __DIR__ . '/index.php';
?>
