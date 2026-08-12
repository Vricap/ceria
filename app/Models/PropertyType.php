<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
