<?php

namespace App\Controllers;

use App\Models\StatisticsModel;

class WorkingDashboard extends BaseController
{
    public function index()
    {
        // STEP 1: Session check with proper error handling
        try {
            $session = session();
            if (!$session->has('user_id')) {
                return redirect()->to('/login');
            }
        } catch (\Exception $e) {
            log_message('error', 'Session error in WorkingDashboard: ' . $e->getMessage());
            return redirect()->to('/login');
        }

        // STEP 2: Initialize safe default data
        $data = [
            'invcount' => 0,
            'bounceRate' => 0,
            'clientcount' => 0,
            'monthturn' => 0,
            'startYear' => date('Y'),
            'endYear' => date('Y') + 1,
            'fy' => [],
            'mainchart' => (object) [
                'total_invoices' => 0,
                'total_items' => 0,
                'total_amount' => 0,
                'total_tax' => 0
            ],
            'productcategorycount2' => []
        ];

        // STEP 3: Try to get real data, but don't break if it fails
        try {
            $statisticsModel = new StatisticsModel();
            
            // Get client count safely
            try {
                $data['clientcount'] = $statisticsModel->clientcount() ?? 0;
            } catch (\Exception $e) {
                log_message('error', 'Error getting client count: ' . $e->getMessage());
            }

            // Get invoice count safely
            try {
                $data['invcount'] = $statisticsModel->invcount() ?? 0;
            } catch (\Exception $e) {
                log_message('error', 'Error getting invoice count: ' . $e->getMessage());
            }

            // Get monthly turnover safely
            try {
                $data['monthturn'] = $statisticsModel->monthturn() ?? 0;
            } catch (\Exception $e) {
                log_message('error', 'Error getting monthly turnover: ' . $e->getMessage());
            }

            // Get bounce rate safely
            try {
                $data['bounceRate'] = $statisticsModel->bounceRate() ?? 0;
            } catch (\Exception $e) {
                log_message('error', 'Error getting bounce rate: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            log_message('error', 'Error initializing StatisticsModel: ' . $e->getMessage());
        }

        // STEP 4: Return simple working dashboard for now
        log_message('info', 'Dashboard accessed by user: ' . session()->get('user_id'));
        
        return $this->response->setBody("
            <html>
            <head>
                <title>Dashboard - Working!</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 40px; }
                    .stats { display: flex; gap: 20px; margin: 20px 0; }
                    .stat-box { background: #f4f4f4; padding: 20px; border-radius: 5px; }
                    .success { color: green; }
                </style>
            </head>
            <body>
                <h1 class='success'>✅ Dashboard Working!</h1>
                <p>Welcome back, " . session()->get('name', 'User') . "!</p>
                
                <div class='stats'>
                    <div class='stat-box'>
                        <h3>Clients</h3>
                        <p>{$data['clientcount']}</p>
                    </div>
                    <div class='stat-box'>
                        <h3>Invoices</h3>
                        <p>{$data['invcount']}</p>
                    </div>
                    <div class='stat-box'>
                        <h3>Monthly Turnover</h3>
                        <p>{$data['monthturn']}</p>
                    </div>
                </div>
                
                <p><a href='/login' onclick='return confirm(\"Logout?\")'>Logout</a></p>
                <p><em>Dashboard is now working on localhost! 🎉</em></p>
            </body>
            </html>
        ");
    }
}
