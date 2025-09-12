<?php
// Database connection test

echo "<h1>Database Connection Test</h1>";

// Test 1: Check if we can load CodeIgniter
try {
    echo "<h2>1. Loading CodeIgniter</h2>";
    require_once __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    $app = require_once SYSTEMPATH . 'bootstrap.php';
    echo "✅ CodeIgniter loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ CodeIgniter failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Check database connection
try {
    echo "<h2>2. Testing Database Connection</h2>";
    $db = \Config\Database::connect();
    echo "✅ Database connection successful<br>";
    
    // Test 3: Check if admin table exists
    echo "<h2>3. Checking Admin Table</h2>";
    $tables = $db->listTables();
    if (in_array('admin', $tables)) {
        echo "✅ Admin table exists<br>";
        
        // Test 4: Check admin table structure
        echo "<h2>4. Admin Table Structure</h2>";
        $fields = $db->getFieldNames('admin');
        echo "Admin table fields: " . implode(', ', $fields) . "<br>";
        
        // Test 5: Check if there are any admin users
        echo "<h2>5. Checking Admin Users</h2>";
        $result = $db->table('admin')->countAllResults();
        echo "Number of admin users: $result<br>";
        
        if ($result > 0) {
            // Test 6: Show first admin user (without password)
            echo "<h2>6. First Admin User</h2>";
            $admin = $db->table('admin')->select('id, username, name, email')->limit(1)->get()->getRowArray();
            if ($admin) {
                echo "✅ Found admin user: " . $admin['username'] . " (ID: " . $admin['id'] . ")<br>";
            }
        } else {
            echo "❌ No admin users found in database<br>";
        }
        
    } else {
        echo "❌ Admin table not found<br>";
        echo "Available tables: " . implode(', ', $tables) . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    echo "Error code: " . $e->getCode() . "<br>";
}

// Test 7: Check environment variables
echo "<h2>7. Environment Check</h2>";
echo "CI_ENVIRONMENT: " . (defined('ENVIRONMENT') ? ENVIRONMENT : 'Not defined') . "<br>";
echo "Database hostname: " . (getenv('database.default.hostname') ?: 'Not set') . "<br>";
echo "Database name: " . (getenv('database.default.database') ?: 'Not set') . "<br>";
echo "Database username: " . (getenv('database.default.username') ?: 'Not set') . "<br>";
echo "Database password: " . (getenv('database.default.password') ? 'Set' : 'Not set') . "<br>";

?>
