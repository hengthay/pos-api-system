<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use SoftDeletes;

    protected $fillable = ["supplier_name", "contact_name", "phone", "address", "email"];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchases::class);
    }
}
