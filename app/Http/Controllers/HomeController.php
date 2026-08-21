<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use App\Models\City;
use App\Models\SiteSetting;
use App\Support\ServiceItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProperties = Property::with(['city', 'images', 'propertyType'])
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount(['properties' => fn($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        $cities = City::where('is_active', true)
            ->withCount([
                'properties' => fn ($q) => $q->published()
            ])
            ->orderByDesc('properties_count')
            ->take(5)
            ->get()
            ->filter(fn ($city) => $city->properties_count > 0)
            ->values();

        $services = ServiceItem::all()->take(6);

        $settings = SiteSetting::getAllAsArray();

        $stats = [
            'total_properties' => Property::published()->count(),
            'total_clients'    => SiteSetting::get('stat_clients', '500+'),
            'support'          => SiteSetting::get('stat_support', '24/7'),
        ];

        return view('home.index', compact(
            'featuredProperties', 'categories', 'cities',
            'services', 'settings', 'stats'
        ));
    }
}
