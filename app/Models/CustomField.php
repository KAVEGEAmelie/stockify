<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'type',
        'options',
        'is_required',
        'order',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Relation avec les valeurs des champs personnalisés
    public function values(): HasMany
    {
        return $this->hasMany(ProductCustomFieldValue::class);
    }

    // Scope pour les champs actifs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour ordonner par ordre
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
