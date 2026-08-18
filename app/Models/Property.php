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
        'address', 'latitude', 'longitude', 'thumbnail', 'meta_title',
        'meta_description', 'og_image', 'status', 'is_featured', 'views', 'published_at',
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
}
