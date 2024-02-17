<?php

namespace App\Http\Controllers;

use App\Models\SensorMeasurement;

class SensorMeasurementController extends Controller
{
    // Monthly charts.
    public function bar()
    {
        // Get all sensor measurements.
        $sensorMeasurements = SensorMeasurement::all();

        // Returns the home page and passes the measurement data as the sensorMeasurements variable.
        return view('pages.graphics.table', compact('sensorMeasurements'));
    }

    public function line()
    {
        // Get all sensor measurements.
        $sensorMeasurements = SensorMeasurement::all();

        // Returns the home page and passes the measurement data as the sensorMeasurements variable.
        return view('pages.graphics.table', compact('sensorMeasurements'));
    }

    // Annual graphs.
    public function b()
    {
        // Get all sensor measurements.
        $sensorMeasurements = SensorMeasurement::all();

        // Returns the home page and passes the measurement data as the sensorMeasurements variable.
        return view('pages.graphics.table', compact('sensorMeasurements'));
    }

    public function l()
    {
        // Get all sensor measurements.
        $sensorMeasurements = SensorMeasurement::all();

        // Returns the home page and passes the measurement data as the sensorMeasurements variable.
        return view('pages.graphics.table', compact('sensorMeasurements'));
    }
}
