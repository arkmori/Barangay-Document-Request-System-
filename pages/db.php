<?php
// 1. Database Credentials (Default for XAMPP)
$host = 'localhost';
$db   = 'barangay_system_db'; // This MUST match the name you created in phpMyAdmin
$user = 'root';               // Default user for XAMPP
$pass = '';                   // Default password for XAMPP is empty

// 2. Attempt to Connect
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Enable error reporting (helper for debugging)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 3. Start Session Globally
    // This allows you to remember who is logged in across different pages
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

} catch (PDOException $e) {
    // If connection fails, stop the script and show the error
    die("Connection failed: " . $e->getMessage());
}
?>