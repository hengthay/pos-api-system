<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;

    protected $fillable = ["invoice_no", "customer_id", "user_id", "subtotal", "discount", "tax", "total", "payment_status", "paid_amount", "sale_date"];

    protected $casts = [
        'subtotal'    => 'decimal:2',
        'discount' => 'decimal:2',
        'tax'=> 'decimal:2',
        'total'=> 'decimal:2',
    ];

    // Sale BELONGS TO one customer (nullable — walk-in)
    public function customer() : BelongsTo {
        return $this->belongsTo(Customers::class);
    }

    // Sale BELONGS TO one user
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Sale HAS MANY line items
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Sale HAS MANY payments
    public function payment() : HasMany {
        return $this->hasMany(Payments::class);
    }

    // Sale HAS MANY inventory
    public function inventoryTransaction() : HasMany {
        return $this->hasMany(InventoryTransactions::class);
    }

    // Sale BELONGS TO MANY products through sale_items
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'sale_items')
                    ->withPivot('quantity', 'unit_price', 'discount', 'total');
    }
}
