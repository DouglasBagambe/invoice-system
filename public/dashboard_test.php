<?php
// Dashboard debug test

echo "<h1>Dashboard Debug Test</h1>";

// Test 1: Load CodeIgniter
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

// Test 2: Test Home controller
try {
    echo "<h2>2. Testing Home Controller</h2>";
    $homeController = new \App\Controllers\Home();
    echo "✅ Home controller created successfully<br>";
    
    // Test 3: Test the index method
    echo "<h2>3. Testing Home::index method</h2>";
    if (method_exists($homeController, 'index')) {
        echo "✅ Home::index method exists<br>";
    } else {
        echo "❌ Home::index method not found<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Home controller failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

// Test 4: Check if Dashboard/home view exists
echo "<h2>4. Checking Dashboard/home view</h2>";
$dashboardView = __DIR__ . '/../app/Views/Dashboard/home.php';
if (file_exists($dashboardView)) {
    echo "✅ Dashboard/home.php exists<br>";
} else {
    echo "❌ Dashboard/home.php not found<br>";
}

// Test 5: Check if Dashboard layout exists
echo "<h2>5. Checking Dashboard layout</h2>";
$dashboardLayout = __DIR__ . '/../app/Views/layout/Dashboard-layout.php';
if (file_exists($dashboardLayout)) {
    echo "✅ Dashboard-layout.php exists<br>";
} else {
    echo "❌ Dashboard-layout.php not found<br>";
}

// Test 6: Check if Include files exist
echo "<h2>6. Checking Include files</h2>";
$includeFiles = [
    'links.php' => __DIR__ . '/../app/Views/Include/links.php',
    'header.php' => __DIR__ . '/../app/Views/Include/header.php',
    'sidebar.php' => __DIR__ . '/../app/Views/Include/sidebar.php',
    'footer.php' => __DIR__ . '/../app/Views/Include/footer.php',
    'settings.php' => __DIR__ . '/../app/Views/Include/settings.php'
];

foreach ($includeFiles as $name => $path) {
    if (file_exists($path)) {
        echo "✅ $name exists<br>";
    } else {
        echo "❌ $name NOT found<br>";
    }
}

// Test 7: Try to load the Dashboard/home view directly
echo "<h2>7. Testing Dashboard/home view loading</h2>";
try {
    $view = \Config\Services::renderer();
    $content = $view->render('Dashboard/home');
    echo "✅ Dashboard/home view loaded successfully<br>";
    echo "Content length: " . strlen($content) . " characters<br>";
} catch (Exception $e) {
    echo "❌ Dashboard/home view failed: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

?>
