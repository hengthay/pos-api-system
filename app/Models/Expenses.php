<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenses extends Model
{
    protected $fillable = ["title", "amount", "expense_date", "description", "created_by"];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
    
    // Expense was logged by a user
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
