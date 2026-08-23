<?php

namespace App\Http\Controllers;

use App\Models\PropertyFacility;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Master list Fasilitas & Fitur disimpan sebagai file JSON di storage/app/facilities.json
     * agar dapat dikelola admin tanpa mengubah struktur database.
     */
    private const STORE_FILE = 'facilities.json';

    private const DEFAULTS = [
        'AC', 'Kolam Renang', 'Carport', 'Garasi', 'Taman / Garden', 'CCTV',
        'Keamanan 24 Jam', 'Water Heater', 'Balkon', 'Internet Ready', 'Kitchen Set',
        'Fully Furnished', 'Unfurnished', 'Line Telepon', 'Akses Jalan Besar',
        'Dekat Kampus', 'Dekat Rumah Sakit', 'Dekat Akses Toll',
    ];

    /**
     * Ambil seluruh master fasilitas (otomatis membuat file default bila belum ada).
     */
    public static function all(): Collection
    {
        if (!Storage::disk('local')->exists(self::STORE_FILE)) {
            $nextId = 1;
            $items = collect(self::DEFAULTS)->map(function ($name) use (&$nextId) {
                return ['id' => $nextId++, 'name' => $name, 'is_active' => true];
            })->values();
            self::persist($items);
        }

        $items = json_decode(Storage::disk('local')->get(self::STORE_FILE), true) ?? [];

        return collect($items)->map(fn($item) => (object) $item);
    }

    /**
     * Hanya fasilitas aktif — dipakai untuk pilihan di form properti.
     */
    public static function active(): Collection
    {
        return self::all()->where('is_active', true)->values();
    }

    private static function persist(Collection $items): void
    {
        Storage::disk('local')->put(
            self::STORE_FILE,
            json_encode($items->values(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

     public function index(Request $request): View
     {
         $facilities = self::all();
 
         if ($request->filled('search')) {
             $search = strtolower($request->search);
             $facilities = $facilities->filter(function ($f) use ($search) {
                 return str_contains(strtolower($f->name), $search);
             });
         }
 
         if ($request->filled('status')) {
             $status = $request->status;
             $facilities = $facilities->filter(function ($f) use ($status) {
                 if ($status === 'active') {
                     return $f->is_active === true;
                 } elseif ($status === 'inactive') {
                     return $f->is_active === false;
                 }
                 return true;
             });
         }
 
         $usage = PropertyFacility::query()
             ->select('name', DB::raw('COUNT(DISTINCT property_id) as total'))
             ->groupBy('name')
             ->pluck('total', 'name');
         $facilities->each(fn($f) => $f->usage_count = (int) ($usage[$f->name] ?? 0));
 
         return view('dashboard.facilities', compact('facilities'));
     }

    /**
     * Store a newly created facility.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
            'name.max'      => 'Nama fasilitas maksimal 100 karakter.',
        ]);

        $facilities = self::all();

        if ($facilities->contains(fn($f) => strcasecmp($f->name, trim($validated['name'])) === 0)) {
            return back()->with('error', 'Fasilitas dengan nama tersebut sudah ada.')->withInput();
        }

        $facilities->push([
            'id'        => $facilities->max('id') + 1,
            'name'      => trim($validated['name']),
            'is_active' => true,
        ]);
        self::persist($facilities);

        return redirect()->route('dashboard.facilities')->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    /**
     * Update the specified facility.
     */
    public function update(Request $request, int $facilityId): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
            'name.max'      => 'Nama fasilitas maksimal 100 karakter.',
        ]);

        $facilities = self::all();
        $facility = $facilities->firstWhere('id', $facilityId);

        if (!$facility) {
            return back()->with('error', 'Fasilitas tidak ditemukan.');
        }

        if ($facilities->contains(fn($f) => $f->id !== $facilityId && strcasecmp($f->name, trim($validated['name'])) === 0)) {
            return back()->with('error', 'Fasilitas dengan nama tersebut sudah ada.');
        }

        $updated = $facilities->map(function ($f) use ($facilityId, $validated, $request) {
            if ($f->id === $facilityId) {
                $f->name      = trim($validated['name']);
                $f->is_active = $request->has('is_active');
            }
            return $f;
        });
        self::persist($updated);

        return redirect()->route('dashboard.facilities')->with('success', 'Fasilitas berhasil diperbarui!');
    }

    /**
     * Remove the specified facility.
     */
    public function destroy(int $facilityId): RedirectResponse
    {
        $facilities = self::all();
        $facility = $facilities->firstWhere('id', $facilityId);

        if (!$facility) {
            return back()->with('error', 'Fasilitas tidak ditemukan.');
        }

        $usageCount = PropertyFacility::where('name', $facility->name)->distinct('property_id')->count('property_id');

        if ($usageCount > 0) {
            return back()->with('error', "Fasilitas \"{$facility->name}\" tidak dapat dihapus karena masih dipakai oleh {$usageCount} properti.");
        }

        self::persist($facilities->reject(fn($f) => $f->id === $facilityId)->values());

        return redirect()->route('dashboard.facilities')->with('success', 'Fasilitas berhasil dihapus!');
    }
}
