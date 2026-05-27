<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = ["invoice_no", "customer_id", "user_id", "subtotal", "discount", "tax", "total", "payment_status", "sale_date"];
}
