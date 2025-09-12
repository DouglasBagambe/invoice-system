<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestConnection extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Test basic connection
            if ($db->connID) {
                echo "Database connection: SUCCESS<br>";
                
                // Test if required tables exist
                $tables = ['admin', 'client', 'invtest2', 'products', 'protest2', 'quote2', 'quickquote'];
                
                foreach ($tables as $table) {
                    if ($db->tableExists($table)) {
                        echo "Table '$table': EXISTS<br>";
                    } else {
                        echo "Table '$table': MISSING<br>";
                    }
                }
                
                // Test StatisticsModel methods
                $statisticsModel = new \App\Models\StatisticsModel();
                
                echo "<br>Testing StatisticsModel methods:<br>";
                
                try {
                    $clientCount = $statisticsModel->getClientCountForCurrentMonth();
                    echo "getClientCountForCurrentMonth(): SUCCESS (Count: $clientCount)<br>";
                } catch (\Exception $e) {
                    echo "getClientCountForCurrentMonth(): ERROR - " . $e->getMessage() . "<br>";
                }
                
                try {
                    $fy = $statisticsModel->getFinancialYears();
                    echo "getFinancialYears(): SUCCESS (Found " . count($fy) . " years)<br>";
                } catch (\Exception $e) {
                    echo "getFinancialYears(): ERROR - " . $e->getMessage() . "<br>";
                }
                
            } else {
                echo "Database connection: FAILED<br>";
            }
            
        } catch (\Exception $e) {
            echo "Database connection error: " . $e->getMessage() . "<br>";
            echo "File: " . $e->getFile() . "<br>";
            echo "Line: " . $e->getLine() . "<br>";
        }
    }
}
