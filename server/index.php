<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to stderr for Vercel logs
ini_set('log_errors', 1);
ini_set('error_log', 'php://stderr');

// Vercel path overrides
if (getenv('VERCEL') || isset($_SERVER['VERCEL_URL'])) {
    // Redirect storage to /tmp
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
        mkdir($storagePath . '/framework/views', 0755, true);
        mkdir($storagePath . '/framework/cache', 0755, true);
        mkdir($storagePath . '/framework/sessions', 0755, true);
        mkdir($storagePath . '/logs', 0755, true);
    }
    
    // Force Laravel to use /tmp for everything
    putenv("LARAVEL_STORAGE_PATH=$storagePath");
    
    // Prevent writing to bootstrap/cache
    putenv('APP_CONFIG_CACHE=' . $storagePath . '/config.php');
    putenv('APP_ROUTES_CACHE=' . $storagePath . '/routes.php');
    putenv('APP_SERVICES_CACHE=' . $storagePath . '/services.php');
    putenv('APP_PACKAGES_CACHE=' . $storagePath . '/packages.php');
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>Aegis Sentinel - Fatal Error during Boot</h1>";
    echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
    error_log($e->getMessage());
}
