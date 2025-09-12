<!DOCTYPE html>
<html>
<head>
    <title>CSS Test</title>
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
</head>
<body>
    <h1>CSS Test Page</h1>
    <p>If you see this with proper styling, CSS is working.</p>
    <p>If you see this with basic text styling, CSS is not loading.</p>
    
    <h2>CSS Files Check:</h2>
    <?php
    $cssFiles = [
        'dist/css/bootstrap.min.css',
        'dist/css/style.css'
    ];
    
    foreach ($cssFiles as $file) {
        if (file_exists($file)) {
            echo "✅ $file exists<br>";
        } else {
            echo "❌ $file NOT found<br>";
        }
    }
    ?>
</body>
</html>
