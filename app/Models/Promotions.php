<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    protected $fillable = ["name", "discount_type", "value", "start_date", "end_date", "is_active"];
}
