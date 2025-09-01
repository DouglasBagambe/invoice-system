<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DatabaseTest extends Controller
{
    public function index()
    {
        try {
            echo "<h2>Database Connection Test</h2>";
            
            // Test 1: Basic connection with current config
            echo "<h3>Test 1: Current Database Config</h3>";
            $db = \Config\Database::connect();
            
            if ($db->connID) {
                echo "✅ Database connected successfully!<br>";
                echo "Database: " . $db->getDatabase() . "<br>";
                echo "Username: " . $db->username . "<br>";
                echo "Hostname: " . $db->hostname . "<br>";
            } else {
                echo "❌ Database connection failed<br>";
            }
            
            // Test 2: Try alternative connection
            echo "<h3>Test 2: Alternative Connection Test</h3>";
            try {
                $mysqli = new \mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db');
                if ($mysqli->connect_error) {
                    echo "❌ MySQLi connection failed: " . $mysqli->connect_error . "<br>";
                } else {
                    echo "✅ MySQLi connection successful!<br>";
                    $mysqli->close();
                }
            } catch (\Exception $e) {
                echo "❌ MySQLi error: " . $e->getMessage() . "<br>";
            }
            
            // Test 3: Check if tables exist
            if ($db->connID) {
                echo "<h3>Test 3: Table Existence Check</h3>";
                $tables = ['admin', 'client', 'invtest2', 'products', 'protest2', 'quote2', 'quickquote'];
                
                foreach ($tables as $table) {
                    try {
                        if ($db->tableExists($table)) {
                            $count = $db->table($table)->countAllResults();
                            echo "✅ Table '$table' exists (Records: $count)<br>";
                        } else {
                            echo "❌ Table '$table' does not exist<br>";
                        }
                    } catch (\Exception $e) {
                        echo "❌ Error checking table '$table': " . $e->getMessage() . "<br>";
                    }
                }
            }
            
        } catch (\Exception $e) {
            echo "<h3>❌ Critical Error:</h3>";
            echo "Error: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
        }
    }
}
