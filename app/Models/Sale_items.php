<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale_items extends Model
{
    protected $fillable = ["sale_id", "product_id", "quantity", "unit_price", "discount", "tax"];
}
