<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;
    protected $fillable = ["name", "phone", "address", "email"];

    public function sales() : HasMany {
        return $this->hasMany(Sales::class);
    }
}
