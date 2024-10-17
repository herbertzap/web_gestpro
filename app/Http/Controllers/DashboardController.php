<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ConsoleTVs\Charts\Facades\Charts;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Crear un gráfico de barras
        $chart = Charts::create('bar', 'highcharts')
                        ->title('Usuarios Semanales')
                        ->elementLabel('Usuarios')
                        ->labels(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
                        ->values([5,10,20,15,25,30,40])
                        ->dimensions(1000, 500)
                        ->responsive(true);

        return view('admin.dashboard', compact('chart'));
    }
}

