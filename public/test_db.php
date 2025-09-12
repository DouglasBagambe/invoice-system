<?php
// Simple database connection test
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=biiteeks_invoice_db;charset=utf8', 'biiteeks_invoice', 'L+.a72a7dZuA6F');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p style='color: green;'>✓ Database connection successful!</p>";

    // Test a simple query
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<p>Found " . count($tables) . " tables in the database.</p>";
    echo "<p>Tables: " . implode(', ', array_slice($tables, 0, 10)) . (count($tables) > 10 ? '...' : '') . "</p>";

    // Test specific tables
    $requiredTables = ['client', 'invtest2', 'products'];
    echo "<h3>Checking required tables:</h3>";
    foreach ($requiredTables as $table) {
        if (in_array($table, $tables)) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Table '$table' missing</p>";
        }
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/dashboard'>Test Dashboard</a></p>";
?>
