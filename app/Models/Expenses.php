<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = ["title", "amount", "expense_date", "description", "created_by"];
}
