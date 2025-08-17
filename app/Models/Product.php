<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'cost_price',
        'stock_quantity',
        'min_stock_level',
        'category_id',
        'supplier_id',
        'unit_of_measure',
        'is_active',
        'barcode',
        'qr_code',
        'alert_threshold',
        'custom_attributes',
        'brand',
        'model',
        'expiry_date',
        'batch_number',
        'serial_number',
        'weight',
        'dimensions'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'alert_threshold' => 'decimal:2',
        'weight' => 'decimal:3',
        'is_active' => 'boolean',
        'custom_attributes' => 'array',
        'expiry_date' => 'date'
    ];

    // Relations existantes
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Nouvelles relations
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags')->withTimestamps();
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'product_locations')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function customFieldValues(): HasMany
    {
        return $this->hasMany(ProductCustomFieldValue::class);
    }

    // Méthodes utilitaires
    public function isLowStock(): bool
    {
        $threshold = $this->alert_threshold ?? $this->min_stock_level;
        return $this->stock_quantity <= $threshold;
    }

    public function primaryImage(): HasMany
    {
        return $this->images()->where('is_primary', true);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primaryImage = $this->primaryImage()->first();
        return $primaryImage ? $primaryImage->url : null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= COALESCE(alert_threshold, min_stock_level)');
    }

    public function scopeWithTag($query, $tagName)
    {
        return $query->whereHas('tags', function ($q) use ($tagName) {
            $q->where('name', $tagName);
        });
    }

    public function scopeInLocation($query, $locationId)
    {
        return $query->whereHas('locations', function ($q) use ($locationId) {
            $q->where('location_id', $locationId);
        });
    }

    // Calcul de la valeur du stock
    public function getStockValueAttribute(): float
    {
        return $this->stock_quantity * $this->cost_price;
    }
}
