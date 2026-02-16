<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file manually
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line && strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
        }
    }
}

use App\Config\Database;

try {
    echo "Attempting to connect to SQL Server...\n";
    
    $connection = Database::getConnection();
    
    echo "✓ Connection successful!\n";
    
    // Test query
    $stmt = $connection->query("SELECT @@VERSION AS version");
    $result = $stmt->fetch();
    
    echo "\nServer Info:\n";
    echo $result['version'] . "\n";
    
    Database::closeConnection();
    
} catch (Exception $e) {
    echo "✗ Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
