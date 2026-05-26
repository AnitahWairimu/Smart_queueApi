<?php
// SmartQueue - Database Connection Script

$host = 'localhost';
$dbname = 'smart_queue';
$username = 'root'; // Usually 'root' for local development (XAMPP/WAMP)
$password = ''; // Usually empty for local development

try {
    // Determine DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    // Set PDO options for better error handling and security
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    // Create a new PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // This echo can be uncommented to test the connection directly in the browser
    // echo "Database connection successful!";
    
} catch (PDOException $e) {
    // If connection fails, catch the error and display a message
    die("Database connection failed: " . $e->getMessage());
}
?>