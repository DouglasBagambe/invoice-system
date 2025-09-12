<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Debug extends Controller
{
    public function dashboard()
    {
        try {
            // Enable all error reporting
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            
            echo "<h2>Dashboard Debug Information</h2>";
            
            // Check session
            $session = session();
            echo "<h3>Session Check:</h3>";
            if ($session->has('user_id')) {
                echo "✅ User is logged in (ID: " . $session->get('user_id') . ")<br>";
                echo "Username: " . $session->get('username') . "<br>";
                echo "Name: " . $session->get('name') . "<br>";
            } else {
                echo "❌ User is NOT logged in<br>";
                return;
            }
            
            // Check database connection
            echo "<h3>Database Connection:</h3>";
            $db = \Config\Database::connect();
            if ($db->connID) {
                echo "✅ Database connection successful<br>";
                
                // Test required tables
                $tables = ['admin', 'client', 'invtest2', 'products'];
                foreach ($tables as $table) {
                    if ($db->tableExists($table)) {
                        echo "✅ Table '$table' exists<br>";
                    } else {
                        echo "❌ Table '$table' missing<br>";
                    }
                }
            } else {
                echo "❌ Database connection failed<br>";
                return;
            }
            
            // Test StatisticsModel
            echo "<h3>StatisticsModel Tests:</h3>";
            $statisticsModel = new \App\Models\StatisticsModel();
            
            try {
                $fy = $statisticsModel->getFinancialYears();
                echo "✅ getFinancialYears(): " . count($fy) . " years found<br>";
            } catch (\Exception $e) {
                echo "❌ getFinancialYears() error: " . $e->getMessage() . "<br>";
            }
            
            try {
                $clientcount = $statisticsModel->getClientCountForCurrentMonth();
                echo "✅ getClientCountForCurrentMonth(): $clientcount<br>";
            } catch (\Exception $e) {
                echo "❌ getClientCountForCurrentMonth() error: " . $e->getMessage() . "<br>";
            }
            
            // Test helper functions
            echo "<h3>Helper Functions:</h3>";
            if (function_exists('moneyFormatIndia')) {
                echo "✅ moneyFormatIndia() exists<br>";
            } else {
                echo "❌ moneyFormatIndia() missing<br>";
            }
            
            if (function_exists('getState')) {
                echo "✅ getState() exists<br>";
            } else {
                echo "❌ getState() missing<br>";
            }
            
            echo "<h3>Environment:</h3>";
            echo "Environment: " . ENVIRONMENT . "<br>";
            echo "Base URL: " . base_url() . "<br>";
            
            echo "<h3>✅ All checks completed successfully!</h3>";
            echo "<p><a href='" . base_url('/dashboard') . "'>Try Dashboard Again</a></p>";
            
        } catch (\Exception $e) {
            echo "<h3>❌ Critical Error:</h3>";
            echo "Error: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}
