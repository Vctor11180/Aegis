<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Aegis Sentinel - PHP Diagnostics</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";

$extensions = ['bcmath', 'gmp', 'sodium', 'openssl', 'pdo_mysql', 'curl'];
echo "<h2>Required Extensions:</h2><ul>";
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? "✅ Loaded" : "❌ Missing";
    echo "<li>$ext: $status</li>";
}
echo "</ul>";

echo "<h2>Project Structure:</h2>";
echo "Current Dir: " . __DIR__ . "<br>";
echo "Public Dir exists: " . (is_dir(__DIR__ . '/../public') ? "✅ Yes" : "❌ No") . "<br>";
echo "Vendor Autoload exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? "✅ Yes" : "❌ No") . "<br>";

echo "<h2>Environment:</h2>";
echo "APP_KEY set: " . (env('APP_KEY') ? "✅ Yes" : "❌ No") . "<br>";
echo "VERCEL_URL: " . ($_SERVER['VERCEL_URL'] ?? 'Not set') . "<br>";

function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) return $default;
    return $value;
}
