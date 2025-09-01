<?php
// Simple redirect to public folder
// This ensures CSS and all static files work properly

// Check if we're already in public
if (strpos($_SERVER['REQUEST_URI'], '/public/') === false) {
    // Redirect to public folder
    header('Location: /public/');
    exit();
}
?>
