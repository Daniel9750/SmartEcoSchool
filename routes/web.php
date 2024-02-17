<?php

// Dependency for routes to do their job.
use Illuminate\Support\Facades\Route;

// Import the graphics driver so that streams can execute data serialization functions.
use App\Http\Controllers\SensorMeasurementController;

// Annual charts.
Route::get('/agua/anual'          , [SensorMeasurementController::class,'pie'  ])->name('pages.annual.pie'  );
Route::get('/electricidad/anual'  , [SensorMeasurementController::class,'radar'])->name('pages.annual.radar');

// Monthly graphs.
Route::get('/agua/mensual'        , [SensorMeasurementController::class,'bar'  ])->name('pages.monthly.bar' );
Route::get('/electricidad/mensual', [SensorMeasurementController::class,'bar'  ])->name('pages.monthly.line');
