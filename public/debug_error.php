<?php
// Debug file to check what's happening after login

echo "<h1>DEBUG: Checking CodeIgniter Setup</h1>";

// Check if we can load the basic files
try {
    echo "<h2>1. Loading Paths.php</h2>";
    require_once __DIR__ . '/../app/Config/Paths.php';
    echo "✅ Paths.php loaded successfully<br>";
    
    echo "<h2>2. Creating Paths object</h2>";
    $paths = new Config\Paths();
    echo "✅ Paths object created<br>";
    
    echo "<h2>3. Checking SYSTEMPATH</h2>";
    if (defined('SYSTEMPATH')) {
        echo "✅ SYSTEMPATH defined: " . SYSTEMPATH . "<br>";
    } else {
        echo "❌ SYSTEMPATH not defined<br>";
    }
    
    echo "<h2>4. Loading bootstrap.php</h2>";
    $app = require_once SYSTEMPATH . 'bootstrap.php';
    if ($app) {
        echo "✅ CodeIgniter app created: " . get_class($app) . "<br>";
    } else {
        echo "❌ Bootstrap returned null<br>";
    }
    
    echo "<h2>5. Testing Home controller</h2>";
    $homeController = new \App\Controllers\Home();
    echo "✅ Home controller created successfully<br>";
    
    echo "<h2>6. Testing index method</h2>";
    // Don't actually call the method, just check if it exists
    if (method_exists($homeController, 'index')) {
        echo "✅ Home::index method exists<br>";
    } else {
        echo "❌ Home::index method not found<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

echo "<h2>7. Test Links</h2>";
echo "<a href='index.php'>Test main site</a><br>";
echo "<a href='index.php/dashboard'>Test dashboard</a><br>";
echo "<a href='index.php/home'>Test home</a><br>";
?>
