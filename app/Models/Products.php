<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["product_name", "product_code", "brand", "cost_price", "selling_price", "stock_quantity", "image_url", "description", "category_id"];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity'=> 'integer',
    ];

    // Relationship
    // Belong to category
    public function category() : BelongsTo {
        return $this->belongsTo(Categories::class);
    }

    // hasMany saleItem
    public function saleItems() : HasMany {
        return $this->hasMany(SaleItem::class);
    }

    // hasMany inventory
    public function inventoryTransactions() : HasMany {
        return $this->hasMany(InventoryTransactions::class);
    }

    // hasMany purchaseItem
    public function purchaseItems() : HasMany {
        return $this->hasMany(PurchaseItem::class);
    }

    // Product has been sold through many sales (via sale_items)
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sales::class, 'sale_items')
                    ->withPivot('quantity', 'unit_price', 'discount', 'total');
    }

    // Product has been purchased through many purchases (via purchase_items)
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchases::class, 'purchase_items')
                    ->withPivot('quantity', 'cost_price', 'total');
    }
}
