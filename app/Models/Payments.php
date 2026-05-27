<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ["sale_id", "payment_method", "amount", "paid_at", "reference_no"];
}
