<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $fillable = ["purchase_id", "product_id", "quantity", "cost_price", "total"];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'total' => 'decimal:2',
        'quantity'=> 'integer',
    ];

    // Purchase item belong product
    public function product() : BelongsTo {
        return $this->belongsTo(Products::class);
    }

    // Purchase item belong to purchase
    public function purchase() : BelongsTo {
        return $this->belongsTo(Purchases::class);
    }
}
