<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'icon', 'image', 'short_description', 'description', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public const CATEGORIES = [
        'perizinan' => 'Perizinan',
        'konstruksi' => 'Konstruksi',
    ];

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category ?? 'Layanan';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return $this->image ? asset('storage/' . $this->image) : asset('images/placeholder-service.svg');
    }
}
