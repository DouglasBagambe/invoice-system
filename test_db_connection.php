<?php
// Simple database connection test - place this in your root directory
echo "<h2>Database Connection Test</h2>";

$hostname = 'localhost';
$username = 'biiteeks_invoice';
$password = 'L+.a72a7dZuA6F';
$database = 'biiteeks_invoice_db';
$port = 3306;

echo "Testing connection with:<br>";
echo "Host: $hostname<br>";
echo "Database: $database<br>";
echo "Username: $username<br>";
echo "Port: $port<br><br>";

try {
    // Test basic mysqli connection
    $mysqli = new mysqli($hostname, $username, $password, $database, $port);
    
    if ($mysqli->connect_error) {
        echo "❌ Connection failed: " . $mysqli->connect_error . "<br>";
        echo "Error code: " . $mysqli->connect_errno . "<br>";
    } else {
        echo "✅ Database connection successful!<br>";
        echo "Server version: " . $mysqli->server_info . "<br>";
        
        // Test if admin table exists
        $result = $mysqli->query("SHOW TABLES LIKE 'admin'");
        if ($result && $result->num_rows > 0) {
            echo "✅ 'admin' table exists<br>";
        } else {
            echo "❌ 'admin' table does not exist<br>";
        }
        
        // Test if client table exists
        $result = $mysqli->query("SHOW TABLES LIKE 'client'");
        if ($result && $result->num_rows > 0) {
            echo "✅ 'client' table exists<br>";
        } else {
            echo "❌ 'client' table does not exist<br>";
        }
        
        $mysqli->close();
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "<br>";
}

echo "<br><a href='/dashboard'>Try Dashboard</a> | <a href='/debug/dashboard'>Debug Dashboard</a>";
?>
