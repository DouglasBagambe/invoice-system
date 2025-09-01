<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// Check if user is logged in
		$session = session();
		if (!$session->has('user_id')) {
			return redirect()->to(base_url().'/login');
		}
		
		// Initialize dashboard data
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
		
		return view('layout/dashboard-layout', $data);
	}
}
