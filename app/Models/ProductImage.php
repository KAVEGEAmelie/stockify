<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'filename',
        'original_name',
        'path',
        'mime_type',
        'size',
        'order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    // Relation avec le produit
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scope pour l'image principale
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Obtenir l'URL complète de l'image
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
