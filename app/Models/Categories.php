<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_name', 'description'];

    public function products() : HasMany {
        return $this->hasMany(Products::class);
    }
}
