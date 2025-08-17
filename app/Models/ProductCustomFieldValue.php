<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCustomFieldValue extends Model
{
    protected $fillable = [
        'product_id',
        'custom_field_id',
        'value'
    ];

    // Relation avec le produit
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relation avec le champ personnalisé
    public function customField(): BelongsTo
    {
        return $this->belongsTo(CustomField::class);
    }
}
