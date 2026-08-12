<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'photo', 'title', 'phone', 'whatsapp',
        'email', 'instagram', 'facebook', 'linkedin', 'specialization',
        'city', 'bio', 'experience_years', 'rating', 'is_active', 'sort_order'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && str_starts_with($this->photo, 'http')) {
            return $this->photo;
        }
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/placeholder-agent.jpg');
    }

    public function getWhatsappUrlAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp ?? $this->phone ?? '');
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return 'https://wa.me/' . $number;
    }

    public function getActivePropertiesCountAttribute(): int
    {
        return $this->properties()->whereIn('status', ['published', 'featured'])->count();
    }

    public function getRatingStarsAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }
}
