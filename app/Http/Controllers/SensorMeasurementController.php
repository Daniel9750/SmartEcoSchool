<?php

// Establishes that it is a controller.
namespace App\Http\Controllers;

// Importing the dependencies.
use App\Models\Building;
use App\Models\Measurement;
use App\Models\Sensor;
use App\Models\SensorType;

use Illuminate\Support\Facades\DB;

// Manages monthly and annual electricity and water queries and returns them along with the corresponding views.
class SensorMeasurementController extends Controller
{
    /**
     * Retrieves and displays the total annual water consumption for sensor ID 2 in a Laravel view.
     * 
     * @return View 'pages/annual/pie' with query results grouped by year for sensor ID 2.
     */
    public function pie()
    {
        $resultados = Measurement::selectRaw('SUM(consumo) as consumo_total, YEAR(fecha) as fecha')
            ->whereIn('id_sensor', [2])
            ->whereIn('fecha', function ($query) {
                $query->selectRaw('MAX(fecha)')
                    ->from('measurements')
                    ->where('id_sensor', 2)
                    ->groupBy(DB::raw('YEAR(fecha), MONTH(fecha)'));
            })
            ->groupBy(DB::raw('YEAR(fecha)'))
            ->orderByDesc('fecha')
            ->get();

        return view('pages.annual.pie')->with('resultados', $resultados);
    }

    /**
     * Retrieves and displays the total annual electricity consumption for sensor ID 1 in a Laravel view.
     * 
     * @return View 'pages/annual/radar' with query results grouped by year for sensor ID 1.
     */
    public function radar()
    {
        $resultados = Measurement::select('id_sensor', 'consumo', DB::raw('YEAR(fecha) as fecha'))
            ->whereIn('id_sensor', [1])
            ->whereIn('fecha', function ($query) {
                $query->selectRaw('MAX(fecha)')
                    ->from('measurements')
                    ->where('id_sensor', 1)
                    ->groupBy(DB::raw('YEAR(fecha)'));
            })
            ->orderByDesc('fecha')
            ->get();

        return view('pages.annual.radar', compact('resultados'));
    }

    /**
     * Retrieves and displays the total monthly water consumption for sensor ID 2 in a Laravel view.
     * 
     * @return View 'pages/monthly/bar' with query results grouped by month for sensor ID 2.
     */
    public function bar()
    {
        $resultados = Measurement::select('id_sensor', 'consumo', DB::raw('YEAR(fecha) as fecha'))
            ->whereIn('id_sensor', [2])
            ->whereIn('fecha', function ($query) {
                $query->selectRaw('MAX(fecha)')
                    ->from('measurements')
                    ->where('id_sensor', 2)
                    ->groupBy(DB::raw('YEAR(fecha)'));
            })
            ->orderByDesc('fecha')
            ->get();

        return view('pages.monthly.bar', compact('resultados'));
    }

    /**
     * Retrieves and displays the total monthly electricity consumption for sensor ID 1 in a Laravel view.
     * 
     * @return View 'pages/monthly/line' with query results grouped by year and month for sensor ID 1.
     */
    public function line()
    {
        $resultados = Measurement::select('id_sensor', 'consumo', DB::raw('CONCAT(YEAR(fecha), "-", LPAD(MONTH(fecha), 2, "0")) as fecha'))
            ->whereIn('id_sensor', [1])
            ->whereIn('fecha', function ($query) {
                $query->selectRaw('MAX(fecha)')
                    ->from('measurements')
                    ->where('id_sensor', 1)
                    ->groupBy(DB::raw('YEAR(fecha), MONTH(fecha)'));
            })
            ->orderByDesc('fecha')
            ->get();

        return view('pages.monthly.line', compact('resultados'));
    }
}
