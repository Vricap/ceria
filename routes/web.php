<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\FacilityController;
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

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $properties = Property::with(['category', 'propertyType', 'city', 'agent'])->latest()->get();

        $query = Property::with(['category', 'propertyType', 'city', 'agent']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('property_id_code', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('property_type_id', $request->type);
        }

        if ($request->filled('transaction')) {
            $query->where('transaction_type', $request->transaction);
        }

        $isFiltered = $request->filled('search') || $request->filled('status') || $request->filled('type') || $request->filled('transaction');
        $tableProperties = $isFiltered ? $query->latest()->get() : $query->latest()->take(5)->get();
        $propertyTypes = \App\Models\PropertyType::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.index', compact('properties', 'tableProperties', 'isFiltered', 'propertyTypes'));
    })->name("dashboard");

    Route::get('/dashboard/properti', function (\Illuminate\Http\Request $request) {
        $query = Property::with(['category', 'propertyType', 'city', 'agent']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('property_id_code', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('property_type_id', $request->type);
        }

        if ($request->filled('transaction')) {
            $query->where('transaction_type', $request->transaction);
        }

        $properties = $query->latest()->get();
        $propertyTypes = \App\Models\PropertyType::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.properties', compact('properties', 'propertyTypes'));
    })->name("dashboard.properties");

    // Property Types (Tipe Properti)
    Route::get('/dashboard/tipe-properti', [PropertyTypeController::class, 'index'])->name("dashboard.property-types");
    Route::post('/property-types/store', [PropertyTypeController::class, 'store'])->name("property-types.store");
    Route::put('/property-types/update/{propertyType}', [PropertyTypeController::class, 'update'])->name("property-types.update");
    Route::delete('/property-types/destroy/{propertyType}', [PropertyTypeController::class, 'destroy'])->name("property-types.destroy");

    // Facilities & Features (Fasilitas & Fitur)
    Route::get('/dashboard/fasilitas', [FacilityController::class, 'index'])->name("dashboard.facilities");
    Route::post('/facilities/store', [FacilityController::class, 'store'])->name("facilities.store");
    Route::put('/facilities/update/{facilityId}', [FacilityController::class, 'update'])->name("facilities.update");
    Route::delete('/facilities/destroy/{facilityId}', [FacilityController::class, 'destroy'])->name("facilities.destroy");

    Route::get('/properties/create', [PropertyController::class, 'create'])->name("properties.create");
    Route::post('/properties/store', [PropertyController::class, 'store'])->name("properties.store");
    Route::get('/properties/edit/{property}', [PropertyController::class, 'edit'])->name("properties.edit");
    Route::put('/properties/update/{property}', [PropertyController::class, 'update'])->name("properties.update");
    Route::delete('/properties/destroy/{property}', [PropertyController::class, 'destroy'])->name("properties.destroy");
    Route::delete('/properties/images/{image}', [PropertyController::class, 'destroyImage'])->name("properties.images.destroy");
});

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
