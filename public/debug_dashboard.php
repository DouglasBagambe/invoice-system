<?php
// Debug script to test dashboard functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Dashboard Debug Test</h1>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db', 'root', '');
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Test a simple query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM client LIMIT 1");
    $result = $stmt->fetch();
    echo "<p style='color: green;'>✓ Database query test successful - Client table has " . $result['count'] . " records</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test if required tables exist
$tables = ['client', 'invtest2', 'invtest', 'products', 'protest2', 'protest', 'quote2', 'quickquote'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Table '$table' does not exist</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error checking table '$table': " . $e->getMessage() . "</p>";
    }
}

// Test memory and execution time
echo "<p>Current memory usage: " . memory_get_usage(true) / 1024 / 1024 . " MB</p>";
echo "<p>Memory limit: " . ini_get('memory_limit') . "</p>";
echo "<p>Max execution time: " . ini_get('max_execution_time') . " seconds</p>";

echo "<h2>Test Complete</h2>";
echo "<p><a href='/dashboard'>Go to Dashboard</a></p>";
?>
