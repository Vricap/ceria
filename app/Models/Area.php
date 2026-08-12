<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    protected $fillable = ['district_id', 'name', 'slug', 'is_active'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
