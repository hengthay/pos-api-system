<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchases extends Model
{
    use SoftDeletes;

    protected $fillable = ["supplier_id", "invoice_no", "total_amount", "purchase_date", "status", "created_by"];

    // Purchase belongs to a supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class);
    }

    // Purchase was created by a user
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Purchase has many line items
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // Purchase has many inventory movements
    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransactions::class);
    }

    // Purchase has many products (via purchase_items)
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'purchase_items')
                    ->withPivot('quantity', 'cost_price', 'total');
    }
}
