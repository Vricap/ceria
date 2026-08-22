<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agent_id', 'category_id', 'property_type_id', 'province_id', 'city_id',
        'district_id', 'area_id', 'title', 'slug', 'property_id_code', 'description',
        'short_description', 'transaction_type', 'price', 'price_rent_monthly',
        'price_note', 'land_area', 'building_area', 'bedrooms', 'bathrooms',
        'garage', 'floors', 'certificate', 'year_built', 'electric_power',
        'address', 'latitude', 'longitude', 'google_maps_link', 'google_maps_embed_url',
        'thumbnail', 'meta_title', 'meta_description', 'og_image', 'status', 'is_featured',
        'views', 'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_rent_monthly' => 'decimal:2',
        'land_area' => 'decimal:2',
        'building_area' => 'decimal:2',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->where('is_primary', true);
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(PropertyFacility::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'featured']);
    }

    /**
     * Visible scope: tampilkan ke publik termasuk sold & rented.
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereIn('status', ['published', 'featured', 'sold', 'rented']);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->whereIn('status', ['published', 'featured']);
    }

    public function scopeForSale(Builder $query): Builder
    {
        return $query->where('transaction_type', 'dijual');
    }

    public function scopeForRent(Builder $query): Builder
    {
        return $query->where('transaction_type', 'disewa');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        // Try primary image
        $primary = $this->images()->where('is_primary', true)->first();
        if ($primary) {
            return asset('storage/' . $primary->image_url);
        }
        return asset('images/placeholder-property.svg');
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->transaction_type === 'disewa') {
            if (!$this->price_rent_monthly) return 'Harga Nego';
            return 'Rp ' . number_format($this->price_rent_monthly, 0, ',', '.') . '/Bulan';
        }
        if (!$this->price) return 'Harga Nego';
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedPriceFullAttribute(): string
    {
        if ($this->transaction_type === 'disewa') {
            if (!$this->price_rent_monthly) return 'Harga Nego';
            return 'Rp ' . number_format($this->price_rent_monthly, 0, ',', '.') . '/Bulan';
        }
        if (!$this->price) return 'Harga Nego';
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'sold') return 'Terjual';
        if ($this->status === 'rented') return 'Tersewa';
        return match($this->transaction_type) {
            'dijual' => 'Dijual',
            'disewa' => 'Disewa',
            default  => 'Tersedia',
        };
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->status === 'sold') return 'badge-sold';
        if ($this->status === 'rented') return 'badge-rented';
        return match($this->transaction_type) {
            'dijual' => 'badge-sale',
            'disewa' => 'badge-rent',
            default  => 'badge-default',
        };
    }

    public function getLocationStringAttribute(): string
    {
        $parts = array_filter([
            $this->district?->name,
            $this->city?->name,
        ]);
        return implode(', ', $parts) ?: ($this->address ?? '-');
    }

    public function getWhatsappMessageAttribute(): string
    {
        $title = $this->title;
        return urlencode("Halo, saya tertarik dengan properti *{$title}*.\n\nSaya ingin mendapatkan informasi lebih lanjut mengenai properti tersebut.\n\nLink: " . route('properties.show', $this->slug));
    }

    protected static function booted()
    {
        static::saving(function ($property) {
            if ($property->isDirty('google_maps_link')) {
                $link = $property->google_maps_link;
                if (empty($link)) {
                    $property->google_maps_embed_url = null;
                } else {
                    $property->google_maps_embed_url = static::convertToEmbedUrl($link);
                }
            }
        });
    }

    public static function convertToEmbedUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (str_contains($url, 'google.com/maps/embed') || str_contains($url, 'output=embed')) {
            return $url;
        }

        $resolvedUrl = $url;
        
        // Resolve short URL
        if (str_contains($url, 'maps.app.goo.gl') || str_contains($url, 'goo.gl/maps')) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $response = curl_exec($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);

                if ($info['http_code'] == 301 || $info['http_code'] == 302) {
                    preg_match('/Location:\s*(.*)/i', $response, $matches);
                    if (isset($matches[1])) {
                        $resolvedUrl = trim($matches[1]);
                    }
                }
            } catch (\Exception $e) {
                // Ignore network errors
            }
        }

        // 1. Try to extract exact pin coordinates (!3d...!4d...)
        if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $resolvedUrl, $matches)) {
            return "https://maps.google.com/maps?q={$matches[1]},{$matches[2]}&z=15&output=embed";
        }

        // 2. Try to extract map center coordinates (@lat,lng)
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $resolvedUrl, $matches)) {
            return "https://maps.google.com/maps?q={$matches[1]},{$matches[2]}&z=15&output=embed";
        }

        // 3. Try to extract place name
        if (preg_match('/maps\/place\/([^\/@?]+)/', $resolvedUrl, $matches)) {
            $placeName = urldecode(str_replace('+', ' ', $matches[1]));
            return "https://maps.google.com/maps?q=" . urlencode($placeName) . "&z=15&output=embed";
        }

        // 4. Try to extract q query parameter
        $queryStr = parse_url($resolvedUrl, PHP_URL_QUERY);
        if ($queryStr) {
            parse_str($queryStr, $params);
            if (isset($params['q'])) {
                return "https://maps.google.com/maps?q=" . urlencode($params['q']) . "&z=15&output=embed";
            }
        }

        return null;
    }
}
