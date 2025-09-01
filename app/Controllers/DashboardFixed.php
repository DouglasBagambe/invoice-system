<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardFixed extends Controller
{
    public function index()
    {
        try {
            // Suppress all warnings and notices
            error_reporting(E_ERROR | E_PARSE);
            
            $session = session();
            if (!$session->has('user_id')) {
                return redirect()->to(base_url().'/login');
            }

            // Use direct mysqli connection since we know it works
            $mysqli = new \mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db', 3306);
            
            if ($mysqli->connect_error) {
                throw new \Exception('Database connection failed: ' . $mysqli->connect_error);
            }

            // Get current financial year
            $month = date('m');
            $year = date('Y');
            if ($month >= 4) {
                $startYear = $year;
                $endYear = $year + 1;
            } else {
                $startYear = $year - 1;
                $endYear = $year;
            }

            // Initialize data with safe defaults
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
                'startYear' => $startYear,
                'endYear' => $endYear
            ];

            // Try to get financial years
            try {
                $result = $mysqli->query("SELECT CASE 
                    WHEN MONTH(created) >= 4 
                    THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                    ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
                END AS financial_year 
                FROM invtest2 
                GROUP BY financial_year 
                ORDER BY financial_year DESC LIMIT 5");
                
                if ($result) {
                    $fy = [];
                    while ($row = $result->fetch_assoc()) {
                        $fy[] = $row;
                    }
                    $data['fy'] = $fy;
                }
            } catch (\Exception $e) {
                // Continue with empty array
            }

            // Try to get client count
            try {
                $currentMonth = date('Y-m');
                $result = $mysqli->query("SELECT COUNT(*) as count FROM client WHERE DATE_FORMAT(created, '%Y-%m') = '$currentMonth'");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['clientcount'] = $row['count'];
                }
            } catch (\Exception $e) {
                // Continue with 0
            }

            // Try to get invoice count
            try {
                $currentMonth = date('Y-m');
                $result = $mysqli->query("SELECT COUNT(invid) as count FROM invtest2 WHERE DATE_FORMAT(created, '%Y-%m') = '$currentMonth'");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['invcount'] = $row['count'];
                }
            } catch (\Exception $e) {
                // Continue with 0
            }

            // Try to get monthly turnover
            try {
                $currentMonth = date('Y-m');
                $result = $mysqli->query("SELECT SUM(totalamount) as total FROM invtest2 WHERE DATE_FORMAT(created, '%Y-%m') = '$currentMonth'");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['monthturn'] = $row['total'] ?? 0;
                }
            } catch (\Exception $e) {
                // Continue with 0
            }

            // Try to get main chart data
            try {
                $startDate = "$startYear-04-01";
                $endDate = "$endYear-03-30";
                $result = $mysqli->query("SELECT COUNT(invid) as total_invoices, SUM(totalitems) as total_items, SUM(totalamount) as total_amount, SUM(taxamount) as total_tax FROM invtest2 WHERE created >= '$startDate' AND created <= '$endDate'");
                if ($result && $row = $result->fetch_assoc()) {
                    $data['mainchart'] = (object) $row;
                }
            } catch (\Exception $e) {
                // Continue with defaults
            }

            // Try to get product category count
            try {
                $result = $mysqli->query("SELECT item_name as label, COUNT(item_name) as value FROM invtest INNER JOIN invtest2 on invtest.orderid = invtest2.orderid INNER join products on invtest.item_name = products.name where products.p_type = 'Machine' and invtest2.created BETWEEN '$startYear-04-01' and '$endYear-03-31' GROUP BY item_name ORDER BY COUNT(item_name) DESC LIMIT 5");
                if ($result) {
                    $productcategorycount2 = [];
                    while ($row = $result->fetch_assoc()) {
                        $productcategorycount2[] = $row;
                    }
                    $data['productcategorycount2'] = $productcategorycount2;
                }
            } catch (\Exception $e) {
                // Continue with empty array
            }

            $mysqli->close();

            return view('layout/dashboard-layout', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Dashboard Fixed error: ' . $e->getMessage());
            return view('errors/html/error_500', ['message' => 'Dashboard error: ' . $e->getMessage()]);
        }
    }
}
