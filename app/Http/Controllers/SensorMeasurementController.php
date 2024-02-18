<?php

namespace App\Http\Controllers;

// Importing the models.
use Illuminate\Support\Facades\DB;

class SensorMeasurementController extends Controller
{
    /**
     * Retrieves and displays the total annual water consumption for a specific sensor in a Laravel view.
     * 
     * @return View 'pages/annual/pie' with query results grouped by year for the water sensor (e.g., sensor ID 2).
     */
    public function pie()
    {
        $query = "SELECT m.id_sensor, SUM(m.consumo) as consumo_total, YEAR(m.fecha) AS fecha
        FROM measurements m
        INNER JOIN (
            SELECT MAX(fecha) AS ultima_fecha
            FROM measurements
            WHERE id_sensor = 2
            GROUP BY YEAR(fecha), MONTH(fecha)
        ) AS ultimas_fechas ON m.fecha = ultimas_fechas.ultima_fecha
        WHERE m.id_sensor = 2
        GROUP BY YEAR(m.fecha)
        ORDER BY m.fecha DESC;";
    
        $resultados = DB::select($query);
    
        return view('pages.annual.pie')->with("resultados", $resultados);
    }

    /**
     * Retrieves and displays the latest consumption data for a specific sensor in a Laravel view using the `radar` function.
     * 
     * @return View 'pages/annual/radar' with query results grouped by year for sensor ID 1.
     */
    public function radar()
    {
        $query = "SELECT m.id_sensor, m.consumo, YEAR(m.fecha) AS fecha
        FROM measurements m
        INNER JOIN (
            SELECT MAX(fecha) AS ultima_fecha
            FROM measurements
            WHERE id_sensor = 1
            GROUP BY YEAR(fecha)
        ) AS ultimas_fechas ON m.fecha = ultimas_fechas.ultima_fecha
        WHERE m.id_sensor = 1
        ORDER BY m.fecha DESC;";

        $resultados = DB::select($query);

        return view('pages.annual.radar')->with("resultados", $resultados);
    }

    /**
     * Retrieves and displays the latest sensor data for annual water consumption in a Laravel view.
     * 
     * @return View 'pages/monthly/bar' with query results grouped by year for sensor ID 2.
     */
    public function bar()
    {
        $query = "SELECT m.id_sensor, m.consumo, YEAR(m.fecha) AS fecha
        FROM measurements m
        INNER JOIN (
            SELECT MAX(fecha) AS ultima_fecha
            FROM measurements
            WHERE id_sensor = 2
            GROUP BY YEAR(fecha)
        ) AS ultimas_fechas ON m.fecha = ultimas_fechas.ultima_fecha
        WHERE m.id_sensor = 2
        ORDER BY m.fecha DESC;";

        $resultados = DB::select($query);

        return view('pages.monthly.bar')->with("resultados", $resultados);
    }

    /**
     * Retrieves and displays monthly electricity consumption data for a specific sensor in a Laravel application.
     * 
     * @return View 'pages/monthly/line' with query results grouped by year and month for sensor ID 1.
     */
    public function line()
    {
        $query = "SELECT m.id_sensor, m.consumo, CONCAT(YEAR(m.fecha), '-', LPAD(MONTH(m.fecha), 2, '0')) AS fecha
        FROM measurements m
        INNER JOIN (
            SELECT MAX(fecha) AS ultima_fecha
            FROM measurements
            WHERE id_sensor = 1
            GROUP BY YEAR(fecha), MONTH(fecha)
        ) AS ultimas_fechas ON m.fecha = ultimas_fechas.ultima_fecha
        WHERE m.id_sensor = 1
        ORDER BY m.fecha DESC;";

        $resultados = DB::select($query);

        return view('pages/monthly/line')->with("resultados", $resultados);
    }
}
