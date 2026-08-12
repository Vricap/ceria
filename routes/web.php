<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Models\Property;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $properties = Property::all();

    return view('dashboard', ['properties' => $properties]);
})->name("dashboard");

Route::get('/properties/create', [PropertyController::class, 'create'])->name("properties.create");
Route::post('/properties/store', [PropertyController::class, 'store'])->name("properties.store");
Route::get('/properties/show/{property}', [PropertyController::class, 'show'])->name("properties.show");
Route::put('/properties/update/{property}', [PropertyController::class, 'update'])->name("properties.update");
Route::delete('/properties/destroy/{property}', [PropertyController::class, 'destroy'])->name("properties.destroy");
