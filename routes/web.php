<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Models\Property;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

// Properties
Route::prefix('properti')->name('properties.')->group(function () {
    Route::get('/',           [PropertyController::class, 'index'])->name('index');
    Route::get('/{slug}',     [PropertyController::class, 'show'])->name('show');
    Route::post('/{slug}/inquiry', [PropertyController::class, 'submitInquiry'])->name('inquiry');
});

Route::get('/dashboard', function () {
    $properties = Property::with(['category', 'propertyType', 'city', 'agent'])->latest()->get();
    return view('dashboard.index', ['properties' => $properties]);
})->name("dashboard");

Route::get('/dashboard/properti', function () {
    $properties = Property::with(['category', 'propertyType', 'city', 'agent'])->latest()->get();
    return view('dashboard.properties', ['properties' => $properties]);
})->name("dashboard.properties");

Route::get('/properties/create', [PropertyController::class, 'create'])->name("properties.create");
Route::post('/properties/store', [PropertyController::class, 'store'])->name("properties.store");
Route::get('/properties/edit/{property}', [PropertyController::class, 'edit'])->name("properties.edit");
Route::put('/properties/update/{property}', [PropertyController::class, 'update'])->name("properties.update");
Route::delete('/properties/destroy/{property}', [PropertyController::class, 'destroy'])->name("properties.destroy");
Route::delete('/properties/images/{image}', [PropertyController::class, 'destroyImage'])->name("properties.images.destroy");

// Portfolio (menggantikan Agents)
Route::prefix('portfolio')->name('portfolio.')->group(function () {
    Route::get('/',       [PortfolioController::class, 'index'])->name('index');
    Route::get('/{slug}', [PortfolioController::class, 'show'])->name('show');
});

// Services / Layanan
Route::prefix('layanan')->name('services.')->group(function () {
    Route::get('/',       [ServiceController::class, 'index'])->name('index');
    Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
});

// Contact
Route::get('/kontak',         [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak/kirim',  [ContactController::class, 'submit'])->name('contact.submit');

// About (static page using layout)
Route::get('/tentang', function () {
    return view('about.index');
})->name('about.index');
