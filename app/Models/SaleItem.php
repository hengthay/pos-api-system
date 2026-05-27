<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = ["sale_id", "product_id", "quantity", "unit_price", "discount", "tax"];

    protected $casts = [
        'unit_price'    => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'quantity'=> 'integer',
    ];

    // Belongs to sales
    public function sale() : BelongsTo {
        return $this->belongsTo(Sales::class);
    }

    // Belong to products
    public function product() : BelongsTo {
        return $this->belongsTo(Products::class);
    }
}
