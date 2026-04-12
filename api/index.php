<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to stderr for Vercel logs
ini_set('log_errors', 1);
ini_set('error_log', 'php://stderr');

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>Aegis Sentinel - Fatal Error during Boot</h1>";
    echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
    error_log($e->getMessage());
}
