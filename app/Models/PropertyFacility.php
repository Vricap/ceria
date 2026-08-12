<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFacility extends Model
{
    protected $fillable = ['property_id', 'name', 'icon'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
