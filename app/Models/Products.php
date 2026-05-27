<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["product_name", "product_code", "brand", "cost_price", "selling_price", "stock_quantity", "image_url", "description", "category_id"];
}
