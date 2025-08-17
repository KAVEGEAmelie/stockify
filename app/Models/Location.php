<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'parent_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relation parent-enfant pour hiérarchie
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    // Relation avec les produits
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_locations')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Scope pour les emplacements actifs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Obtenir le chemin hiérarchique complet
    public function getFullPathAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->full_path . ' > ' . $this->name;
        }
        return $this->name;
    }
}
