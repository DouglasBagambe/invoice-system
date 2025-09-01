<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SimpleDashboard extends Controller
{
    public function index()
    {
        // Suppress PHP compatibility warnings
        error_reporting(E_ERROR | E_PARSE);
        
        // Check session without using CodeIgniter's session helper
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Simple session check
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . 'https://invoice.biiteeksms.com/login');
            exit;
        }

        // Simple data array
        $data = [
            'fy' => [],
            'clientcount' => 0,
            'monthturn' => 0,
            'invcount' => 0,
            'bounceRate' => 0,
            'mainchart' => (object) [
                'total_invoices' => 0,
                'total_items' => 0,
                'total_amount' => 0,
                'total_tax' => 0
            ],
            'productcategorycount2' => [],
            'startYear' => date('Y'),
            'endYear' => date('Y') + 1
        ];

        // Try to get basic database data
        try {
            $mysqli = new \mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db', 3306);
            
            if (!$mysqli->connect_error) {
                // Get simple counts
                $result = $mysqli->query("SELECT COUNT(*) as count FROM client");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['clientcount'] = $row['count'];
                }
                
                $result = $mysqli->query("SELECT COUNT(*) as count FROM invtest2");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['invcount'] = $row['count'];
                }
                
                $mysqli->close();
            }
        } catch (\Exception $e) {
            // Continue with defaults
        }

        // Load view directly
        $viewPath = APPPATH . 'Views/layout/Dashboard-layout.php';
        if (file_exists($viewPath)) {
            // Extract data for view
            extract($data);
            
            // Start output buffering
            ob_start();
            include $viewPath;
            $output = ob_get_clean();
            
            echo $output;
        } else {
            echo "<h1>Dashboard</h1>";
            echo "<p>Welcome to your dashboard!</p>";
            echo "<p>Clients: " . $data['clientcount'] . "</p>";
            echo "<p>Invoices: " . $data['invcount'] . "</p>";
            echo "<p><a href='/login/logout'>Logout</a></p>";
        }
    }
}
