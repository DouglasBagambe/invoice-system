<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MinimalTest extends Controller
{
    public function index()
    {
        // Suppress all warnings
        error_reporting(E_ERROR | E_PARSE);
        
        // Test 1: Basic output
        echo "<h1>Test 1: Basic Controller Works</h1>";
        
        // Test 2: Session check without helper
        echo "<h2>Test 2: Session Check</h2>";
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            
            if (isset($_SESSION['user_id'])) {
                echo "✅ User logged in: " . $_SESSION['user_id'] . "<br>";
                echo "✅ Username: " . ($_SESSION['username'] ?? 'N/A') . "<br>";
            } else {
                echo "❌ User not logged in<br>";
                return;
            }
        } catch (\Exception $e) {
            echo "❌ Session error: " . $e->getMessage() . "<br>";
            return;
        }
        
        // Test 3: Database
        echo "<h2>Test 3: Database</h2>";
        try {
            $mysqli = new \mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db', 3306);
            if ($mysqli->connect_error) {
                echo "❌ DB Error: " . $mysqli->connect_error . "<br>";
            } else {
                echo "✅ Database connected<br>";
                $mysqli->close();
            }
        } catch (\Exception $e) {
            echo "❌ DB Exception: " . $e->getMessage() . "<br>";
        }
        
        // Test 4: Simple view load
        echo "<h2>Test 4: View Load Test</h2>";
        try {
            echo "✅ About to load simple HTML<br>";
            echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px;">
                    <h3>Dashboard Preview</h3>
                    <p>If you see this, the controller is working!</p>
                    <a href="/dashboard">Try Full Dashboard</a>
                  </div>';
        } catch (\Exception $e) {
            echo "❌ View error: " . $e->getMessage() . "<br>";
        }
    }
}
