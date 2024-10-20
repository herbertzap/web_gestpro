<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Charts\UserChart;

class DashboardController extends Controller
{
    public function index()
    {
        $chart = new UserChart();  // Instanciar el gráfico

        return view('dashboard', compact('chart'));
    }
}

