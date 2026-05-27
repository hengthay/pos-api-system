<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransactions extends Model
{
    protected $fillable = ["product_id", "transaction_type", "quantity", "sale_id", "purchase_id", 
    "notes", "created_by"];

    protected $casts = [
        'quantity' => 'integer',
    ];
    
    // Transaction belong to product
    public function product() : BelongsTo {
        return $this->belongsTo(Products::class);
    }

    // Transaction belong sale
    public function sale() : BelongsTo {
        return $this->belongsTo(Sales::class);
    }

    // Transaction belong to created by a user
    public function createdBy() : BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Transaction belong to purchase
    public function purchase() : BelongsTo {
        return $this->belongsTo(Purchases::class);
    }
}
