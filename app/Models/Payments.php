<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payments extends Model
{
    protected $fillable = ["sale_id", "payment_method", "amount", "paid_at", "reference_no"];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
    
    public function sale() : BelongsTo {
        return $this->belongsTo(Sales::class);
    }
}
