<?php

// Establishes that it is a controller.
namespace App\Http\Controllers;

// Importing the dependencies.
use App\Models\Measurement;

use Illuminate\Support\Facades\DB;

// Manages monthly and annual electricity and water queries and returns them along with the corresponding views.
class SensorMeasurementController extends Controller
{
    /**
     * Retrieves and displays the total annual water consumption for sensor ID 2 in a Laravel view.
     * 
     * @return View 'pages/annual/pie' with query results grouped by year for sensor ID 2.
     */
    public function polarArea()
    {
        // Obtén la fecha máxima para cada año del sensor proporcionado.
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

        // Reverse the results since the year 2023 arrives in position 0.
        $resultadosRevertidos = $resultados->reverse();

        // Stores the subtraction of the years.
        $sortedResultados = [];

        // Stores the total consumption of all years.
        $totalConsumption = 0;

        // Processes the results to calculate the consumption difference for each year.
        foreach ($resultadosRevertidos as $result) {
            $year = $result->fecha;
            $consumption = $result->consumo;
        
            // Subtract the accumulated consumption of all previous years.
            $difference = $consumption - $totalConsumption;
        
            // Store the result in the new array.
            $sortedResultados[$year] = $difference;
        
            // Accumulate the total consumption for the next iteration.
            $totalConsumption += $difference;
        }

        return view('pages.annual.polarArea', compact('sortedResultados', 'totalConsumption'));
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

        // dd($resultados);

        // Process the results to calculate the difference in consumption for each year.
        $sortedResultados = [];
        $totalConsumption = 0;

        foreach ($resultados as $result) {
            $year = $result->fecha;
            $consumption = $result->consumo;

            // Resta el consumo acumulado de todos los años anteriores.
            $consumption -= $totalConsumption;

            // Almacena el resultado en el nuevo array.
            $sortedResultados[$year] = abs($consumption);

            // Acumula el consumo total para la próxima iteración.
            $totalConsumption += $result->consumo;
        }

        // Ordena el array por año.
        // dd($sortedResultados);

        return view('pages.annual.radar', compact('sortedResultados', 'totalConsumption'));
    }

    /**
     * Retrieves and displays the total monthly water consumption for sensor ID 2 in a Laravel view.
     * 
     * @return View 'pages/monthly/bar' with query results grouped by month for sensor ID 2.
     */
    public function bar()
    {
        $resultados = Measurement::select('id_sensor', DB::raw('MAX(consumo) as consumo_total'), DB::raw('YEAR(fecha) as year'), DB::raw('MONTH(fecha) as month'))
            ->whereIn('fecha', function ($query) {
                $query->select(DB::raw('MAX(fecha)'))
                    ->from('measurements')
                    ->whereRaw('id_sensor = measurements.id_sensor')
                    ->groupBy(DB::raw('YEAR(fecha), MONTH(fecha)'));
            })
            ->where('id_sensor', 2)
            ->groupBy('id_sensor', DB::raw('YEAR(fecha)'), DB::raw('MONTH(fecha)'))
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        // Filter only results from the last year stored.
        $lastYear = $resultados->max('year');
        $resultados = $resultados->filter(function ($item) use ($lastYear) {
            return $item->year == $lastYear;
        });

        // dd($sortedResultados);

        return view('pages.monthly.bar', compact('resultados'));
    }

    /**
     * Retrieves and displays the total monthly electricity consumption for sensor ID 1 in a Laravel view.
     * 
     * @return View 'pages/monthly/line' with query results grouped by year and month for sensor ID 1.
     */
    public function line()
    {
        $resultados = Measurement::select('id_sensor', DB::raw('MAX(consumo) as consumo_total'), DB::raw('YEAR(fecha) as year'), DB::raw('MONTH(fecha) as month'))
            ->whereIn('fecha', function ($query) {
                $query->select(DB::raw('MAX(fecha)'))
                    ->from('measurements')
                    ->whereRaw('id_sensor = measurements.id_sensor')
                    ->groupBy(DB::raw('YEAR(fecha), MONTH(fecha)'));
            })
            ->where('id_sensor', 1)
            ->groupBy('id_sensor', DB::raw('YEAR(fecha)'), DB::raw('MONTH(fecha)'))
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        // Filter only results from the last year stored.
        $lastYear = $resultados->max('year');
        $resultados = $resultados->filter(function ($item) use ($lastYear) {
            return $item->year == $lastYear;
        });

        // dd($resultados);
        return view('pages.monthly.line', compact('resultados'));
    }
}
