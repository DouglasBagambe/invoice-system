<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// Initialize dashboard data
		$data = [
			'invcount' => 0,
			'bounceRate' => 0,
			'clientcount' => 0,
			'monthturn' => 0,
			'startYear' => date('Y'),
			'endYear' => date('Y') + 1,
			'fy' => []
		];
		
		return view('Dashboard/home', $data);
	}
}
