<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory_transactions extends Model
{
    protected $fillable = ["product_id", "transaction_type", "quantity", "sale_id", "purchase_id", 
    "notes", "created_by"];
}
