<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit_logs extends Model
{
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'old_value', 'new_value'];
}
