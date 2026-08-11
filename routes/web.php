<?php

use Illuminate\Support\Facades\Route;
use App\Models\Property;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $properties = Property::all();

    return view('dashboard', ['properties' => $properties]);
});
