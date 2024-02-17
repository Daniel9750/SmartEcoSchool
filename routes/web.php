<?php

use Illuminate\Support\Facades\Route;

// Import the graphics driver so that streams can execute data serialization functions.
use App\Http\Controllers\SensorMeasurementController;

// Graph views.
Route::get('/graphics/line', [SensorMeasurementController::class,'line' ])->name('graphics.bar');
Route::get('/graphics/bar' , [SensorMeasurementController::class,'bar'  ])->name('graphics.bar');
Route::get('/graphics/bar' , [SensorMeasurementController::class,'bar'  ])->name('graphics.bar');
Route::get('/graphics/bar' , [SensorMeasurementController::class,'bar'  ])->name('graphics.bar');
