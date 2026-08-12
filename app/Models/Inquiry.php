<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'property_id', 'agent_id', 'name', 'email', 'whatsapp', 'phone',
        'message', 'subject', 'status', 'notes', 'source', 'contacted_at'
    ];

    protected $casts = ['contacted_at' => 'datetime'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new'        => 'Baru',
            'contacted'  => 'Dihubungi',
            'follow_up'  => 'Follow Up',
            'qualified'  => 'Qualified',
            'closed'     => 'Closed',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new'        => '#3b82f6',
            'contacted'  => '#f59e0b',
            'follow_up'  => '#8b5cf6',
            'qualified'  => '#10b981',
            'closed'     => '#1a5c3a',
            'cancelled'  => '#ef4444',
            default      => '#6b7280',
        };
    }
}
